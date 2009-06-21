<h1><?php __('Edit Language') ?></h1>
<?php
	echo $form->create('Language', array('action' => 'edit'));
	echo $form->input('name');
	echo $form->input('code');
	echo $form->input('id', array('type'=>'hidden')); 
	echo $form->end(__('Save Language',true));
?>