<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleReviewsAppController', 'ModuleReviews.Controller');

class ActionController extends ModuleReviewsAppController {
	var $uses = array('ModuleReview');
	var $components = array('ContentBase');
	
	function link ()
	{
		global $content, $config;
		$assignments = array('review_display_link' => BASE.'/page/read-reviews'.$config['URL_EXTENSION'].'?content_id=' . $content['Content']['id'],
							 'review_create_link' => BASE.'/page/create-review'.$config['URL_EXTENSION'].'?content_id=' . $content['Content']['id']);
		return $assignments;
	}
	
	function create ()
	{
		if(!empty($_POST))
		{
			$new_review = array();
			$new_review['ModuleReview']['content_id'] = $_POST['content_id'];
			$new_review['ModuleReview']['name'] = $_POST['name'];
			$new_review['ModuleReview']['content'] = $_POST['content'];
			
			App::uses('Sanitize', 'Utility');
			$Clean = new Sanitize();
			
			$Clean->paranoid($new_review);
			
			$this->ModuleReview->save($new_review);
			
			global $config;
			
			$this->redirect('/page/read-reviews'.$config['URL_EXTENSION'].'?content_id=' . $_POST['content_id']);
		}
		else
		{
			$content = $this->ContentBase->get_content_information($_GET['content_id']);
			$content_description = $this->ContentBase->get_content_description($_GET['content_id']);			
			
			$assignments = array();
			$assignments['content_id'] = $_GET['content_id'];
			$assignments['content_alias'] = $content['Content']['alias'];
			$assignments['content_name'] = $content_description['ContentDescription']['name'];
			return $assignments;
		}
	}
	
	function display () 
	{
		$assignments = array();
		if(empty($_GET['content_id']))
		{
			global $content;
			$content_id = $content['Content']['id'];	
		}
		else
			$content_id = $_GET['content_id'];
		
		$this->ModuleReview->unbindAll();		
		$reviews = $this->ModuleReview->find('all', array('conditions' => array('content_id' => $content_id)));
		
		App::uses('CakeTime', 'Utility');
		
		$assigned_reviews = array();
		foreach($reviews AS $review)
		{
			$review['ModuleReview']['created'] = CakeTime::niceShort($review['ModuleReview']['created']);
			$assigned_reviews[] = $review['ModuleReview'];
		}

		// Assign some content vars
		$content = $this->ContentBase->get_content_information($content_id);
		$content_description = $this->ContentBase->get_content_description($content_id);			
			
		$assignments = array();
		$assignments['content_id'] = $content_id;
		$assignments['content_alias'] = $content['Content']['alias'];
		$assignments['content_name'] = $content_description['ContentDescription']['name'];		
		
		$assignments['reviews'] = $assigned_reviews;
		
		return $assignments;

	}
	
	/**
	* The template function simply calls the view specified by the $action parameter.
	*
	*/
	function template ($action)
	{
	}

}

?>