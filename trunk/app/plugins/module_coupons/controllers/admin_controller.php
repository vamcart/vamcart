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

class AdminController extends ModuleCouponsAppController {
	var $helpers = array('Time','Admin');
	var $uses = array('ModuleCoupon');
	
	function admin_delete($id)
	{
		$this->ModuleCoupon->del($id);
		$this->Session->setFlash(__('You have deleted a coupon.', true));
		$this->redirect('/module_coupons/admin/admin_index/');
	}
	
	function admin_edit($id = null)
	{
		if(empty($this->data))
		{
			$this->set('current_crumb',__('Edit Coupon', true));

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
		$this->set('coupons',$this->ModuleCoupon->findl('all'));
	}
	
	function admin_help()
	{
	}

}

?>