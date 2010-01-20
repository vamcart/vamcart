<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $javascript->link('modified', false);
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
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
?>