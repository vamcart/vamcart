<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Form->input('AddressBook.ship_country', 
   					array(
							'type' => 'select',
							'id' => 'ship_country',
				   		'label' => __('Country'),
							'options' => $country_list
	               ));
	               