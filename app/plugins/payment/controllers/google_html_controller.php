<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class GoogleHtmlController extends PaymentAppController {
	var $uses = null;
	var $components = array('OrderBase');

	function before_process () 
	{
		global $order;
		
		loadModel('PaymentMethod');
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