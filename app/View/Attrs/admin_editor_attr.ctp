<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
echo $this->Form->create('Attribute', array('id' => 'attributeform', 'name' => 'attributeform','enctype' => 'multipart/form-data', 'url' => '/admin_editor_attr/save/' . $type));

echo $this->Form->input('id',array('type' => 'hidden',
                                           'value' => $attribute['Attribute']['id']
	               ));
echo $this->Form->input('parent_id',array('type' => 'hidden',
                                           'value' => $attribute['Attribute']['parent_id']
	               ));
echo $this->Form->input('content_id',array('type' => 'hidden',
                                           'value' => $attribute['Attribute']['content_id']
	               ));
echo $this->Form->input('order',array('type' => 'hidden',
                                           'value' => $attribute['Attribute']['order']
	               ));


echo '<ul id="myTabLang" class="nav nav-tabs">';
$i = 0;
foreach($languages AS $language)
{
    echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],'cus-page-white',($i == 0 ? 'active' : null));
$i++;
}
echo '</ul>';
echo $this->Admin->StartTabs('sub-tabs');

foreach($languages AS $language)
{
    $language_key = $language['Language']['id'];
    echo $this->Admin->StartTabContent('language_'.$language_key);
    echo $this->Form->input('AttributeDescription][' . $language['Language']['id'] . '][dsc_id',array('type' => 'hidden',
                                           'value' => isset($attribute['AttributeDescription'][$language_key]['dsc_id']) ? $attribute['AttributeDescription'][$language_key]['dsc_id'] : 0
	               ));
    echo $this->Form->input('AttributeDescription][' . $language['Language']['id'] . '][name', 
                		array(
				'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Name'),
				'type' => 'text',
				'value' => isset($attribute['AttributeDescription'][$language_key]['name']) ? $attribute['AttributeDescription'][$language_key]['name'] : ''
                                ));
    echo $this->Admin->EndTabContent();
}
echo $this->Admin->EndTabs();

if($type != 'attr')   
{
    echo $this->Form->input('Attribute.type_attr',array(
				'type' => 'select',
				'label' => __('Value Type'),
				'options' => $template,//array('list_value' => 'list value','max' => 'max value','min' => 'min value','value' => 'numeric value','like' => 'mask value'),
				'selected' => isset($attribute['Attribute']['type_attr']) ? $attribute['Attribute']['type_attr'] : ''
			));
    echo $this->Form->input('Attribute.val',array(
				'type' => 'text',
				'label' => __('Default value'),
				'value' => isset($attribute['Attribute']['val']) ? $attribute['Attribute']['val'] : ''
			));
    echo $this->Form->input('Attribute.price_modificator',array(
				'type' => 'select',
				'label' => __('Price Modificator'),
				'options' => array('0' => __('no'),'=' => '=','+' => '+','-' => '-','/' => '/','*' => '*'),
				'selected' => isset($attribute['Attribute']['price_modificator']) ? $attribute['Attribute']['price_modificator'] : ''
			));
    echo $this->Form->input('Attribute.price_value',array(
				'type' => 'text',
				'label' => __('Modificator Value'),
				'value' => isset($attribute['Attribute']['price_value']) ? $attribute['Attribute']['price_value'] : '0'
			));
}
else if($type == 'attr')
{
        
    echo $this->Form->input('Attribute.price_value',array(
				'type' => 'hidden',
				'value' => '0'
			));
    
    echo $this->Form->input('Attribute.attribute_template_id',array(
				'type' => 'select',
				'label' => __('Attribute Type'),
				'options' => $template,
				'selected' => isset($attribute['Attribute']['attribute_template_id']) ? $attribute['Attribute']['attribute_template_id'] : '',
				'after' => ' '.$this->Html->link($this->Html->image("admin/icons/new.png", array('alt' => __('Attribute Templates'), 'title' => __('Attribute Templates'))),'/attribute_templates/admin/', array('escape' => false, 'target' => '_blank'))
			));
    
    echo __('Attribute Values');
    
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array(__('Name'),__('Action')));
    $count_attr = count($attribute['ValAttribute']);
    //var_dump($attribute['ValAttribute']);
    //die();
    foreach ($attribute['ValAttribute'] AS $val_ttribute)
    {
        echo $this->Admin->TableCells(array($val_ttribute['name'],
                                           array($this->Admin->ActionButton('edit','/attributes/admin_editor_attr/' . 'edit/val/' . $val_ttribute['id'],__('Edit')) . $this->Admin->ActionButton('delete','/attributes/admin_editor_attr/' . 'delete/val/' . $val_ttribute['id'],__('Delete')),array('align'=>'center'))
                                          ));  
    }
    if($attribute['Attribute']['id'] != 0)
        echo $this->Admin->TableCells(array($this->Html->link($this->Html->tag('i', '',array('class' => 'cus-add')) . ' ' . __('Add'), '/attributes/admin_editor_attr/' . 'add/val/' . $attribute['Attribute']['id'], array('class' => 'btn btn-default', 'escape' => false)),
                                           ''
                                           ));
    echo '</table>';

}

echo $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'applybutton')) . ' ' . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));

echo $this->Form->end();
echo $this->Admin->ShowPageHeaderEnd();
?>