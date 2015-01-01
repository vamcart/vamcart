<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Form->input('AddressBook.ship_state', 
   					array(
							'type' => 'select',
							'id' => 'ship_state',
				   		'label' => __('State'),
							'options' => $state_list
	               ));