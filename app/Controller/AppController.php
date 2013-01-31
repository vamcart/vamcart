<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $helpers = array('Html', 'Js', 'Ajax', 'Form', 'Admin', 'Session');
	public $components = array(
		'RequestHandler',
		'ConfigurationBase',
		'CurrencyBase',
		'OrderBase',
		'Translit',
		'Session',
		'Auth' => array(
		)
	);
	public $layout = 'admin';

	/**
	* Changes the value of the sort field of a database record.
	* Swaps the value of the next record in the direction we are moving this record.
	*
	* @param int $id ID of the database record we are moving
	* @param int $direction Direction we are moving the record.  Can be 'up' or 'down'
	*/
	public function moveItem ($id, $direction)
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

		$this->redirect('/' . $current_controller . '/admin/0/' . $current[$current_model]['parent_id'] . '/' . $this->RequestHandler->isAjax());
	}
	

	/**
	* Sets the 'default' column to 1, for the current model.
	* Any previous record marked as default will be reset to 0.
	*
	* @param int $id ID of the database record we are setting as default.
	*/	
	public function setDefaultItem ($id)
	{

		$current_model = $this->modelClass;
		$current_controller = $this->params['controller'];
		$grab_info = $this->$current_model->find('all');
		$parent_id = -1;

		foreach ($grab_info AS $info)
		{
			if ($id == $info[$current_model]['id'])
			{
				$info[$current_model]['default'] = 1;
				$parent_id = (!empty($info[$current_model]['parent_id']) ? $info[$current_model]['parent_id'] : 0);
			}
			else
			{
				$info[$current_model]['default'] = 0;
			}
			$this->$current_model->save($info);
		}
		
		
		$this->redirect('/' . $current_controller . '/admin/0/' . $parent_id . '/' . $this->RequestHandler->isAjax());
		
	}
	
	/**
	* Changes the active status of a model's record dynamically based upon the current model
	*
	* @param int $id ID of the database record we are changing
	*/	
	public function changeActiveStatus ($id)
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
		$this->redirect('/' . $current_controller . '/admin/0/' . (!empty($record[$current_model]['parent_id']) ? $record[$current_model]['parent_id'] : 0) . '/' . $this->RequestHandler->isAjax());
	}

	/**
	* Private helper for the generateAlias method.
	* Strips out non-alphanumeric characters.
	*
	* @param string $alias String to modify.
	* @return  string  $alias Modified alias.
	*/		
	public function _makeAlias ($alias)
	{
		if($alias == "")
			$alias = rand(1000,9999);
			
		$alias = trim($alias);
		$alias = strtolower($alias);
		$alias = str_replace(' ','-',$alias);
		//Replace cyrillic symbols to translit
		$alias = $this->Translit->convert($alias);
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
	public function generateAlias($name, $tail=1)
	{
		// Add the tail if it's greater than 1
		if($tail > 1)
			$tmp_name = $name . $tail;
		else
			$tmp_name = $name;
		
	
		$alias = $this->_makeAlias($tmp_name);
		
		// Get the model we're in and make sure that alias isn't taken
		$current_model = $this->modelClass;
		$check_records = $this->$current_model->find('all', array('conditions' => array($current_model . '.id !=' => $this->data[$current_model]['id'], $current_model . '.alias =' => $alias)));

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
	public function getAdminNavigation ()
	{
		// Navigation Menu Array
		$navigation = array(
			//1 => array('icon' => 'home.png', 'text' => __('Home', true), 'path' => '/admin/admin_top/'),	
			2 => array('icon' => 'orders.png', 'text' => __('Orders', true), 'path' => '/admin/admin_top/2', 
				'children' => array(
					1 => array('icon' => 'all-orders.png', 'text' => __('All Orders', true), 'path' => '/orders/admin/')
				)			
			),				
			3 => array('icon' => 'contents.png', 'text' => __('Contents', true), 'path' => '/admin/admin_top/3',
				'children' => array(
					1 => array('icon' => 'categories.png', 'text' => __('Categories/Products', true), 'path' => '/contents/admin/'),
					2 => array('icon' => 'import.png', 'text' => __('Import/Export', true), 'path' => '/import_export/admin/'),
					3 => array('icon' => 'pages.png', 'text' => __('Pages', true), 'path' => '/contents/admin_core_pages/'),
					4 => array('icon' => 'blocks.png', 'text' => __('Content Blocks', true), 'path' => '/global_content_blocks/admin/')
				)
			),
			4 => array('icon' => 'layout.png', 'text' => __('Layout', true), 'path' => '/admin/admin_top/4',
				'children' => array(
					1 => array('icon' => 'templates.png', 'text' => __('Templates', true), 'path' => '/templates/admin/'),
					2 => array('icon' => 'stylesheets.png', 'text' => __('Stylesheets', true), 'path' => '/stylesheets/admin/'),
					3 => array('icon' => 'micro-templates.png', 'text' => __('Micro Templates', true), 'path' => '/micro_templates/admin/')									
				)
			),
			5 => array('icon' => 'configurations.png', 'text' => __('Configurations', true), 'path' => '/admin/admin_top/5',
				'children' => array(
					1 => array('icon' => 'store.png', 'text' => __('Store Settings', true), 'path' => '/configuration/admin/'),
					2 => array('icon' => 'license.png', 'text' => __('License', true), 'path' => '/license/admin/'),
					3 => array('icon' => 'update.png', 'text' => __('Update', true), 'path' => '/update/admin/'),
					4 => array('icon' => 'order-status.png', 'text' => __('Order status', true), 'path' => '/order_status/admin/'),
					5 => array('icon' => 'payment-methods.png', 'text' => __('Payment Methods', true), 'path' => '/payment_methods/admin/'),
					6 => array('icon' => 'shipping-methods.png', 'text' => __('Shipping Methods', true), 'path' => '/shipping_methods/admin/'),
					7 => array('icon' => 'tax-classes.png', 'text' => __('Tax Classes', true), 'path' => '/taxes/admin/'),
					8 => array('icon' => 'tax-rates.png', 'text' => __('Tax Rates', true), 'path' => '/tax_country_zone_rates/admin/0'),
					9 => array('icon' => 'email-templates.png', 'text' => __('Email Templates', true), 'path' => '/email_template/admin/')
				)
			),	
			6 => array('icon' => 'locale.png', 'text' => __('Locale', true), 'path' => '/admin/admin_top/6',
				'children' => array(
					1 => array('icon' => 'currencies.png', 'text' => __('Currencies', true), 'path' => '/currencies/admin/'),
					2 => array('icon' => 'languages.png', 'text' => __('Languages', true), 'path' => '/languages/admin/'),
					3 => array('icon' => 'countries.png', 'text' => __('Countries', true), 'path' => '/countries/admin/'),
					4 => array('icon' => 'geo-zones.png', 'text' => __('Geo Zones', true), 'path' => '/geo_zones/admin/'),
					5 => array('icon' => 'defined.png', 'text' => __('Defined Languages', true), 'path' => '/defined_languages/admin/')															
				)
			),					
			7 => array('icon' => 'extensions.png', 'text' => __('Extensions', true), 'path' => '/admin/admin_top/7',
				'children' => array(
					1 => array('icon' => 'modules.png', 'text' => __('Modules', true), 'path' => '/modules/admin/'),
					2 => array('icon' => 'tags.png', 'text' => __('Tags', true), 'path' => '/tags/admin/'),
					3 => array('icon' => 'user-tags.png', 'text' => __('User Tags', true), 'path' => '/user_tags/admin/'),
					4 => array('icon' => 'events.png', 'text' => __('Events', true), 'path' => '/events/admin/')
				)
			),									
			8 => array('icon' => 'account.png', 'text' => __('Account', true), 'path' => '/admin/admin_top/8',
				'children' => array(
					1 => array('icon' => 'manage-accounts.png', 'text' => __('Manage Accounts', true), 'path' => '/users/admin/'),
					2 => array('icon' => 'my-account.png', 'text' => __('My Account', true), 'path' => '/users/admin_user_account/'),
					3 => array('icon' => 'prefences.png', 'text' => __('Prefences', true), 'path' => '/users/admin_user_preferences/'),					
					4 => array('icon' => 'logout.png', 'text' => __('Logout', true), 'path' => '/users/admin_logout/')					
				)
			),						
			9 => array('icon' => 'tools.png', 'text' => __('Tools', true), 'path' => '/admin/admin_top/9',
				'children' => array(
					1 => array('icon' => 'backup.png', 'text' => __('Database Backup', true), 'path' => '/tools/admin_backup/')
				)
			),
			10 => array('icon' => 'catalog.png', 'text' => __('Launch Site', true), 'path' => '/', 'attributes' => array('target' => 'blank'))
		);
		
		// Add module navigation elements
		App::import('Model', 'Module');
		$Module =& new Module();
		
		$modules = $Module->find('all');
		
		foreach($modules AS $module)
		{
			$nav_level = $module['Module']['nav_level'];
			$navigation[$nav_level]['children'][] = array('icon' => $module['Module']['alias'].'.png', 'text' => ucfirst($module['Module']['name']), 'path' => '/module_' . $module['Module']['alias'] . '/admin/admin_index/', 'attributes' => array('class' => 'module'));
		}
		
		return($navigation);
	}

	/**
	* Called before anything.
	* This public function really needs some help.
	*
	*/				
	public function beforeFilter()
	{
		if (isset($_GET['return_url'])) {
			
			$this->Auth->loginRedirect = urldecode(base64_decode($_GET['return_url']));
		}
		
		$this->Auth->allow();
		
		// Set a base to use for smarty URLs.
		if(!defined('BASE')) {
			define('BASE', $this->base);
		}

		if(strstr($_SERVER['REQUEST_URI'],'/install'))
		{
			$install = 1;
			$this->Auth->userModel = 'UserInstall';
			$this->Auth->authenticate = ClassRegistry::init('UserInstall');
		}
		
		if(!isset($install)) // We're viewing the front end
		{
			$this->Auth->userModel = 'Customer';
			$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->Auth->loginAction = array('admin' => false, 'controller' => 'site', 'action' => 'login');
			$this->Auth->logoutAction = array('admin' => false, 'controller' => 'site', 'action' => 'logout');
			$this->Auth->authenticate = ClassRegistry::init('Customer');

			if(!isset($_SESSION['Customer']))
			{
				// Set the default language
				$new_customer = array();

				// Get the default language
				App::import('Model', 'Language');
				$this->Language = new Language();
				$languages = $this->Language->find('first', array('conditions' => array('Language.default' => 1)));

				$new_customer['language_id'] = $languages['Language']['id'];
				$new_customer['language'] = $languages['Language']['iso_code_2'];
				
				//$this->Session->write('Config.language', $languages['Language']['code']);
				
				// Get the default currency
				App::import('Model', 'Currency');
				$this->Currency = new Currency();		
				$default_currency = $this->Currency->find('first', array('conditions' => array('Currency.default' => 1)));
		
				$new_customer['currency_id'] = $default_currency['Currency']['id']; 
				$new_customer['currency_code'] = $default_currency['Currency']['code'];
				
				if (!$this->Session->check('Customer'))
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
		
		// If we're in the admin area
		if(substr($this->action, 0, 5) == 'admin')
		{
			$this->Auth->userModel = 'User';
			$this->Auth->fields = array('username' => 'username', 'password' => 'password');
			$this->Auth->authenticate = ClassRegistry::init('User');
			// Set the menu if the action is prefixed with admin_
			$this->set('navigation',$this->getAdminNavigation());	

			// We load the locale component here so it doesn't get loaded for the front end
			App::uses('LocaleComponent', 'Controller/Component');

			$Locale =& new LocaleComponent(new ComponentCollection ());
			
			// Set a current breadcrumb from the locale based on the current controller/action		
			$this->set('current_crumb',$Locale->set_crumb($this->params['action'],$this->params['controller']));	
		
			// Check the admin login credentials against the database
			// ToDo: Make this more secure, possibly change to a requestaction in users controller
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
		
		// Prevent direct requests to extensions
		if((!$this->Session->check('User.username')) && (($this->action == 'install') || ($this->action == 'uninstall') || ($this->action == 'settings')))
		{
			$this->Session->setFlash(__('Login Error.',true));
			$this->redirect('/users/admin_login/');
		}

	}
}
