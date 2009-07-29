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

	echo $form->create('PaymentMethod', array('id' => 'contentform', 'action' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id'], 'url' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id']));
	echo $form->inputs(array(
					'fieldset' => __('Payment Method Details', true),
				   'PaymentMethod.id' => array(
				   		'type' => 'hidden',
						'value' => $data['PaymentMethod']['id']
	               ),
	               'PaymentMethod.name' => array(
				   		'label' => __('Name', true),
   						'value' => $data['PaymentMethod']['name']
	               )				     				   	   																									
			));
	
	echo $this->requestAction( '/payment/admin/edit/' . $data['PaymentMethod']['id'], array('return'=>true));	
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>