<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-add');

	echo $this->Form->create('MicroTemplate', array('id' => 'contentform', 'action' => '/micro_templates/admin_edit/', 'url' => '/micro_templates/admin_edit/'));
		
		echo $this->Form->input('MicroTemplate.id', 
							array(
   				   		'type' => 'hidden'
							));  
		echo $this->Form->input('MicroTemplate.alias', 
							array(
   				   		'label' => __('Alias')
							));
		echo $this->Form->input('MicroTemplate.tag_name', 
							array(
   				   		'label' => __('Tag Name')
							));
		echo $this->Form->input('MicroTemplate.template', 
							array(
								'type' => 'textarea',
   				   		'label' => __('Template')
	                	));

	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Apply'), 'cus-disk', array('class' => 'btn', 'type' => 'submit', 'name' => 'apply')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
	?>