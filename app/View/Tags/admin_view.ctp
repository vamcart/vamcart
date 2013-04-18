<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Html->script('modified', array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'view.png');

echo $help_content;

echo $about_content;

if(isset($default_template))
{
	echo '<div class="pageheader">' . __('Default Template') . '</div>';
	
		echo $this->Form->create('MicroTemplate', array('id' => 'contentform', 'action' => '/micro_templates/admin_create_from_tag/', 'url' => '/micro_templates/admin_create_from_tag/'));
		
		echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details'),
					'MicroTemplate.tag_name' => array(
						'value' => $tag_name,
   				   		'type' => 'hidden'
	                ),
					'MicroTemplate.tag_type' => array(
						'value' => $tag_type,
   				   		'type' => 'hidden'
	                ),
					'MicroTemplate.template' => array(
						'type' => 'textarea',
				   	'label' => __('Template'),
						'value' => $default_template,
						'onfocus' => 'this.select();'
					)
				));

	echo $this->Admin->formButton(__('Create Micro Template From Tag'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
}

echo $this->Admin->ShowPageHeaderEnd();

?>