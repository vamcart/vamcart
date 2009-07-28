<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AdminController extends AppController {
	var $name = 'Admin';
	var $uses = array('User');
	var $helpers = array('Html','Javascript','Admin','Form');

	function index() 
	{
		$this->redirect('/users/admin_login/');
	}
	
	function admin_top($level = 1)
	{
		$this->set('level',$level);
	}
}
?>