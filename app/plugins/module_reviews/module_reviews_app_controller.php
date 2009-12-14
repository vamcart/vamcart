<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ModuleReviewsAppController extends AppController 
{
	function loadModels()
	{
		App::import('Model', 'Module');
			$this->Module =& new Module();
		
		if($this->Module->findCount(array('alias' => 'reviews')) == 1)
		{
			App::import('Model', 'ModuleReview');
				$this->ModuleReview =& new Module();
		}

	}

}
?>