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
	$user_tag_id = $this->data['UserTag']['id'];
	echo $form->create('UserTag', array('action' => '/user_tags/admin_edit/'.$user_tag_id, 'url' => '/user_tags/admin_edit/'.$user_tag_id));
	
	echo $admin->StartTabs();
			echo $admin->CreateTab('main');
			echo $admin->CreateTab('options');			
	echo $admin->EndTabs();

	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
					'fieldset' => __('UserTag_details', true),
				   'UserTag/id' => array(
				   		'type' => 'hidden'
	               ),
	               'UserTag/name' => array(
   				   		'label' => __('name', true)
	               ),
				   'UserTag/content' => array(
   				   		'label' => __('content', true)
	               )																										
			));
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
		echo $form->inputs(array(
					'fieldset' => __('UserTag_details', true),
	                'UserTag/alias' => array(
   				   		'label' => __('alias', true)
	                )																								
			));
	echo $admin->EndTabContent();
	
	
	echo $form->submit('Submit', array('name' => 'submit')) . $form->submit('Apply', array('name' => 'apply')) . $form->submit('Cancel', array('name' => 'cancel'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>