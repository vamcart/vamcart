<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/


	echo $form->create('Country', array('action' => '/countries/admin_edit/' . $data['Country']['id'], 'url' => '/countries/admin_edit/' . $data['Country']['id']));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('options',__('Options',true));			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo '<fieldset>';

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