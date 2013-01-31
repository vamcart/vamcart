<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminController extends ModuleCouponsAppController {
	var $helpers = array('Time','Admin');
	var $uses = array('ModuleCoupon');
	
	function admin_delete($id)
	{
		$this->ModuleCoupon->delete($id);
		$this->Session->setFlash(__('You have deleted a coupon.', true));
		$this->redirect('/module_coupons/admin/admin_index/');
	}
	
	function admin_edit($id = null)
	{
		if(empty($this->data))
		{
			$this->set('current_crumb',__('Edit Coupon', true));
			$this->set('title_for_layout', __('Edit Coupon', true));

			$this->set('free_shipping_options',array('no' => __('no' ,true), 'yes' => __('yes',true)));
			$this->data = $this->ModuleCoupon->read(null,$id);

		}
		else
		{
			if(isset($this->params['form']['cancelbutton']))
			{
				$this->redirect('/module_coupons/admin/admin_index/');
				die();
			}
			
			$this->ModuleCoupon->save($this->data);
			$this->Session->setFlash(__('You have updated a coupon.', true));
			
			if($id == null)
				$id = $this->ModuleCoupon->getLastInsertId();
			
			if(isset($this->params['form']['applybutton']))
				$this->redirect('/module_coupons/admin/admin_edit/' . $id);		
			else
				$this->redirect('/module_coupons/admin/admin_index/');
		
		}
	}
	
	function admin_new()
	{
		$this->redirect('/module_coupons/admin/admin_edit/');
	}
	
	function admin_index()
	{
		$this->set('current_crumb',__('Manage Coupons', true));
		$this->set('title_for_layout', __('Manage Coupons', true));
		$this->set('coupons',$this->ModuleCoupon->find('all'));
	}
	
	function admin_help()
	{
		$this->set('current_crumb',__('Coupons', true));
		$this->set('title_for_layout', __('Coupons', true));
	}

}

?>