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


echo $form->create('Order', array('action' => '/orders/admin_modify_selected/', 'url' => '/orders/admin_modify_selected/'));

echo '<table class="pagetable" cellspacing="0">';

echo $html->tableHeaders(array(__('name', true), __('status', true), __('action', true)));

foreach ($data AS $order)
{
	echo $admin->TableCells(
		  array(
				$html->link($time->niceShort($order['Order']['created']) . ' - ' . $order['Order']['bill_name'],'/orders/admin_view/' . $order['Order']['id']),
				$order['OrderStatus']['OrderStatusDescription']['name'],
				$admin->ActionButton('edit','/orders/admin_view/' . $order['Order']['id']) . $admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'])
		   ));
		   	
}
echo '</table>';
echo $admin->EmptyResults($data);

echo $paginator->prev();
echo $paginator->numbers(array('separator'=>' - '));
echo $paginator->next('Next Page'); 

echo $form->end();

?>