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

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_edit_details/'.$data['Template']['id'], 'url' => '/templates/admin_edit_details/'.$data['Template']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Template Details', true),
				   'Template.id' => array(
				   		'type' => 'hidden',
						'value' => $data['Template']['id']
	               ),
	               'Template.name' => array(
				   		'label' => __('Name', true),
   						'value' => $data['Template']['name']
	               )																										
			));
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>