<?php 
    echo $this->Form->input('Fields.' . ((isset($order))?$order:microtime()) . '.' . $name_field, array(
        'label'=>false
        ,'type'=>'checkbox'
        ,'class'=>'export-state' ,'data-on-color'=>'success' 
        ,'data-off-color'=>'danger'
        ,'data-on-text'=>__('yes', true), 'data-off-text'=>__('no', true)
        , 'checked' => true 
        ,'readonly' => ((isset($readonly)&&$readonly==true)?true:false)
        )
    );
?>