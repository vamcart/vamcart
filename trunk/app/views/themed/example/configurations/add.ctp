<?php echo $html->css('forms', '', '', false); ?>
<?php echo $javascript->link('forms.js', false); ?>
<h1><?php __('Add Configuration') ?></h1>
<?php
echo $form->create('Configuration');
echo $form->input('configuration_key', array('label' => __('Configuration Key',true)));
echo $form->input('configuration_value', array('label' => __('Configuration Value',true)));
echo $form->end(__('Save Configuration',true));
?>