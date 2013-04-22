<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>