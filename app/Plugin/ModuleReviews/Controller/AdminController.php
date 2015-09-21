<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleReviewsAppController', 'ModuleReviews.Controller');

class AdminController extends ModuleReviewsAppController {
	public $uses = array('ModuleReviews.ModuleReview');
	public $helpers = array('Time','Admin');
	public $components = array('ContentBase');
	public $paginate = array('limit' => 20, 'order' => array('ModuleReview.created' => 'desc'));
	
	public function admin_delete ($id)
	{
		$this->ModuleReview->delete($id);
		$this->Session->setFlash(__('Record Deleted.'));
		$this->redirect('/module_reviews/admin/admin_index/');
	}

	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['ModuleReview']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->ModuleReview->id = $value;
				$review = $this->ModuleReview->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						$this->ModuleReview->delete($value);
						$build_flash .= __('Record deleted.', true) . ' ' . $review['ModuleReview']['name'] . '<br />';									
					break;								
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/module_reviews/admin/admin_index/');
	}	
		
	public function admin_edit ($id)
	{
		$this->set('current_crumb', __('Reviews'));
		$this->set('title_for_layout', __('Read Review'));

		if(empty($this->data))
		{

		$data = $this->ModuleReview->read(null,$id);
		$this->request->data = $this->ModuleReview->read(null,$id);
		
		$content_description = $this->ContentBase->get_content_description($data['ModuleReview']['content_id']);
    	$data['ModuleReview']['product_name'] = $content_description['ContentDescription']['name'];

		$this->set('data',$data);
		$this->set('id',$id);

		}
		else
		{
			$this->ModuleReview->save($this->data);		
			$this->Session->setFlash(__('Record saved.', true));
			$this->redirect('/module_reviews/admin/admin_edit/'.$id);
		}		
		
	}
	
	public function admin_index()
	{
		$this->set('current_crumb', __('Manage Reviews'));
		$this->set('title_for_layout', __('Reviews'));
		$data = $this->paginate('ModuleReview');
		
    	foreach($data AS $key => $value)
    	{
        $content_description = $this->ContentBase->get_content_description($data[$key]['ModuleReview']['content_id']);
        $data[$key]['ModuleReview']['product_name'] = $content_description['ContentDescription']['name'];
      }

		$this->set('reviews',$data);
	}
	
	public function admin_help()
	{
		$this->set('current_crumb', __('Reviews'));
		$this->set('title_for_layout', __('Reviews'));
	}

}

?>