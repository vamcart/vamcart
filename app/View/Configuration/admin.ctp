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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cog');

echo $this->Form->create('Configuration', array('id' => 'contentform', 'action' => '/configuration/admin_edit/', 'url' => '/configuration/admin_edit/'));

		$gr = '';	
		$st = '';	

		$yes_no_options = array();
		$yes_no_options[0] = __('no');
		$yes_no_options[1] = __('yes');
	
		foreach ($data AS $groups)
			{
			$gr .= $this->Admin->CreateTab($groups['ConfigurationGroup']['key'],__($groups['ConfigurationGroup']['name']), $groups['ConfigurationGroup']['group_icon']);
			
					$st .= $this->Admin->StartTabContent($groups['ConfigurationGroup']['key']);
					foreach($groups['Configuration'] AS $settings)
					{
						$st .= $this->Form->input($settings['key'], array('label' => __($settings['name']), 'type' => $settings['type'], 'options' => (!isset($settings['options']) ? null : $yes_no_options), 'value' => $settings['value']));
					}
					$st .= $this->Admin->EndTabContent();
			
		}

			echo '<ul id="myTab" class="nav nav-tabs">'.$gr.'</ul>';

			echo $this->Admin->StartTabs();

			echo $st;

	echo $this->Admin->EndTabs();

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>