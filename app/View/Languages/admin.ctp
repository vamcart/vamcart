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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-flag-green');

echo $this->Form->create('Language', array('action' => '/languages/admin_modify_selected/', 'url' => '/languages/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Language'), __('Code'), __('Flag'), __('Active'), __('Default'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($language_data AS $language)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($language['Language']['name'], '/languages/admin_edit/' . $language['Language']['id']),
				array($language['Language']['iso_code_2'], array('align'=>'center')),				
				array($this->Admin->ShowFlag($language['Language']), array('align'=>'center')),
				array($this->Ajax->link(($language['Language']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/languages/admin_change_active_status/' . $language['Language']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($this->Admin->DefaultButton($language['Language']), array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/languages/admin_edit/' . $language['Language']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/languages/admin_delete/' . $language['Language']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $language['Language']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')));

echo $this->Admin->ShowPageHeaderEnd();

?>