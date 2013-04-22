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

	echo $this->Form->create('EmailTemplate', array('id' => 'contentform', 'action' => '/email_template/admin_edit/' . $data['EmailTemplate']['id'], 'url' => '/email_template/admin_edit/' . $data['EmailTemplate']['id']));
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Email Templates Details'),
				   'EmailTemplate.id' => array(
				   		'type' => 'hidden',
						'value' => $data['EmailTemplate']['id']
	               )
		 ));
		
		echo $this->Form->inputs(array(
						'legend' => null,
	               'EmailTemplate.alias' => array(
   				   		'label' => __('Alias'),				   
   						'value' => $data['EmailTemplate']['alias']
	               )
				));
	
			echo '<ul id="myTabLang" class="nav nav-tabs">';
	foreach($languages AS $language)
	{
			echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],'cus-page');
	}
			echo '</ul>';

	echo $this->Admin->StartTabs();
	
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $this->Admin->StartTabContent('language_'.$language_key);
		
	   	echo $this->Form->inputs(array(
						'legend' => null,
	   				'EmailTemplateDescription.' . $language['Language']['id'].'.subject' => array(
				   	'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Subject'),
						'value' => $data['EmailTemplateDescription'][$language_key]['subject']
	            	  ) 	   																									
				));
		echo $this->Form->inputs(array(
					'legend' => null,
					'EmailTemplateDescription.' . $language['Language']['id'].'.content' => array(
			   	'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . __('Content'),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',											
					'value' => $data['EmailTemplateDescription'][$language_key]['content']
            	  )));
	
	echo $this->Admin->EndTabContent();
	
	}
	
	echo $this->Admin->EndTabs();
	
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
	?>