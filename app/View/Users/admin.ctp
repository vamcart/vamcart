<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-group');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Title'), __('Action')));

foreach ($users AS $user)
{
	echo $this->Admin->TableCells(
		  array(
			$user['User']['username'],
			array($this->Admin->ActionButton('delete','/users/admin_delete/' . $user['User']['id'],__('Delete')), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $this->Admin->CreateNewLink(); 

echo $this->Admin->ShowPageHeaderEnd();

?>