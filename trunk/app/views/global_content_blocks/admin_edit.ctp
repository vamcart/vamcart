<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/jquery.min.js',
	'jquery/plugins/ui.core.js',
	'jquery/plugins/ui.tabs.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $html->css('ui.tabs', null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	$id = $this->data['GlobalContentBlock']['id'];
	echo $form->create('GlobalContentBlock', array('id' => 'contentform', 'action' => '/global_content_blocks/admin_edit/'.$id, 'url' => '/global_content_blocks/admin_edit/'.$id));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true), 'main.png');
			echo $admin->CreateTab('options',__('Options',true), 'options.png');			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Global Content Block Details', true),
				   'GlobalContentBlock.id' => array(
				   		'type' => 'hidden'
	               ),
	               'GlobalContentBlock.name' => array(
   				   		'label' => __('Name', true)
	               ),
				   'GlobalContentBlock.content' => array(
   				   		'label' => __('Contents', true)
	               )																										
			));
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Global Content Block Details', true),
	                'GlobalContentBlock.alias' => array(
   				   		'label' => __('Alias', true)
	                ),
				    'GlobalContentBlock.active' => array(
						'type' => 'checkbox',
   				   		'label' => __('Active', true),
						'value' => '1',
						'class' => 'checkbox_group'
	                )																										
			));
	echo $admin->EndTabContent();
	
	echo $admin->EndTabs();
	
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Apply', true), 'apply.png', array('type' => 'submit', 'name' => 'apply')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>