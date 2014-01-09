<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'selectall.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page-white-world');

echo $this->Form->create('GeoZone', array('action' => '/geo_zones/admin_modify_selected/', 'url' => '/geo_zones/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Description'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data as $geo_zone)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link(__($geo_zone['GeoZone']['name']),'/geo_zones/admin_zones_edit/' . $geo_zone['GeoZone']['id']),
			array($geo_zone['GeoZone']['description'], array('allign' => 'left', 'width' => '100%')),
			array($this->Admin->ActionButton('edit','/geo_zones/admin_edit/' . $geo_zone['GeoZone']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/geo_zones/admin_delete/' . $geo_zone['GeoZone']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $geo_zone['GeoZone']['id'])), array('align'=>'center'))
		   ));
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')));
echo $this->Form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php echo $this->Admin->ShowPageHeaderEnd(); ?>