<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleCouponsAppController', 'ModuleCoupons.Controller');

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