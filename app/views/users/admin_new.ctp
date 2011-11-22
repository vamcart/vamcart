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

	echo $admin->ShowPageHeaderStart($current_crumb, 'new.png');

	echo $form->create('User', array('id' => 'contentform', 'action' => '/users/admin_new/', 'url' => '/users/admin_new/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('New Admin', true),
	               'User.username' => array(
				   		'label' => __('Username', true)
	               ),
				   'User.email' => array(
   				   		'label' => __('Email', true)
	               ),
				   'User.password' => array(
				   		'type' => 'text',
   				   		'label' => __('Password', true)
	               )	   				   
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
?>