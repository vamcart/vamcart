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

function default_template_checkout ()
{
$template = '
<div id="checkout">
<form action="{$checkout_form_action}" method="post">
	<div id="bill_information">
		<div>
			<h3>{lang}Billing Information{/lang}</h3>
		</div>
		<div>	
			<label>{lang}name{/lang}</label>
			<input type="text" name="bill_name" value="{$order.bill_name}"/>
		</div>
		<div>	
			<label>{lang}address_line_1{/lang}</label>
			<input type="text" name="bill_line_1" value="{$order.bill_line_1}" />
		</div>		
		<div>	
			<label>{lang}address_line_2{/lang}</label>
			<input type="text" name="bill_line_2" value="{$order.bill_line_2}" />
		</div>		
		<div>	
			<label>{lang}city{/lang}</label>
			<input type="text" name="bill_city" value="{$order.bill_city}" />
		</div>		
		<div>	
			<label>{lang}state{/lang}</label>
			<input type="text" name="bill_state" value="{$order.bill_state}" />
		</div>		
		<div>	
			<label>{lang}zipcode{/lang}</label>
			<input type="text" name="bill_zip" value="{$order.bill_zip}" />
		</div>	
	</div>		
	<hr />
	<div id="ship_information">
		<div>
			<h3>{lang}Shipping Information{/lang}</h3>
		</div>
		<div>	
			<label>{lang}name{/lang}</label>
			<input type="text" name="ship_name" value="{$order.ship_name}" />
		</div>
		<div>	
			<label>{lang}address_line_1{/lang}</label>
			<input type="text" name="ship_line_1" value="{$order.ship_line_1}" />
		</div>		
		<div>	
			<label>{lang}address_line_2{/lang}</label>
			<input type="text" name="ship_line_2" value="{$order.ship_line_2}" />
		</div>		
		<div>	
			<label>{lang}city{/lang}</label>
			<input type="text" name="ship_city" value="{$order.ship_city}" />
		</div>		
		<div>	
			<label>{lang}state{/lang}</label>
			<input type="text" name="ship_state" value="{$order.ship_state}" />
		</div>		
		<div>	
			<label>{lang}zipcode{/lang}</label>
			<input type="text" name="ship_zip" value="{$order.ship_zip}" />
		</div>								
	</div>
	<hr />
	<div id="contact_information">
		<div>
			<h3>{lang}Contact Information{/lang}</h3>
		</div>
		<div>	
			<label>{lang}email{/lang}</label>
			<input type="text" name="email" value="{$order.email}" />
		</div>
		<div>	
			<label>{lang}phone{/lang}</label>
			<input type="text" name="phone" value="{$order.phone}" />
		</div>		
	</div>
	<hr />	
	<div id="shipping_method">
		<div>
			<h3>{lang}Shipping Method{/lang}</h3>
		</div>	
		{foreach from=$ship_methods item=ship_method}
			<div>
				<input type="radio" name="shipping_method_id" value="{$ship_method.id}" id="ship_{$ship_method.id}" 
				{if $ship_method.id == $order.shipping_method_id}
				  checked="checked"
				 {/if}
				/>
				<label for="ship_{$ship_method.id}">{$ship_method.name} - {$ship_method.cost}</label>
			</div>
		{/foreach}
	</div>
	<div id="payment_method">
		<div>
			<h3>{lang}Payment Method{/lang}</h3>
		</div>		
		{foreach from=$payment_methods item=payment_method}
			<div>
				<input type="radio" name="payment_method_id" value="{$payment_method.id}" id="payment_{$payment_method.id}" 
				{if $payment_method.id == $order.payment_method_id}
				  checked="checked"
				 {/if}				
				/>
				<label for="payment_{$payment_method.id}">{$payment_method.name}</label>
			</div>
		{/foreach}		
	</div>
	<div>
	{module alias="coupons" action="checkout_box"}
	</div>
	<button id="sms_checkout_button" type="submit">{lang}continue to payment{/lang}</button>
</form>
</div>
';		

return $template;
}


function smarty_function_checkout($params, &$smarty)
{

	global $config;

	/*
	 *  Load some necessary models
	 **/	
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();

	App::import('Component', 'CurrencyBase');
		$CurrencyBase =& new CurrencyBaseComponent();		
	
	App::import('Model', 'Order');
		$Order =& new Order();
		
	App::import('Model', 'ShippingMethod');
		$ShippingMethod =& new ShippingMethod();

	App::import('Model', 'PaymentMethod');
		$PaymentMethod =& new PaymentMethod();

	// Assign the shipping methods
	$assignments = array();
	$active_ship_methods = $ShippingMethod->find('all', array('conditions' => array('active' => '1')));

	$keyed_ship_methods = array();
	foreach($active_ship_methods AS $method)
	{
		$shipping_component = Inflector::classify($method['ShippingMethod']['code']);
		$shipping_component2 =  Inflector::classify($method['ShippingMethod']['code']) . 'Component';
		loadPluginComponent('shipping',$shipping_component);
		$MethodBase =& new $shipping_component2();
		
		$ship_method_id = $method['ShippingMethod']['id'];
		$keyed_ship_methods[$ship_method_id] = array(
										  'id' => $ship_method_id,
										  'name' => $method['ShippingMethod']['name'],
										  'cost' => $CurrencyBase->display_price($MethodBase->calculate())
										  );

	}	
	
	// Assign the payment methods
	$active_payment_methods = $PaymentMethod->find('all', array('conditions' => array('active' => '1')));

	$keyed_payment_methods = array();
	foreach($active_payment_methods AS $method)
	{
		$payment_method_id = $method['PaymentMethod']['id'];
		$keyed_payment_methods[$payment_method_id] = array(
										  'id' => $payment_method_id,
										  'name' => $method['PaymentMethod']['name']
										  );

	}			
		
	// Assign the current order
	$Order->unbindAll();
	$order = $Order->find(array('Order.id' => $_SESSION['Customer']['order_id']));
		
	$assignments = array(
		'ship_methods' => $keyed_ship_methods,
		'payment_methods' => $keyed_payment_methods,
		'order' => $order['Order'],
		'checkout_form_action' => BASE . '/Page/payment.html'
	);
	
	$display_template = $Smarty->load_template($params,'checkout');
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_checkout() {
	?>
	<h3>What does this do?</h3>
	<p>This plugin handles the entire checkout process.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{checkout}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(none)</em></li>
	</ul>
	<?php
}

function smarty_about_function_checkout() {
	?>
	<p>Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>
	<p>Version: 0.1</p>
	<p>
	Change History:<br/>
	None
	</p>
	<?php
}
?>