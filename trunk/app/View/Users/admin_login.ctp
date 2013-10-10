<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-lock');
	
	$this->Html->script(array(
			'focus-first-input.js',
		'modified.js'
	), array('inline' => false));
	
	echo $this->Form->create('User', array('id' => 'contentform', 'action' => '/users/admin_login/', 'url' => '/users/admin_login/'));

	echo $this->Form->input('username', array('label' => __('Username')));
	echo $this->Form->input('password', array('label' => __('Password')));

	echo $this->Admin->formButton(__('Login'), 'cus-key', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();

	echo $this->Admin->ShowPageHeaderEnd();

?>