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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

	echo $this->Form->create('Country', array('id' => 'contentform', 'action' => '/countries/admin_edit/' . $data['Country']['id'], 'url' => '/countries/admin_edit/' . $data['Country']['id']));
	
			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	echo $this->Admin->StartTabContent('main');
		echo $this->Form->input('Country.id', 
						array(
				   		'type' => 'hidden',
							'value' => $data['Country']['id']
	               ));
		echo $this->Form->input('Country.name', 
	               array(
				   		'label' => __('Name'),
   						'value' => $data['Country']['name']
	               ));
		echo $this->Form->input('Country.iso_code_2', 
	               array(
				   		'label' => __('ISO Code 2'),
   						'value' => $data['Country']['name']
	               ));
		echo $this->Form->input('Country.iso_code_3', 
						array(
				   		'label' => __('ISO Code 3'),
   						'value' => $data['Country']['iso_code_3']
	               ));

		echo $this->Form->input('Country.active', array(
				   		'label' => __('Active'),
				   		'type' => 'checkbox',
							'class' => 'checkbox_group',	
   						'checked' => $active_checked
	               )	);

		echo $this->Admin->EndTabContent();

		echo $this->Admin->StartTabContent('options');
						echo $this->Form->input('Country.address_format', 
							array(
				   			'type' => 'textarea',
				   			'label' => __('Address Format'),
   							'value' => $data['Country']['address_format']
	               	));	
		echo $this->Admin->EndTabContent();

	echo $this->Admin->EndTabs();

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>