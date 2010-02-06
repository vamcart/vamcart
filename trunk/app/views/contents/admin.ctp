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

$combine->js(array(
	'jquery/jquery.min.js',
	'selectall.js'
));

echo $admin->ShowPageHeaderStart($current_crumb, 'content.png');

echo $form->create('Content', array('action' => '/contents/admin_modify_selected/', 'url' => '/contents/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array(	 __('Title', true), __('Type', true), __('Active', true), __('Show in menu', true), __('Default', true), __('Sort Order', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($content_data AS $content)
{

		// Link to child view, link to the edit screen
		$name_link = $html->link($html->image('admin/icons/folder.png'), '/contents/admin/0/' . $content['Content']['id'], null, null, false) . $html->link($content['ContentDescription']['name'], '/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
	
	echo $admin->TableCells(
		  array(
				$name_link,
				__($content['ContentType']['name'],true),
				array($ajax->link(($content['Content']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/contents/admin_change_active_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($ajax->link(($content['Content']['show_in_menu'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/contents/admin_change_show_in_menu_status/' . $content['Content']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($admin->DefaultButton($content['Content']), array('align'=>'center')),
				array($admin->MoveButtons($content['Content'], $content_count), array('align'=>'center')),				
				array($admin->ActionButton('edit','/contents/admin_edit/' . $content['Content']['id'].'/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0),__('Edit', true)) . $admin->ActionButton('delete','/contents/admin_delete/' . $content['Content']['id'],__('Delete', true)), array('align'=>'center')),
				array($form->checkbox('modify][', array('value' => $content['Content']['id'])), array('align'=>'center'))
		   ));
		   	
}

// Display a link letting the user to go up one level
if(isset($parent_content))
{
	$parent_link = $html->link(__('Up One Level', true),'/contents/admin/' . $parent_content['Content']['parent_id']);
	echo '<tr><td colspan="8">' . $parent_link . '</td></tr>';	
}
echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'show_in_menu'=>__('Show In Menu',true),'hide_from_menu'=>__('Hide From Menu',true),'delete'=>__('Delete',true)),true,'0/'.(isset($parent_content) ? $parent_content['Content']['id'] : 0));
echo $form->end();

echo $admin->ShowPageHeaderEnd();

?>