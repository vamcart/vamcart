<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

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

			$this->render('','admin');
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
		$this->set('coupons',$this->ModuleCoupon->findAll());
		$this->render('','admin');
	}
	
	function admin_help()
	{
		$this->render('','admin');
	}

}

?>