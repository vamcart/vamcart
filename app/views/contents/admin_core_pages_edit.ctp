<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/plugins/ui.core.js',
	'jquery/plugins/ui.tabs.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $html->css('ui.tabs', null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Content', array('id' => 'contentform', 'name' => 'contentform','enctype' => 'multipart/form-data', 'action' => '/contents/admin_edit/'.$data['Content']['id'], 'url' => '/contents/admin_edit/'.$data['Content']['id']));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true), 'main.png');
			echo $admin->CreateTab('options',__('Options',true), 'options.png');			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
				'legend' => false,
				'fieldset' => false,
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
	
	  	echo $form->inputs(array(
						'legend' => false,
	  					'Content.template_id' => array(
						'type' => 'select',
			   		'label' => __('Template', true),
						'options' => $templates,
						'selected' => $data['Content']['template_id']
	            	  )));
	echo '</div>';	
	
	echo $admin->StartTabs('sub-tabs');
			echo '<ul>';
	foreach($languages AS $language)
	{
			echo $admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],$language['Language']['iso_code_2'].'.png');
	}
			echo '</ul>';
	
	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $admin->StartTabContent('language_'.$language_key);
		
		echo $form->inputs(array(
						'legend' => false,
						'ContentDescription]['.$language['Language']['id'].'][name.' . $language['Language']['id'] => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Title', true),
						'value' => $data['ContentDescription'][$language_key]['name']
	            	  )));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required">';
			echo $form->inputs(array(
						'legend' => false,
						'ContentDescription]['.$language['Language']['id'].'][description.' . $language['Language']['id'] => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Description', true),
						'type' => 'textarea',
						'value' => $data['ContentDescription'][$language_key]['description']
	            	  )));
		echo '</div>';

		echo $form->inputs(array(
						'legend' => false,
						'ContentDescription]['.$language['Language']['id'].'][meta_title.' . $language['Language']['id'] => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Title', true),
						'value' => $data['ContentDescription'][$language_key]['meta_title']
	            	  )));																								

		echo $form->inputs(array(
						'legend' => false,
						'ContentDescription]['.$language['Language']['id'].'][meta_description.' . $language['Language']['id'] => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Description', true),
						'value' => $data['ContentDescription'][$language_key]['meta_description']
	            	  )));																								

		echo $form->inputs(array(
						'legend' => false,
						'ContentDescription]['.$language['Language']['id'].'][meta_keywords.' . $language['Language']['id'] => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Keywords', true),
						'value' => $data['ContentDescription'][$language_key]['meta_keywords']
	            	  )));																								
								  
	echo $admin->EndTabContent();
	
	}
		
	echo $admin->EndTabs();
		
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
			echo $form->inputs(array(
				'legend' => false,
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
	
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submitbutton', 'id' => 'submitbutton')) . $admin->formButton(__('Apply', true), 'apply.png', array('type' => 'submit', 'name' => 'applybutton')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
	?>