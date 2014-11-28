<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_product_label()
{
$template = '
{if $label.html}
<span class="label html">{$label.html}</span>
{else}
<span class="label {$label.alias}">{lang}{$label.name}{/lang}</span>
{/if}
';		

return $template;
}

function smarty_function_product_label($params, $template)
{
	global $content;
	global $config;

	if(!isset ($params['label_id']))
		$params['label_id'] = $content['ContentProduct']['label_id'];

	if($params['label_id'] > 0) {

	// Cache the output.
	$cache_name = 'vam_product_label_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'] . '_' . $params['label_id'];
	$label_box_output = Cache::read($cache_name, 'catalog');
	if($label_box_output === false)
	{
		ob_start();
	
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Label');
		$Label =& new Label();
	
	$label = $Label->find('first', array('conditions' => array('id' => $params['label_id'])));

	if(!$label)
		return;

	$vars = array('label' => $label['Label']);
	
	$display_template = $Smarty->load_template($params,'product_label');	
	$Smarty->display($display_template,$vars);
	
		// Write the output to cache and echo them
		$label_box_output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $label_box_output, 'catalog');		
	}
	echo $label_box_output;	
	
	}

}

function smarty_help_function_product_label() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product label.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_label}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(label_id)') ?></em> - <?php echo __('Display label name of selected label_id element.') ?></li>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_product_label() {
}
?>