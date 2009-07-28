<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $form->create('Country', array('id' => 'contentform', 'action' => '/countries/admin_edit/' . $data['Country']['id'], 'url' => '/countries/admin_edit/' . $data['Country']['id']));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('options',__('Options',true));			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
					'fieldset' => __('Country Details', true),
				   'Country/id' => array(
				   		'type' => 'hidden',
						'value' => $data['Country']['id']
	               ),
	               'Country/name' => array(
				   		'label' => __('Name', true),
   						'value' => $data['Country']['name']
	               ),
	               'Country/iso_code_2' => array(
				   		'label' => __('ISO Code 2', true),
   						'value' => $data['Country']['name']
	               ),
	               'Country/iso_code_3' => array(
				   		'label' => __('ISO Code 3', true),
   						'value' => $data['Country']['iso_code_3']
	               )		     				   	   																									
			));
		echo $admin->EndTabContent();

		echo $admin->StartTabContent('options');
						echo $form->inputs(array(
					'fieldset' => __('Country Details', true),
	               'Country/address_format' => array(
				   		'type' => 'textarea',
				   		'label' => __('Address Format', true),
   						'value' => $data['Country']['address_format']
	               )		
				  ));	
		echo $admin->EndTabContent();

	echo $admin->EndTabs();

	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>