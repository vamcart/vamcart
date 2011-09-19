<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class UserTagBaseComponent extends Object 
{

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{

    }

	function call_user_tag ($params)
	{
		// Load the model
		App::import('Model', 'UserTag');
			$this->UserTag =& new UserTag();
	
		$tag = $this->UserTag->findByAlias($params['alias']);
		
		eval($tag['UserTag']['content']);
	}
	
	
}
?>