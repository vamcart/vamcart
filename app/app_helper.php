<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.ru
   http://vamcart.com
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
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