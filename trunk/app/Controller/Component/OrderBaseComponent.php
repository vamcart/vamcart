<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
App::uses('ContentBaseComponent', 'Controller/Component');
App::uses('EventBaseComponent', 'Controller/Component');
App::import('Model', 'Content');
App::import('Model', 'ContentDescription');
App::import('Model', 'Order');
App::import('Model', 'ContentProduct');
App::import('Model', 'ContentDownloadable');

class OrderBaseComponent extends Object
{

	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	$this->load_models();
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
	}

	public function load_models()
	{
	
		
		$this->ContentBase = new ContentBaseComponent(new ComponentCollection());

		
		$this->Content = new Content();

	
		$this->ContentDescription = new ContentDescription();

		
		$this->Order = new Order();

	
		$this->ContentProduct = new ContentProduct();

	
		$this->ContentDownloadable = new ContentDownloadable();
	}

	public function get_order ($order_id = null)
	{
		if (($order_id == null) && (isset($_SESSION['Customer']['order_id']))) {
			$order_id = $_SESSION['Customer']['order_id'];
		}

		$this->load_models();

		if ($order_id != null) {
			$this->Order->unbindModel(array('belongsTo' => array('OrderStatus')));
			$this->Order->unbindModel(array('hasMany' => array('OrderComment')));
			$order = $this->Order->find('first', array('recursive' => 2, 'conditions' => array('Order.id' => $order_id)));
		} else {
			$order = array();
		}

		return $order;
	}

	public function get_order_shipping (&$order)
	{

		if (!isset($order['ShippingMethod']['code'])) {
			return 0;
		}

		$shipping = Inflector::classify($order['ShippingMethod']['code']);
		$shipping_controller =  Inflector::classify($order['ShippingMethod']['code']) . 'Controller';
		 App::import('Controller', 'Shipping.'.$shipping);
		$MethodBase =& new $shipping_controller();

		$shipping_total = $MethodBase->calculate();

		return $shipping_total;
	}

	public function get_order_tax (&$order)
	{
		$running_total = 0;

		foreach($order['OrderProduct'] AS $product) {
			$running_total += ($product['quantity'] * $product['tax']);
		}

		return $running_total;

	}

	public function get_order_total (&$order)
	{
		$running_total = 0;

		foreach($order['OrderProduct'] AS $product) {
			$running_total += ($product['quantity'] * $product['price']);
		}

		return $running_total;
	}

	public function update_order_totals ()
	{
		$this->load_models();

		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$order['Order']['shipping'] = $this->get_order_shipping($order);
		$order['Order']['tax'] = $this->get_order_tax($order);
		$order['Order']['total'] = $this->get_order_total($order) + $order['Order']['tax'] + $order['Order']['shipping'] ;

		$EventBase =& new EventBaseComponent(new ComponentCollection());

		$EventBase->ProcessEvent('UpdateOrderTotalsBeforeSave');
		$this->Order->save($order);
		$EventBase->ProcessEvent('UpdateOrderTotalsAfterSave');
	}

	public function remove_product ($product_id, $qty = 1)
	{
		$this->load_models();

		$order_product = $this->Order->OrderProduct->find('first', array('conditions' => array('content_id' => $product_id,'order_id' => $_SESSION['Customer']['order_id'])));
                $prices = $this->get_price_product($product_id);                

		$EventBase =& new EventBaseComponent(new ComponentCollection());

		$EventBase->ProcessEvent('RemoveFromCartBeforeSave');

		if($order_product['OrderProduct']['quantity'] <= $qty) {
			$this->Order->OrderProduct->delete($order_product['OrderProduct']['id']);
		} else {
			$order_product['OrderProduct']['quantity'] -= $qty;
                        $order_product['OrderProduct']['price'] = $prices['ContentProduct']['price'];
                        if (isset($prices['ContentProductPrice'])) {
				foreach($prices['ContentProductPrice'] as $price) {
					if ($order_product['OrderProduct']['quantity'] >= $price['quantity']) {
						$order_product['OrderProduct']['price'] = $price['price'];
					}
				}
			}
			$this->Order->OrderProduct->save($order_product);
		}

		$EventBase->ProcessEvent('RemoveFromCartAfterSave');

		$this->update_order_totals();
	}

	public function add_product($content_id, $qty = 1, $update = false) {
		$this->load_models();
		$content = $this->ContentBase->get_content_information($content_id);
		$content_type = $content['ContentType']['name'];
		$content_description = $this->ContentBase->get_content_description($content_id);
		$content['ContentDescription'] = $content_description['ContentDescription'];

		$product = $this->Order->OrderProduct->Content->find('first', array('conditions' => array('Content.id' => $content_id)));

		// Get the product from the OrderProduct model...
		$order_product = $this->Order->OrderProduct->find('first', array('conditions' => array('order_id' => $_SESSION['Customer']['order_id'], 'content_id' => $content_id)));

		// needed for calculating correct discount price
                $prices = $this->get_price_product($content_id);

		if (empty($order_product)) {

			if ('product' == $content_type) {
				if ($qty < $prices['ContentProduct']['moq']) {
					$qty = $prices['ContentProduct']['moq'];
				}
			}

			switch ($content_type) {
				case 'product':
					$order_product = array('order_id' => $_SESSION['Customer']['order_id'],
						'content_id' => $content_id,
						'name' => $content['ContentDescription']['name'],
						'model' => $product['ContentProduct']['model'],
						'quantity' => $qty,
						'price' => $product['ContentProduct']['price'],
						'weight' => $product['ContentProduct']['weight']
					);
					break;
				case 'downloadable':
					$order_product = array('order_id' => $_SESSION['Customer']['order_id'],
						'content_id' => $content_id,
						'name' => $content['ContentDescription']['name'],
						'model' => $product['ContentDownloadable']['model'],
						'quantity' => $qty,
						'price' => $product['ContentDownloadable']['price'],
						'weight' => 0,
						'filename' => $product['ContentDownloadable']['filename'],
						'filestorename' => $product['ContentDownloadable']['filestorename'],
						'download_count' => 0,
						'max_downloads' => (int)$product['ContentDownloadable']['max_downloads'],
						'max_days_for_download' => (int)$product['ContentDownloadable']['max_days_for_download'],
						'order_status_id' => (int)$product['ContentDownloadable']['order_status_id'],
						'download_key' => $this->_random_string()
					);
					break;
			}

			if (isset($prices['ContentProductPrice'])) {
				foreach ($prices['ContentProductPrice'] as $price) {
					if ($qty >= $price['quantity']) {
						$order_product['price'] = $price['price'];
					}
				}
			}
		} else {
			if (true === $update) {
				$order_product['OrderProduct']['quantity'] = abs($qty);
			} else {
				$order_product['OrderProduct']['quantity'] += abs($qty);
			}

			if ('product' == $content_type) {
				if ($order_product['OrderProduct']['quantity'] < $prices['ContentProduct']['moq']) {
					$order_product['OrderProduct']['quantity'] = $prices['ContentProduct']['moq'];
				}
			}

                        $order_product['OrderProduct']['price'] = $product['ContentProduct']['price'];
			if (isset($prices['ContentProductPrice'])) {
				foreach($prices['ContentProductPrice'] as $price) {
					if ($order_product['OrderProduct']['quantity'] >= $price['quantity']) {
						$order_product['OrderProduct']['price'] = $price['price'];
					}
				}
			}
		}

		$EventBase =& new EventBaseComponent(new ComponentCollection());

		$EventBase->ProcessEvent('AddToCartBeforeSave');
		$this->Order->OrderProduct->save($order_product);
		$EventBase->ProcessEvent('AddToCartAfterSave');

		$this->update_order_totals();
	}
        
        public function get_price_product($product_id = 0)
	{
            $this->load_models();
            $content = $this->ContentBase->get_content_information($product_id);
            $prices = null;
            switch ($content['ContentType']['name']) {
			case 'product':
				$prices = $this->ContentProduct->find('first', array(
					'conditions' => array('content_id' => $product_id)
				));
				break;
			case 'downloadable':
				$prices = $this->ContentDownloadable->find('first', array(
					'conditions' => array('content_id' => $product_id)
				));
				break;
		}
            return $prices;            
        }
	
	public function _random_string()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < 16; $i++) {
			$randstring .= mb_substr($characters, rand(0, strlen($characters) - 1), 1);
		}
		return $randstring;
	}
}
?>
