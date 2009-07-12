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

class PaypalController extends PaymentAppController {
	var $uses = array('PaymentMethod');
	var $components = array('OrderBase');

	function before_process () 
	{
		$order = $this->OrderBase->get_order();
		
		$paypal_email = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'paypal_email'));
		$email = $paypal_email['PaymentMethodValue']['value'];
		$return_url = $_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		$cancel_url = $_SERVER['HTTP_HOST'];
		
		$content = '
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_cart">
			<input type="hidden" name="upload" value="1">
			<input type="hidden" name="business" value="' . $email . '">
			<input type="hidden" name="return" value="' . $return_url . '">
			<input type="hidden" name="rm" value="2">
			<input type="hidden" name="cancel_return" value="' . $cancel_url . '">';
		
		$product_count = 1;
		foreach($order['OrderProduct'] AS $product)
		{
			$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="' . $product['name'] . '">
						 <input type="hidden" name="quantity_' . $product_count . '" value="' . $product['quantity'] . '">
						 <input type="hidden" name="amount_' . $product_count . '" value="' . $product['price'] . '">';

			++$product_count;
		}
		$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="shipping">
					 <input type="hidden" name="amount_' . $product_count . '" value="' . $order['Order']['shipping'] . '">
					 <input type="hidden" name="tax_x" value="' . $order['Order']['tax'] . '">';		
						
		$content .= '
			<button id="sms_checkout_button" type="submit">{lang}Confirm Order{/lang}</button>
			</form>';
		return $content;
	}
}

?>