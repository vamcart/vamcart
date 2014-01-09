<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-group-key');

	echo $this->Form->create('UserPref', array('id' => 'contentform', 'action' => '/users/admin_user_preferences/', 'url' => '/users/admin_user_preferences/'));

	echo $this->Form->input('UserPref.language', 
				array(
					'label' => __('Language'),
					'type' => 'select',
					'options' => $available_languages,
					'selected' => $current_language
				));
	   
	echo $this->Admin->formButton(__('Apply'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();	   
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>