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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-palette');

echo $this->Form->create('Stylesheet', array('action' => '/stylesheets/admin_modify_selected/', 'url' => '/stylesheets/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Active'), __('Media Type'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($stylesheets AS $stylesheet)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link(__($stylesheet['Stylesheet']['name']),'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']),
			array($this->Ajax->link(($stylesheet['Stylesheet']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/stylesheets/admin_change_active_status/' . $stylesheet['Stylesheet']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			$stylesheet['StylesheetMediaType']['name'],
			array($this->Admin->ActionButton('stylesheet','/stylesheets/admin_attach_templates/' . $stylesheet['Stylesheet']['id'],__('Attach Template')) . $this->Admin->ActionButton('copy','/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'],__('Copy')) . $this->Admin->ActionButton('edit','/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/stylesheets/admin_delete/' . $stylesheet['Stylesheet']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $stylesheet['Stylesheet']['id'])), array('align'=>'center'))
			
		   ));
}
echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')), true, '', true, true);
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();

?>