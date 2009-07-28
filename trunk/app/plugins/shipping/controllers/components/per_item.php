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

class PerItemComponent extends Object 
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
		$key_values = $this->ShippingMethod->findByCode('per_item');
	
		$data = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
							  Set::extract($key_values, 'ShippingMethodValue.{n}.value'));	
		
		global $order;
		
		$shipping_total = $data['per_item_handling'];
		
		foreach($order['OrderProduct'] AS $product)
		{
			$shipping_total += ($data['per_item_amount']*$product['quantity']);
		}
		
		return $shipping_total;
	}
	
	
}
?>