<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $this->Form->create('Tax', array('id' => 'contentform', 'action' => '/taxes/admin_edit/', 'url' => '/taxes/admin_edit/'));
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Tax Details'),
				   'Tax.id' => array(
				   		'type' => 'hidden'
	               ),
	               'Tax.name' => array(
				   		'label' => __('Name')
	               )					     				   	   																									
			));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>