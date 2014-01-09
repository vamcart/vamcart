<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cart-edit');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Name'), __('Default'),  __('Order'), __('Action')));

foreach ($order_status_data AS $order_status)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($order_status['OrderStatusDescription']['name'], '/order_status/admin_edit/' . $order_status['OrderStatus']['id']),
				array($this->Admin->DefaultButton($order_status['OrderStatus']), array('align'=>'center')),
				array($this->Admin->MoveButtons($order_status['OrderStatus'], $order_status_count), array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/order_status/admin_edit/' . $order_status['OrderStatus']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/order_status/admin_delete/' . $order_status['OrderStatus']['id'],__('Delete')), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>