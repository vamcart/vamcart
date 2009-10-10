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

echo $form->create('Stylesheet', array('action' => '/stylesheets/admin_modify_selected/', 'url' => '/stylesheets/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Active', true), __('Media Type', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($stylesheets AS $stylesheet)
{
	echo $admin->TableCells(
		  array(
			$html->link($stylesheet['Stylesheet']['name'],'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']),
			$ajax->link(($stylesheet['Stylesheet']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/stylesheets/admin_change_active_status/' . $stylesheet['Stylesheet']['id'], 'update' => 'content'), null, false),
			$stylesheet['StylesheetMediaType']['name'],
			$admin->ActionButton('stylesheet','/stylesheets/admin_attach_templates/' . $stylesheet['Stylesheet']['id'],__('Attach Template', true)) . $admin->ActionButton('copy','/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'],__('Copy', true)) . $admin->ActionButton('edit','/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id'],__('Edit', true)) . $admin->ActionButton('delete','/stylesheets/admin_delete/' . $stylesheet['Stylesheet']['id'],__('Delete', true)), 
			array($form->checkbox('modify][', array('value' => $stylesheet['Stylesheet']['id'])), array('align'=>'center'))
			
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));
echo $form->end(); 

?>