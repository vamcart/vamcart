<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Form->input('TaxCountryZoneRate.country_zone_id', 
					array(
		   			'label' => __('Country Zones'),
						'type' => 'select',
						'options' => $zones,
						'selected' => 'ALL'
					));

?>