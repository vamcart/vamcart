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

class AdminController extends ShippingAppController {
	var $uses = null;
	
	function edit($code)
	{
		App::import('Model', 'ShippingMethod');
		$this->ShippingMethod =& new ShippingMethod();
		
		$data = $this->ShippingMethod->findByCode($code);
	
		$keys = array();
		if(!empty($data['ShippingMethodValue']))
			$keys = array_combine(Set::extract($data, 'ShippingMethodValue.{n}.key'),
							  Set::extract($data, 'ShippingMethodValue.{n}.value'));		
				
		$this->set('data',$keys);
	}
	
}
?>