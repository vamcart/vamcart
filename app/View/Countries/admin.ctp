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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-world');

echo $this->Form->create('Country', array('url' => '/countries/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Flag'), __('Code') . ' 2', __('Code') . ' 3', __('Active'), __('Default'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $country)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($this->Html->image('admin/icons/folder.png'),'/country_zones/admin/' . $country['Country']['id'], array('escape' => false)).'&nbsp;'.$this->Html->link(__($country['Country']['name']),'/country_zones/admin/' . $country['Country']['id']),
			array($this->Html->link($this->Html->image('flags/' . strtolower($country['Country']['iso_code_2']) . '.png', array('alt' => $country['Country']['name'])), '/countries/admin_edit/' . $country['Country']['id'], array('escape' => false)), array('align'=>'center')),
			array($country['Country']['iso_code_2'], array('align'=>'center')),
			array($country['Country']['iso_code_3'], array('align'=>'center')),
			array($this->Ajax->link(($country['Country']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/countries/admin_change_active_status/' . $country['Country']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Ajax->link(($country['Country']['default'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/countries/admin_set_as_default/' . $country['Country']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/countries/admin_delete/' . $country['Country']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $country['Country']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')));
echo $this->Form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php echo $this->Admin->ShowPageHeaderEnd(); ?>