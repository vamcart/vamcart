<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class AdminController extends AppController {
	public $name = 'Admin';
	public $uses = array('User');
	//public $components = array('Check');
	public $helpers = array('Html','Js','Admin','Form', 'FlashChart');

	public function index() 
	{
		$this->redirect('/users/admin_login/');
	}
	
	public function admin_top($level = 1)
	{
		$this->set('current_crumb', __('', true));	
		$this->set('title_for_layout', __('Home', true));
	//App::import('Model', 'Order');
	
	//$this->Order =& new Order();
	
	//$orders = $this->Order->find('all');
	//echo var_dump($orders);
	
	$this->set('level', $level);
	
	}
}
?>