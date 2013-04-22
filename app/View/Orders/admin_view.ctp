<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('customer',__('Customer'), 'cus-user');
			echo $this->Admin->CreateTab('order',__('Products'), 'cus-cart');	
			echo $this->Admin->CreateTab('comments',__('Order Comments'), 'cus-comment');
			echo $this->Admin->CreateTab('status',__('New Comment'), 'cus-comment-add');	
			echo '</ul>';

	echo $this->Admin->StartTabs();
		   		   
	echo $this->Admin->StartTabContent('customer');

echo '
<table class="orderTable">
	<tr><td width="50%">';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Billing Information')));
	echo $this->Admin->TableCells(
		  array(
				__('Customer Name') . ': ' . $data['Order']['bill_name']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Address Line 1') . ': ' . $data['Order']['bill_line_1']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Address Line 2') . ': ' . $data['Order']['bill_line_2']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('City') . ': ' . $data['Order']['bill_city']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('State') . ': ' . $data['Order']['bill_state']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Country') . ': ' . $data['Order']['bill_country']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Zip') . ': ' . $data['Order']['bill_zip']
		   ));
echo '</table>';

echo '</td><td width="50%">';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Shipping Information')));
	echo $this->Admin->TableCells(
		  array(
				__('Customer Name') . ': ' . $data['Order']['ship_name']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Address Line 1') . ': ' . $data['Order']['ship_line_1']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Address Line 2') . ': ' . $data['Order']['ship_line_2']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('City') . ': ' . $data['Order']['ship_city']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('State') . ': ' . $data['Order']['ship_state']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Country') . ': ' . $data['Order']['ship_country']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Zip') . ': ' . $data['Order']['ship_zip']
		   ));
echo '</table>';

echo '</td></tr>';
echo '<tr><td colspan="2">';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Contact Information')));
	echo $this->Admin->TableCells(
		  array(
				__('Email') . ': ' . $data['Order']['email']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Phone') . ': ' . $data['Order']['phone']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Company') . ': ' . $data['Order']['company_name']
		   ));
echo '</table>';

echo '</td></tr>';
echo '<tr><td colspan="2">';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Payment Information')));
	echo $this->Admin->TableCells(
		  array(
				__('Credit Card') . ': ' . $data['Order']['cc_number']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Expiration') . ': ' . $data['Order']['cc_expiration_month'] . '-' . $data['Order']['cc_expiration_year']
		   ));
echo '</table>';

echo '</td></tr>';
echo '</table>';

	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('order');

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Product Name'), __('Model'), __('Price'), __('Quantity'), __('Total')));
foreach($data['OrderProduct'] AS $product) 
{
	echo $this->Admin->TableCells(
		  array(
				$product['name'],
				$product['model'],
				$product['price'],
				$product['quantity'],
				$product['quantity']*$product['price']
		   ));
}

	echo $this->Admin->TableCells(
		  array(
		  		'<strong>' . $data['ShippingMethod']['name'] . ' ' . '</strong>',
				$data['ShippingMethod']['code'],
				$data['Order']['shipping'],
				'1',
				$data['Order']['shipping']					
		  ));
	echo $this->Admin->TableCells(
		  array(
		  		'<strong>' . __('Order Total') . '</strong>',
				'&nbsp;',
				'&nbsp;',
				'&nbsp;',
				'<strong>' . $data['Order']['total'] .'</strong>'
		  ));		  
echo '</table>';


	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('comments');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Date'), __('Sent To Customer'), __('Comment')));

foreach($data['OrderComment'] AS $comment) 
{
	echo $this->Admin->TableCells(
		  array(
				$this->Time->timeAgoInWords($comment['created']),
				($comment['sent_to_customer'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False')))),
				$comment['comment']
		   ));
}
echo '</table>';

	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('status');

echo $this->Form->create('OrderComment', array('id' => 'contentform', 'action' => '/orders/admin_new_comment/', 'url' => '/orders/admin_new_comment/'));

	echo $this->Form->input('Order.id', 
			array(
				'type' => 'hidden',
				'value' => $data['Order']['id']
			));	
	echo $this->Form->input('Order.order_status_id', 
			array(
				'type' => 'select',
				'options' => $order_status_list,
				'selected' => $data['Order']['order_status_id'],
				'label' => __('Update Status')
			));
	echo $this->Form->input('OrderComment.order_id', 
			array(
				'type' => 'hidden',
				'value' => $data['Order']['id']
			));				
	echo $this->Form->input('OrderComment.user_id', 
			array(
				'type' => 'hidden',
				'value' => $_SESSION['User']['id']
			));	
	echo $this->Form->input('OrderComment.sent_to_customer', 
			array(
				'type' => 'checkbox',
				'label' => __('Send To Customer'),
				'class' => 'checkbox_group'
			));
	echo $this->Form->input('OrderComment.comment', 
			array(
				'type' => 'textarea',
				'label' => __('Comment'),
				'class' => 'pagesmallesttextarea'
			));

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit', 'id' => 'submit'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();

	echo $this->Admin->EndTabs();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>