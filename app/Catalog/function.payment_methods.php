<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_payment_methods()
{
$template = '
<h4>{lang}Payment Methods{/lang}</h4>
{foreach from=$payment_methods item=payment_method}
{if $payment_method.icon}<img class="text-center" src="{$payment_method.icon}" alt="{lang}{$payment_method.name}{/lang}" title="{lang}{$payment_method.name}{/lang}"{if {$payment_method.width} > 0} width="{$payment_method.width}"{/if}{if {$payment_method.height} > 0} height="{$payment_method.height}"{/if} /> {/if}
{/foreach}
';
		
return $template;
}


function smarty_function_payment_methods($params, $template)
{
	global $content, $config, $order;

	if(!isset ($params['limit']))
		$params['limit'] = $config['PRODUCTS_PER_PAGE'];

	// Cache the output.
	$cache_name = 'vam_payment_methods_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::import('Model', 'PaymentMethod');
		$PaymentMethod = new PaymentMethod();

	// Assign the payment methods
	$active_payment_methods = $PaymentMethod->find('all', array('conditions' => array('active' => '1'), 'limit' => $params['limit'], 'order' => array('order')));

	$keyed_payment_methods = array();
	foreach($active_payment_methods AS $method)
	{
		$payment_method_id = $method['PaymentMethod']['id'];

		$icon_name = $method['PaymentMethod']['icon'];	
		$icon_path = IMAGES . 'icons/payment/' . $icon_name;
		$icon_url = BASE . '/img/icons/payment/' . $icon_name;

		if(file_exists($icon_path) && is_file($icon_path)) {
			list($width, $height, $type, $attr) = getimagesize($icon_path);
		}

		$keyed_payment_methods[$payment_method_id] = array(
										  'id' => $payment_method_id,
										  'name' => $method['PaymentMethod']['name'],
										  'code' => (isset($method['PaymentMethod']['alias']) && $method['PaymentMethod']['alias'] !== '') ? $method['PaymentMethod']['alias'] : false,
										  'description' => (isset($method['PaymentMethod']['description'])) ? __($method['PaymentMethod']['description']) : false,
										  'icon' => (isset($icon_name) && file_exists($icon_path)) ? $icon_url : false,
										  'width' => (isset($icon_name) && file_exists($icon_path)) ? $width : false,
										  'height' => (isset($icon_name) && file_exists($icon_path)) ? $height : false
										  );

	}			

	$assignments = array(
		'payment_methods' => $keyed_payment_methods
	);

	$display_template = $Smarty->load_template($params, 'payment_methods');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
}

function smarty_help_function_payment_methods () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the active payment methods.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{payment_methods}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(limit)') ?></em> - <?php echo __('Limit displayed items.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_payment_methods() {
}
?>