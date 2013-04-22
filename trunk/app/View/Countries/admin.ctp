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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-world');

echo $this->Form->create('Country', array('action' => '/countries/admin_modify_selected/', 'url' => '/countries/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Flag'), __('Code') . ' 2', __('Code') . ' 3', __('EU'), __('Private'), __('Firm'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $country)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link(__($country['Country']['name']),'/country_zones/admin/' . $country['Country']['id']),
			array($this->Html->link($this->Html->image('flags/' . strtolower($country['Country']['iso_code_2']) . '.png', array('alt' => $country['Country']['name'])), '/countries/admin_edit/' . $country['Country']['id'], array('escape' => false)), array('align'=>'center')),
			array($country['Country']['iso_code_2'], array('align'=>'center')),
			array($country['Country']['iso_code_3'], array('align'=>'center')),
                        array($country['Country']['eu'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'))), array('align'=>'center')),
			array($country['Country']['private'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'))), array('align'=>'center')),
                        array($country['Country']['firm'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'))), array('align'=>'center')),
			array($this->Admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/countries/admin_delete/' . $country['Country']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $country['Country']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')));
echo $this->Form->end();

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->prev(__('<< Previous')); ?></td>
		<td>&nbsp;<?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $this->Paginator->next(__('Next >>')); ?></td>
	</tr>
</table>

<?php echo $this->Admin->ShowPageHeaderEnd(); ?>