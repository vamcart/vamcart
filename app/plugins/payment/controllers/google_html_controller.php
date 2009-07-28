<?php 
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class GoogleHtmlController extends PaymentAppController {
	var $uses = null;
	var $components = array('OrderBase');

	function before_process () 
	{
		global $order;
		
		App::import('Model', 'PaymentMethod');
		$this->PaymentMethod =& new PaymentMethod();
		
		$google_merchant_id = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'google_html_merchant_id'));
		$merchant_id = $google_merchant_id['PaymentMethodValue']['value'];
		
		
		$return_url = $_SERVER['HTTP_HOST'] .'/orders/place_order/';
		$cancel_url = $_SERVER['HTTP_HOST'];
		
		$content = '<form method="POST" action="https://sandbox.google.com/checkout/cws/v2/Merchant/' . $merchant_id . '/checkout">';
		
		$product_count = 1;
		foreach($order['OrderProduct'] AS $product)
		{
			$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="' . $product['name'] . '">
						 <input type="hidden" name="item_quantity_' . $product_count . '" value="' . $product['quantity'] . '">
						 <input type="hidden" name="item_price_' . $product_count . '" value="' . $product['price'] . '">';

			++$product_count;
		}
		$content .= '
						<input type="hidden" name="ship_method_name" value="' . $order['ShippingMethod']['name'] . '">
						<input type="hidden" name="ship_method_price" value="' . $order['Order']['shipping'] . '">
					';		
						
		$content .= '
			    <input type="image" name="Google Checkout" alt="Fast checkout through Google"
        		src="http://sandbox.google.com/checkout/buttons/checkout.gif?merchant_id=' . $merchant_id . '
             	&w=180&h=46&style=white&variant=text&loc=en_US"  height="46" width="180">
			</form>';
		return $content;
	}
}

?>