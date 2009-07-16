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

echo '<h3>' . __('Customer Details', true) . '</h3>';
echo '
<table class="orderTable">
	<tr><td>
		<strong>' . __('Billing Information',true) . '</strong><br />	
		' . __('Customer Name',true) . ': ' . $data['Order']['bill_name'] . '<br />
		' . __('Address Line 1',true) . ': ' . $data['Order']['bill_line_1'] . '<br />
		' . __('Address Line 2',true) . ': ' . $data['Order']['bill_line_2'] . '<br />
		' . __('City',true) . ': ' . $data['Order']['bill_city'] . '<br />
		' . __('State',true) . ': ' . $data['Order']['bill_state'] . '<br />
		' . __('Zip',true) . ': ' . $data['Order']['bill_zip'] . '
	</td><td>
		<strong>' . __('Shipping Information',true) . '</strong><br />			
		' . __('Customer Name',true) . ': ' . $data['Order']['ship_name'] . '<br />
		' . __('Address Line 1',true) . ': ' . $data['Order']['ship_line_1'] . '<br />
		' . __('Address Line 2',true) . ': ' . $data['Order']['ship_line_2'] . '<br />
		' . __('City',true) . ': ' . $data['Order']['ship_city'] . '<br />
		' . __('State',true) . ': ' . $data['Order']['ship_state'] . '<br />
		' . __('Zip',true) . ': ' . $data['Order']['ship_zip'] . '
	</td></tr>
	<tr><td colspan="2">
		<strong>' . __('Contact Information',true) . '</strong><br />				
		' . __('Email',true) . ': ' . $data['Order']['email'] . '<br />
		' . __('Phone',true) . ': ' . $data['Order']['phone'] . '		
	</td></tr>
	<tr><td colspan="2">
		<strong>' . __('Payment Information',true) . '</strong><br />				
		' . __('Credit Card',true) . ': ' . $data['Order']['cc_number'] . '<br />
		' . __('Expiration',true) . ': ' . $data['Order']['cc_expiration_month'] . '-' . $data['Order']['cc_expiration_year'] . '
	</td></tr>
	
</table>';

echo '<h3>' . __('Order Details', true) . '</h3>';

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





echo '<h3>' . __('Order Comments', true) . '</h3>';
echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Date', true), __('User', true), __('Sent To Customer', true), __('Comment', true)));

foreach($data['OrderComment'] AS $comment) 
{
	echo $admin->TableCells(
		  array(
				$time->niceShort($comment['created']),
				$comment['User']['username'],
				($comment['sent_to_customer'] == 1?$html->image('admin/icons/true.png'):$html->image('admin/icons/false.png')),
				$comment['comment']
		   ));
}
echo '</table>';

echo '<h3>' . __('New Comment', true) . '</h3>';

echo $form->create('OrderComment', array('action' => '/orders/admin_new_comment/', 'url' => '/orders/admin_new_comment/'));

	echo $form->inputs(array(
			'Order/id' => array(
				'type' => 'hidden',
				'value' => $data['Order']['id']
			),	
			'Order/order_status_id' => array(
				'type' => 'select',
				'options' => $order_status_list,
				'selected' => $data['Order']['order_status_id'],
				'label' => __('Update Status',true)
			),
			'OrderComment/order_id' => array(
				'type' => 'hidden',
				'value' => $data['Order']['id']
			),				
			'OrderComment/user_id' => array(
				'type' => 'hidden',
				'value' => $_SESSION['User']['id']
			),	
			'OrderComment/sent_to_customer' => array(
				'type' => 'checkbox',
				'label' => __('Send To Customer',true),
				'class' => 'checkbox_group'
			)									,
			'OrderComment/comment' => array(
				'type' => 'textarea',
				'label' => __('Comment',true),
				'class' => 'pagesmallesttextarea'
			)
		));

echo $form->submit( __('Submit', true), array('name' => 'submit', 'id' => 'submit'));
echo '<div class="clear"></div>';
echo $form->end();
	
?>