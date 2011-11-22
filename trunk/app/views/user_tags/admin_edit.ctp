<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/plugins/ui.core.js',
	'jquery/plugins/ui.tabs.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $html->css('ui.tabs', null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	$user_tag_id = $this->data['UserTag']['id'];
	echo $form->create('UserTag', array('id' => 'contentform', 'action' => '/user_tags/admin_edit/'.$user_tag_id, 'url' => '/user_tags/admin_edit/'.$user_tag_id));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true), 'main.png');
			echo $admin->CreateTab('options',__('Options',true), 'options.png');			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('User Tag Details', true),
				   'UserTag.id' => array(
				   		'type' => 'hidden'
	               ),
	               'UserTag.name' => array(
   				   		'label' => __('Name', true)
	               ),
				   'UserTag.content' => array(
   				   		'label' => __('Content', true)
	               )																										
			));
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('User Tag Details', true),
	                'UserTag.alias' => array(
   				   		'label' => __('Alias', true)
	                )																								
			));
	echo $admin->EndTabContent();
	
	echo $admin->EndTabs();
	
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit')) . $admin->formButton(__('Apply', true), 'apply.png', array('type' => 'submit', 'name' => 'apply')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>