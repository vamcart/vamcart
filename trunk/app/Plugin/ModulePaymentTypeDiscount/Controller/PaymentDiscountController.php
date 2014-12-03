<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class PaymentDiscountController extends ModulePaymentTypeDiscountAppController {
	public $uses = array('ModulePaymentTypeDiscount');
	
	public function apply()
	{
		global $order;

		$discount = 0;
		$payment_discount = $this->ModulePaymentTypeDiscount->find('first', array('conditions' => array('payment_method_id' => $order['Order']['payment_method_id'])));

		if($payment_discount['ModulePaymentTypeDiscount']['discount'] > 0) {

		$discount = $discount - (((int)$payment_discount['ModulePaymentTypeDiscount']['discount']/100)*$order['Order']['total']);	
		
		$payment_discount_product = array();
		$payment_discount_product['OrderProduct']['order_id'] = $order['Order']['id'];
		$payment_discount_product['OrderProduct']['name'] = __('Discount') . ' ' . $payment_discount['ModulePaymentTypeDiscount']['discount'] . '%';
		$payment_discount_product['OrderProduct']['quantity'] = 1;
		$payment_discount_product['OrderProduct']['price'] = $discount;	

		$payment_discount_product['OrderProduct']['content_id'] = 46;

		// Load the OrderProduct model for saving and error checking
		App::import('Model', 'OrderProduct');
		$this->OrderProduct = new OrderProduct();
		
		// Save the new discount as an order product
		$this->OrderProduct->save($payment_discount_product);
		
		// Save the new order totals
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		$order['Order']['total'] = 	$order['Order']['total'] + $discount;

		$this->Order->save($order);
		
		}
		
	}
	
}

?>