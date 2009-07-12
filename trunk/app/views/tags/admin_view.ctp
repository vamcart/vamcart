<?php

echo $help_content;


echo '<div class="pageheader">' . __('about', true) . '</div>';
echo $about_content;

if(isset($default_template))
{
	echo '<div class="pageheader">' . __('default_template', true) . '</div>';
	
		echo $form->create('MicroTemplate', array('action' => '/micro_templates/admin_create_from_tag/', 'url' => '/micro_templates/admin_create_from_tag/'));
		
		echo $form->inputs(array(
					'fieldset' => __('list_template_details', true),
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
						'value' => $default_template,
						'onfocus' => 'this.select();'
					)
				));

	echo $form->submit('Create Micro Template From Tag', array('name' => 'submit'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	
}

?>