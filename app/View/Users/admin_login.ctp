<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-lock');
	
	$this->Html->script(array(
			'focus-first-input.js',
		'modified.js'
	), array('inline' => false));
	
	echo $this->Form->create('User', array('id' => 'contentform', 'url' => '/users/admin_login/'));

	echo $this->Form->input('username', array('label' => __('Username')));
	echo $this->Form->input('password', array('label' => __('Password'), 'autocomplete' => 'off'));

	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Login'), 'cus-key', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'submitbutton'));
	echo $this->Form->end();

	echo $this->Admin->ShowPageHeaderEnd();

?>