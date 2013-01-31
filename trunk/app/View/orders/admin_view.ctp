<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/plugins/jquery-ui-min.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $html->css('ui.tabs', null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'view.png');

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('customer',__('Customer', true), 'customer.png');
			echo $admin->CreateTab('order',__('Products', true), 'products.png');	
			echo $admin->CreateTab('comments',__('Order Comments', true), 'comment.png');
			echo $admin->CreateTab('status',__('New Comment', true), 'comment_add.png');	
			echo '</ul>';

		   		   
	echo $admin->StartTabContent('customer');

echo '
<table class="orderTable">
	<tr><td width="50%">';

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
				__('Country',true) . ': ' . $data['Order']['bill_country']
		   ));
	echo $admin->TableCells(
		  array(
				__('Zip',true) . ': ' . $data['Order']['bill_zip']
		   ));
echo '</table>';

echo '</td><td width="50%">';

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
				__('Country',true) . ': ' . $data['Order']['ship_country']
		   ));
	echo $admin->TableCells(
		  array(
				__('Zip',true) . ': ' . $data['Order']['ship_zip']
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
	echo $admin->TableCells(
		  array(
				__('Company',true) . ': ' . $data['Order']['company_name']
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
echo $html->tableHeaders(array( __('Product Name', true), __('Model', true), __('Price', true), __('Quantity', true), __('Total', true)));
foreach($data['OrderProduct'] AS $product) 
{
	echo $admin->TableCells(
		  array(
				$product['name'],
				$product['model'],
				$product['price'],
				$product['quantity'],
				$product['quantity']*$product['price']
		   ));
}

	echo $admin->TableCells(
		  array(
		  		'<strong>' . $data['ShippingMethod']['name'] . ' ' . '</strong>',
				$data['ShippingMethod']['code'],
				$data['Order']['shipping'],
				'1',
				$data['Order']['shipping']					
		  ));
	echo $admin->TableCells(
		  array(
		  		'<strong>' . __('Order Total',true) . '</strong>',
				'&nbsp;',
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
				$time->timeAgoInWords($comment['created']),
				($comment['sent_to_customer'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))),
				$comment['comment']
		   ));
}
echo '</table>';

	echo $admin->EndTabContent();

	echo $admin->StartTabContent('status');

echo $form->create('OrderComment', array('id' => 'contentform', 'action' => '/orders/admin_new_comment/', 'url' => '/orders/admin_new_comment/'));

	echo $form->inputs(array(
			'legend' => null,
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

	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit', 'id' => 'submit'));
	echo '<div class="clear"></div>';
	echo $form->end();

	echo $admin->EndTabs();
	
	echo $admin->ShowPageHeaderEnd();
	
?>