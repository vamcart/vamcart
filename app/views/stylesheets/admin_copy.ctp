<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	$html->script(array(
		'jquery/jquery.min.js',
		'focus-first-input.js',
		'modified.js'
	), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'copy.png');

	echo $form->create('Stylesheet', array('id' => 'contentform', 'action' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'], 'url' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' =>  __('Copy Stylesheet', true),
					'Stylesheet.name' => array(
						'type' => 'text',
						'label' => __('Name the copy:', true),
	               ),								
					'Stylesheet.stylesheet' => array(
						'type' => 'hidden',
						'value' => $stylesheet['Stylesheet']['stylesheet']
	               ),												   																
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>