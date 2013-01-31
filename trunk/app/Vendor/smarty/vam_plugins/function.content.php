<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_content($params, $template)
{
	global $content;
	// Cache the output... Don't cache core pages.
	$cache_name = 'vam_page_content_' . $content['Content']['id'] . '_' . $_SESSION['Customer']['language_id']. '_' . $_SESSION['Customer']['currency_id'];
	$output = Cache::read($cache_name);

	if (($output === false)||($content['Content']['parent_id'] == '-1')) {
		ob_start();

		// Load the smarty component because we're coming from a plugin
		App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());

		// Load the template model and get the sub-template from the databse
		App::import('Model', 'Template');
		$Template =& new Template();

		$contentTemplate = $Template->find('first', array('conditions' => array('parent_id' => $content['Template']['id'], 'template_type_id' => $content['ContentType']['template_type_id'])));

		$Smarty->display($contentTemplate['Template']['template'], $template->smarty->tpl_vars);
		// Write the output to cache and echo them
		$output = @ob_get_contents();
		ob_end_clean();
		Cache::write($cache_name, $output);
	}

	echo $output;
}

function smarty_help_function_content () {
?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('This is where the content for your page will be displayed. It\'s inserted into the template and changed based on the current page being displayed. This tag will call any sub-templates that are required to display the page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{content}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
<?php
}

function smarty_about_function_content () {
}
?>
