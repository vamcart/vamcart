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

echo $javascript->link('jquery/jquery.min', false);
echo $javascript->link('tabs', false);
echo $javascript->link('selectall', false);

echo $form->create('Language', array('action' => '/languages/admin_modify_selected/', 'url' => '/languages/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Language', true), __('Code', true), __('Flag', true), __('Active', true), __('Default', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($language_data AS $language)
{
	echo $admin->TableCells(
		  array(
				$html->link($language['Language']['name'], '/languages/admin_edit/' . $language['Language']['id']),
				array($language['Language']['iso_code_2'], array('align'=>'center')),				
				array($admin->ShowFlag($language['Language']), array('align'=>'center')),
				array($ajax->link(($language['Language']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/languages/admin_change_active_status/' . $language['Language']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($admin->DefaultButton($language['Language']), array('align'=>'center')),
				array($admin->ActionButton('edit','/languages/admin_edit/' . $language['Language']['id'],__('Edit', true)) . $admin->ActionButton('delete','/languages/admin_delete/' . $language['Language']['id'],__('Delete', true)), array('align'=>'center')),
				array($form->checkbox('modify][', array('value' => $language['Language']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));

?>