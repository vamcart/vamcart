<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	$this->Html->script(array(
			'focus-first-input.js',
			'modified.js'
	), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table-multiple');

	echo $this->Form->create('Stylesheet', array('id' => 'contentform', 'action' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'], 'url' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id']));
	echo $this->Form->input('Stylesheet.name', 
						array(
							'type' => 'text',
							'label' => __('Name the copy:'),
	               ));								
	echo $this->Form->input('Stylesheet.stylesheet', 
						array(
							'type' => 'hidden',
							'value' => $stylesheet['Stylesheet']['stylesheet']
	               ));
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>