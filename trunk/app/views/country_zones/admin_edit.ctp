<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/jquery.min.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');
	
	echo $form->create('CountryZone', array('id' => 'contentform', 'action' => '/country_zones/admin_edit/' . $country_id, 'url' => '/country_zones/admin_edit/' . $country_id));
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Country Zone Details', true),
				   'CountryZone.country_id' => array(
				   		'type' => 'hidden',
						'value' => $country_id
	               ),
				   'CountryZone.id' => array(
				   		'type' => 'hidden'
	               ),
	               'CountryZone.name' => array(
				   		'label' => __('Name', true)
	               ),
	               'CountryZone.code' => array(
				   		'label' => __('Code', true)
	               )	     		
				   ));		   	   																									
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
	?>