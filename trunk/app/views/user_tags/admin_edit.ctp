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

$javascript->link(array(
	'modified.js',
	'jquery/jquery.min.js',
	'jquery/plugins/ui.core.js',
	'jquery/plugins/ui.tabs.js',
	'tabs.js',
	'focus-first-input.js'
), false);

	echo $html->css('jquery/plugins/ui.tabs','','', false);

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
	
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Apply', true), array('name' => 'apply')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>