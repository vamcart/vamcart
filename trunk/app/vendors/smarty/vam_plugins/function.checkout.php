<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.ru
   http://vamshop.com
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function default_template_checkout ()
{
$template = '
<div id="checkout">
<form action="{$checkout_form_action}" method="post">
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
	<div id="ship_information">
		<div>
			<h3>{lang}Shipping Information{/lang}</h3>
		</div>
		<div>	
			<label>{lang}Name{/lang}</label>
			<input type="text" name="ship_name" value="{$order.ship_name}" />
		</div>
		<div>	
			<label>{lang}Address Line 1{/lang}</label>
			<input type="text" name="ship_line_1" value="{$order.ship_line_1}" />
		</div>		
		<div>	
			<label>{lang}Address Line 1{/lang}</label>
			<input type="text" name="ship_line_2" value="{$order.ship_line_2}" />
		</div>		
		<div>	
			<label>{lang}City{/lang}</label>
			<input type="text" name="ship_city" value="{$order.ship_city}" />
		</div>		
		<div>	
			<label>{lang}State{/lang}</label>
			<input type="text" name="ship_state" value="{$order.ship_state}" />
		</div>		
		<div>	
			<label>{lang}Zipcode{/lang}</label>
			<input type="text" name="ship_zip" value="{$order.ship_zip}" />
		</div>								
	</div>
	<div id="bill_information">
		<div>
			<h3>{lang}Billing Information{/lang}</h3>
		</div>
		<div>	
			<label>{lang}Name{/lang}</label>
			<input type="text" name="bill_name" value="{$order.bill_name}"/>
		</div>
		<div>	
			<label>{lang}Address Line 1{/lang}</label>
			<input type="text" name="bill_line_1" value="{$order.bill_line_1}" />
		</div>		
		<div>	
			<label>{lang}Address Line 2{/lang}</label>
			<input type="text" name="bill_line_2" value="{$order.bill_line_2}" />
		</div>		
		<div>	
			<label>{lang}City{/lang}</label>
			<input type="text" name="bill_city" value="{$order.bill_city}" />
		</div>		
		<div>	
			<label>{lang}State{/lang}</label>
			<input type="text" name="bill_state" value="{$order.bill_state}" />
		</div>		
		<div>	
			<label>{lang}Zipcode{/lang}</label>
			<input type="text" name="bill_zip" value="{$order.bill_zip}" />
		</div>	
	</div>		
	<div id="contact_information">
		<div>
			<h3>{lang}Contact Information{/lang}</h3>
		</div>
		<div>	
			<label>{lang}Email{/lang}</label>
			<input type="text" name="email" value="{$order.email}" />
		</div>
		<div>	
			<label>{lang}Phone{/lang}</label>
			<input type="text" name="phone" value="{$order.phone}" />
		</div>		
	</div>
	<div>
	{module alias="coupons" action="checkout_box"}
	</div>
	<span class="button"><button type="submit" value="{lang}Continue{/lang}">{lang}Continue{/lang}</button></span>
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
	$active_ship_methods = $ShippingMethod->find('all', array('conditions' => array('active' => '1'),'order' => array('order')));

	$keyed_ship_methods = array();
	foreach($active_ship_methods AS $method)
	{
		$shipping = Inflector::classify($method['ShippingMethod']['code']);
		$shipping_controller =  Inflector::classify($method['ShippingMethod']['code']) . 'Controller';
		App::import('Controller', 'shipping.'.$shipping);
		$MethodBase =& new $shipping_controller();
		
		$ship_method_id = $method['ShippingMethod']['id'];
		$keyed_ship_methods[$ship_method_id] = array(
										  'id' => $ship_method_id,
										  'name' => $method['ShippingMethod']['name'],
										  'cost' => $CurrencyBase->display_price($MethodBase->calculate())
										  );

	}	
	
	// Assign the payment methods
	$active_payment_methods = $PaymentMethod->find('all', array('conditions' => array('active' => '1'),'order' => array('order')));

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
		

	global $config;

	$assignments = array(
		'ship_methods' => $keyed_ship_methods,
		'payment_methods' => $keyed_payment_methods,
		'order' => $order['Order'],
		'checkout_form_action' => BASE . '/page/payment' . $config['URL_EXTENSION']
	);
	
	$display_template = $Smarty->load_template($params,'checkout');
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_checkout() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('This plugin handles the entire checkout process.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{checkout}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_checkout() {
	?>
	<p><?php echo __('Author: Kevin Grandon &lt;kevingrandon@hotmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>