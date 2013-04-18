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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'prefences.png');

	echo $this->Form->create('UserPref', array('id' => 'contentform', 'action' => '/users/admin_user_preferences/', 'url' => '/users/admin_user_preferences/'));

	echo $this->Form->inputs(array(
		'legend' => null,
		'fieldset' => __('User Prefences'),
		'UserPref.language' => array(
			'label' => __('Language'),
			'type' => 'select',
			'options' => $available_languages,
			'selected' => $current_language
              )		 			  			  
	   ));
	   
	echo $this->Admin->formButton(__('Apply'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();	   
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>