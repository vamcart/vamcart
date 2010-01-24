<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo '<div class="page">';
echo '<h2>'.$admin->ShowPageHeader($current_crumb, 'users.png').'</h2>';
echo '<div class="pageContent">';

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

echo '</div>';
echo '</div>';

?>