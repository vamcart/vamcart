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

class ActionController extends ModuleReviewsAppController {
	var $uses = array('ModuleReview');
	var $components = array('ContentBase');
	var $view = 'Theme';
	var $layout = 'admin';
	var $theme = 'vamshop';
	
	function link ()
	{
		global $content;
		$assignments = array('review_display_link' => '/Page/read-reviews.html?content_id=' . $content['Content']['id'],
							 'review_create_link' => '/Page/create-review.html?content_id=' . $content['Content']['id']);
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
			
			uses('sanitize');
			$Clean = new Sanitize();
			
			$Clean->paranoid($new_review);
			
			$this->ModuleReview->save($new_review);
			
			$this->redirect('/Page/read-reviews.html?content_id=' . $_POST['content_id']);
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
		$reviews = $this->ModuleReview->findAll(array('content_id' => $content_id));
		
		loadHelper('Time');
		$time = new TimeHelper();
		
		$assigned_reviews = array();
		foreach($reviews AS $review)
		{
			$review['ModuleReview']['created'] = $time->niceShort($review['ModuleReview']['created']);
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