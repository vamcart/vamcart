<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminController extends ModuleGiftAppController {
	public $helpers = array('Time','Admin');
	public $uses = array('PaymentMethod', 'ModuleGift');

	public function admin_index()
	{
		$this->set('current_crumb', __d('module_gift', 'Gift'));
		$this->set('title_for_layout', __d('module_gift', 'Gift'));
		$this->set('payment_methods',$this->PaymentMethod->find('all', array('conditions' => array('active' => '1'),'order' => array('name' => 'asc'))));

		if(!empty($this->data))
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/module_gift/admin/admin_index/');
				die();
			}
			
			$this->ModuleGift->saveMany($this->data['ModuleGift']);
			$this->Session->setFlash(__d('module_gift', 'Settings saved.'));
			
			if(isset($this->data['applybutton']))
				$this->redirect('/module_gift/admin/admin_index/');		
		}
		
	}
	
	public function admin_help()
	{
		$this->set('current_crumb', __d('module_gift', 'Gift'));
		$this->set('title_for_layout', __d('module_gift', 'Gift'));
	}

	public function get_gift ($id)
	{
		$this->set('data', $this->ModuleGift->findByPaymentMethodId($id));
	}

}

?>