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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'account.png');

	echo $this->Form->create('User', array('id' => 'contentform', 'action' => '/users/admin_user_account/', 'url' => '/users/admin_user_account/'));
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Account Details'),
				   'User.id' => array(
				   		'type' => 'hidden'
	               ),
	               'User.username' => array(
				   		'label' => __('Username')
	               ),
				   'User.email' => array(
   				   		'label' => __('Email')
	               ),
				   'User.password' => array(
				   		'type' => 'password',
   				   		'label' => __('New Password')
	               ),
				   'User.confirm_password' => array(
				   		'type' => 'password',				   
   				   		'label' => __('Confirm Password')
	               )				   				   
			));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>