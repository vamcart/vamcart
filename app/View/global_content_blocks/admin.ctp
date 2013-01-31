<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'blocks.png');

echo $form->create('GlobalContentBlock', array('action' => '/global_content_blocks/admin_modify_selected/', 'url' => '/global_content_blocks/admin_modify_selected/'));

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true), __('Active', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($global_content_blocks AS $global_content_block)
{
	echo $admin->TableCells(
		  array(
			$html->link($global_content_block['GlobalContentBlock']['name'],'/global_content_blocks/admin_edit/' . $global_content_block['GlobalContentBlock']['id']),
			'{global_content alias="' . $global_content_block['GlobalContentBlock']['alias'] . '"}',
			array($ajax->link(($global_content_block['GlobalContentBlock']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('escape' => false, 'url' => '/global_content_blocks/admin_change_active_status/' . $global_content_block['GlobalContentBlock']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($admin->ActionButton('edit','/global_content_blocks/admin_edit/' . $global_content_block['GlobalContentBlock']['id'],__('Edit', true)) . $admin->ActionButton('delete','/global_content_blocks/admin_delete/' . $global_content_block['GlobalContentBlock']['id'],__('Delete', true)), array('align'=>'center')),
			array($form->checkbox('modify][', array('value' => $global_content_block['GlobalContentBlock']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';
echo $admin->EmptyResults($global_content_blocks);

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));
echo $form->end(); 

echo $admin->ShowPageHeaderEnd();

?>