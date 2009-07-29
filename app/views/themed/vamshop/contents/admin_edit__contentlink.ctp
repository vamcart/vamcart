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

echo $form->inputs(array(
		'fieldset' => __('Link Details', true),
		   'ContentLink.url' => array(
		   		'type' => 'text',
				'label' => __('URL', true),
				'value' => $data['ContentLink']['url']
              )
		  ));

?>