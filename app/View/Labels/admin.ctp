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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-tag-blue');

echo $this->Form->create('Label', array('action' => '/labels/admin_modify_selected/', 'url' => '/labels/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Name'), __('Alias'), __('Active'), __('Default'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($label_data AS $label)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link(__($label['Label']['name']), '/labels/admin_edit/' . $label['Label']['id']),
				array($label['Label']['alias'], array('align'=>'center')),				
				array($this->Ajax->link(($label['Label']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/labels/admin_change_active_status/' . $label['Label']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($this->Admin->DefaultButton($label['Label']), array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/labels/admin_edit/' . $label['Label']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/labels/admin_delete/' . $label['Label']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $label['Label']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')));

echo $this->Admin->ShowPageHeaderEnd();

?>