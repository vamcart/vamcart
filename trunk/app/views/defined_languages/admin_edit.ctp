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

	echo $form->create('DefinedLanguage', array('action' => '/defined_languages/admin_edit/'.$defined_key, 'url' => '/defined_languages/admin_edit/'.$defined_key));	echo '<fieldset>';
	
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

	echo '</fieldset>';		
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>