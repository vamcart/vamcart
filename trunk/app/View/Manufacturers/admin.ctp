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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cog');

echo $this->Form->create('Manufacturer', array('action' => '/manufacturers/admin_modify_selected/', 'url' => '/manufacturers/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Manufacturer'), __('Active'), __('Sort Order'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($manufacturer_data AS $manufacturer)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($manufacturer['Manufacturer']['name'], '/manufacturers/admin_edit/' . $manufacturer['Manufacturer']['id']),
				array($this->Ajax->link(($manufacturer['Manufacturer']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/manufacturers/admin_change_active_status/' . $manufacturer['Manufacturer']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($manufacturer['Manufacturer']['order'], array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/manufacturers/admin_edit/' . $manufacturer['Manufacturer']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/manufacturers/admin_delete/' . $manufacturer['Manufacturer']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $manufacturer['Manufacturer']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')));
?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>
<?php
echo $this->Admin->ShowPageHeaderEnd();

?>