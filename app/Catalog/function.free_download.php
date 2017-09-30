<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_free_download()
{
$template = '
{if $price == 0}
<a class="btn btn-warning" href="{$url}">{lang}Download{/lang}</a>
{/if}
';
		
return $template;
}


function smarty_function_free_download($params, $template)
{
	global $content, $config;
	
	if ($content['Content']['content_type_id'] == 7) {

	// Cache the output.
	$cache_name = 'vam_free_download_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	if ($content['Content']['content_type_id'] != 7) return;

	$price = $content['ContentDownloadable']['price'];

	if ($content['ContentDownloadable']['price'] == 0) {
	$filename = $content['ContentDownloadable']['filename'];
	}

	$url = FULL_BASE_URL . BASE . '/download/0/' . $content['Content']['id'] . '/free';

	$assignments = array(
		'filename' => $filename,
		'url' => $url,
		'price' => $price
	);

	$display_template = $Smarty->load_template($params, 'free_download');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
	}
	
}

function smarty_help_function_free_download () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product download link. Only for free products (product price must be 0).') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{free_download}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_free_download() {
}
?>