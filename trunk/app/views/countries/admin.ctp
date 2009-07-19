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


$paginator->options(array('update' => 'content', 'url' => '/countries/admin/', 'indicator' => 'spinner')); 

echo $form->create('Country', array('action' => '/countries/admin_modify_selected/', 'url' => '/countries/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), '&nbsp;', __('Code', true) . ' 2', __('Code', true) . ' 3', __('Action', true), '&nbsp;'));

foreach ($data AS $country)
{
	echo $admin->TableCells(
		  array(
			$html->link($country['Country']['name'],'/country_zones/admin/' . $country['Country']['id']),
			$html->link($html->image('flags/' . strtolower($country['Country']['iso_code_2']) . '.png', array('alt' => $country['Country']['name'])), '/countries/admin_edit/' . $country['Country']['id'],null,null,false),
			$country['Country']['iso_code_2'],
			$country['Country']['iso_code_3'],
			$admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'],__('Edit', true)) . $admin->ActionButton('delete','/countries/admin_delete/' . $country['Country']['id'],__('Delete', true)),
			$form->checkbox('modify][', array('value' => $country['Country']['id']))
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('delete'=>__('Delete',true)));
echo $form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $paginator->prev(__('<< Previous', true)); ?></td>
		<td>&nbsp;<?php echo $paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $paginator->next(__('Next >>', true)); ?></td>
	</tr>
</table>