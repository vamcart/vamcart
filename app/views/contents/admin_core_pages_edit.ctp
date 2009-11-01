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

	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('jquery/plugins/jquery-ui.min', false);
	echo $javascript->link('tabs', false);
	echo $html->css('jquery/plugins/ui/css/smoothness/jquery-ui','','', false);

	echo $form->create('Content', array('id' => 'contentform', 'name' => 'contentform','enctype' => 'multipart/form-data', 'action' => '/contents/admin_edit/'.$data['Content']['id'], 'url' => '/contents/admin_edit/'.$data['Content']['id']));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('options',__('Options',true));			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
				'fieldset' => __('Edit Page', true),
				'Content.id' => array(
					'type' => 'hidden',
					'value' => $data['Content']['id']
	               ),
				'Content.order' => array(
					'type' => 'hidden',
					'value' => $data['Content']['order']
	               ),
				'Content.parent_id' => array(
					'type' => 'hidden',
					'value' => '-1'
	               ),				   
				'Content.content_type_id' => array(
					'label' => __('Content Type', true),
					'type' => 'hidden',
					'value' => $data['Content']['content_type_id']
	              )
				));
		echo $this->requestAction( '/contents/admin_edit_type/' . $data['Content']['content_type_id'] . '/' . $data['Content']['id'], array('return'));	
				  
	
	echo '<div class="template_required" id="template_required_template_picker">';
	
	  	echo $form->inputs(array('Content.template_id' => array(
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
		
		echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][name.' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Title (%s) ', true),__($language['Language']['name'], true)),
						'value' => $data['ContentDescription'][$language_key]['name']
	            	  )));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required">';
			echo $form->inputs(array('ContentDescription]['.$language['Language']['id'].'][description.' . $language['Language']['id'] => array(
				   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Description (%s) ', true),__($language['Language']['name'], true)),
						'type' => 'textarea',
						'value' => $data['ContentDescription'][$language_key]['description']
	            	  )));
		echo '</div>';						  
	}
		
		
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
			echo $form->inputs(array(
				'fieldset' => __('Content Details', true),
                'Content.alias' => array(
			   		'type' => 'hidden',
					'value' => $data['Content']['alias']
                ),
				'Content.head_data' => array(
					'label' => __('Head Data', true),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',
					'value' => $data['Content']['head_data']
	             ),				
			    'Content.active' => array(
					'type' => 'hidden',
					'value' => '1'
                )
		));
	echo $admin->EndTabContent();

	echo $admin->EndTabs();
	
	echo $form->submit( __('Submit', true), array('name' => 'submitbutton', 'id' => 'submitbutton')) . $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>