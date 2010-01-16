<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

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

?>