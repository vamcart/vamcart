<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleReviewsAppController', 'ModuleReviews.Controller');

class ActionController extends ModuleReviewsAppController {
	var $uses = array('ModuleReviews.ModuleReview');
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
			global $content, $config, $filter_list;

		if(!empty($_POST) && !$this->request->is('ajax'))
		{

			if(empty($_POST['content_id']))
			{
				global $content;
				$content_id = $content['Content']['id'];	
			} else {
				$content_id = $_POST['content_id'];
			}

			$content = $this->ContentBase->get_content_information($content_id);			

			$spam_flag = false;
	
			if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
				$spam_flag = true;
				if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
					$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
				} else {
					$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
				}
			}
			if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
				$spam_flag = true;
				$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
			}
	
			if($spam_flag == true)
			{
				$this->redirect('/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION']);
			}
			
			$new_review = array();
			$new_review['ModuleReview']['content_id'] = $_POST['content_id'];
			$new_review['ModuleReview']['name'] = $_POST['name'];
			$new_review['ModuleReview']['content'] = $_POST['content'];
			$new_review['ModuleReview']['rating'] = $_POST['rating'];
			
			App::uses('Sanitize', 'Utility');
			$Clean = new Sanitize();
			
			$Clean->paranoid($new_review);
			
			$this->ModuleReview->save($new_review);
			
			Cache::delete('vam_content_' . $_SESSION['Customer']['customer_group_id'] . '_' . $_SESSION['Customer']['language_id'] . '_' . $content['Content']['alias'], 'catalog');
			Cache::delete('vam_page_content_' . $_SESSION['Customer']['customer_group_id'] . '_' . $content['Content']['id'] . '_' . $_SESSION['Customer']['language_id']. '_' . $_SESSION['Customer']['currency_id']. '_' . $_SESSION['Customer']['page'] . (isset($filter_list)?md5(serialize($filter_list)):''), 'catalog');

			$this->redirect('/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION']);
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
			$assignments['content_short_description'] = $content_description['ContentDescription']['short_description'];
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
		$total_rating = null;
		$max = null;
		$min = 99999999; //to make sure it's not below all the values
		foreach($reviews AS $review)
		{
			$col++;
			$total_rating += (int) $review['ModuleReview']['rating'];
			$max = (int) max($max, $review['ModuleReview']['rating']);
			$min = (int) min($min, $review['ModuleReview']['rating']);
			$review['ModuleReview']['created'] = CakeTime::i18nFormat($review['ModuleReview']['created']);
			$assigned_reviews[] = $review['ModuleReview'];
		}

		// Assign some content vars
		$content_description = $this->ContentBase->get_content_description($content_id);			
			
		$assignments = array();
		$assignments['content_id'] = $content_id;
		$assignments['content_alias'] = $content['Content']['alias'];
		$assignments['content_name'] = $content_description['ContentDescription']['name'];		
		$assignments['content_description'] = $content_description['ContentDescription']['description'];
		$assignments['content_short_description'] = $content_description['ContentDescription']['short_description'];
		$assignments['content_price'] = $CurrencyBase->display_price($content['ContentProduct']['price']);	
		$assignments['content_url'] = BASE . '/' . $content_description['ContentDescription']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION'];
		
		$assignments['total'] = $col;
		$assignments['total_rating'] = $total_rating;
		$assignments['average_rating'] = number_format($total_rating/$col, 2);
		$assignments['max_rating'] = $max;
		$assignments['min_rating'] = $min;
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