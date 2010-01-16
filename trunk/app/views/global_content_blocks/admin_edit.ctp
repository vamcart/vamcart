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

	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('jquery/plugins/jquery-ui.min', false);
	echo $javascript->link('tabs', false);
	echo $html->css('jquery/plugins/ui/css/smoothness/jquery-ui','','', false);

	$id = $this->data['GlobalContentBlock']['id'];
	echo $form->create('GlobalContentBlock', array('id' => 'contentform', 'action' => '/global_content_blocks/admin_edit/'.$id, 'url' => '/global_content_blocks/admin_edit/'.$id));
	
	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true));
			echo $admin->CreateTab('options',__('Options',true));			
			echo '</ul>';
	
	echo $admin->StartTabContent('main');
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Global Content Block Details', true),
				   'GlobalContentBlock.id' => array(
				   		'type' => 'hidden'
	               ),
	               'GlobalContentBlock.name' => array(
   				   		'label' => __('Name', true)
	               ),
				   'GlobalContentBlock.content' => array(
   				   		'label' => __('Contents', true)
	               )																										
			));
	echo $admin->EndTabContent();

	echo $admin->StartTabContent('options');
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Global Content Block Details', true),
	                'GlobalContentBlock.alias' => array(
   				   		'label' => __('Alias', true)
	                ),
				    'GlobalContentBlock.active' => array(
						'type' => 'checkbox',
   				   		'label' => __('Active', true),
						'value' => '1',
						'class' => 'checkbox_group'
	                )																										
			));
	echo $admin->EndTabContent();
	
	echo $admin->EndTabs();
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Apply', true), array('name' => 'apply')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>