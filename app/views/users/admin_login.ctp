<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $admin->ShowPageHeaderStart($current_crumb, 'login.png');
	
	$html->script(array(
		'jquery/jquery.min.js',
		'focus-first-input.js',
		'modified.js'
	), array('inline' => false));
	
	echo $form->create('User', array('id' => 'contentform', 'action' => '/users/admin_login/', 'url' => '/users/admin_login/'));
	echo $form->input('username', array('label' => __('Username', true)));
	echo $form->input('password', array('label' => __('Password', true)));
	echo $admin->formButton(__('Login', true), 'login.png', array('type' => 'submit', 'name' => 'submitbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();

	echo $admin->ShowPageHeaderEnd();

?>