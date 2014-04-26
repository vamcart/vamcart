<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($content_data['ContentDescription']['name'], 'cus-table');
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Name'),__('Type'),__('Status'),__('Filter'),__('Compare'),__('Sort Order'),__('Action')));
$count_attr = count($content_data['Attribute']);
foreach ($content_data['Attribute'] AS $attribute)
{
    echo $this->Admin->TableCells(array($attribute['name']
                                       ,$attribute['AttributeTemplate']['name']
                                       ,array($this->Ajax->link(($attribute['is_active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attributes/change_field_status/is_active/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Ajax->link(($attribute['is_show_flt'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attributes/change_field_status/is_show_flt/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Ajax->link(($attribute['is_show_cmp'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attributes/change_field_status/is_show_cmp/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Admin->MoveButtons($attribute, $count_attr), array('align'=>'center'))
                                       ,array($this->Admin->ActionButton('edit','/attributes/admin_editor_attr/' . 'edit/attr/' . $attribute['id'],__('Edit')) . $this->Admin->ActionButton('delete','/attributes/admin_editor_attr/' . 'delete/attr/' . $attribute['id'],__('Delete')),array('align'=>'center'))
                                  ));
}
echo $this->Admin->TableCells(array(''
                                   ,''
                                   ,''
                                   ,''
                                   ,''
                                   ,''
                                   ,array($this->Html->link($this->Html->image('admin/icons/new.png', array('title' => __('Add'), 'alt' => __('Add'))),'/attributes/admin_editor_attr/' . 'add/attr/' . $content_data['Content']['id'], array('escape' => false)),array('align'=>'center'))
                              ));

echo '</table>';
echo $this->Html->link($this->Html->tag('i', '',array('class' => 'cus-arrow-up')) . ' ' . __('Up One Level'), '/attributes/admin' , array('class' => 'btn', 'escape' => false));
echo $this->Admin->ShowPageHeaderEnd();
?>