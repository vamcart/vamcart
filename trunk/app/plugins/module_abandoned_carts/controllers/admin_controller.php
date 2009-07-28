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

class AdminController extends ModuleAbandonedCartsAppController {
	var $helpers = array('Time','Admin');
	var $uses = null;

	function purge_old_carts()
	{
		App::import('Model', 'Order');
		$this->Order =& new Order();
		
		$old_carts = $this->Order->findAll(array('Order.order_status_id' => '0'));
		foreach($old_carts AS $cart)
		{
			$this->Order->del($cart, true);
		}
		$this->Session->setFlash(__('Abandoned carts have been purged.', true));
		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}

	function admin_index ()
	{
		App::import('Model', 'Order');
		$this->Order =& new Order();
			
		$this->set('current_crumb',__('Abandoned Carts', true));
		$this->set('data',$this->Order->findAll(array('Order.order_status_id' => '0')));
		
		$this->render('','admin');
	}

	function admin_help()
	{
		$this->render('','admin');
	}

}

?>