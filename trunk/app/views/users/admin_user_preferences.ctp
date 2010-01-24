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

echo '<div class="page">';
echo '<h2>'.$admin->ShowPageHeader($current_crumb, 'prefences.png').'</h2>';
echo '<div class="pageContent">';

	echo $form->create('UserPref', array('id' => 'contentform', 'action' => '/users/admin_user_preferences/', 'url' => '/users/admin_user_preferences/'));

echo $form->inputs(array(
		'legend' => null,
		'fieldset' => __('User Prefences', true),
		'UserPref.language' => array(
			'label' => __('Language', true),
			'type' => 'select',
			'options' => $available_languages,
			'selected' => $current_language
              )		 			  			  
	   ));
	   
	echo $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();	   
	
echo '</div>';
echo '</div>';
	
?>