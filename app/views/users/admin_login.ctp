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

	echo $admin->ShowPageHeaderStart($current_crumb, 'login.png');

	echo $javascript->link('modified', false);
	echo $form->create('User', array('id' => 'contentform', 'action' => '/users/admin_login/', 'url' => '/users/admin_login/'));
	echo $form->input('username', array('label' => __('Username', true)));
	echo $form->input('password', array('label' => __('Password', true)));
	echo $form->submit(__('Login',true));
	echo '<div class="clear"></div>';
	echo $form->end();

	echo $admin->ShowPageHeaderEnd();

?>