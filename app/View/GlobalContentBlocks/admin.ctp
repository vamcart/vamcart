<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-cascade');

echo $this->Form->create('GlobalContentBlock', array('action' => '/global_content_blocks/admin_modify_selected/', 'url' => '/global_content_blocks/admin_modify_selected/'));

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Title'), __('Call (Template Placeholder)'), __('Active'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($global_content_blocks AS $global_content_block)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($global_content_block['GlobalContentBlock']['name'],'/global_content_blocks/admin_edit/' . $global_content_block['GlobalContentBlock']['id']),
			'{global_content alias="' . $global_content_block['GlobalContentBlock']['alias'] . '"}',
			array($this->Ajax->link(($global_content_block['GlobalContentBlock']['active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/global_content_blocks/admin_change_active_status/' . $global_content_block['GlobalContentBlock']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
			array($this->Admin->ActionButton('edit','/global_content_blocks/admin_edit/' . $global_content_block['GlobalContentBlock']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/global_content_blocks/admin_delete/' . $global_content_block['GlobalContentBlock']['id'],__('Delete')), array('align'=>'center')),
			array($this->Form->checkbox('modify][', array('value' => $global_content_block['GlobalContentBlock']['id'])), array('align'=>'center'))
		   ));
}
echo '</table>';
echo $this->Admin->EmptyResults($global_content_blocks);

echo $this->Admin->ActionBar(array('activate'=>__('Activate'),'deactivate'=>__('Deactivate'),'delete'=>__('Delete')));
echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();

?>