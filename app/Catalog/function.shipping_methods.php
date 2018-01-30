<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_shipping_methods()
{
$template = '
<table class="table table-striped">
<thead>
<tr>
<th class="ship-title">{lang}Shipping{/lang}</th>
</tr>
</thead>
<tbody>
{foreach from=$ship_methods item=ship_method}
<tr>
<td>{lang}{$ship_method.name}{/lang}</td>
</tr>
{/foreach}
</tbody>
</table>  
';
		
return $template;
}


function smarty_function_shipping_methods($params, $template)
{
	global $content, $config, $order;

	if(!isset ($params['limit']))
		$params['limit'] = $config['PRODUCTS_PER_PAGE'];

	// Cache the output.
	$cache_name = 'vam_shipping_methods_output' . (isset($params['template'])?'_'.$params['template']:'') . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

	App::import('Model', 'ShippingMethod');
		$ShippingMethod = new ShippingMethod();

	$active_ship_methods = $ShippingMethod->find('all', array('conditions' => array('active' => '1'), 'limit' => $params['limit'], 'order' => array('order')));

	$keyed_ship_methods = array();
	foreach($active_ship_methods AS $method)
	{
		$shipping = Inflector::classify($method['ShippingMethod']['code']);
		$shipping_controller =  Inflector::classify($method['ShippingMethod']['code']) . 'Controller';
		App::import('Controller', 'Shipping.'.$shipping);
		$MethodBase = new $shipping_controller();
		
		$ship_method_id = $method['ShippingMethod']['id'];

		$icon_name = $method['ShippingMethod']['icon'];	
		$icon_path = IMAGES . 'icons/shipping/' . $icon_name;
		$icon_url = BASE . '/img/icons/shipping/' . $icon_name;

		if(file_exists($icon_path) && is_file($icon_path)) {
			list($width, $height, $type, $attr) = getimagesize($icon_path);
		}
		
		$keyed_ship_methods[$ship_method_id] = array(
										  'id' => $ship_method_id,
										  'name' => $method['ShippingMethod']['name'],
										  'code' => (isset($method['ShippingMethod']['code']) && $method['ShippingMethod']['code'] !== '') ? $method['ShippingMethod']['code'] : false,
										  'description' => (isset($method['ShippingMethod']['description'])) ? __($method['ShippingMethod']['description']) : false,
										  'icon' => (isset($icon_name) && file_exists($icon_path)) ? $icon_url : false,
										  'width' => (isset($icon_name) && file_exists($icon_path)) ? $width : false,
										  'height' => (isset($icon_name) && file_exists($icon_path)) ? $height : false,
										  'cost_plain' => $MethodBase->calculate(),
										  'cost' => $CurrencyBase->display_price($MethodBase->calculate())
										  );

	}	
	
	$assignments = array(
		'ship_methods' => $keyed_ship_methods
	);

	$display_template = $Smarty->load_template($params, 'shipping_methods');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
}

function smarty_help_function_shipping_methods() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the active shipping methods and calculations for the current product.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{shipping_methods}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(limit)') ?></em> - <?php echo __('Limit displayed items.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_shipping_methods() {
}
?>