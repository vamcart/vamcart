<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AdminController extends AppController {
	var $name = 'Admin';
	var $uses = array('User');
	var $components = array('Check');
	var $helpers = array('Html','Javascript','Admin','Form', 'FlashChart');

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