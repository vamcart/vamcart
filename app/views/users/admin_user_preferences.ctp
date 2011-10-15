<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'prefences.png');

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
	   
	echo $admin->formButton(__('Apply', true), 'apply.png', array('type' => 'submit', 'name' => 'applybutton')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();	   
	
	echo $admin->ShowPageHeaderEnd();
	
?>