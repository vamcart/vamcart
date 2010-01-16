<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $form->create('OrderStatus', array('id' => 'contentform', 'action' => '/order_status/admin_edit/' . $data['OrderStatus']['id'], 'url' => '/order_status/admin_edit/' . $data['OrderStatus']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Order Status Details', true),
				   'OrderStatus.id' => array(
				   		'type' => 'hidden',
						'value' => $data['OrderStatus']['id']
	               )
		 ));

	foreach($languages AS $language)
	{
		$language_key = $language['Language']['id'];
		
	   	echo $form->inputs(array(
						'legend' => null,
	   				'OrderStatusDescription.' . $language['Language']['id'] => array(
				   	'label' => $admin->ShowFlag($language['Language']) . '&nbsp;' . $language['Language']['name'],
						'value' => $data['OrderStatusDescription'][$language_key]['name']
	            	  ) 	   																									
				));
	}
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>