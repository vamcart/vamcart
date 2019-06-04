<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class GiftController extends ModuleGiftAppController {
	public $uses = array('ModuleGift');
	public $components = array('ContentBase');
	
	public function get_gift()
	{
		global $order;

		$discount = 0;
		//$gift = $this->ModuleGift->find('first', array('conditions' => array('ModuleGift.order_total <=' => $order['Order']['total'], 'ModuleGift.content_id >' => 0), 'order' => array('ModuleGift.order_total' => 'DESC')));
		//$gifts = $gift;
		
		$gift = $this->ModuleGift->find('all', array('conditions' => array('ModuleGift.order_total <=' => $order['Order']['total'], 'ModuleGift.content_id >' => 0), 'order' => array('ModuleGift.order_total' => 'DESC')));
		
		if ($gift) {
		foreach ($gift as $gifts) { 
		if($order['Order']['total'] >= $gifts['ModuleGift']['order_total']) {
			
		$content_description = $this->ContentBase->get_content_description($gifts['ModuleGift']['content_id']);

		$order_product_gift = array();
		$order_product_gift['OrderProduct']['order_id'] = $order['Order']['id'];
		$order_product_gift['OrderProduct']['name'] = $content_description['ContentDescription']['name'];
		$order_product_gift['OrderProduct']['quantity'] = 1;
		$order_product_gift['OrderProduct']['price'] = 0;	

		$order_product_gift['OrderProduct']['content_id'] = $gifts['ModuleGift']['content_id'];

		// Load the OrderProduct model for saving and error checking
		App::import('Model', 'OrderProduct');
		$this->OrderProduct = new OrderProduct();

		// Make sure this gift isn't already in our 'cart'	
		$coupon_count = $this->OrderProduct->find('count', array('conditions' => array('order_id' => $order['Order']['id'], 'name' => $order_product_gift['OrderProduct']['name'])));
		if($coupon_count > 0)
		{
			return;
		}
				
		// Save the new discount as an order product
		$this->OrderProduct->save($order_product_gift);
		
		// Save the new order totals
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		$order['Order']['total'] = $order['Order']['total'] - $discount;

		$this->Order->save($order);
		
		}
		}
		}

		// Remove gifts from the cart when cart total < gift minimum order total
		$gift_remove = $this->ModuleGift->find('all', array('conditions' => array('ModuleGift.order_total >=' => $order['Order']['total'], 'ModuleGift.content_id >' => 0), 'order' => array('ModuleGift.order_total' => 'DESC')));
		
		if ($gift_remove) {
		foreach ($gift_remove as $gift_removes_remove) { 
		if($order['Order']['total'] <= $gift_removes_remove['ModuleGift']['order_total']) {
			
		// Load the OrderProduct model for saving and error checking
		App::import('Model', 'OrderProduct');
		$this->OrderProduct = new OrderProduct();

		// Make sure this gift isn't already in our 'cart'	
		$coupon_count = $this->OrderProduct->find('first', array('conditions' => array('order_id' => $order['Order']['id'], 'content_id' => $gift_removes_remove['ModuleGift']['content_id']), 'order' => 'OrderProduct.id DESC'));
		if($coupon_count)
		{
			$this->OrderProduct->delete($coupon_count['OrderProduct']['id']);
		}
				
		}
		}
		}		
	
	}
	
}

?>