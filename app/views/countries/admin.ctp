<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $javascript->link('jquery/jquery.min', false);
echo $javascript->link('jquery/plugins/jquery-ui.min', false);
echo $javascript->link('selectall', false);

$paginator->options(array('update' => 'content', 'url' => '/countries/admin/', 'indicator' => 'spinner')); 

echo $admin->ShowPageHeaderStart($current_crumb, 'countries.png');

echo $form->create('Country', array('action' => '/countries/admin_modify_selected/', 'url' => '/countries/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Flag', true), __('Code', true) . ' 2', __('Code', true) . ' 3', __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $country)
{
	echo $admin->TableCells(
		  array(
			$html->link(__($country['Country']['name'],true),'/country_zones/admin/' . $country['Country']['id']),
			array($html->link($html->image('flags/' . strtolower($country['Country']['iso_code_2']) . '.png', array('alt' => $country['Country']['name'])), '/countries/admin_edit/' . $country['Country']['id'],null,null,false), array('align'=>'center')),
			array($country['Country']['iso_code_2'], array('align'=>'center')),
			array($country['Country']['iso_code_3'], array('align'=>'center')),
			array($admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'],__('Edit', true)) . $admin->ActionButton('delete','/countries/admin_delete/' . $country['Country']['id'],__('Delete', true)), array('align'=>'center')),
			array($form->checkbox('modify][', array('value' => $country['Country']['id'])), array('align'=>'center'))
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

<?php echo $admin->ShowPageHeaderEnd(); ?>