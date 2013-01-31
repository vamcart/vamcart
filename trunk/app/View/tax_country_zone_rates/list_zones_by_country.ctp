<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $form->inputs(array(
					'legend' => null,
					'TaxCountryZoneRate.country_zone_id' => array(
		   		'label' => __('Country Zones', true),
					'type' => 'select',
					'options' => $zones,
					'selected' => 'ALL'
	              )));

?>