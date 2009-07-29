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

	echo $form->inputs(array('TaxCountryZoneRate.country_zone_id' => array(
			   		'label' => __('Country Zones', true),
					'type' => 'select',
					'options' => $zones,
					'selected' => 'ALL'
	              )));

?>