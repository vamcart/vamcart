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
			echo $admin->CreateTab('main');
			echo $admin->CreateTab('options');			
	echo $admin->EndTabs();
	
	echo $admin->StartTabContent('main');
		echo '<fieldset>';

		echo $form->inputs(array(
					'fieldset' => __('country_details', true),
				   'Country/id' => array(
				   		'type' => 'hidden',
						'value' => $data['Country']['id']
	               ),
	               'Country/name' => array(
				   		'label' => __('name', true),
   						'value' => $data['Country']['name']
	               ),
	               'Country/iso_code_2' => array(
				   		'label' => __('iso_code_2', true),
   						'value' => $data['Country']['name']
	               ),
	               'Country/iso_code_3' => array(
				   		'label' => __('iso_code_3', true),
   						'value' => $data['Country']['iso_code_3']
	               )		     				   	   																									
			));
		echo $admin->EndTabContent();

		echo $admin->StartTabContent('options');
						echo $form->inputs(array(
					'fieldset' => __('country_details', true),
	               'Country/address_format' => array(
				   		'type' => 'textarea',
				   		'label' => __('address_format', true),
   						'value' => $data['Country']['address_format']
	               )		
				  ));	
		echo $admin->EndTabContent();
	echo $form->submit( __('form_submit', true), array('name' => 'submit')) . $form->submit( __('form_cancel', true), array('name' => 'cancel'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>