<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('jquery/plugins/jquery-ui.min', false);
	echo $javascript->link('tabs', false);
	echo $html->css('jquery/plugins/ui/css/smoothness/jquery-ui','','', false);

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('customer',__('Customer', true));
			echo $admin->CreateTab('order',__('Products', true));	
			echo $admin->CreateTab('comments',__('Order Comments', true));
			echo $admin->CreateTab('status',__('New Comment', true));	
			echo '</ul>';

		   		   
	echo $admin->StartTabContent('customer');

echo '
<table class="orderTable">
	<tr><td width="50%">';

echo '<table class="contentTable">';
echo $html->tableHeaders(array(__('Shipping Information',true)));
	echo $admin->TableCells(
		  array(
				__('Customer Name',true) . ': ' . $data['Order']['ship_name']
		   ));
	echo $admin->TableCells(
		  array(
				__('Address Line 1',true) . ': ' . $data['Order']['ship_line_1']
		   ));
	echo $admin->TableCells(
		  array(
				__('Address Line 2',true) . ': ' . $data['Order']['ship_line_2']
		   ));
	echo $admin->TableCells(
		  array(
				__('City',true) . ': ' . $data['Order']['ship_city']
		   ));
	echo $admin->TableCells(
		  array(
				__('State',true) . ': ' . $data['Order']['ship_state']
		   ));
	echo $admin->TableCells(
		  array(
				__('Zip',true) . ': ' . $data['Order']['ship_zip']
		   ));
echo '</table>';

echo '</td><td width="50%">';

echo '<table class="contentTable">';
echo $html->tableHeaders(array(__('Billing Information',true)));
	echo $admin->TableCells(
		  array(
				__('Customer Name',true) . ': ' . $data['Order']['bill_name']
		   ));
	echo $admin->TableCells(
		  array(
				__('Address Line 1',true) . ': ' . $data['Order']['bill_line_1']
		   ));
	echo $admin->TableCells(
		  array(
				__('Address Line 2',true) . ': ' . $data['Order']['bill_line_2']
		   ));
	echo $admin->TableCells(
		  array(
				__('City',true) . ': ' . $data['Order']['bill_city']
		   ));
	echo $admin->TableCells(
		  array(
				__('State',true) . ': ' . $data['Order']['bill_state']
		   ));
	echo $admin->TableCells(
		  array(
				__('Zip',true) . ': ' . $data['Order']['bill_zip']
		   ));
echo '</table>';

echo '</td></tr>';
echo '<tr><td colspan="2">';

echo '<table class="contentTable">';
echo $html->tableHeaders(array(__('Contact Information',true)));
	echo $admin->TableCells(
		  array(
				__('Email',true) . ': ' . $data['Order']['email']
		   ));
	echo $admin->TableCells(
		  array(
				__('Phone',true) . ': ' . $data['Order']['phone']
		   ));
echo '</table>';

echo '</td></tr>';
echo '<tr><td colspan="2">';

echo '<table class="contentTable">';
echo $html->tableHeaders(array(__('Payment Information',true)));
	echo $admin->TableCells(
		  array(
				__('Credit Card',true) . ': ' . $data['Order']['cc_number']
		   ));
	echo $admin->TableCells(
		  array(
				__('Expiration',true) . ': ' . $data['Order']['cc_expiration_month'] . '-' . $data['Order']['cc_expiration_year']
		   ));
echo '</table>';

echo '</td></tr>';
echo '</table>';

	echo $admin->EndTabContent();

	echo $admin->StartTabContent('order');

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Product Name', true), __('Price', true), __('Quantity', true), __('Total', true)));
foreach($data['OrderProduct'] AS $product) 
{
	echo $admin->TableCells(
		  array(
				$product['name'],
				$product['price'],
				$product['quantity'],
				$product['quantity']*$product['price']
		   ));
}

	echo $admin->TableCells(
		  array(
		  		'<strong>' . $data['ShippingMethod']['name'] . ' ' . '</strong>',
				$data['Order']['shipping'],
				'1',
				$data['Order']['shipping']					
		  ));
	echo $admin->TableCells(
		  array(
		  		'<strong>' . __('Order Total',true) . '</strong>',
				'&nbsp;',
				'&nbsp;',
				'<strong>' . $data['Order']['total'] .'</strong>'
		  ));		  
echo '</table>';


	echo $admin->EndTabContent();

	echo $admin->StartTabContent('comments');

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Date', true), __('Sent To Customer', true), __('Comment', true)));

foreach($data['OrderComment'] AS $comment) 
{
	echo $admin->TableCells(
		  array(
				$comment['created'],
				($comment['sent_to_customer'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))),
				$comment['comment']
		   ));
}
echo '</table>';

	echo $admin->EndTabContent();

	echo $admin->StartTabContent('status');

echo $form->create('OrderComment', array('id' => 'contentform', 'action' => '/orders/admin_new_comment/', 'url' => '/orders/admin_new_comment/'));

	echo $form->inputs(array(
			'Order.id' => array(
				'type' => 'hidden',
				'value' => $data['Order']['id']
			),	
			'Order.order_status_id' => array(
				'type' => 'select',
				'options' => $order_status_list,
				'selected' => $data['Order']['order_status_id'],
				'label' => __('Update Status',true)
			),
			'OrderComment.order_id' => array(
				'type' => 'hidden',
				'value' => $data['Order']['id']
			),				
			'OrderComment.user_id' => array(
				'type' => 'hidden',
				'value' => $_SESSION['User']['id']
			),	
			'OrderComment.sent_to_customer' => array(
				'type' => 'checkbox',
				'label' => __('Send To Customer',true),
				'class' => 'checkbox_group'
			)									,
			'OrderComment.comment' => array(
				'type' => 'textarea',
				'label' => __('Comment',true),
				'class' => 'pagesmallesttextarea'
			)
		));

echo $form->submit( __('Submit', true), array('name' => 'submit', 'id' => 'submit'));
echo '<div class="clear"></div>';
echo $form->end();

	echo $admin->EndTabs();
	
?>