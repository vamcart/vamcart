<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_my_orders()
{
$template = '
{if !$orders}
{lang}Orders Not Found!{/lang}
{else}
{foreach from=$orders item=order}

<ul id="myTab{$order.Order.id}" class="nav nav-tabs">
	<li><a href ="#customer{$order.Order.id}" data-toggle="tab"><i class="fa fa-user"></i> {lang}Customer{/lang}</a></li>
	<li><a href ="#order{$order.Order.id}" data-toggle="tab"><i class="fa fa-shopping-cart"></i> {lang}Products{/lang}</a></li>
	<li><a href ="#comments{$order.Order.id}" data-toggle="tab"><i class="fa fa-comment-o"></i> {lang}Order Comments{/lang}</a></li>
</ul>

<div id="myTabContent{$order.Order.id}" class="tab-content">

	<div id="customer{$order.Order.id}" class="tab-pane fade in active">

		<table class="table">
		  <thead>
		  <tr>
			<th>{lang}Order number{/lang}: {$order.Order.id}</th>
			<th>{payment_after order_id={$order.Order.id}}</th>
			</tr>
		  </thead>
		  <tbody>
			<tr><td>
			<table class="table table-striped table-hover">
				<thead><tr><th>{lang}Billing Information{/lang}</th></tr></thead>
				<tbody>
					<tr><td>{lang}Name{/lang}: {$order.Order.bill_name}</td></tr>
					{if {$display_address_field} == "1"}<tr><td>{lang}Address Line 1{/lang}: {$order.Order.bill_line_1}</td></tr>{/if}
					{if {$display_address_1_field} == "1"}<tr><td>{lang}Address Line 2{/lang}: {$order.Order.bill_line_2}</td></tr>{/if}
					{if {$display_city_field} == "1"}<tr><td>{lang}City{/lang}: {$order.Order.bill_city}</td></tr>{/if}
					{if {$display_state_field} == "1"}<tr><td>{lang}State{/lang}: {lang domain="default"}{$order.BillState.name}{/lang}</td></tr>{/if}
					{if {$display_country_field} == "1"}<tr><td>{lang}Country{/lang}: {lang domain="default"}{$order.BillCountry.name}{/lang}</td></tr>{/if}
					{if {$display_postcode_field} == "1"}<tr><td>{lang}Zipcode{/lang}: {$order.Order.bill_zip}</td></tr>{/if}
				</tbody>
			</table>
			</td><td>
			<table class="table table-striped table-hover">
				<thead><tr><th>{lang}Shipping Information{/lang}</th></tr></thead>
				<tbody>
					<tr><td>{lang}Name{/lang}: {$order.Order.ship_name}</td></tr>
					{if {$display_address_field} == "1"}<tr><td>{lang}Address Line 1{/lang}: {$order.Order.ship_line_1}</td></tr>{/if}
					{if {$display_address_1_field} == "1"}<tr><td>{lang}Address Line 2{/lang}: {$order.Order.ship_line_2}</td></tr>{/if}
					{if {$display_city_field} == "1"}<tr><td>{lang}City{/lang}: {$order.Order.ship_city}</td></tr>{/if}
					{if {$display_state_field} == "1"}<tr><td>{lang}State{/lang}: {lang domain="default"}{$order.ShipState.name}{/lang}</td></tr>{/if}
					{if {$display_country_field} == "1"}<tr><td>{lang}Country{/lang}: {lang domain="default"}{$order.ShipCountry.name}{/lang}</td></tr>{/if}
					{if {$display_postcode_field} == "1"}<tr><td>{lang}Zipcode{/lang}: {$order.Order.ship_zip}</td></tr>{/if}
				</tbody>
			</table>
		
				</td></tr>

				<tr><td colspan="2">
		
				<table class="table table-striped table-hover">
					<thead><tr><th>{lang}Order Status{/lang}</th></tr></thead>
					<tbody>
						<tr><td>{$order.OrderStatus.OrderStatusDescription.name}</td></tr>
					</tbody>
				</table>
		
				</td></tr>

				<tr><td colspan="2">
		
				<table class="table table-striped table-hover">
					<thead><tr><th>{lang}Contact Information{/lang}</th></tr></thead>
					<tbody>
						<tr><td>{lang}Email{/lang}: {$order.Order.email}</td></tr>
						<tr><td>{lang}Phone{/lang}: {$order.Order.phone}</td></tr>
						<tr><td>{lang}Company{/lang}: {$order.Order.company_name}</td></tr>
					</tbody>
				</table>
		
				</td></tr>

				<tr>
				
				<td>
		
				<table class="table table-striped table-hover">
					<thead><tr><th>{lang}Payment Method{/lang}</th></tr></thead>
					<tbody>
						<tr><td>{lang}{$order.PaymentMethod.name}{/lang}</td></tr>
					</tbody>
				</table>
		
				</td>

				<td>
		
				<table class="table table-striped table-hover">
					<thead><tr><th>{lang}Shipping Method{/lang}</th></tr></thead>
					<tbody>
						<tr><td>{lang}{$order.ShippingMethod.name}{/lang}</td></tr>
					</tbody>
				</table>
		
				</td>
				
				</tr>
    </tbody>
		</table>
		
	</div>
	
	<div id="order{$order.Order.id}" class="tab-pane fade">

		<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th>{lang}Product{/lang}</th>
			<th>{lang}Model{/lang}</th>
			<th>{lang}Price{/lang}</th>
			<th>{lang}Quantity{/lang}</th>
			<th>{lang}Total{/lang}</th>
		</tr>
		</thead>
    <tbody>
		{foreach from=$order.OrderProduct item=products}
		<tr>
			<td>{$products.name} {if $products.filename != ""} - <a href="{$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order.Order.id}/{$products.id}/{$products.download_key}"><span class="label label-success">{lang}Download file{/lang}</span></a>{/if}</td>
			<td>{$products.model}</td>
			<td>{$products.price}</td>
			<td>{$products.quantity}</td>
			<td>{$products.quantity*$products.price}</td>
		</tr>
		{/foreach}
		<tr>
			<td><strong>{lang}{$order.ShippingMethod.name}{/lang}</strong></td>
			<td></td>
			<td>{$order.Order.shipping}</td>
			<td>1</td>
			<td>{$order.Order.shipping}</td>					
		</tr>
		{if $order.Order.tax > 0}
		<tr>
			<td colspan="3">&nbsp;</td>
			<td><strong>{lang}Tax{/lang}</strong></td>
			<td><strong>{$order.Order.tax}</strong></td>
		</tr>
		{/if}
		<tr>
			<td colspan="3">&nbsp;</td>
			<td><strong>{lang}Order Total{/lang}</strong></td>
			<td><strong>{$order.Order.total}</strong></td>
		</tr>
    <tbody>
		</table>
		
	</div>

	<div id="comments{$order.Order.id}" class="tab-pane fade">

		<table class="table table-striped table-hover">
		<thead>
		<tr>
		<th>{lang}Date{/lang}</th>
		<th>{lang}Sent To Customer{/lang}</th>
		<th>{lang}Comment{/lang}</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$order.OrderComment item=comments}
		<tr>
		<td>{$comments.created}</td>
		<td>{$comments.sent_to_customer}</td>
		<td><pre>{$comments.comment}</pre></td>
		</tr>
		{/foreach}
		</tbody>
		</table>
	
	</div>
	
</div>

<hr>
<script type="text/javascript">
$(document).ready(function () {

$("#myTab{$order.Order.id} a:first").tab("show"); // Select first tab	
	
});
</script>
{/foreach}
{/if}
';

return $template;
}


function smarty_function_my_orders($params, $template)
{
	if (!isset($_SESSION['Customer']['customer_id']) or $_SESSION['Customer']['customer_id'] == 0) {
		return;
	}

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Order');
	$Order = new Order();

		$Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'OrderStatusDescription.language_id = ' . $_SESSION['Customer']['language_id']
                )
            )
           	)
	    );			

	$order_data = $Order->find('all', array('recursive' => 2, 'conditions' => array('Order.customer_id' => $_SESSION['Customer']['customer_id'], 'Order.order_status_id >' => '0'), 'order' => 'Order.id DESC'));

	global $config;

	$display_template = $Smarty->load_template($params, 'my_orders');
	$assignments = array(
		'orders' => $order_data,
		'display_address_field' => $config['CHECKOUT_DISPLAY_ADDRESS_FIELD'],
		'display_address_1_field' => $config['CHECKOUT_DISPLAY_ADDRESS_1_FIELD'],
		'display_city_field' => $config['CHECKOUT_DISPLAY_CITY_FIELD'],
		'display_postcode_field' => $config['CHECKOUT_DISPLAY_POSTCODE_FIELD'],
		'display_country_field' => $config['CHECKOUT_DISPLAY_COUNTRY_FIELD'],
		'display_state_field' => $config['CHECKOUT_DISPLAY_STATE_FIELD'],
		'display_shipping_info_block' => $config['CHECKOUT_DISPLAY_SHIPPING_INFO_BLOCK'],
		'display_email_field' => $config['CHECKOUT_DISPLAY_EMAIL_FIELD'],
		'display_comments_field' => $config['CHECKOUT_DISPLAY_COMMENTS_FIELD'],
		'display_shipping_methods_block' => $config['CHECKOUT_DISPLAY_SHIPPING_METHODS_BLOCK'],
		'display_payment_methods_block' => $config['CHECKOUT_DISPLAY_PAYMENT_METHODS_BLOCK']
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_my_orders() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays orders page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{my_orders}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_my_orders() {
}
