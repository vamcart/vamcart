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

echo $javascript->link('selectall', false);

echo '<div class="page">';
echo '<h2>'.$admin->ShowPageHeader($current_crumb, 'user-tags.png').'</h2>';
echo '<div class="pageContent">';

echo $form->create('UserTag', array('action' => '/UserTags/admin_modify_selected/', 'url' => '/UserTags/admin_modify_selected/'));

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($user_tags AS $UserTag)
{
	echo $admin->TableCells(
		  array(
			$html->link($UserTag['UserTag']['name'],'/user_tags/admin_edit/' . $UserTag['UserTag']['id']),
			'{user_tag alias=\'' . $UserTag['UserTag']['alias'] . '\'}',
			array($admin->ActionButton('edit','/user_tags/admin_edit/' . $UserTag['UserTag']['id'],__('Edit', true)) . $admin->ActionButton('delete','/user_tags/admin_delete/' . $UserTag['UserTag']['id'],__('Delete', true)), array('align'=>'center')),
			array($form->checkbox('modify][', array('value' => $UserTag['UserTag']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('delete'=>__('Delete',true)));
echo $form->end(); 

echo '</div>';
echo '</div>';

?>