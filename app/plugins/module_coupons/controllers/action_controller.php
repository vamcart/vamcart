<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ActionController extends ModuleCouponsAppController {
	var $uses = null;

	function show_info()
	{
		$assignments = array();
		return $assignments;
	}

	function checkout_box ()
	{
		$assignments = array();
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