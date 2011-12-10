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

echo $admin->ShowPageHeaderStart($current_crumb, 'content.png');

echo $form->create('Configuration', array('id' => 'contentform', 'action' => '/configuration/admin_edit/', 'url' => '/configuration/admin_edit/'));

	echo $admin->StartTabs();
	
		$gr = '';	
		$st = '';	

		$yes_no_options = array();
		$yes_no_options[0] = __('no', true);
		$yes_no_options[1] = __('yes', true);
	
		foreach ($data AS $groups)
			{
			$gr .= $admin->CreateTab($groups['ConfigurationGroup']['key'],__($groups['ConfigurationGroup']['name'],true), $groups['ConfigurationGroup']['group_icon']);
			
					$st .= $admin->StartTabContent($groups['ConfigurationGroup']['key']);
					foreach($groups['Configuration'] AS $settings)
					{
						$st .= $form->input($settings['key'], array('label' => __($settings['name'], true), 'type' => $settings['type'], 'options' => (!isset($settings['options']) ? null : $yes_no_options), 'value' => $settings['value']));
					}
					$st .= $admin->EndTabContent();
			
		}

			echo '<ul>'.$gr.'</ul>';
			echo $st;

	echo $admin->EndTabs();

	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();

echo $admin->ShowPageHeaderEnd();

?>