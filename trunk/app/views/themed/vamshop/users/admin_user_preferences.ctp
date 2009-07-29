<?php 
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->create('UserPref', array('id' => 'contentform', 'action' => '/users/admin_user_preferences/', 'url' => '/users/admin_user_preferences/'));

echo $form->inputs(array(
		'fieldset' => __('User Prefences', true),
		'UserPref.language' => array(
			'label' => __('Language', true),
			'type' => 'select',
			'options' => $available_languages,
			'selected' => $_SESSION['UserPref']['language']
              )		 			  			  
	   ));
	   
	echo $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();	   
?>