<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $html->script('selectall', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'user-tags.png');

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

echo $admin->ShowPageHeaderEnd();

?>