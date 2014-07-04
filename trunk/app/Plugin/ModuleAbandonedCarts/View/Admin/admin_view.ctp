<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-table');

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('order',__('Products'), 'cus-cart');	
			echo $this->Admin->CreateTab('customer',__('Order View'), 'cus-user');
			echo '</ul>';

	echo $this->Admin->StartTabs();
		   		 
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
				__('Zip') . ': ' . $data['Order']['bill_zip']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Country') . ': ' . __($data['BillCountry']['name'])
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('State') . ': ' . $data['BillState']['name']
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
				__('Zip') . ': ' . $data['Order']['ship_zip']
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('Country') . ': ' . __($data['ShipCountry']['name'])
		   ));
	echo $this->Admin->TableCells(
		  array(
				__('State') . ': ' . $data['ShipState']['name']
		   ));
echo '</table>';
echo '</td></tr>';

echo '<tr><td colspan="2">';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Contact Information')));
	echo $this->Admin->TableCells(
		  array(
				__('Order ID') . ': ' . $data['Order']['id']
		   ));
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

echo '<tr>';
echo '<td>';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Payment Method Details')));
	echo $this->Admin->TableCells(
		  array(
				__($data['PaymentMethod']['name'])
		   ));
echo '</table>';
echo '</td>';

echo '<td>';

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Shipping Method Details')));
	echo $this->Admin->TableCells(
		  array(
				__($data['ShippingMethod']['name'])
		   ));
echo '</table>';
echo '</td>';

echo '</tr>';

echo '</table>';

	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('comments');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Date'), __('Sent To Customer'), __('Comment')));

foreach($data['OrderComment'] AS $comment) 
{
	echo $this->Admin->TableCells(
		  array(
				$this->Time->i18nFormat($comment['created']),
				($comment['sent_to_customer'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))),
				'<pre>'.$comment['comment'].'</pre>'
		   ));
}
echo '</table>';

	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('status');

echo $this->Form->create('OrderComment', array('id' => 'contentform', 'name' => 'contentform', 'action' => '/orders/admin_new_comment/', 'url' => '/orders/admin_new_comment/'));

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
	echo $this->Form->input('Order.answer_template_id', 
			array(
				'type' => 'select',
				'options' => $answer_template_list,
				'label' => __('Answer Template'),
				'name' => 'menu',
				'empty' => __('Select'),
				'onclick' => 'var textarea = document.getElementById("comment"); textarea.value=document.contentform.menu.options[document.contentform.menu.selectedIndex].value;',
				'after' => ' '.$this->Html->link($this->Html->image("admin/icons/new.png", array('alt' => __('Add Answer Template'), 'title' => __('Add Answer Template'))),'/answer_template/admin/', array('escape' => false, 'target' => '_blank'))
			));
	echo $this->Form->input('OrderComment.comment', 
			array(
				'type' => 'textarea',
				'label' => __('Comment'),
				'class' => 'pagesmallesttextarea',
				'id' => 'comment'
			));
	echo $this->Form->input('OrderComment.sent_to_customer', 
			array(
				'type' => 'checkbox',
				'label' => __('Send To Customer'),
				'class' => 'checkbox_group'
			));
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit', 'id' => 'submit'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();

	echo $this->Admin->EndTabContent();

	echo $this->Admin->EndTabs();

	echo $this->Admin->ShowPageHeaderEnd();
	
?>