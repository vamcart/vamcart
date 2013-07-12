<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_my_orders()
{
$template = '
{if !$orders}
{lang}Orders Not Found!{/lang}
{else}
{foreach from=$orders item=order}
<div>{lang}Order number{/lang}: {$order.Order.id}</div>

<ul id="myTab{$order.Order.id}" class="nav nav-tabs">
	<li><a href ="#customer{$order.Order.id}" data-toggle="tab"><i class="cus-user"></i> {lang}Customer{/lang}</a></li>
	<li><a href ="#order{$order.Order.id}" data-toggle="tab"><i class="cus-cart"></i> {lang}Products{/lang}</a></li>
	<li><a href ="#comments{$order.Order.id}" data-toggle="tab"><i class="cus-comment"></i> {lang}Order Comments{/lang}</a></li>
</ul>

<div id="myTabContent{$order.Order.id}" class="tab-content">

	<div id="customer{$order.Order.id}" class="tab-pane fade in active">

		<table border=0 class="orderTable">
			<tr><td width="50%">
		
			<table border="0" class="contentTable">
				<tr><th>{lang}Billing Information{/lang}</th></tr>
					<tr><td>{lang}Name{/lang}: {$order.Order.bill_name}</td></tr>
					<tr><td>{lang}Address Line 1{/lang}: {$order.Order.bill_line_1}</td></tr>
					<tr><td>{lang}Address Line 2{/lang}: {$order.Order.bill_line_2}</td></tr>
					<tr><td>{lang}City{/lang}: {$order.Order.bill_city}</td></tr>
					<tr><td>{lang}State{/lang}: {$order.Order.bill_state}</td></tr>
					<tr><td>{lang}Country{/lang}: {$order.Order.bill_country}</td></tr>
					<tr><td>{lang}Zipcode{/lang}: {$order.Order.bill_zip}</td></tr>
			</table>
		
			</td><td width="50%">
		
			<table class="contentTable">
				<tr><th>{lang}Shipping Information{/lang}</th></tr>
					<tr><td>{lang}Name{/lang}: {$order.Order.ship_name}</td></tr>
					<tr><td>{lang}Address Line 1{/lang}: {$order.Order.ship_line_1}</td></tr>
					<tr><td>{lang}Address Line 2{/lang}: {$order.Order.ship_line_2}</td></tr>
					<tr><td>{lang}City{/lang}: {$order.Order.ship_city}</td></tr>
					<tr><td>{lang}State{/lang}: {$order.Order.ship_state}</td></tr>
					<tr><td>{lang}Country{/lang}: {$order.Order.ship_country}</td></tr>
					<tr><td>{lang}Zipcode{/lang}: {$order.Order.ship_zip}</td></tr>
			</table>
		
				</td></tr>

				<tr><td colspan="2">
		
				<table class="contentTable">
					<tr><th>{lang}Order Status{/lang}</th></tr>
						<tr><td>{$order.OrderStatus.OrderStatusDescription.name}</td></tr>
				</table>
		
				</td></tr>

				<tr><td colspan="2">
		
				<table class="contentTable">
					<tr><th>{lang}Contact Information{/lang}</th></tr>
						<tr><td>{lang}Email{/lang}: {$order.Order.email}</td></tr>
						<tr><td>{lang}Phone{/lang}: {$order.Order.phone}</td></tr>
						<tr><td>{lang}Company{/lang}: {$order.Order.company_name}</td></tr>
				</table>
		
				</td></tr>

				<tr>
				
				<td>
		
				<table class="contentTable">
					<tr><th>{lang}Payment Method{/lang}</th></tr>
						<tr><td>{$order.PaymentMethod.name}</td></tr>
				</table>
		
				</td>

				<td>
		
				<table class="contentTable">
					<tr><th>{lang}Shipping Method{/lang}</th></tr>
						<tr><td>{$order.ShippingMethod.name}</td></tr>
				</table>
		
				</td>
				
				</tr>

		</table>
		
	</div>
	
	<div id="order{$order.Order.id}" class="tab-pane fade">

		<table class="contentTable">
		<tr>
			<th>{lang}Product{/lang}</th>
			<th>{lang}Model{/lang}</th>
			<th>{lang}Price{/lang}</th>
			<th>{lang}Quantity{/lang}</th>
			<th>{lang}Total{/lang}</th>
		</tr>
		{foreach from=$order.OrderProduct item=products}
		<tr>
			<td>{$products.name}</td>
			<td>{$products.model}</td>
			<td>{$products.price}</td>
			<td>{$products.quantity}</td>
			<td>{$products.quantity*$products.price}</td>
		<tr>
		{/foreach}
		
		<tr>
			<td><strong>{$order.ShippingMethod.name}</strong></td>
			<td>{$order.ShippingMethod.code}</td>
			<td>{$order.Order.shipping}</td>
			<td>1</td>
			<td>{$order.Order.shipping}</td>					
		<tr>

		<tr>
			<td>{lang}Order Total{/lang}</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong>{$order.Order.total}</strong></td>
		<tr>

		</table>
		
	</div>

	<div id="comments{$order.Order.id}" class="tab-pane fade">

		<table class="contentTable">
		
		<tr>
		<th>{lang}Date{/lang}</th>
		<th>{lang}Sent To Customer{/lang}</th>
		<th>{lang}Comment{/lang}</th>
		</tr>
		
		{foreach from=$order.OrderComment item=comments}
		<tr>
		<td>{$comments.created}</td>
		<td>{$comments.sent_to_customer}</td>
		<td><pre>{$comments.comment}</pre></td>
		</tr>
		{/foreach}
		
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
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Order');
	$Order =& new Order();

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

	$order_data = $Order->find('all', array('recursive' => 2, 'conditions' => array('Order.customer_id' => $_SESSION['customer_id'], 'Order.order_status_id >' => '0'), 'order' => 'Order.id DESC'));

	$display_template = $Smarty->load_template($params, 'my_orders');
	$assignments = array(
		'orders' => $order_data,
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
