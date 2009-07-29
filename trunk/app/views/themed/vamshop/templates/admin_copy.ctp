<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_copy/' . $template['Template']['id'], 'url' => '/templates/admin_copy/' . $template['Template']['id']));
	echo $form->inputs(array(
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