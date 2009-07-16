<?php 
/* --------------------------------------------------------------
   VaM Shop - open source ecommerce solution
   http://vamshop.com
   Copyright (c) 2007-2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

class AppHelper extends Helper 
	{
		function __construct() 
		{
			parent::__construct();
			$this->loadConfig(); 
		}
	}
?>