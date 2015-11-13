<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
echo '<div id="table-wrapper"><div id="table-scroll"><table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Name'),__('Type'),__('Status'),__('Filter'),__('Compare'),__('Value'),__('Action')));
$count_attr = count($attributes);
    foreach ($attributes AS $attribute) {       
        echo $this->Admin->TableCells(array($attribute['Attribute']['name']
                                           ,$attribute['AttributeTemplate']['name']
                                           ,array($this->Ajax->link(($attribute['Attribute']['is_active'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attributes/change_field_status/is_active/' . $attribute['Attribute']['id'], 'update' => 'view_attr'), null, false), array('align'=>'center'))                                               
                                           ,array($this->Ajax->link(($attribute['Attribute']['is_show_flt'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attributes/change_field_status/is_show_flt/' . $attribute['Attribute']['id'], 'update' => 'view_attr'), null, false), array('align'=>'center'))                                               
                                           ,array($this->Ajax->link(($attribute['Attribute']['is_show_cmp'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), 'null', $options = array('escape' => false, 'url' => '/attributes/change_field_status/is_show_cmp/' . $attribute['Attribute']['id'], 'update' => 'view_attr'), null, false), array('align'=>'center'))                                               
                                           ,''
                                           ,$this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Edit'),'class' => 'cus-tag-blue-edit')), '/attributes/admin_editor_attr_dialog/edit/attr/' . $attribute['Attribute']['id'], array('escape' => false, 'update' => '#dialog_add_attr'))
                                           . '&nbsp' . $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Delete'),'class' => 'cus-tag-blue-delete')), '/attributes/admin_editor_attr/delete/attr/' . $attribute['Attribute']['id'], array('escape' => false, 'update' => '#view_attr', 'confirm' => __('Confirm delete action?',true)))
                                      ));
        foreach ($attribute['ValAttribute'] AS $val_attribute) {
            echo $this->Admin->TableCells(array('','','','',''
                                               ,$val_attribute['name']
                                               ,$this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Edit'),'class' => 'cus-tag-blue-edit')), '/attributes/admin_editor_attr_dialog/edit/val/' . $val_attribute['id'], array('escape' => false, 'update' => '#dialog_add_attr'))
                                           . '&nbsp' . $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Delete'),'class' => 'cus-tag-blue-delete')), '/attributes/admin_editor_attr/delete/val/' . $val_attribute['id'], array('escape' => false, 'update' => '#view_attr', 'confirm' => __('Confirm delete action?',true)))
                                          ));
        }
        echo $this->Admin->TableCells(array('','','','',''
                                               ,'<div class="btn-group">' . $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Add Attribute Values'),'class' => 'cus-tag-blue-add')) . ' ' . __('Add Attribute Values'), '/attributes/admin_editor_attr_dialog/' . 'add/val/' . $attribute['Attribute']['id'], array('escape' => false, 'update' => '#dialog_add_attr','class' => 'btn btn-default')).$this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Copy Attribute Values'),'class' => 'cus-tag-blue-add')) . ' ' . __('Copy Attribute Values'), '/attributes/admin_copy_attrvalues_dialog/' . $content_id . '/' . $attribute['Attribute']['id'], array('escape' => false, 'update' => '#dialog_add_attr','class' => 'btn btn-default')) . '</div>'
                                            ,''
                                          ));
        
    }
    echo $this->Js->writeBuffer(); 
echo '</table>';

?>  
<div class="btn-group">
<?php    
    echo $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Add Attributes'),'class' => 'cus-tag-blue-add')) . ' ' . __('Add Attributes'), '/attributes/admin_editor_attr_dialog/' . 'add/attr/' . $content_id, array('escape' => false, 'update' => '#dialog_add_attr','class' => 'btn btn-default'))
  . $this->Js->link($this->Html->image('admin/transparency.png', array('title' => __('Copy Attributes'),'class' => 'cus-tag-blue-add')) . ' ' . __('Copy Attributes'), '/attributes/admin_copy_attr_dialog/' . $content_id, array('escape' => false, 'update' => '#dialog_add_attr','class' => 'btn btn-default'));
?>
</div>
<br /><br />
<?php    
    echo $this->Js->writeBuffer(); 
?>
</div></div>