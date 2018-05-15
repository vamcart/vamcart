<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

	echo $this->TinyMce->init();
	
	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

	echo $this->Form->create('EmailTemplate', array('id' => 'contentform', 'url' => '/email_template/admin_edit/' . $data['EmailTemplate']['id']));
	echo $this->Form->input('EmailTemplate.id', 
						array(
				   		'type' => 'hidden',
							'value' => $data['EmailTemplate']['id']
	               ));
		
		echo $this->Form->input('EmailTemplate.alias', 
						array(
   				   	'label' => __('Alias'),				   
   						'value' => $data['EmailTemplate']['alias']
	               ));
	
			echo '<ul id="myTabLang" class="nav nav-tabs">';
	foreach($languages AS $language)
	{
			echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],'cus-page-white');
	}
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $this->Admin->StartTabContent('language_'.$language_key);
		
	   	echo $this->Form->input('EmailTemplateDescription.' . $language['Language']['id'].'.subject', 
	   				array(
				   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Subject'),
							'value' => $data['EmailTemplateDescription'][$language_key]['subject']
	            	  ));
		echo $this->Form->input('EmailTemplateDescription.' . $language['Language']['id'].'.content', 
					array(
			   		'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Content'),
						'type' => 'textarea',
						'class' => 'pagesmalltextarea',											
						'value' => $data['EmailTemplateDescription'][$language_key]['content']
            	  ));

		echo $this->TinyMce->toggleEditor('EmailTemplateDescription.' . $language['Language']['id'].'.content');						  
			
	echo $this->Admin->EndTabContent();
	
	}
	
	echo $this->Admin->EndTabs();
	
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
	?>