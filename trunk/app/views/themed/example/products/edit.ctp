<h1><?php __('Edit Product') ?></h1>
<?php
	echo $form->create('Product', array('action' => 'edit'));
	echo $form->input('name');
	echo $form->input('description', array('rows' => '3'));
	echo $form->input('id', array('type'=>'hidden')); 
	echo $form->end(__('Save Product',true));
?>