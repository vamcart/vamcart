<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-email-open');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Subject'), __('Alias'),  __('Action')));

foreach ($email_template_data AS $email_template)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($email_template['EmailTemplateDescription']['subject'], '/email_template/admin_edit/' . $email_template['EmailTemplate']['id']),
				$email_template['EmailTemplate']['alias'],
				array($this->Admin->ActionButton('edit','/email_template/admin_edit/' . $email_template['EmailTemplate']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/email_template/admin_delete/' . $email_template['EmailTemplate']['id'],__('Delete')), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>