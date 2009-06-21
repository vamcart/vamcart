<h1><?php __('Edit Configuration') ?></h1>
<?php
	echo $form->create('Configuration', array('action' => 'edit'));
	echo $form->input('configuration_key');
	echo $form->input('configuration_value');
	echo $form->input('id', array('type'=>'hidden')); 
	echo $form->end(__('Save',true));
?>