<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ConfigurationGroupController extends AppController {
	var $name = 'ConfigurationGroup';
	
	function admin ()
	{
		$this->set('current_crumb', __('Store Configuration', true));
		$this->set('title_for_layout', __('Store Configuration', true));
		
		$this->set('data',$this->ConfigurationGroup->find('all'));
	}
}
?>