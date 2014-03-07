<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_global_content($params, $template)
{
	// Cache the output.
	$cache_name = 'vam_gcb_output_' .  $params['alias'] . '_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
		ob_start();

	global $content;
		
	// Load the smarty component because we're coming from a plugin
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());
	
	// Load the template model and get the sub-template from the databse
	App::import('Model', 'GlobalContentBlock');
		$GlobalContentBlock =& new GlobalContentBlock();

	$gcb = $GlobalContentBlock->find('first', array('conditions' => array('alias' => $params['alias'])));

	$Smarty->display($gcb['GlobalContentBlock']['content'], $template->smarty->tpl_vars);
		
		
		// Write the output to cache and echo them
		$output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $output, 'catalog');		
	}
	echo $output;	
		
}

function smarty_help_function_global_content() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Outputs the global_content of the current page, product, or category depending on the user\'s default selected language.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{global_content alias='footer'}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(alias)') ?></em> - <?php echo __('Alias of the global content block to display.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_global_content() {
}
?>