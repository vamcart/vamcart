<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-group-edit');

	echo $this->Form->create('User', array('id' => 'contentform', 'action' => '/users/admin_user_account/', 'url' => '/users/admin_user_account/'));
	echo $this->Form->input('User.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('User.username', 
						array(
				   		'label' => __('Username')
	               ));
	echo $this->Form->input('User.email', 
						array(
   				   	'label' => __('Email')
	               ));
	echo $this->Form->input('User.password', 
						array(
				   		'type' => 'password',
				   		'autocomplete' => 'off',
   				   	'label' => __('New Password')
	               ));
	echo $this->Form->input('User.confirm_password', 
						array(
				   		'type' => 'password',
				   		'autocomplete' => 'off',				   
   				   	'label' => __('Confirm Password')
	               ));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>