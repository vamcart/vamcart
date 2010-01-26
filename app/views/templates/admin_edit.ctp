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

	echo $javascript->link('modified', false);
	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('focus-first-input', false);

	$template_id = $this->data['Template']['id'];

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_edit/'.$template_id, 'url' => '/templates/admin_edit/'.$template_id));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details', true),
				   'Template.id' => array(
				   		'type' => 'hidden'
	               ),
				   'Template.template' => array(
   				   		'label' => __('Template', true)
	               )																										
			));
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Apply', true), array('name' => 'apply')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>