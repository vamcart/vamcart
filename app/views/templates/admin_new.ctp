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

	echo $form->create('Template', array('id' => 'contentform', 'action' => '/templates/admin_new/', 'url' => '/templates/admin_new/'));
	echo $form->inputs(array(
					'fieldset' => __('Template Details', true),				   
	               'Template.name' => array(
				   		'label' => __('Name', true)
	               )																										
			));
	echo $form->submit( __('Create Template Set', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>