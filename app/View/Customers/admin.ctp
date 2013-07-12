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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-user');

echo $this->Form->create('Customer', array('action' => '/customers/admin_modify_selected/', 'url' => '/customers/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Customer Name'), __('Email'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($customer_data AS $customer)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($customer['Customer']['name'], '/customers/admin_edit/' . $customer['Customer']['id']),
				array($customer['Customer']['email'], array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/customers/admin_edit/' . $customer['Customer']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/customers/admin_delete/' . $customer['Customer']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $customer['Customer']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->ActionBar(array('delete'=>__('Delete')));

echo $this->Admin->ShowPageHeaderEnd();
