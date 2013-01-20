<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	var $name = 'Admin';
	var $uses = array('User');
	//var $components = array('Check');
	var $helpers = array('Html','Js','Admin','Form', 'FlashChart');

	function index() 
	{
		$this->redirect('/users/admin_login/');
	}
	
	function admin_top($level = 1)
	{
	
		$this->set('title_for_layout', __('Home', true));
	//App::import('Model', 'Order');
	
	//$this->Order =& new Order();
	
	//$orders = $this->Order->find('all');
	//echo var_dump($orders);
	
	$this->set('level', $level);
	
	}
}
?>