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

echo $form->create('Configuration', array('id' => 'contentform', 'action' => '/configuration/admin_edit/', 'url' => '/configuration/admin_edit/'));

$yes_no_options = array();
$yes_no_options[0] = __('no', true);
$yes_no_options[1] = __('yes', true);

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true), 'main.png');
			echo $admin->CreateTab('caching',__('Caching',true), 'cache.png');	
			echo $admin->CreateTab('email',__('Email Settings',true), 'email.png');	
			echo '</ul>';

	echo $admin->StartTabContent('main');
	
	echo $form->input('SITE_NAME', array('label' => __('Site Name', true), 'type' => 'text', 'value' => $configuration_values['SITE_NAME']['value']));
	echo $form->input('METADATA', array('label' => __('Metadata', true), 'type' => 'textarea', 'value' => $configuration_values['METADATA']['value']));
	echo $form->input('URL_EXTENSION', array('label' => __('URL Extension', true), 'type' => 'text', 'value' => $configuration_values['URL_EXTENSION']['value']));
	echo $form->input('GD_LIBRARY', array('label' => __('GD Library Enabled', true), 'type' => 'select', 'options' => $yes_no_options, 'selected' => $configuration_values['GD_LIBRARY']['value']));
	echo $form->input('THUMBNAIL_SIZE', array('label' => __('Image Thumbnail Size', true), 'type' => 'text', 'value' => $configuration_values['THUMBNAIL_SIZE']['value']));
	
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('caching');

	echo $form->input('CACHE_TIME', array('label' => __('Cache Time in Seconds', true), 'type' => 'text', 'value' => $configuration_values['CACHE_TIME']['value']));

	echo __('Reset Cache', true) . '&nbsp;&nbsp;&nbsp;' . $html->link(__('Click here to clear cache',true),'/configuration/admin_clear_cache/',array('class' => 'button'));
	echo $admin->EndTabContent();
	
	echo $admin->StartTabContent('email');
	
	echo $form->input('SEND_EXTRA_EMAIL', array('label' => __('Send extra order emails to', true), 'type' => 'text', 'value' => $configuration_values['SEND_EXTRA_EMAIL']['value']));
	echo $form->input('NEW_ORDER_FROM_EMAIL', array('label' => __('New Order: From', true), 'type' => 'text', 'value' => $configuration_values['NEW_ORDER_FROM_EMAIL']['value']));
	echo $form->input('NEW_ORDER_FROM_NAME', array('label' => __('New Order: From Name', true), 'type' => 'text', 'value' => $configuration_values['NEW_ORDER_FROM_NAME']['value']));
	echo $form->input('NEW_ORDER_STATUS_FROM_EMAIL', array('label' => __('New Order Status: From', true), 'type' => 'text', 'value' => $configuration_values['NEW_ORDER_STATUS_FROM_EMAIL']['value']));
	echo $form->input('NEW_ORDER_STATUS_FROM_NAME', array('label' => __('New Order Status: From Name', true), 'type' => 'text', 'value' => $configuration_values['NEW_ORDER_STATUS_FROM_NAME']['value']));
	echo $form->input('SEND_CONTACT_US_EMAIL', array('label' => __('Send contact us emails to', true), 'type' => 'text', 'value' => $configuration_values['SEND_CONTACT_US_EMAIL']['value']));
	
	echo $admin->EndTabContent();	
	
	echo $admin->EndTabs();
	
	echo $form->submit( __('Apply', true), array('name' => 'applybutton')) . $form->submit( __('Cancel', true), array('name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
?>