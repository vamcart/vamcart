<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/plugins/jquery-ui-min.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $html->css('ui.tabs', null, array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('EmailTemplate', array('id' => 'contentform', 'action' => '/email_template/admin_edit/' . $data['EmailTemplate']['id'], 'url' => '/email_template/admin_edit/' . $data['EmailTemplate']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Email Templates Details', true),
				   'EmailTemplate.id' => array(
				   		'type' => 'hidden',
						'value' => $data['EmailTemplate']['id']
	               )
		 ));
		
		echo $form->inputs(array(
						'legend' => null,
	               'EmailTemplate.alias' => array(
   				   		'label' => __('Alias', true),				   
   						'value' => $data['EmailTemplate']['alias']
	               )
				));
	
	echo $admin->StartTabs();
			echo '<ul>';
	foreach($languages AS $language)
	{
			echo $admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],$language['Language']['iso_code_2'].'.png');
	}
			echo '</ul>';
	
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $admin->StartTabContent('language_'.$language_key);
		
	   	echo $form->inputs(array(
						'legend' => null,
	   				'EmailTemplateDescription.' . $language['Language']['id'].'.subject' => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Subject', true),
						'value' => $data['EmailTemplateDescription'][$language_key]['subject']
	            	  ) 	   																									
				));
		echo $form->inputs(array(
					'legend' => null,
					'EmailTemplateDescription.' . $language['Language']['id'].'.content' => array(
			   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Content', true),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',											
					'value' => $data['EmailTemplateDescription'][$language_key]['content']
            	  )));
	
	echo $admin->EndTabContent();
	
	}
	
	echo $admin->EndTabs();
	
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
	?>