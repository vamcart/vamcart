<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $form->create('User', array('action' => '/users/admin_login/', 'url' => '/users/admin_login/'));
	echo $form->input('username', array('label' => __('Username', true)));
	echo $form->input('password', array('label' => __('Password', true)));
	echo $form->submit(__('Login',true));
	echo '<div class="clear"></div>';
	echo $form->end();
?>