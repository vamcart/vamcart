<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_stylesheet($params, $template)
{
	global $content;

	$stylesheet = '';
	
	if (isset($params['alias']) && $params['alias'] != '')
	{
		$stylesheet .= '<link rel="stylesheet" type="text/css" ';
		if (isset($params['media']) && $params['media'] != '')
		{
			$stylesheet .= 'media="' . $params['media'] . '" ';
		}
		$stylesheet .= 'href="' . BASE . '/stylesheets/load/'.$params['alias'];
		$stylesheet .= "\" />\n"; 
	}
	else
	{
		foreach ($content['Template']['Stylesheet'] AS $attached_stylesheet)
		{
			$stylesheet .= '<link type="text/css" ';
			if (isset($params['media']) && $params['media'] != '')
			{
			$stylesheet .= 'media="' . $params['media'] . '" ';
			}
			$stylesheet .= 'href="' . BASE . '/stylesheets/load/'.$attached_stylesheet['alias'] . '.css';
			$stylesheet .= '" rel="stylesheet" />'; 
		}
	}

	return $stylesheet;
}

function smarty_help_function_stylesheet() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Gets stylesheet information from the system. By default, it grabs all of the stylesheets attached to the current template.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page\'s head section like:') ?> <code>{stylesheet}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(optional)') ?></em> alias - <?php echo __('Instead of getting all stylesheets for the given page, it will only get one spefically named one, whether it\'s attached to the current template or not. Set the alias to be the ID or alias of the stylesheet.') ?></li>
		<li><em><?php echo __('(optional)') ?></em> media - <?php echo __('If name is defined, this allows you set a different media type for that stylesheet.') ?></li>
	</ul>
	</p>
	<?php
}

function smarty_about_function_stylesheet() {
}
?>