<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class CartController extends AppController {
	public $name = 'Cart';
	public $uses = array('Content','Order');
	public $components = array('ConfigurationBase', 'ContentBase', 'OrderBase', 'Smarty', 'EventBase');

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
			$new_order['Order']['customer_id'] = (!isset($_SESSION['Customer']['customer_id'])) ? 0 : $_SESSION['Customer']['customer_id'];

			if ($_SESSION['Customer']['customer_id'] > 0) {
				
			App::import('Model', 'Customer');
			$Customer =& new Customer();
				
			if (isset($_SESSION['Customer']['customer_id'])) {
				$customer = $Customer->find('first', array('conditions' => array('Customer.id' => $_SESSION['Customer']['customer_id'])));
			}
			
			if ($customer['AddressBook']['ship_name'] != '') $new_order['Order']['bill_name'] = $customer['AddressBook']['ship_name'];
			if ($customer['AddressBook']['ship_line_1'] != '') $new_order['Order']['bill_line_1'] = $customer['AddressBook']['ship_line_1'];
			if ($customer['AddressBook']['ship_line_2'] != '') $new_order['Order']['bill_line_2'] = $customer['AddressBook']['ship_line_2'];
			if ($customer['AddressBook']['ship_city'] != '') $new_order['Order']['bill_city'] = $customer['AddressBook']['ship_city'];
			if ($customer['AddressBook']['ship_country'] != '') $new_order['Order']['bill_country'] = $customer['AddressBook']['ship_country'];
			if ($customer['AddressBook']['ship_state'] != '') $new_order['Order']['bill_state'] = $customer['AddressBook']['ship_state'];
			if ($customer['AddressBook']['ship_zip'] != '') $new_order['Order']['bill_zip'] = $customer['AddressBook']['ship_zip'];
			
			if ($customer['AddressBook']['ship_name'] != '') $new_order['Order']['ship_name'] = $customer['AddressBook']['ship_name'];
			if ($customer['AddressBook']['ship_line_1'] != '') $new_order['Order']['ship_line_1'] = $customer['AddressBook']['ship_line_1'];
			if ($customer['AddressBook']['ship_line_2'] != '') $new_order['Order']['ship_line_2'] = $customer['AddressBook']['ship_line_2'];
			if ($customer['AddressBook']['ship_city'] != '') $new_order['Order']['ship_city'] = $customer['AddressBook']['ship_city'];
			if ($customer['AddressBook']['ship_country'] != '') $new_order['Order']['ship_country'] = $customer['AddressBook']['ship_country'];
			if ($customer['AddressBook']['ship_state'] != '') $new_order['Order']['ship_state'] = $customer['AddressBook']['ship_state'];
			if ($customer['AddressBook']['ship_zip'] != '') $new_order['Order']['ship_zip'] = $customer['AddressBook']['ship_zip'];

			if ($customer['AddressBook']['phone'] != '') $new_order['Order']['phone'] = $customer['AddressBook']['phone'];
			if ($customer['Customer']['email'] != '') $new_order['Order']['email'] = $customer['Customer']['email'];
			
			}
		
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

		if (!isset($_POST['product_quantity']) && sizeof($_POST['product_quantity'] < 0)) $_POST['product_quantity'] = 1;

		// Add the product to the order from the component
		$this->OrderBase->add_product($_POST['product_id'], $_POST['product_quantity']);

		global $config;
		$content = $this->Content->read(null, $_POST['product_id']);

		if ($this->RequestHandler->isAjax()) {
			$this->Smarty->display("{shopping_cart template='cart-content-box'}");
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
