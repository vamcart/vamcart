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
	
echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');
	
	echo $form->create('DefinedLanguage', array('id' => 'contentform', 'action' => '/defined_languages/admin_edit/'.$defined_key, 'url' => '/defined_languages/admin_edit/'.$defined_key));
	
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Defined Language Details', true),
	               'DefinedLanguage.key' => array(
   				   		'label' => __('Alias', true),				   
   						'value' => $defined_key
	               )
				));
	
	echo $admin->StartTabs();
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
		
		// Quick fix to avoid errors, change this later
		if(!isset($data[$language_key]['DefinedLanguage']['value']))
			$data[$language_key]['DefinedLanguage']['value'] = "";
			
		echo $form->inputs(array(
					'legend' => null,
					'DefinedLanguage]['.$language['Language']['id'].'][value' => array(
			   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . __('Value', true),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',											
					'value' => $data[$language_key]['DefinedLanguage']['value']
            	  )));
            	  
	echo $admin->EndTabContent();
	
	}
	
	echo $admin->EndTabs();
	
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
echo $admin->ShowPageHeaderEnd();
	
	?>