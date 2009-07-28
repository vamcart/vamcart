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

	echo $form->create('DefinedLanguage', array('id' => 'contentform', 'action' => '/defined_languages/admin_edit/'.$defined_key, 'url' => '/defined_languages/admin_edit/'.$defined_key));
	
		echo $form->inputs(array(
					'fieldset' => __('Defined Language Details', true),
	               'DefinedLanguage/key' => array(
   				   		'label' => __('Alias', true),				   
   						'value' => $defined_key
	               )
				));

	// Loop through the languages and display a name and descrition for each
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		// Quick fix to avoid errors, change this later
		if(!isset($data[$language_key]['DefinedLanguage']['value']))
			$data[$language_key]['DefinedLanguage']['value'] = "";
			
		echo $form->inputs(array('DefinedLanguage]['.$language['Language']['id'].'][value' => array(
			   		'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . sprintf(__('Value (%s) ', true),__($language['Language']['name'], true)),
					'type' => 'textarea',
					'class' => 'pagesmalltextarea',											
					'value' => $data[$language_key]['DefinedLanguage']['value']
            	  )));
	}

	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>