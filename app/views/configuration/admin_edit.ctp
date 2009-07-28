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

//pr($configuration_values);
echo $form->create('Configuration', array('id' => 'contentform', 'action' => '/configuration/admin_edit/', 'url' => '/configuration/admin_edit/'));

$yes_no_options = array();
$yes_no_options[0] = __('no', true);
$yes_no_options[1] = __('yes', true);

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('caching',__('Caching',true));	
			echo '</ul>';

	echo $admin->StartTabContent('main');
	
	
echo $form->inputs(array(
		'fieldset' => __('Store Settings', true),
		'Configuration/SITE_NAME' => array(
			'label' => __('Site Name', true),
			'type' => 'text',
			'value' => $configuration_values['SITE_NAME']['value']
              ),
		'Configuration/METADATA' => array(
			'label' => __('Metadata', true),
			'type' => 'textarea',
			'class' => 'pagesmalltextarea',
			'value' => $configuration_values['METADATA']['value']
             ),
		'Configuration/URL_EXTENSION' => array(
			'label' => __('URL Extension', true),
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
	echo $form->inputs(array(
		'fieldset' => __('Store Settings', true),
		'Configuration/CACHE_TIME' => array(
			'label' => __('Cache Time in Seconds', true),
			'type' => 'text',
			'value' => $configuration_values['CACHE_TIME']['value']
              ))
			);
	echo __('Reset Cache', true) . '&nbsp;&nbsp;&nbsp;' . $html->link(__('Click here to clear cache',true),'/configuration/admin_clear_cache/',array('class' => 'button'));
	echo $admin->EndTabContent();
	
	echo $admin->EndTabs();
	
	echo $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
?>