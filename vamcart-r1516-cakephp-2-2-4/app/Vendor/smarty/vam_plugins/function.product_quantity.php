<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_product_quantity()
{
$template = '<input id="product_quantity" name="product_quantity" type="text" value="1" size="3" />';		

return $template;
}


function smarty_function_product_quantity($params, $template)
{
	$cache_name = 'vam_product_quantity' . (isset($params['template'])?'_'.$params['template']:'');
	$results = Cache::read($cache_name);
	if($results === false)
	{	
		App::uses('SmartyComponent', 'Controller/Component');
			$Smarty =& new SmartyComponent(new ComponentCollection());

		$results = $Smarty->load_template($params,'product_quantity');

		Cache::write($cache_name, $results);		
	}
	
	
	return $results;
}

function smarty_help_function_product_quantity() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Creates a product quantity box.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your product_info template like:') ?> <code>{product_quantity}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_product_quantity() {
}
?>