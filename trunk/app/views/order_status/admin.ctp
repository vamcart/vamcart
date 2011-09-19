<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'order-status.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Default', true),  __('Order', true), __('Action', true)));

foreach ($order_status_data AS $order_status)
{
	echo $admin->TableCells(
		  array(
				$html->link($order_status['OrderStatusDescription']['name'], '/order_status/admin_edit/' . $order_status['OrderStatus']['id']),
				array($admin->DefaultButton($order_status['OrderStatus']), array('align'=>'center')),
				array($admin->MoveButtons($order_status['OrderStatus'], $order_status_count), array('align'=>'center')),
				array($admin->ActionButton('edit','/order_status/admin_edit/' . $order_status['OrderStatus']['id'],__('Edit', true)) . $admin->ActionButton('delete','/order_status/admin_delete/' . $order_status['OrderStatus']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $admin->CreateNewLink();

echo $admin->ShowPageHeaderEnd();

?>