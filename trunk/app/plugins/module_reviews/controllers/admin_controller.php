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