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
        echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_copy/' . $template['Template']['id'], 'url' => '/templates/admin_copy/' . $template['Template']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Copy Template', true),
					'Template.id' => array(
						'type' => 'hidden',
						'value' =>  $template['Template']['id']
	               ),
					'Template.name' => array(
						'type' => 'text',
						'label' => __('Template Copy Name', true) . ': '
	               )										   																
			));
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>