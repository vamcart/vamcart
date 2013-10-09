<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleReviewsAppController', 'ModuleReviews.Controller');

class AdminController extends ModuleReviewsAppController {
	var $uses = array('ModuleReviews.ModuleReview');
	var $helpers = array('Time','Admin');
	
	function admin_delete ($id)
	{
		$this->ModuleReview->delete($id);
		$this->Session->setFlash(__('Record Deleted.'));
		$this->redirect('/module_reviews/admin/admin_index/');
	}
	
	function admin_edit ($id)
	{
		$this->set('current_crumb',__('Read Review'));
		$this->set('title_for_layout', __('Read Review'));
		$this->set('data',$this->ModuleReview->read(null,$id));
	}
	
	function admin_index()
	{
		$this->set('current_crumb',__('Manage Reviews'));
		$this->set('title_for_layout', __('Manage Reviews'));
		$this->set('reviews',$this->ModuleReview->find('all'));
	}
	
	function admin_help()
	{
		$this->set('current_crumb',__('Reviews'));
		$this->set('title_for_layout', __('Reviews'));
	}

}

?>