<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($content_data['ContentDescription']['name'], 'cus-table');
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Name'),__('Type'),__('Status'),__('Filter')__('Filter Links'),__('Compare'),__('Action')));
$count_attr = count($content_data['Attr']);
foreach ($content_data['Attr'] AS $attribute)
{
    echo $this->Admin->TableCells(array($attribute['name']
                                       ,$attribute['AttributeTemplate']['name']
                                       ,array($this->Ajax->link(($attribute['is_active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attrs/change_field_status/is_active/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Ajax->link(($attribute['is_show_flt'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attrs/change_field_status/is_show_flt/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Ajax->link(($attribute['is_show_var'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attrs/change_field_status/is_show_var/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Ajax->link(($attribute['is_show_cmp'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attrs/change_field_status/is_show_cmp/' . $attribute['id'], 'update' => 'content'), null, false), array('align'=>'center'))                                               
                                       ,array($this->Admin->ActionButton('edit','/attrs/admin_editor_attr/' . 'edit/attr/' . $attribute['id'],__('Edit')) . $this->Admin->ActionButton('delete','/attrs/admin_editor_attr/' . 'delete/attr/' . $attribute['id'],__('Delete')),array('align'=>'center'))
                                  ));
}
echo $this->Admin->TableCells(array($this->Html->link($this->Html->tag('i', '',array('class' => 'cus-add')) . ' ' . __('Add'), '/attrs/admin_editor_attr/' . 'add/attr/' . $content_data['Content']['id'], array('class' => 'btn btn-default', 'escape' => false))
                                   ,''
                                   ,''
                                   ,''
                                   ,''
                                   ,''
                                   ,''
                              ));

echo '</table>';
echo $this->Html->link($this->Html->tag('i', '',array('class' => 'cus-arrow-up')) . ' ' . __('Up One Level'), '/attrs/admin' , array('class' => 'btn btn-default', 'escape' => false));
echo $this->Admin->ShowPageHeaderEnd();
?>