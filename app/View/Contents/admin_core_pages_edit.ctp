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

	echo $this->Form->create('Content', array('id' => 'contentform', 'name' => 'contentform','enctype' => 'multipart/form-data', 'action' => '/contents/admin_edit/'.$data['Content']['id'], 'url' => '/contents/admin_edit/'.$data['Content']['id']));
	
			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	echo $this->Admin->StartTabContent('main');
		echo $this->Form->input('Content.id', 
						array(
							'type' => 'hidden',
							'value' => $data['Content']['id']
	               ));
		echo $this->Form->input('Content.order', 
						array(
							'type' => 'hidden',
							'value' => $data['Content']['order']
	               ));
		echo $this->Form->input('Content.parent_id', 
						array(
							'type' => 'hidden',
							'value' => '-1'
	               ));				   
		echo $this->Form->input('Content.content_type_id', 
						array(
							'label' => __('Content Type'),
							'type' => 'hidden',
							'value' => $data['Content']['content_type_id']
	              ));
		echo $this->requestAction( '/contents/admin_edit_type/' . $data['Content']['content_type_id'] . '/' . $data['Content']['id'], array('return'));	
				  
	
	echo '<div class="template_required" id="template_required_template_picker">';
	
	  	echo $this->Form->input('Content.template_id', 
	  					array(
							'type' => 'select',
			   			'label' => __('Template'),
							'options' => $templates,
							'selected' => $data['Content']['template_id']
						));
	echo '</div>';	
	
			echo '<ul id="myTabLang" class="nav nav-tabs">';
	foreach($languages AS $language)
	{
			echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],'cus-page-white');
	}
			echo '</ul>';

	echo $this->Admin->StartTabs('sub-tabs');
	
	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $this->Admin->StartTabContent('language_'.$language_key);
		
		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][name.' . $language['Language']['id'], 
							array(
				   			'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Title'),
								'value' => $data['ContentDescription'][$language_key]['name']
							));																								
	
		echo '<div id="template_required_' . $language['Language']['id'] . '" class="template_required">';
			echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][description.' . $language['Language']['id'], 
							array(
				   			'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Description'),
								'type' => 'textarea',
								'value' => $data['ContentDescription'][$language_key]['description']
							));
		echo '</div>';

		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][meta_title.' . $language['Language']['id'], 
							array(
				   			'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Title'),
								'value' => $data['ContentDescription'][$language_key]['meta_title']
							));																								

		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][meta_description.' . $language['Language']['id'], 
							array(
				   			'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Description'),
								'value' => $data['ContentDescription'][$language_key]['meta_description']
							));																								

		echo $this->Form->input('ContentDescription]['.$language['Language']['id'].'][meta_keywords.' . $language['Language']['id'], 
							array(
				   			'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Meta Keywords'),
								'value' => $data['ContentDescription'][$language_key]['meta_keywords']
							));																								
								  
	echo $this->Admin->EndTabContent();
	
	}
		
	echo $this->Admin->EndTabs();
		
	echo $this->Admin->EndTabContent();

	echo $this->Admin->StartTabContent('options');
			echo $this->Form->input('Content.alias', 
					array(
			   		'type' => 'hidden',
						'value' => $data['Content']['alias']
					));
			echo $this->Form->input('Content.head_data', 
					array(
						'label' => __('Head Data'),
						'type' => 'textarea',
						'class' => 'pagesmalltextarea',
						'value' => $data['Content']['head_data']
					));				
			echo $this->Form->input('Content.active', 
					array(
						'type' => 'hidden',
						'value' => '1'
					));
	echo $this->Admin->EndTabContent();

	echo $this->Admin->EndTabs();
	
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submitbutton', 'id' => 'submitbutton')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'applybutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
	?>