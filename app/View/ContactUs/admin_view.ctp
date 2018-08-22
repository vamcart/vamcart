<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Answer'), __('Reply Sent'), __('Action')));

foreach ($data AS $answer)
{
	echo $this->Admin->TableCells(
		  array(
				$answer['ContactAnswer']['answer'],
				array(($answer['ContactAnswer']['sent_to_customer'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('Yes'),'title' => __('Yes'))):$this->Html->image('admin/icons/false.png', array('alt' => __('No'),'title' => __('No')))), array('align'=>'center')),
				array($this->Admin->ActionButton('delete','/contact_us/admin_delete_answer/' . $answer['ContactAnswer']['id'] . '/' . $answer['ContactAnswer']['contact_id'],__('Delete')), array('align'=>'center'))
		   ));

		   	
}

echo '</table>';
echo '<br />';
echo $this->Admin->linkButton(__('Return'),'/contact_us/admin/','cus-arrow-left',array('escape' => false, 'class' => 'btn btn-default'));

echo $this->Admin->ShowPageHeaderEnd();
	
?>