<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'login.png');
	
	$this->Html->script(array(
			'focus-first-input.js',
		'modified.js'
	), array('inline' => false));
	
	echo $this->Form->create('User', array('id' => 'contentform', 'action' => '/users/admin_login/', 'url' => '/users/admin_login/'));
	echo $this->Form->input('username', array(
													'label' => __('Username'), 
													'tooltip' => __('Username'), 
													'div' => 'input input-prepend', 
													'before' => '<span class="add-on"><i class="icon-user"></i></span>'
													));
													
	echo $this->Form->input('password', array(
													'label' => __('Password'), 
													'tooltip' => __('Password'), 
													'div' => 'input input-prepend', 
													'before' => '<span class="add-on"><i class="icon-pencil"></i></span>'
													));
	
	echo $this->Admin->formButton(__('Login'), 'cus-key', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();

	echo $this->Admin->ShowPageHeaderEnd();

?>