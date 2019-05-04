<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/selectall.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-page-white-world');

echo $this->Form->create('CountryZone', array('url' => '/country_zones/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Code'), __('Default'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($zones AS $zone)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link(__($zone['CountryZone']['name']),'/country_zones/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id']),
			$zone['CountryZone']['code'],
			array($this->Ajax->link(($zone['CountryZone']['default'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/country_zones/admin_set_as_default/' . $zone['CountryZone']['id'] . '/' . $zone['CountryZone']['country_id'], 'update' => 'content'), null, false), array('align'=>'center')),
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

echo '<br />';

echo $this->Admin->linkButton(__('Back to country list'),'/countries/admin/','cus-arrow-left',array('escape' => false, 'class' => 'btn btn-default'));

echo $this->Admin->ShowPageHeaderEnd();

?>