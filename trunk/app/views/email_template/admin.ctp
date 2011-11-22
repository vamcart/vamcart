<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'email.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Subject', true), __('Alias', true),  __('Action', true)));

foreach ($email_template_data AS $email_template)
{
	echo $admin->TableCells(
		  array(
				$html->link($email_template['EmailTemplateDescription']['subject'], '/email_template/admin_edit/' . $email_template['EmailTemplate']['id']),
				$email_template['EmailTemplate']['alias'],
				array($admin->ActionButton('edit','/email_template/admin_edit/' . $email_template['EmailTemplate']['id'],__('Edit', true)) . $admin->ActionButton('delete','/email_template/admin_delete/' . $email_template['EmailTemplate']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $admin->CreateNewLink();

echo $admin->ShowPageHeaderEnd();

?>