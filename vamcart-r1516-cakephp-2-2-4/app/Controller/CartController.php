<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class CartController extends AppController {
	public $name = 'Cart';
	public $uses = array('Content','Order');
	public $components = array('ConfigurationBase', 'ContentBase', 'OrderBase', 'Smarty', 'EventBase', 'Gzip.Gzip');

	public function remove_product ($product_id, $qty = 9999) {
		$this->OrderBase->remove_product($product_id, $qty);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}

	public function purchase_product () {
		// Clean up the post
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->paranoid($_POST);

		// Check if we have an active cart, if there is no order_id set, then lets create one.
		if (!isset($_SESSION['Customer']['order_id'])) {
			$new_order = array();
			$new_order['Order']['order_status_id'] = 0;

			// Get default shipping & payment methods and assign them to the order
			$default_payment = $this->Order->PaymentMethod->find('first', array('conditions' => array('default' => '1')));
			$new_order['Order']['payment_method_id'] = $default_payment['PaymentMethod']['id'];

			$default_shipping = $this->Order->ShippingMethod->find('first', array('conditions' => array('default' => '1')));
			$new_order['Order']['shipping_method_id'] = $default_shipping['ShippingMethod']['id'];

			// Save the order
			$this->Order->save($new_order);
			$order_id = $this->Order->getLastInsertId();
			$_SESSION['Customer']['order_id'] = $order_id;
			global $order;
			$order = $new_order;
		}

		// Add the product to the order from the component
		$this->OrderBase->add_product($_POST['product_id'], $_POST['product_quantity']);

		global $config;
		$content = $this->Content->read(null, $_POST['product_id']);

		if ($this->RequestHandler->isAjax()) {
			$this->Smarty->display("{shopping_cart template='cart-content-box-ajax'}");
			die();
		} else {
			$this->redirect('/product/' . $content['Content']['alias'] . $config['URL_EXTENSION']);
		}
	}

	public function update_cart_qty()
	{
		// Clean up the post
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->paranoid($_POST);

		if (isset($_POST['qty']) && sizeof($_POST['qty'] > 0)) {
			foreach ($_POST['qty'] as $products_id => $quantity) {
				$this->OrderBase->add_product($products_id, $quantity, true);
			}
		}
		
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
}
?>
