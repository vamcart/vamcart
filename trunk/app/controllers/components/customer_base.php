<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class CustomerBaseComponent extends Object 
{

    function startup(&$controller)
	{

    }

	/**
	* Saves all current customer information to the correct order record
	*
	* @param  array  $details A key => value paired array of customer details.  Keys should be the same as the fields in the Order table.
	*/
	function save_customer_details ($customer_details)
	{

		App::import('Component', 'EventBase');
		$this->EventBase =& new EventBaseComponent();
		
		App::import('Model', 'Order');
		$this->Order =& new Order();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$this->EventBase->ProcessEvent('UpdateCustomerDetailsBeforeSave');
				
		foreach($customer_details AS $key => $value)
			$order['Order'][$key] = $value;
			$order['Order']['cc_expiration_month'] = $order['Order']['cc_expiration']['month'];
			$order['Order']['cc_expiration_year'] = $order['Order']['cc_expiration']['year'];

		$this->Order->save($order);
		
		$this->EventBase->ProcessEvent('UpdateCustomerDetailsAfterSave');		
	}
}
?>