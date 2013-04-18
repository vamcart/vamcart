<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'jquery/plugins/jquery-ui-min.js',
	'tabs.js',
	'focus-first-input.js'
), array('inline' => false));
	
	echo $this->Html->css('ui.tabs', null, array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $this->Form->create('OrderStatus', array('id' => 'contentform', 'action' => '/order_status/admin_edit/' . $data['OrderStatus']['id'], 'url' => '/order_status/admin_edit/' . $data['OrderStatus']['id']));
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Order Status Details'),
				   'OrderStatus.id' => array(
				   		'type' => 'hidden',
						'value' => $data['OrderStatus']['id']
	               )
		 ));
	
	echo $this->Admin->StartTabs();
			echo '<ul>';
	foreach($languages AS $language)
	{
			echo $this->Admin->CreateTab('language_'.$language['Language']['id'],$language['Language']['name'],$language['Language']['iso_code_2'].'.png');
	}
			echo '</ul>';
			
	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
		echo $this->Admin->StartTabContent('language_'.$language_key);
		
	   	echo $this->Form->inputs(array(
						'legend' => null,
	   				'OrderStatusDescription.' . $language['Language']['id'] => array(
				   	'label' => $this->Admin->ShowFlag($language['Language']) . '&nbsp;' . $language['Language']['name'],
						'value' => $data['OrderStatusDescription'][$language_key]['name']
	            	  ) 	   																									
				));
				
	echo $this->Admin->EndTabContent();
	
	}
	
	echo $this->Admin->EndTabs();
		
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>