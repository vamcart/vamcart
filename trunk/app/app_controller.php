<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class AppController extends Controller {
	var $helpers = array('Html','Javascript','Ajax','Form','Admin');
	var $components = array('RequestHandler','ConfigurationBase','CurrencyBase','OrderBase');

	/**
	* Changes the value of the sort field of a database record.
	* Swaps the value of the next record in the direction we are moving this record.
	*
	* @param int $id ID of the database record we are moving
	* @param int $direction Direction we are moving the record.  Can be 'up' or 'down'
	*/	
	function moveItem ($id, $direction)
	{
		// Define the current model and controller
		$current_model = $this->modelClass;
		$current_controller = $this->params['controller'];	
	
		// Get the record we're moving
		$this->$current_model->id = $id;
		$current = $this->$current_model->read();
		
		// Check if it has a parent_id set
		if(isset($current[$current_model]['parent_id']))
			$parent_conditions = " AND " . $current_model . ".parent_id = " . $current[$current_model]['parent_id'] . " ";
		else
			$parent_conditions = " ";
		
		if($direction == 'up')
			$new = $this->$current_model->find($current_model.'.order < ' . $current[$current_model]['order'] . $parent_conditions, null, $current_model.'.order DESC');
		else
			$new = $this->$current_model->find($current_model.'.order > ' . $current[$current_model]['order'] . $parent_conditions, null, $current_model.'.order ASC');
		
		$temp_order = $new[$current_model]['order'];
			
		$new[$current_model]['order'] = $current[$current_model]['order'];
		$current[$current_model]['order'] = $temp_order;

		$this->$current_model->save($new);
		$this->$current_model->save($current);	

		$this->redirect('/' . $current_controller . '/admin/' . $this->RequestHandler->isAjax());	
	}
	

	/**
	* Sets the 'default' column to 1, for the current model.
	* Any previous record marked as default will be reset to 0.
	*
	* @param int $id ID of the database record we are setting as default.
	*/	
	function setDefaultItem ($id)
	{

		$current_model = $this->modelClass;
		$current_controller = $this->params['controller'];
		$grab_info = $this->$current_model->findAll();

		foreach ($grab_info AS $info)
		{
			if ($id == $info[$current_model]['id'])
			{
				$info[$current_model]['default'] = 1;	
			}
			else
			{
				$info[$current_model]['default'] = 0;
			}
			$this->$current_model->save($info);
		}
		
		
		$this->redirect('/' . $current_controller . '/admin/' . $this->RequestHandler->isAjax());	
		
	}
	
	/**
	* Changes the active status of a model's record dynamically based upon the current model
	*
	* @param int $id ID of the database record we are changing
	*/	
	function changeActiveStatus ($id)
	{
		// Set the model and controller
		$current_model = $this->modelClass;
		$current_controller = $this->params['controller'];
		
		// Read the record
		$this->$current_model->id = $id;
		$record = $this->$current_model->read();
				
		if($record[$current_model]['active'] == 0)
		{
			$record[$current_model]['active'] = 1;
		}
		else
		{
			$record[$current_model]['active'] = 0;		
		}
		$this->$current_model->save($record);

		// Redirect depending on the current controller
		$this->redirect('/' . $current_controller . '/admin/' . $this->RequestHandler->isAjax());	
	}

	/**
	* Private helper for the generateAlias method.
	* Strips out non-alphanumeric characters.
	*
	* @param string $alias String to modify.
	* @return  string  $alias Modified alias.
	*/		
	function _makeAlias ($alias)
	{
		if($alias == "")
			$alias = rand(1000,9999);
			
		$alias = trim($alias);
		$alias = strtolower($alias);
		$alias = str_replace(' ','-',$alias);
		$alias = preg_replace("/[^a-zA-Z0-9-s]/", "", $alias);
		
		return $alias;
	}
	
	/**
	* Generates a unique alias by a given name.
	* If a record exists with this alias, we just tack on a larger number on the end.
	*
	* @param string $name A string to convert into an alias.
	* @param int $tail Tail to tack onto the alias if it exists.
	* @return  string  A modified and unique alias.
	*/			
	function generateAlias($name, $tail=1)
	{
		// Add the tail if it's greater than 1
		if($tail > 1)
			$tmp_name = $name . $tail;
		else
			$tmp_name = $name;
		
	
		$alias = $this->_makeAlias($tmp_name);
		
		// Get the model we're in and make sure that alias isn't taken
		$current_model = $this->modelClass;
		$check_records = $this->$current_model->findAll($current_model . ".id != '" . $this->data[$current_model]['id'] . "' AND " . $current_model . ".alias = '" . $alias . "'");

		if(count($check_records) > 0)
		{
			return($this->generateAlias($name,$tail+1));
		}

		// Return the newly formatted alias
		return($alias);
	}
	
	/**
	* Array of all administration navigation elements.
	* Finds installed modules and adds those onto the array.
	*
	* @return  array  Navigation array for the administration area.
	*/				
	function getAdminNavigation ()
	{
		// Navigation Menu Array
		$navigation = array(
			1 => array('text' => 'Home', 'path' => '/admin/admin_top/1'
			),	
			2 => array('text' => 'Orders', 'path' => '/orders/admin/', 
				'children' => array(
					1 => array('text' => 'All Orders', 'path' => '/orders/admin/')
				)			
			),				
			3 => array('text' => 'Contents', 'path' => '/admin/admin_top/3',
				'children' => array(
					1 => array('text' => 'Categories & Products', 'path' => '/contents/admin/'),
					2 => array('text' => 'Pages', 'path' => '/contents/admin_core_pages/'),
					3 => array('text' => 'Content Blocks', 'path' => '/global_content_blocks/admin/')
				)
			),
			4 => array('text' => 'Layout', 'path' => '/admin/admin_top/4',
				'children' => array(
					1 => array('text' => 'Templates', 'path' => '/templates/admin/'),
					2 => array('text' => 'Stylesheets', 'path' => '/stylesheets/admin/'),
					3 => array('text' => 'Micro Templates', 'path' => '/micro_templates/admin/')									
				)
			),
			5 => array('text' => 'Configurations', 'path' => '/admin/admin_top/5',
				'children' => array(
					1 => array('text' => 'Store Settings', 'path' => '/configuration/admin_edit/'),
					2 => array('text' => 'Order status', 'path' => '/order_status/admin/'),
					3 => array('text' => 'Payment Methods', 'path' => '/payment_methods/admin/'),
					4 => array('text' => 'Shipping Methods', 'path' => '/shipping_methods/admin/'),
					5 => array('text' => 'Tax Classes', 'path' => '/taxes/admin/'),
					6 => array('text' => 'Tax Rates', 'path' => '/tax_country_zone_rates/admin/0')
				)
			),	
			6 => array('text' => 'Locale', 'path' => '/admin/admin_top/6',
				'children' => array(
					1 => array('text' => 'Currencies', 'path' => '/currencies/admin/'),
					2 => array('text' => 'Languages', 'path' => '/languages/admin/'),
					3 => array('text' => 'Countries', 'path' => '/countries/admin/'),
					4 => array('text' => 'Defined Languages', 'path' => '/defined_languages/admin/')															
				)
			),					
			7 => array('text' => 'Extensions', 'path' => '/admin/admin_top/7',
				'children' => array(
					1 => array('text' => 'Modules', 'path' => '/modules/admin/'),
					2 => array('text' => 'Tags', 'path' => '/tags/admin/'),
					3 => array('text' => 'User Tags', 'path' => '/user_tags/admin/'),
					4 => array('text' => 'Events', 'path' => '/events/admin/')
				)
			),									
			8 => array('text' => 'Account', 'path' => '/admin/admin_top/8',
				'children' => array(
					1 => array('text' => 'Manage Accounts', 'path' => '/users/admin/'),
					2 => array('text' => 'My Account', 'path' => '/users/admin_user_account/'),
					3 => array('text' => 'Prefences', 'path' => '/users/admin_user_preferences/'),					
					4 => array('text' => 'Logout', 'path' => '/users/admin_logout/')					
				)
			),						
			9 => array('text' => 'Launch Site', 'path' => '/', 'attributes' => array('target' => 'blank')
				
			)
		);
		
		// Add module navigation elements
		loadModel('Module');
		$this->Module =& new Module();
		
		$modules = $this->Module->findAll();
		
		foreach($modules AS $module)
		{
			$nav_level = $module['Module']['nav_level'];
			$navigation[$nav_level]['children'][] = array('text' => $module['Module']['name'], 'path' => '/module_' . $module['Module']['alias'] . '/admin/admin_index/', 'attributes' => array('class' => 'module'));
		}
		
		return($navigation);
	}

	/**
	* Called before anything.
	* This function really needs some help.
	*
	*/				
	function beforeFilter()
	{
		// Set a base to use for smarty URLs.
		if(!defined('BASE'))
			define('BASE', $this->base);

		if(strstr($_SERVER['REQUEST_URI'],'/install'))
		{
			$install = 1;
		}
		// If we're in the admin area
		if(substr($this->action, 0, 5) == 'admin')
		{
			// Set the menu if the action is prefixed with admin_
			$this->set('navigation',$this->getAdminNavigation());	

			// We load the locale component here so it doesn't get loaded for the front end
			loadComponent('Locale');
			$this->Locale =& new LocaleComponent();
			
			// Set a current breadcrumb from the locale based on the current controller/action		
			$this->set('current_crumb',$this->Locale->set_crumb($this->params['action'],$this->params['controller']));	
		
			// Check the admin login credentials against the database
			// TODO: Make this more secure, possibly change to a requestaction in users controller
			if((!$this->Session->check('User.username'))&& (($this->action != 'admin_login') || ($this->action == 'index')))
			{
				$this->Session->setFlash(__('Login Error.',true));			
				$this->redirect('/users/admin_login/');
			}
			else
			{
				$this->Session->write('User',$this->Session->read('User'));
			}
		}
		elseif(!isset($install)) // We're viewing the front end
		{
			if(!isset($_SESSION['Customer']))
			{
				// Set the default language
				$new_customer = array();

				// Get the default language
				loadModel('Language');
				$this->Language =& new Language();		
				$default_language = $this->Language->find(array('default' => '1'));

				$new_customer['language_id'] = $default_language['Language']['id'];

				$this->Session->write('Config.language_id', $default_language['Language']['id']);

				// Get the default currency
				loadModel('Currency');
				$this->Currency =& new Currency();		
				$default_currency = $this->Currency->find(array('default' => '1'));
		
				$new_customer['currency_id'] = $default_currency['Currency']['id']; 
				$this->Session->write('Customer', $new_customer);
			}
			else
			{
				// Renew the session
				$_SESSION['Customer'] = $_SESSION['Customer'];
			}
	
			// Get the configuration information
			global $config;
			$config = $this->ConfigurationBase->load_configuration();	
		
			// Assign the order information
			global $order;
			$order = $this->OrderBase->get_order();
		}
		
	}
}
?>