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
//pr($data);
	

	echo $form->create('Content', array('id' => 'contentform', 'name' => 'contentform','enctype' => 'multipart/form-data', 'action' => '/contents/admin_edit/'.$data['Content']['id'], 'url' => '/contents/admin_edit/'.$data['Content']['id']));
	
	echo $admin->StartTabs();
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('options',__('Options',true));			
	echo $admin->EndTabs();
	
	echo $admin->StartTabContent('main');
		echo '<fieldset>';
		echo $form->inputs(array(
				'fieldset' => 'adfsdf',
				'Content/id' => array(
					'type' => 'hidden',
					'value' => $data['Content']['id']
	               ),
				'Content/order' => array(
					'type' => 'hidden',
					'value' => $data['Content']['order']
	               ),
				'Content/parent_id' => array(
					'type' => 'hidden',
					'value' => '-1'
	               ),				   
				'Content/content_type_id' => array(
					'label' => __('Content Type', true),
					'type' => 'hidden',
					'value' => $data['Content']['content_type_id']
	              )
				));
		echo $this->requestAction( '/contents/admin_edit_type/' . $data['Content']['content_type_id'] . '/' . $data['Content']['id'], array('return'=>true));	
				  
	
	echo '<div class="template_required" id="template_required_template_picker">';
	
	  	echo $form->inputs(array('Content/template_id' => array(
						'type' => 'select',
				   		'label' => __('Template', true),
						'options' => $templates,
						'selected' => $data['Content']['template_id']
	            	  )));
	echo '</div>';	
	
	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][name/' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . $language['Language']['name'] . ' ' . __('Title', true),
						'value' => $data['ContentDescription'][$language_key]['name']
	            	  )));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required">';
			echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][description/' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . $language['Language']['name'] . ' ' . __('Description', true),
						'type' => 'textarea',
						'value' => $data['ContentDescription'][$language_key]['description']
	            	  )));
		echo '</div>';						  
	}
		
		
	echo '</fieldset>';
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
			echo $form->inputs(array(
				'fieldset' => __('Content Details', true),
                'Content/alias' => array(
			   		'type' => 'hidden',
					'value' => $data['Content']['alias']
                ),
				'Content/head_data' => array(
					'label' => __('Head Data', true),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',
					'value' => $data['Content']['head_data']
	             ),				
			    'Content/active' => array(
					'type' => 'hidden',
					'value' => '1'
                )
		));
	echo $admin->EndTabContent();
	
	echo $form->submit( __('Submit', true), array('name' => 'submitbutton', 'id' => 'submitbutton')) . $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	?>
</div>