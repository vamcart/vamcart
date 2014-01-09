<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class CustomerBaseComponent extends Object 
{

   public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
	}

	/**
	* Saves all current customer information to the correct order record
	*
	* @param  array  $details A key => value paired array of customer details.  Keys should be the same as the fields in the Order table.
	*/
	public function save_customer_details ($customer_details)
	{

		App::uses('EventBaseComponent', 'Controller/Component');
		$this->EventBase =& new EventBaseComponent(new ComponentCollection());
		
		App::import('Model', 'Order');
		$this->Order =& new Order();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$this->EventBase->ProcessEvent('UpdateCustomerDetailsBeforeSave');
				
		foreach($customer_details AS $key => $value)
			$order['Order'][$key] = $value;
		
		$this->Order->save($order);
		
		$this->EventBase->ProcessEvent('UpdateCustomerDetailsAfterSave');		
	}
}
?>