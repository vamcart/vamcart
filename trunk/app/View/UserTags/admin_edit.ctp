<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'jquery/plugins/jquery-ui-min.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Html->css('ui.tabs', null, array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	$user_tag_id = $this->data['UserTag']['id'];
	echo $this->Form->create('UserTag', array('id' => 'contentform', 'action' => '/user_tags/admin_edit/'.$user_tag_id, 'url' => '/user_tags/admin_edit/'.$user_tag_id));
	
	echo $this->Admin->StartTabs();
			echo '<ul>';
			echo $this->Admin->CreateTab('main',__('Main'), 'main.png');
			echo $this->Admin->CreateTab('options',__('Options'), 'options.png');			
			echo '</ul>';
	
	echo $this->Admin->StartTabContent('main');
		echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('User Tag Details'),
				   'UserTag.id' => array(
				   		'type' => 'hidden'
	               ),
	               'UserTag.name' => array(
   				   		'label' => __('Name')
	               ),
				   'UserTag.content' => array(
   				   		'label' => __('Content')
	               )																										
			));
	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('options');
		echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('User Tag Details'),
	                'UserTag.alias' => array(
   				   		'label' => __('Alias')
	                )																								
			));
	echo $this->Admin->EndTabContent();
	
	echo $this->Admin->EndTabs();
	
	echo $this->Admin->formButton(__('Submit'), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submit')) . $this->Admin->formButton(__('Apply'), 'apply.png', array('type' => 'submit', 'name' => 'apply')) . $this->Admin->formButton(__('Cancel'), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>