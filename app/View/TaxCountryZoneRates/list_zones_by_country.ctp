<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Form->input('TaxCountryZoneRate.country_zone_id', 
					array(
		   			'label' => __('Country Zones'),
						'type' => 'select',
						'options' => $zones,
						'selected' => 'ALL'
					));

?>