<?php

echo $help_content;

echo '<div class="pageheader">' . __('About', true) . '</div>';
echo $about_content;

if(isset($default_template))
{
	echo '<div class="pageheader">' . __('Default Template', true) . '</div>';
	
		echo $form->create('MicroTemplate', array('action' => '/micro_templates/admin_create_from_tag/', 'url' => '/micro_templates/admin_create_from_tag/'));
		
		echo $form->inputs(array(
					'fieldset' => __('Template Details', true),
					'MicroTemplate/tag_name' => array(
						'value' => $tag_name,
   				   		'type' => 'hidden'
	                ),
					'MicroTemplate/tag_type' => array(
						'value' => $tag_type,
   				   		'type' => 'hidden'
	                ),
					'MicroTemplate/template' => array(
						'type' => 'textarea',
				   	'label' => __('Template', true),
						'value' => $default_template,
						'onfocus' => 'this.select();'
					)
				));

	echo $form->submit(__('Create Micro Template From Tag', true), array('name' => 'submit'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
}

?>