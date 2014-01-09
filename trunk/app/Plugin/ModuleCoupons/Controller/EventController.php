<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleCouponsAppController', 'ModuleCoupons.Controller');

class EventController extends ModuleCouponsAppController {
	var $uses = null;
	
	function utilize_coupon()
	{
		global $order;
		$coupon_code = $_SESSION['module_coupon_code'];

		if(empty($coupon_code))
			return;
		
		App::import('Model', 'ModuleCoupons.ModuleCoupon');
		$this->ModuleCoupon = new ModuleCoupon();			

		$coupon = $this->ModuleCoupon->find('first', array('conditions' => array('code' => $coupon_code)));

		if($coupon) {

		foreach($order['OrderProduct'] AS $product) {
			
		// Check restrictions
		if($product['quantity'] < $coupon['ModuleCoupon']['min_product_count'])
			$invalid_msg = __('Not enough products in cart for coupon. Requires: ') . $coupon['ModuleCoupon']['min_product_count'] . __(' products.');
		elseif($product['quantity'] > $coupon['ModuleCoupon']['max_product_count'])
			$invalid_msg = __('Too many products in cart for coupon. Requires less than: ') . $coupon['ModuleCoupon']['min_product_count'] . __(' products.');
		elseif($order['Order']['total'] < $coupon['ModuleCoupon']['min_order_total'])
			$invalid_msg = __('Order total not enough. Requires at least: ') . $coupon['ModuleCoupon']['min_order_total'] . '.';	
		elseif($order['Order']['total'] > $coupon['ModuleCoupon']['max_order_total'])
			$invalid_msg = __('Order total too high. Requires less than: ') . $coupon['ModuleCoupon']['min_order_total'] . '.';	
			
		}			
	
		if(isset($invalid_msg))
		{
			echo '<div class="error">' . $invalid_msg . '</div>';
			return;
		}
	
		// Take off the discounts
		$discount = 0;	
		if($coupon['ModuleCoupon']['percent_off_total'] > 0)
			$discount = $discount - (($coupon['ModuleCoupon']['percent_off_total']/100)*$order['Order']['total']);
		if($coupon['ModuleCoupon']['amount_off_total'] > 0)
			$discount = $discount - $coupon['ModuleCoupon']['amount_off_total'];
		if($coupon['ModuleCoupon']['free_shipping'] == 1)
			$discount = $discount - $order['Order']['shipping'];
		
		$coupon_product = array();
		$coupon_product['OrderProduct']['order_id'] = $order['Order']['id'];
		$coupon_product['OrderProduct']['order_id'] = $order['Order']['id'];
		$coupon_product['OrderProduct']['name'] = $coupon['ModuleCoupon']['name'] . ' - ' . $coupon['ModuleCoupon']['code'];
		$coupon_product['OrderProduct']['quantity'] = 1;
		$coupon_product['OrderProduct']['price'] = $discount;	

		// Get the content_id for the new product
		App::import('Model', 'Content');
		$this->Content = new Content();
		$content_page = $this->Content->findByAlias('coupon-details');
		$coupon_product['OrderProduct']['content_id'] = $content_page['Content']['id'];
	
		// Load the OrderProduct model for saving and error checking
		App::import('Model', 'OrderProduct');
		$this->OrderProduct = new OrderProduct();
		
		// Make sure this coupon isn't already in our 'cart'	
		$coupon_count = $this->OrderProduct->find('count', array('conditions' => array('order_id' => $order['Order']['id'], 'name' => $coupon_product['OrderProduct']['name'])));
		if($coupon_count > 0)
		{
			echo '<div class="error">'.__('Error: Coupon already used.').'</div>';
			return;
		}
		
		// Save the new coupon as an order product
		$this->OrderProduct->save($coupon_product);
		
		// Save the new order totals
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		$order['Order']['total'] = 	$order['Order']['total'] + $discount;

		$this->Order->save($order);
		unset($_SESSION['module_coupon_code']);
		
		}
		
	}
	
}

?>