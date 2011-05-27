<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.ru
   http://vamcart.com
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function smarty_function_global_content($params, $template)
{
	// Cache the output.
	$cache_name = 'vam_gcb_output_' .  $params['alias'] . '_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name);
	if($output === false)
	{
		ob_start();

	global $content;
		
	// Load the smarty component because we're coming from a plugin
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();
	
	// Load the template model and get the sub-template from the databse
	App::import('Model', 'GlobalContentBlock');
		$GlobalContentBlock =& new GlobalContentBlock();

	$gcb = $GlobalContentBlock->find(array('alias' => $params['alias']));

	$Smarty->display($gcb['GlobalContentBlock']['content'], $template->smarty->tpl_vars);
		
		
		// Write the output to cache and echo them
		$output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $output);		
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
	?>
	<p><?php echo __('Author: Kevin Grandon &lt;kevingrandon@hotmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>