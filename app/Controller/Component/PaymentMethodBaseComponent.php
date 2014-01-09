<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class PaymentMethodBaseComponent extends Object 
{

	public function beforeFilter ()
	{
	}

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
	
	public function save_customer_data()
	{
		App::uses('CustomerBaseComponent', 'Controller/Component');
		$this->CustomerBase =& new CustomerBaseComponent(new ComponentCollection());
		$this->CustomerBase->save_customer_details($_POST);

		App::uses('OrderBaseComponent', 'Controller/Component');	
		$this->OrderBase =& new OrderBaseComponent(new ComponentCollection());		
		
		$this->OrderBase->update_order_totals();
	}
	
}
?>