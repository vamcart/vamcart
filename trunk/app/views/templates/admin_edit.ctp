<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	$template_id = $this->data['Template']['id'];
	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_edit/'.$template_id, 'url' => '/templates/admin_edit/'.$template_id));
	echo $form->inputs(array(
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
	?>
</div>