<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
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
		$this->ModuleReview->delete($id);
		$this->Session->setFlash(__('Record Deleted.',true));
		$this->redirect('/module_reviews/admin/admin_index/');
	}
	
	function admin_edit ($id)
	{
		$this->set('current_crumb',__('Read Review',true));
		$this->set('title_for_layout', __('Read Review', true));
		$this->set('data',$this->ModuleReview->read(null,$id));
	}
	
	function admin_index()
	{
		$this->set('current_crumb',__('Manage Reviews',true));
		$this->set('title_for_layout', __('Manage Reviews', true));
		$this->set('reviews',$this->ModuleReview->find('all'));
	}
	
	function admin_help()
	{
		$this->set('current_crumb',__('Reviews',true));
		$this->set('title_for_layout', __('Reviews', true));
	}

}

?>