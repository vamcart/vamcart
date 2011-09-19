<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function default_template_shipping ()
{
$template = '
{shipping_content alias=$shipping_alias}
';
return $template;
}

function smarty_function_shipping($params, $template)
{

	/*
	 *  Load some necessary vars
	 **/	
	global $config;
	global $order;		
		
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();

	App::import('Model', 'ShippingMethod');
		$ShippingMethod =& new ShippingMethod();

	// Get the shipping method 
	$shipping = $ShippingMethod->read(null,$order['Order']['shipping_method_id']);
	
	$assignments = array('shipping_alias' => $shipping['ShippingMethod']['code']);

	$display_template = $Smarty->load_template($params,'shipping');	
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_shipping() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('This plugin returns the shipping info text.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('You should only use this tag in the confirmation core page. Just insert the tag into your page like:') ?> <code>{shipping}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_shipping() {
	?>
	<p><?php echo __('Author: Alexandr Menovchicov &lt;vam@kypi.ru&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>