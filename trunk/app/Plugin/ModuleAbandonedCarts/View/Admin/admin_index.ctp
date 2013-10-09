<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cart-error');

			echo '<ul id="myTab" class="nav nav-tabs">';
			echo $this->Admin->CreateTab('main',__('Main'), 'cus-application');
			echo $this->Admin->CreateTab('options',__('Options'), 'cus-cog');			
			echo '</ul>';

echo $this->Admin->StartTabs();

echo $this->Admin->StartTabContent('main');
echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(  __('Order Id'), __('Number of Products'), __('Date Placed')));

foreach($data AS $order)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($order['Order']['id'],'/module_abandoned_carts/admin/admin_manage/' . $order['Order']['id']),
			count($order['OrderProduct']),
			$this->Time->i18nFormat($order['Order']['created'],'%d %b %Y')
		   ));
}

echo '</table>';
echo $this->Admin->EmptyResults($data);

echo $this->Admin->EndTabContent();
echo $this->Admin->StartTabContent('options');

		echo $this->Html->link(__('Click here to purge all Abandoned Carts.'),'/module_abandoned_carts/admin/purge_old_carts/',null,__('Are you sure?'));
	
echo $this->Admin->EndTabContent();

echo $this->Admin->EndTabs();

echo $this->Admin->ShowPageHeaderEnd();

?>