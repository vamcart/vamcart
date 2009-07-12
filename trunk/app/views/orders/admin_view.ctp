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

echo '<h3>' . __('customer_details', true) . '</h3>';
echo '
<table class="ordertable">
	<tr><td>
		<strong>' . __('billing_information',true) . '</strong><br />	
		' . __('name',true) . ': ' . $data['Order']['bill_name'] . '<br />
		' . __('address_line1',true) . ': ' . $data['Order']['bill_line_1'] . '<br />
		' . __('address_line2',true) . ': ' . $data['Order']['bill_line_2'] . '<br />
		' . __('city',true) . ': ' . $data['Order']['bill_city'] . '<br />
		' . __('state',true) . ': ' . $data['Order']['bill_state'] . '<br />
		' . __('zip',true) . ': ' . $data['Order']['bill_zip'] . '
	</td><td>
		<strong>' . __('shipping_information',true) . '</strong><br />			
		' . __('name',true) . ': ' . $data['Order']['ship_name'] . '<br />
		' . __('address_line1',true) . ': ' . $data['Order']['ship_line_1'] . '<br />
		' . __('address_line2',true) . ': ' . $data['Order']['ship_line_2'] . '<br />
		' . __('city',true) . ': ' . $data['Order']['ship_city'] . '<br />
		' . __('state',true) . ': ' . $data['Order']['ship_state'] . '<br />
		' . __('zip',true) . ': ' . $data['Order']['ship_zip'] . '
	</td></tr>
	<tr><td colspan="2">
		<strong>' . __('contact_information',true) . '</strong><br />				
		' . __('email',true) . ': ' . $data['Order']['email'] . '<br />
		' . __('phone',true) . ': ' . $data['Order']['phone'] . '		
	</td></tr>
	<tr><td colspan="2">
		<strong>' . __('payment_information',true) . '</strong><br />				
		' . __('credit_card',true) . ': ' . $data['Order']['cc_number'] . '<br />
		' . __('expiration',true) . ': ' . $data['Order']['cc_expiration_month'] . '-' . $data['Order']['cc_expiration_year'] . '
	</td></tr>
	
</table>';

echo '<h3>' . __('order_details', true) . '</h3>';

echo '<table class="pagetable" cellspacing="0">';
echo $html->tableHeaders(array( __('table_heading_name', true), __('price', true), __('quantity', true), __('total', true)));
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
		  		'<strong>' . $data['ShippingMethod']['name'] . ' ' . __('shipping',true) . '</strong>',
				$data['Order']['shipping'],
				'1',
				$data['Order']['shipping']					
		  ));
	echo $admin->TableCells(
		  array(
		  		'<strong>' . __('total',true) . '</strong>',
				'&nbsp;',
				'&nbsp;',
				'<strong>' . $data['Order']['total'] .'</strong>'
		  ));		  
echo '</table>';





echo '<h3>' . __('order_comments', true) . '</h3>';
echo '<table class="pagetable" cellspacing="0">';

echo $html->tableHeaders(array( __('date', true), __('user', true), __('sent_to_customer', true), __('comment', true)));

foreach($data['OrderComment'] AS $comment) 
{
	echo $admin->TableCells(
		  array(
				$time->niceShort($comment['created']),
				$comment['User']['username'],
				($comment['sent_to_customer'] == 1?$html->image('admin/true.gif'):$html->image('admin/false.gif')),
				$comment['comment']
		   ));
}
echo '</table>';







echo '<h3>' . __('new_comment', true) . '</h3>';

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
				'label' => __('update_status',true)
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
				'label' => __('send_to_customer',true),
				'class' => 'checkbox_group'
			)									,
			'OrderComment/comment' => array(
				'type' => 'textarea',
				'class' => 'pagesmallesttextarea'
			)
		));



echo $form->submit( __('form_submit', true), array('name' => 'submit', 'id' => 'submit'));
echo '<div class="clearb"></div>';
echo $form->end();
	

?>