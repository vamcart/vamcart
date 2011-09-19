<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'jquery/jquery.min.js',
	'selectall.js'
), array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'stylesheets.png');

echo $form->create('Stylesheet', array('action' => '/stylesheets/admin_modify_selected/', 'url' => '/stylesheets/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Active', true), __('Media Type', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($stylesheets AS $stylesheet)
{
	echo $admin->TableCells(
		  array(
			$html->link(__($stylesheet['Stylesheet']['name'],true),'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']),
			array($ajax->link(($stylesheet['Stylesheet']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('escape' => false, 'url' => '/stylesheets/admin_change_active_status/' . $stylesheet['Stylesheet']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			$stylesheet['StylesheetMediaType']['name'],
			array($admin->ActionButton('stylesheet','/stylesheets/admin_attach_templates/' . $stylesheet['Stylesheet']['id'],__('Attach Template', true)) . $admin->ActionButton('copy','/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'],__('Copy', true)) . $admin->ActionButton('edit','/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id'],__('Edit', true)) . $admin->ActionButton('delete','/stylesheets/admin_delete/' . $stylesheet['Stylesheet']['id'],__('Delete', true)), array('align'=>'center')),
			array($form->checkbox('modify][', array('value' => $stylesheet['Stylesheet']['id'])), array('align'=>'center'))
			
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));
echo $form->end(); 

echo $admin->ShowPageHeaderEnd();

?>