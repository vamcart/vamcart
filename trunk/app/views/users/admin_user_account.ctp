<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'account.png');

	echo $form->create('User', array('id' => 'contentform', 'action' => '/users/admin_user_account/', 'url' => '/users/admin_user_account/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Account Details', true),
				   'User.id' => array(
				   		'type' => 'hidden'
	               ),
	               'User.username' => array(
				   		'label' => __('Username', true)
	               ),
				   'User.email' => array(
   				   		'label' => __('Email', true)
	               ),
				   'User.password' => array(
				   		'type' => 'password',
   				   		'label' => __('New Password', true)
	               ),
				   'User.confirm_password' => array(
				   		'type' => 'password',				   
   				   		'label' => __('Confirm Password', true)
	               )				   				   
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
?>