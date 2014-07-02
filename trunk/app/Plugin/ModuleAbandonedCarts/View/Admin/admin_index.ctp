<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-cart-error');

	echo $this->Form->create('Order', array('action' => '/module_abandoned_carts/admin_modify_selected/', 'url' => '/module_abandoned_carts/admin_modify_selected/', 'onsubmit' => 'return beforeSubmit(this);'));

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('main');
echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(  __('Order Id'), __('Total'), __('Number of Products'), __('Date Placed'), __('Phone'), __('Email'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach($data AS $order)
{
	echo $this->Admin->TableCells(
		  array(
			$order['Order']['id'],
			$order['Order']['total'],
			count($order['OrderProduct']),
			$this->Time->i18nFormat($order['Order']['created']),
			$order['Order']['phone'],
			$order['Order']['email'],
			array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')) . $this->Admin->ActionButton('edit','/orders_edit/admin/edit/' . $order['Order']['id'],__('Edit'))  . $this->Admin->ActionButton('delete','/orders/admin_delete/' . $order['Order']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $order['Order']['id'])), array('align'=>'center'))
		   ));
}

echo '</table>';
echo $this->Admin->EmptyResults($data);

echo $this->Admin->EndTabContent();
echo $this->Admin->StartTabContent('options');

		echo $this->Html->link(__('Click here to purge all Abandoned Carts.'),'/module_abandoned_carts/admin/purge_old_carts/',null,__('Are you sure?'));
	
echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>