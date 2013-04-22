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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $this->Form->create('Country', array('id' => 'contentform', 'action' => '/countries/admin_edit/' . $data['Country']['id'], 'url' => '/countries/admin_edit/' . $data['Country']['id']));
	
			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	echo $this->Admin->StartTabContent('main');
		echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Country Details'),
				   'Country.id' => array(
				   		'type' => 'hidden',
						'value' => $data['Country']['id']
	               ),
	               'Country.name' => array(
				   		'label' => __('Name'),
   						'value' => $data['Country']['name']
	               ),
	               'Country.iso_code_2' => array(
				   		'label' => __('ISO Code 2'),
   						'value' => $data['Country']['name']
	               ),
	               'Country.iso_code_3' => array(
				   		'label' => __('ISO Code 3'),
   						'value' => $data['Country']['iso_code_3']
	               ),
                       'Country.eu' => array(
				   		'label' => __('EU Country'),
   						'value' => $data['Country']['eu']
	               ),
                       'Country.private' => array(
				   		'label' => __('Private person VAT'),
   						'value' => $data['Country']['privat']
	               ),
                       'Country.firm' => array(
				   		'label' => __('Firm VAT'),
   						'value' => $data['Country']['pravna']
	               )
			));
		echo $this->Admin->EndTabContent();

		echo $this->Admin->StartTabContent('options');
						echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Country Details'),
	               'Country.address_format' => array(
				   		'type' => 'textarea',
				   		'label' => __('Address Format'),
   						'value' => $data['Country']['address_format']
	               )		
				  ));	
		echo $this->Admin->EndTabContent();

	echo $this->Admin->EndTabs();

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>