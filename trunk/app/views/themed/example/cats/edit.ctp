<h1><?php __('Edit Category') ?></h1>
<?php
	echo $form->create('Cat', array('action' => 'edit'));
	echo $form->input('name');
	echo $form->input('description', array('rows' => '3'));
	echo $form->input('id', array('type'=>'hidden')); 
	echo $form->end(__('Save Category',true));
?>