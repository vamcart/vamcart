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
			global $content, $config;

		if(!empty($_POST))
		{
			
			if(empty($_POST['content_id']))
			{
				global $content;
				$content_id = $content['Content']['id'];	
			} else {
				$content_id = $_POST['content_id'];
			}
			
			$new_review = array();
			$new_review['ModuleReview']['content_id'] = $_POST['content_id'];
			$new_review['ModuleReview']['name'] = $_POST['name'];
			$new_review['ModuleReview']['content'] = $_POST['content'];
			
			App::uses('Sanitize', 'Utility');
			$Clean = new Sanitize();
			
			$Clean->paranoid($new_review);
			
			$this->ModuleReview->save($new_review);
		
			$this->redirect(BASE . '/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION']);
		}
		else
		{

			if(empty($_GET['content_id']))
			{
				global $content;
				$content_id = $content['Content']['id'];	
			} else {
				$content_id = $_GET['content_id'];
			}
			
			$content_description = $this->ContentBase->get_content_description($content_id);			
			
			$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());
			
			$assignments = array();
			
			$assignments['content_id'] = $content_id;
			$assignments['content_alias'] = $content['Content']['alias'];
			$assignments['content_name'] = $content_description['ContentDescription']['name'];
			$assignments['content_description'] = $content_description['ContentDescription']['description'];
			$assignments['content_price'] = $CurrencyBase->display_price($content['ContentProduct']['price']);	
			$assignments['content_url'] = BASE . '/' . $content_description['ContentDescription']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION'];
			
			return $assignments;
		}
	}
	
	function display () 
	{
		$assignments = array();
		
		$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());
		
		if(empty($_GET['content_id']))
		{
			global $content;
			$content_id = $content['Content']['id'];	
		}
		else
			$content_id = $_GET['content_id'];
		
		$this->ModuleReview->unbindAll();		
		$reviews = $this->ModuleReview->find('all', array('conditions' => array('content_id' => $content_id), 'order' => 'ModuleReview.id DESC'));
		
		App::uses('CakeTime', 'Utility');
		
		$assigned_reviews = array();
		$col = 0;
		foreach($reviews AS $review)
		{
			$col++;
			$review['ModuleReview']['created'] = CakeTime::i18nFormat($review['ModuleReview']['created'],'%d %b %Y');
			$assigned_reviews[] = $review['ModuleReview'];
		}

		// Assign some content vars
		$content_description = $this->ContentBase->get_content_description($content_id);			
			
		$assignments = array();
		$assignments['content_id'] = $content_id;
		$assignments['content_alias'] = $content['Content']['alias'];
		$assignments['content_name'] = $content_description['ContentDescription']['name'];		
		$assignments['content_description'] = $content_description['ContentDescription']['description'];
		$assignments['content_price'] = $CurrencyBase->display_price($content['ContentProduct']['price']);	
		$assignments['content_url'] = BASE . '/' . $content_description['ContentDescription']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION'];
		
		$assignments['total'] = $col;
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