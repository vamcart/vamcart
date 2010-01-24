<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $javascript->link('modified', false);
	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('jquery/plugins/ui.core', false);
	echo $javascript->link('jquery/plugins/ui.tabs', false);
	echo $javascript->link('tabs', false);
	echo $html->css('jquery/plugins/ui.tabs','','', false);

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
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>