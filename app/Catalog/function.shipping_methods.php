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
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
<thead>
<tr>
<th colspan="2" class="ship-title"><div>Доставка в <span><u>{$city}</span></u></div></th>
</tr>
</thead>
<tbody>
{foreach from=$ship_methods item=ship_method}
<tr>
<td>{lang}{$ship_method.name}{/lang}</td>
<td class="text-right">{$ship_method.cost}</td>
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
	
	// Cache the output.
	$cache_name = 'vam_shipping_methods_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
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

	App::import('Model', 'PaymentMethod');
		$PaymentMethod = new PaymentMethod();

	if(!isset ($params['content_id']))
		$params['content_id'] = $content['Content']['id'];

	if(!isset($params['price']))
		$params['price'] = 0;		

	if(!isset($params['weight']))
		$params['weight'] = 0;		

	if(!isset($params['length']))
		$params['length'] = 0;		

	if(!isset($params['width']))
		$params['width'] = 0;		

	if(!isset($params['height']))
		$params['height'] = 0;		

	if(!isset($params['volume']))
		$params['volume'] = 0;		

	if(!isset($params['city']))
		$params['city'] = false;		

	if(!isset($params['state']))
		$params['state'] = false;		

   $ip = $_SERVER['REMOTE_ADDR'];
	
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, "https://ru.sxgeo.city/json/".$ip);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $data = curl_exec($curl);
    
   curl_close($curl);
   if($data === false) {
	 echo "Город не определён.";
   }
    
   $ip_geo = json_decode($data, $assoc=true);
    
	$city = $ip_geo["city"]["name_ru"];
	$state = $ip_geo["region"]["name_ru"];
	$country = $ip_geo["country"]["name_ru"];

	$order['Order']['bill_city'] = $ip_geo["city"]["name_ru"];

	$order['OrderProduct'][1]['name'] = $content['ContentDescription']['name'];	
	$order['OrderProduct'][1]['quantity'] = 1;	
	$order['OrderProduct'][1]['weight'] = $content['ContentProduct']['weight'];	
	$order['OrderProduct'][1]['length'] = $content['ContentProduct']['length'];	
	$order['OrderProduct'][1]['width'] = $content['ContentProduct']['width'];	
	$order['OrderProduct'][1]['height'] = $content['ContentProduct']['height'];	
	$order['OrderProduct'][1]['volume'] = $content['ContentProduct']['volume'];	

	$active_ship_methods = $ShippingMethod->find('all', array('conditions' => array('active' => '1'),'order' => array('order')));

	$keyed_ship_methods = array();
	foreach($active_ship_methods AS $method)
	{
		$shipping = Inflector::classify($method['ShippingMethod']['code']);
		$shipping_controller =  Inflector::classify($method['ShippingMethod']['code']) . 'Controller';
		App::import('Controller', 'Shipping.'.$shipping);
		$MethodBase = new $shipping_controller();
		
		$ship_method_id = $method['ShippingMethod']['id'];
		
		$keyed_ship_methods[$ship_method_id] = array(
										  'id' => $ship_method_id,
										  'name' => $method['ShippingMethod']['name'],
										  'description' => (isset($method['ShippingMethod']['description'])) ? __($method['ShippingMethod']['description']) : false,
										  'icon' => (isset($method['ShippingMethod']['icon']) && file_exists(IMAGES . 'icons/shipping/' . $method['ShippingMethod']['icon'])) ? $method['ShippingMethod']['icon'] : false,
										  'cost_plain' => $MethodBase->calculate(),
										  'cost' => $CurrencyBase->display_price($MethodBase->calculate())
										  );

	}	
	
	// Assign the payment methods
	$active_payment_methods = $PaymentMethod->find('all', array('conditions' => array('active' => '1'),'order' => array('order')));

	$keyed_payment_methods = array();
	foreach($active_payment_methods AS $method)
	{
		$payment_method_id = $method['PaymentMethod']['id'];

		$keyed_payment_methods[$payment_method_id] = array(
										  'id' => $payment_method_id,
										  'name' => $method['PaymentMethod']['name'],
										  'description' => (isset($method['PaymentMethod']['description'])) ? __($method['PaymentMethod']['description']) : false,
										  'icon' => (isset($method['PaymentMethod']['icon']) && file_exists(IMAGES . 'icons/payment/' . $method['PaymentMethod']['icon'])) ? $method['PaymentMethod']['icon'] : false
										  );

	}			

	$assignments = array(
		'city' => $city,
		'state' => $state,
		'ship_methods' => $keyed_ship_methods,
		'payment_methods' => $keyed_payment_methods
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
		<li><em><?php echo __('(content_id)') ?></em> - <?php echo __('Content id number.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_shipping_methods() {
}
?>