<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'selectall.js'
), array('inline' => false));

$paginator->options(array('update' => 'content', 'url' => '/geo_zones/admin/', 'indicator' => 'spinner')); 

echo $admin->ShowPageHeaderStart($current_crumb, '');

echo $form->create('GeoZone', array('action' => '/geo_zones/admin_modify_selected/', 'url' => '/geo_zones/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Description', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data as $geo_zone)
{
	echo $admin->TableCells(
		  array(
			$html->link(__($geo_zone['GeoZone']['name'], true),'/geo_zones/admin_zones_edit/' . $geo_zone['GeoZone']['id']),
			array($geo_zone['GeoZone']['description'], array('allign' => 'left', 'width' => '100%')),
			array($admin->ActionButton('edit','/geo_zones/admin_edit/' . $geo_zone['GeoZone']['id'],__('Edit', true)) . $admin->ActionButton('delete','/geo_zones/admin_delete/' . $geo_zone['GeoZone']['id'],__('Delete', true)), array('align'=>'center')),
			array($form->checkbox('modify][', array('value' => $geo_zone['GeoZone']['id'])), array('align'=>'center'))
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