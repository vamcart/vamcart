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

class ActionController extends ModuleReviewsAppController {
	var $uses = array('ModuleReview');
	var $components = array('ContentBase');
	
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
		$this->render($action,'');
	}

}

?>