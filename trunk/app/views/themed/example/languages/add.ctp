<!-- File: /app/views/Languages/add.ctp -->	
<?php echo $html->css('forms', '', '', false); ?>
<?php echo $javascript->link('forms.js', false); ?>
<h1><?php __('Add Language') ?></h1>
<?php
echo $form->create('Language');
echo $form->input('name', array('label' => __('Name',true)));
echo $form->input('code', array('label' => __('Code',true)));
echo $form->end(__('Save Language',true));
?>