<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->create('UserTag', array('action' => '/UserTags/admin_modify_selected/', 'url' => '/UserTags/admin_modify_selected/'));

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true), __('Action', true), '&nbsp;'));

foreach ($user_tags AS $UserTag)
{
	echo $admin->TableCells(
		  array(
			$html->link($UserTag['UserTag']['name'],'/user_tags/admin_edit/' . $UserTag['UserTag']['id']),
			'{user_tag alias=\'' . $UserTag['UserTag']['alias'] . '\'}',
			$admin->ActionButton('edit','/user_tags/admin_edit/' . $UserTag['UserTag']['id'],__('Edit', true)) . $admin->ActionButton('delete','/user_tags/admin_delete/' . $UserTag['UserTag']['id'],__('Delete', true)),
			$form->checkbox('modify][', array('value' => $UserTag['UserTag']['id']))
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('delete'=>__('Delete',true)));
echo $form->end(); 
?>