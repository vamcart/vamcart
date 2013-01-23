<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ModuleReviewsAppController extends AppController 
{
	function loadModels()
	{
		App::import('Model', 'Module');
			$this->Module =& new Module();
		
		if($this->Module->find('count', array('conditions' => array('alias' => 'reviews'))) == 1)
		{
			App::import('Model', 'ModuleReview');
				$this->ModuleReview =& new Module();
		}

	}

}
?>