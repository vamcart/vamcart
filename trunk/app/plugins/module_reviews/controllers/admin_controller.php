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

class AdminController extends ModuleReviewsAppController {
	var $uses = array('ModuleReview');
	var $helpers = array('Time','Admin');
	
	function admin_delete ($id)
	{
		$this->ModuleReview->del($id);
		$this->Session->setFlash(__('Record Deleted.',true));
		$this->redirect('/module_reviews/admin/admin_index/');
	}
	
	function admin_edit ($id)
	{
		$this->set('current_crumb',__('Read Review',true));
		$this->set('data',$this->ModuleReview->read(null,$id));
		$this->render('','admin');		
	}
	
	function admin_index()
	{
		$this->set('current_crumb',__('Manage Reviews',true));
		$this->set('reviews',$this->ModuleReview->findAll());
		$this->render('','admin');
	}
	
	function admin_help()
	{
		$this->render('','admin');
	}

}

?>