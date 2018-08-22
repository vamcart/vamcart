<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Message'), __('Sent To Customer'), __('Action')));

foreach ($data AS $messages)
{
	echo $this->Admin->TableCells(
		  array(
				$messages['CustomerMessage']['message'],
				array(($messages['CustomerMessage']['sent_to_customer'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('Yes'),'title' => __('Yes'))):$this->Html->image('admin/icons/false.png', array('alt' => __('No'),'title' => __('No')))), array('align'=>'center')),
				array($this->Admin->ActionButton('delete','/customers/admin_delete_message/' . $messages['CustomerMessage']['id'] . '/' . $messages['CustomerMessage']['customer_id'],__('Delete')), array('align'=>'center'))
		   ));

		   	
}

echo '</table>';
echo '<br />';
echo $this->Admin->linkButton(__('Return'),'/customers/admin/','cus-arrow-left',array('escape' => false, 'class' => 'btn btn-default'));

echo $this->Admin->ShowPageHeaderEnd();
	
?>