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

class FlatRateComponent extends Object 
{

	function beforeFilter ()
	{
	}

    function startup(&$controller)
	{
    }


	function calculate ()
	{
		App::import('Model', 'ShippingMethod');
		$this->ShippingMethod =& new ShippingMethod();
		
		$method = $this->ShippingMethod->find(array('code' => 'flat_rate'));

		return $method['ShippingMethodValue'][0]['value'];
	}
	
}
?>