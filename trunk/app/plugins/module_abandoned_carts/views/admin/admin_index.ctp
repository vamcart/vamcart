<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $javascript->link('modified', false);
	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('jquery/plugins/ui.core', false);
	echo $javascript->link('jquery/plugins/ui.tabs', false);
	echo $javascript->link('tabs', false);
	echo $javascript->link('focus-first-input', false);
	echo $html->css('jquery/plugins/ui.tabs','','', false);

	echo $admin->ShowPageHeaderStart($current_crumb, 'abandoned.png');

echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('main',__('Main',true), 'main.png');
			echo $admin->CreateTab('options',__('Options',true), 'options.png');			
			echo '</ul>';

echo $admin->StartTabContent('main');
echo '<table class="contentTable">';

echo $html->tableHeaders(array(  __('Order Id', true), __('Number of Products', true), __('Date Placed', true)));

foreach($data AS $order)
{
	echo $admin->TableCells(
		  array(
			$html->link($order['Order']['id'],'/module_abandoned_carts/admin/admin_manage/' . $order['Order']['id']),
			count($order['OrderProduct']),
			$time->niceShort($order['Order']['created'])
		   ));
}

echo '</table>';
echo $admin->EmptyResults($data);

echo $admin->EndTabContent();
echo $admin->StartTabContent('options');

		echo $html->link(__('Click here to purge all Abandoned Carts.', true),'/module_abandoned_carts/admin/purge_old_carts/',null,__('Are you sure?', true));
	
echo $admin->EndTabContent();

echo $admin->EndTabs();

echo $admin->ShowPageHeaderEnd();

?>