<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
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
		$version = file_get_contents(WWW_ROOT . 'version.txt');
		return $version;
	}
	
    function begin_install ()
    {

    }
	
	
	
}
?>