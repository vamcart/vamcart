<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
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