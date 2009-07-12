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

echo $admin->StartTabs();
		echo $admin->CreateTab('main');
		echo $admin->CreateTab('options');			
echo $admin->EndTabs();

echo $admin->StartTabContent('main');
echo '<table class="pagetable" cellspacing="0">';

echo $html->tableHeaders(array(  __('Order Id', true), __('# of Products', true), __('Date Placed', true)));

foreach($data AS $order)
{
	echo $admin->TableCells(
		  array(
			$html->link($order['Order']['id'],'/module_abandoned_carts/admin/admin_manage/' . $order['Order']['id']),
			count($order['OrderProduct']),
			$time->niceShort($order['Order']['created'])
		   ));
}

echo '</table>';
echo $admin->EmptyResults($data);

echo $admin->EndTabContent();
echo $admin->StartTabContent('options');

	echo '<fieldset>';
		echo $html->link('Click here to purge all Abandoned Carts','/module_abandoned_carts/admin/purge_old_carts/',null,'Are you sure?');
	echo '</fieldset>';
	
echo $admin->EndTabContent();

?>