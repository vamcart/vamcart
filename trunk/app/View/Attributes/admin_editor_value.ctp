<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
echo $this->Form->create('Attribute', array('id' => 'valueform', 'name' => 'valueform','enctype' => 'multipart/form-data', 'action' => '/admin_editor_value/save'));

echo $this->Form->input('content_id',array('type' => 'hidden',
                                           'value' => $data['content_id']
	               ));
echo $this->Form->input('parent_id',array('type' => 'hidden',
                                           'value' => $data['parent_id']
	               ));

foreach ($data['values'] AS $k => $attribute)
{
    echo $attribute['name'];
    /*echo $this->Form->input('values.' . $k . '.value_id',array('type' => 'text',
                                           'value' => isset($value['value']['id']) ? $value['value']['id'] : 0
                        ));*/
    $this->Smarty->display($attribute['template'],array('id_attribute' => $attribute['id']
                                                       ,'val_attribute' => $attribute['value']
                                                       ,'name_attribute' => $attribute['name']
                                                       ,'is_editor' => '1'));

}

echo $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));

echo $this->Form->end();
echo $this->Admin->ShowPageHeaderEnd();
?>
