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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table-edit');

echo $this->Form->create('Currency', array('action' => '/currencies/admin_modify_selected/', 'url' => '/currencies/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Currency'), __('Code'), __('Active'), __('Default'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($currency_data AS $currency)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($currency['Currency']['name'], '/currencies/admin_edit/' . $currency['Currency']['id']),
				array($currency['Currency']['code'], array('align'=>'center')),
				array($this->Ajax->link(($currency['Currency']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/currencies/admin_change_active_status/' . $currency['Currency']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($this->Admin->DefaultButton($currency['Currency']), array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/currencies/admin_edit/' . $currency['Currency']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/currencies/admin_delete/' . $currency['Currency']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $currency['Currency']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')));

echo $this->Admin->ShowPageHeaderEnd();

?>