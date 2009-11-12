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

class InstallComponent extends Object 
{
    var $components = array('Session','Smarty');

	function beforeFilter ()
	{
		
	}

    function startup(&$controller)
	{
	
    }

	function getVersion ()
	{
		$version = file_get_contents(APP . 'version.txt');
		return $version;
	}
	
    function begin_install ()
    {

    }
	
	
	
}
?>