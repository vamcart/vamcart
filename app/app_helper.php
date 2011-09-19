<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AppHelper extends Helper 
	{
		function __construct() 
		{
			parent::__construct();
			$this->loadConfig(); 
		}
	}
?>