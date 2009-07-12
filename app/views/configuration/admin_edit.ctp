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

//pr($configuration_values);
echo $form->create('Configuration', array('action' => '/configuration/admin_edit/', 'url' => '/configuration/admin_edit/'));

$yes_no_options = array();
$yes_no_options[0] = 'no';
$yes_no_options[1] = 'yes';

	echo $admin->StartTabs();
			echo $admin->CreateTab('main');
			echo $admin->CreateTab('caching');	
	echo $admin->EndTabs();


	echo $admin->StartTabContent('main');
	
	
echo $form->inputs(array(
		'fieldset' => 'store_settings',
		'Configuration/SITE_NAME' => array(
			'label' => __('configuration_site_name', true),
			'type' => 'text',
			'value' => $configuration_values['SITE_NAME']['value']
              ),
		'Configuration/METADATA' => array(
			'label' => __('configuration_metadata', true),
			'type' => 'textarea',
			'class' => 'pagesmalltextarea',
			'value' => $configuration_values['METADATA']['value']
             ),
		'Configuration/URL_EXTENSION' => array(
			'label' => __('configuration_url_ext', true),
			'type' => 'text',
			'value' => $configuration_values['URL_EXTENSION']['value']
              ),			 
		'Configuration/GD_LIBRARY' => array(
			'label' => __('GD Library Enabled', true),
			'type' => 'select',
			'options' => $yes_no_options,
			'selected' => $configuration_values['GD_LIBRARY']['value']
              ),			 			  
		'Configuration/THUMBNAIL_SIZE' => array(
			'label' => __('Image Thumbnail Size', true),
			'type' => 'text',
			'value' => $configuration_values['THUMBNAIL_SIZE']['value']
              ),			 			  			  
	   ));
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('caching');
	echo '<fieldset>';
	echo $form->inputs(array(
		'fieldset' => 'store_settings',
		'Configuration/CACHE_TIME' => array(
			'label' => __('Cache Time in Seconds', true),
			'type' => 'text',
			'value' => $configuration_values['CACHE_TIME']['value']
              ))
			);
	echo 'Reset Cache &nbsp;&nbsp;&nbsp;' . $html->link(__('Click here to clear cache',true),'/configuration/admin_clear_cache/',array('class' => 'button'));
	echo '</fieldset>';			
	echo $admin->EndTabContent();
	
	
	echo $form->submit( __('form_apply', true), array('name' => 'applybutton')) . $form->submit( __('form_cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clearb"></div>';
	echo $form->end();
?>