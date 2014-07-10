<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminMenuComponent extends Component
{
	public function beforeFilter () {
	}
	
	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
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
			//1 => array('icon' => 'cus-house', 'text' => __('Dashboard', true), 'path' => '/admin/admin_top/'),	
			2 => array('icon' => 'cus-cart', 'text' => __('Orders', true), 'path' => '/admin/admin_top/2', 
				'children' => array(
					1 => array('icon' => 'cus-cart-go', 'text' => __('All Orders', true), 'path' => '/orders/admin/'),
					2 => array('icon' => 'cus-user', 'text' => __('Customers', true), 'path' => '/customers/admin/'),
					3 => array('icon' => 'cus-group', 'text' => __('Customers Groups', true), 'path' => '/groups_customers/admin/')
				)			
			),				
			3 => array('icon' => 'cus-table', 'text' => __('Contents', true), 'path' => '/admin/admin_top/3',
				'children' => array(
					1 => array('icon' => 'cus-book-add', 'text' => __('Categories/Products', true), 'path' => '/contents/admin/'),
					2 => array('icon' => 'cus-database-refresh', 'text' => __('Import/Export', true), 'path' => '/import_export/admin/'),
					3 => array('icon' => 'cus-page', 'text' => __('Pages', true), 'path' => '/contents/admin_core_pages/'),
					4 => array('icon' => 'cus-application-cascade', 'text' => __('Content Blocks', true), 'path' => '/global_content_blocks/admin/'),
					6 => array('icon' => 'cus-tag-green', 'text' => __('Attributes', true), 'path' => '/attributes/admin/')
				)
			),
			4 => array('icon' => 'cus-paintbrush', 'text' => __('Layout', true), 'path' => '/admin/admin_top/4',
				'children' => array(
					1 => array('icon' => 'cus-layout', 'text' => __('Templates', true), 'path' => '/templates/admin/'),
					2 => array('icon' => 'cus-palette', 'text' => __('Stylesheets', true), 'path' => '/stylesheets/admin/'),
					3 => array('icon' => 'cus-layout-content', 'text' => __('Micro Templates', true), 'path' => '/micro_templates/admin/')									
				)
			),
			5 => array('icon' => 'cus-cog', 'text' => __('Configurations', true), 'path' => '/admin/admin_top/5',
				'children' => array(
					1 => array('icon' => 'cus-cog-edit', 'text' => __('Store Settings', true), 'path' => '/configuration/admin/'),
					2 => array('icon' => 'cus-lock', 'text' => __('License', true), 'path' => '/license/admin/'),
					3 => array('icon' => 'cus-arrow-refresh', 'text' => __('Update', true), 'path' => '/update/admin/'),
					4 => array('icon' => 'cus-cart-edit', 'text' => __('Order status', true), 'path' => '/order_status/admin/'),
					5 => array('icon' => 'cus-report', 'text' => __('Payment Methods', true), 'path' => '/payment_methods/admin/'),
					6 => array('icon' => 'cus-box', 'text' => __('Shipping Methods', true), 'path' => '/shipping_methods/admin/'),
					7 => array('icon' => 'cus-calculator-add', 'text' => __('Tax Classes', true), 'path' => '/taxes/admin/'),
					8 => array('icon' => 'cus-calculator-edit', 'text' => __('Tax Rates', true), 'path' => '/tax_country_zone_rates/admin/0'),
					9 => array('icon' => 'cus-email-open', 'text' => __('Email Templates', true), 'path' => '/email_template/admin/'),
					10 => array('icon' => 'cus-comment-edit', 'text' => __('Answer Templates', true), 'path' => '/answer_template/admin/'),
					11 => array('icon' => 'cus-tag-blue-edit', 'text' => __('Attribute Templates', true), 'path' => '/attribute_templates/admin/')
				)
			),	
			6 => array('icon' => 'cus-world', 'text' => __('Locale', true), 'path' => '/admin/admin_top/6',
				'children' => array(
					1 => array('icon' => 'cus-table-edit', 'text' => __('Currencies', true), 'path' => '/currencies/admin/'),
					2 => array('icon' => 'cus-flag-green', 'text' => __('Languages', true), 'path' => '/languages/admin/'),
					3 => array('icon' => 'cus-world-add', 'text' => __('Countries', true), 'path' => '/countries/admin/'),
					4 => array('icon' => 'cus-page-white-world', 'text' => __('Geo Zones', true), 'path' => '/geo_zones/admin/'),
					5 => array('icon' => 'cus-world-edit', 'text' => __('Defined Languages', true), 'path' => '/defined_languages/admin/')															
				)
			),					
			7 => array('icon' => 'cus-plugin', 'text' => __('Extensions', true), 'path' => '/admin/admin_top/7',
				'children' => array(
					1 => array('icon' => 'cus-plugin-add', 'text' => __('Modules', true), 'path' => '/modules/admin/'),
					2 => array('icon' => 'cus-tag-blue', 'text' => __('Tags', true), 'path' => '/tags/admin/'),
					3 => array('icon' => 'cus-tag-blue-add', 'text' => __('User Tags', true), 'path' => '/user_tags/admin/'),
					4 => array('icon' => 'cus-page-gear', 'text' => __('Events', true), 'path' => '/events/admin/'),
				)
			),									
			8 => array('icon' => 'cus-group', 'text' => __('Account', true), 'path' => '/admin/admin_top/8',
				'children' => array(
					1 => array('icon' => 'cus-group-add', 'text' => __('Manage Accounts', true), 'path' => '/users/admin/'),
					2 => array('icon' => 'cus-group-edit', 'text' => __('My Account', true), 'path' => '/users/admin_user_account/'),
					3 => array('icon' => 'cus-group-key', 'text' => __('Prefences', true), 'path' => '/users/admin_user_preferences/'),					
					4 => array('icon' => 'cus-group-go', 'text' => __('Logout', true), 'path' => '/users/admin_logout/')					
				)
			),						
			9 => array('icon' => 'cus-wrench', 'text' => __('Tools', true), 'path' => '/admin/admin_top/9',
				'children' => array(
					1 => array('icon' => 'cus-database-save', 'text' => __('Database Backup', true), 'path' => '/tools/admin_backup/'),
					2 => array('icon' => 'cus-chart-curve', 'text' => __('Sales Report', true), 'path' => '/reports/admin/')
				)
			),
			10 => array('icon' => 'cus-application-go', 'text' => __('Launch Site', true), 'path' => '/', 'attributes' => array('target' => 'blank'))
		);
		
		// Add module navigation elements
		App::import('Model', 'Module');
		$Module =& new Module();
		
		$modules = $Module->find('all');
		
		foreach($modules AS $module)
		{
			$nav_level = $module['Module']['nav_level'];
			$navigation[$nav_level]['children'][] = array('icon' => $module['Module']['icon'], 'text' => ucfirst($module['Module']['name']), 'path' => '/module_' . $module['Module']['alias'] . '/admin/admin_index/', 'attributes' => array('class' => 'module'));
		}
		
		return($navigation);
	}
}
?>
