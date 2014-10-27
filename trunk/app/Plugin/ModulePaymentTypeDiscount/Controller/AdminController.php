<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminController extends ModulePaymentTypeDiscountAppController {
	public $helpers = array('Time','Admin');
	public $uses = array('PaymentMethod', 'ModulePaymentTypeDiscount');

	public function admin_index()
	{
		$this->set('current_crumb', false);
		$this->set('title_for_layout', __d('module_payment_type_discount', 'Payment Type Discount'));
		$this->set('payment_methods',$this->PaymentMethod->find('all', array('conditions' => array('active' => '1'),'order' => array('name' => 'asc'))));

		if(!empty($this->data))
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/module_payment_type_discount/admin/admin_index/');
				die();
			}
			
			$this->ModulePaymentTypeDiscount->saveMany($this->data['ModulePaymentTypeDiscount']);
			$this->Session->setFlash(__d('module_payment_type_discount', 'Discounts saved.'));
			
			if(isset($this->data['applybutton']))
				$this->redirect('/module_payment_type_discount/admin/admin_index/');		
		}
		
	}
	
	public function admin_help()
	{
		$this->set('current_crumb', false);
		$this->set('title_for_layout', __d('module_payment_type_discount', 'Payment Type Discount'));
	}

	public function get_payment_discount ($id)
	{
		$this->set('data', $this->ModulePaymentTypeDiscount->findByPaymentMethodId($id));
	}

}

?>