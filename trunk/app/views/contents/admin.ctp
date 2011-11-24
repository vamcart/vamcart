<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'selectall.js'
), array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'content.png');

echo $form->create('Content', array('action' => '/contents/admin_modify_selected/', 'url' => '/contents/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array(	 __('Title', true), __('Type', true), __('Active', true), __('Show in menu', true), __('Default', true), __('Sort Order', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($content_data AS $content)
{

		// Link to child view, link to the edit screen
				if ($content['ContentType']['name']=='category') {
					$name_link = $html->link($html->image('admin/icons/folder.png'), '/contents/admin/0/' . $content['Content']['id'], array('escape' => false));				} else {
					$name_link = '';				}
				
				if ($content['ContentType']['name']=='category') {
                $name_link .= $html->link($content['ContentDescription']['name'], '/contents/admin/0/' . $content['Content']['id']);
				} else {
                $name_link .= $html->link($content['ContentDescription']['name'], '/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
				}

				if ($content['ContentType']['name']=='product') {
					$discounts = $admin->ActionButton('discounts', '/discounts/admin/' . $content['ContentProduct']['id'],__('Discounts', true)); 
				} else {
					$discounts = null; 
				}
	
	echo $admin->TableCells(
		  array(
				$name_link,
				__($content['ContentType']['name'],true),
				array($ajax->link(($content['Content']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_active_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($ajax->link(($content['Content']['show_in_menu'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('escape' => false, 'url' => '/contents/admin_change_show_in_menu_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($admin->DefaultButton($content['Content']), array('align'=>'center')),
				array($admin->MoveButtons($content['Content'], $content_count), array('align'=>'center')),				
				array($admin->ActionButton('edit','/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0),__('Edit', true)) . $admin->ActionButton('delete','/contents/admin_delete/' . $content['Content']['id'],__('Delete', true)) . $discounts, array('align'=>'center')),
				array($form->checkbox('modify][', array('value' => $content['Content']['id'])), array('align'=>'center'))
		   ));
		   	
}

// Display a link letting the user to go up one level
if(isset($parent_content))
{
	$parent_link = $admin->linkButton(__('Up One Level', true),'/contents/admin/' . $parent_content['Content']['parent_id'],'up.png',array('escape' => false, 'class' => 'button'));
	echo '<tr><td colspan="8">' . $parent_link . '</td></tr>';	
}
echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'show_in_menu'=>__('Show In Menu',true),'hide_from_menu'=>__('Hide From Menu',true),'delete'=>__('Delete',true)),true,'0/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
echo $form->end();
echo $admin->ShowPageHeaderEnd();

?>