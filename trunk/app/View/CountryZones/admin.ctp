<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'selectall.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page-white-world');

echo $this->Form->create('CountryZone', array('action' => '/country_zones/admin_modify_selected/', 'url' => '/country_zones/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Code'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($zones AS $zone)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link(__($zone['CountryZone']['name']),'/country_zones/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id']),
			$zone['CountryZone']['code'],
			array($this->Admin->ActionButton('edit','/country_zones/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/country_zones/admin_delete/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $zone['CountryZone']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')), true, $country['Country']['id']);

echo $this->Form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php

echo $this->Admin->ShowPageHeaderEnd();

?>