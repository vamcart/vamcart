<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function default_template_shopping_cart()
{
$template = '
<div class="cart">
	<table style="width:100%;">
		<tr>	
			<th> </th>
			<th>{lang}Product{/lang}</th>
			<th>{lang}Price Ea.{/lang}</th>
			<th>{lang}Qty{/lang}</th>
			<th>{lang}Total{/lang}</th>
		</tr>
				
		{foreach from=$order_items item=product}			
			<tr>
				<td><a href="{base_path}/cart/remove_product/{$product.id}" class="remove">x</a></td>
				<td><a href="{$product.link}">{$product.name}</a></td>
				<td>{$product.price}</td>
				<td>{$product.qty}</td>
				<td>{$product.line_total}</td>
			</tr>				
		{foreachelse}	
			<tr>
				<td colspan="5">{lang}No Cart Items{/lang}</td>
			</tr>
		{/foreach}				
				
		<tr class="cart_total">
			<td colspan="5">
				{lang}Shipping{/lang}: {$shipping_total}<br />
				<strong>{lang}Total{/lang}:</strong> {$order_total}
			</td>
		</tr>
	</table>
	<a class="checkout" href="{$checkout_link}">{lang}Checkout{/lang}</a>
</div>
';		

return $template;
}


function smarty_function_shopping_cart($params, $template)
{
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();
	
	App::import('Component', 'OrderBase');
		$OrderBase =& new OrderBaseComponent();		
	
	App::import('Component', 'CurrencyBase');
		$CurrencyBase =& new CurrencyBaseComponent();		
		
	global $order;		
	global $config;
	
	
	$order_items = array();
	if(!isset($order['OrderProduct']))
	{
		// Quit if we passed the param and the cart is empty
		if((!isset($params['showempty']))||($params['showempty'] == false))
			return;

		$order['Order']['total'] = 0;
		$order['OrderProduct'] = array();
	}
		
	foreach($order['OrderProduct'] AS $cart_item)
	{
		$content_id = $cart_item['content_id'];
		$order_items[$content_id] = array('id' => $cart_item['content_id'],
										  'link' => BASE . '/product/' . $content_id . $config['URL_EXTENSION'],
										  'name' => $cart_item['name'],
										  'price' => $CurrencyBase->display_price($cart_item['price']),
										  'qty' => $cart_item['quantity'],
										  'url' => BASE . '/product/' . $cart_item['content_id'] . $config['URL_EXTENSION'],										  
										  'line_total' => $CurrencyBase->display_price($cart_item['quantity']*$cart_item['price']));

	}	
	
	$assignments = array('checkout_link' => BASE . '/page/checkout' . $config['URL_EXTENSION'],
						 'order_total' => $CurrencyBase->display_price($order['Order']['total']),
						 'shipping_total' => $CurrencyBase->display_price($order['Order']['shipping']),
						 'order_items' => $order_items,
						 'cart_link' => BASE . '/page/cart-contents' . $config['URL_EXTENSION']
						 );								 

	$display_template = $Smarty->load_template($params,'shopping_cart');
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_shopping_cart() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a more detailed version of the user\'s cart.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{shopping_cart}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
		<li><em><?php echo __('(showempty)') ?></em> - <?php echo __('(true or false) If set to false does not display the cart if the user has not added any items.  Defaults to false.') ?></li>		
	</ul>
	<?php
}

function smarty_about_function_shopping_cart() {
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