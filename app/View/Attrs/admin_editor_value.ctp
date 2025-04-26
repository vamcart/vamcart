<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
echo $this->Form->create('Attr', array('id' => 'valueform', 'name' => 'valueform','enctype' => 'multipart/form-data', 'url' => '/admin_editor_value/save'));

echo $this->Form->input('content_id',array('type' => 'hidden',
                                           'value' => $content_id
	               ));
echo $this->Form->input('parent_id',array('type' => 'hidden',
                                           'value' => $parent_id
	               ));

foreach ($element_list AS $k => $element)
{
    $this->Smarty->display($element['template_attribute'],array('id_attribute' => $element['id_attribute']
                                                       ,'values_attribute' => $element['values_attribute']
                                                       ,'name_attribute' => $element['name_attribute']
                                                     ));
}

echo $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'applybutton')) . ' ' . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));

echo $this->Form->end();
echo $this->Admin->ShowPageHeaderEnd();
?>