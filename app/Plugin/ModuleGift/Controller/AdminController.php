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

	public function admin_delete($id)
	{
		$this->ModuleGift->delete($id);
		$this->Session->setFlash(__d('module_gift', 'You have deleted a gift.'));
		$this->redirect('/module_gift/admin/admin_index/');
	}
	
	public function admin_edit($id = null)
	{
		if(empty($this->data))
		{
			$this->set('current_crumb', __d('module_gift', 'Gift Edit'));
			$this->set('title_for_layout', __d('module_gift', 'Gift Edit'));

			$this->request->data = $this->ModuleGift->read(null,$id);

		}
		else
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/module_gift/admin/admin_index/');
				die();
			}
			
			$this->ModuleGift->save($this->data);
			$this->Session->setFlash(__d('module_gift', 'You have saved a gift.'));
			
			if($id == null)
				$id = $this->ModuleGift->getLastInsertId();
			
			if(isset($this->data['applybutton']))
				$this->redirect('/module_gift/admin/admin_edit/' . $id);		
			else
				$this->redirect('/module_gift/admin/admin_index/');
		
		}
	}
	
	public function admin_new()
	{
		$this->redirect('/module_gift/admin/admin_edit/');
	}
	
	public function admin_index()
	{
		$this->set('current_crumb', __d('module_gift', 'Gifts'));
		$this->set('title_for_layout', __d('module_gift', 'Manage Gifts'));
		$this->set('gifts',$this->ModuleGift->find('all'));
	}
	
	public function admin_help()
	{
		$this->set('current_crumb', __d('module_gift', 'Gifts'));
		$this->set('title_for_layout', __d('module_gift', 'Gifts'));
	}

}

?>