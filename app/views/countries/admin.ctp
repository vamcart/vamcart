<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

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