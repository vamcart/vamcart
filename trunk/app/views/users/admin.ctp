<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'users.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Action', true)));

foreach ($users AS $user)
{
	echo $admin->TableCells(
		  array(
			$user['User']['username'],
			array($admin->ActionButton('delete','/users/admin_delete/' . $user['User']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $admin->CreateNewLink(); 

echo $admin->ShowPageHeaderEnd();

?>