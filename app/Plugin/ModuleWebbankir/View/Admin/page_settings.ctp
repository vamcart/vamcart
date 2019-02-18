<?php

$content = $this->Form->create('settingsForm', array(
    'id' => 'settingsForm',
    'url' => '/module_webbankir/admin/admin_save',
));

foreach ($webbankirSettings as $element) {
    $setting = current($element);

    $content .= $this->Form->input($setting['code'], array(
        'label' => __d(WEBBANKIR_MODULE, $setting['name']),
        'type' => $setting['type'],
        'options' => (!isset($setting['options']) ? null : $setting['options']),
        'value' => $setting['value'],
    ));
}

$content .= $this->Admin->formButton(__d(WEBBANKIR_MODULE, 'WEBBANKIR_SAVE'), 'cus-tick', array(
    'class' => 'btn btn-primary',
    'type' => 'submit',
    'name' => 'submit'
));

echo $content;