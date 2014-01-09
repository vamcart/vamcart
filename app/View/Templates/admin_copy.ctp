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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table-multiple');

	echo $this->Form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_copy/' . $template['Template']['id'], 'url' => '/templates/admin_copy/' . $template['Template']['id']));
	echo $this->Form->input('Template.id', 
						array(
							'type' => 'hidden',
							'value' =>  $template['Template']['id']
	               ));
	echo $this->Form->input('Template.name', 
						array(
							'type' => 'text',
							'label' => __('Template Copy Name') . ': '
	               ));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>