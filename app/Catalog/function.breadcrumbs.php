<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_breadcrumbs()
{
$template = '
{if !$default_page and $parent_id > 0}
<div id="breadcrumbs">
    <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
      <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a href="{$parent_url}" itemprop="item"><span itemprop="name">{$parent_name}</span></a><meta itemprop="position" content="1" /></li>
      <li itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem" class="active"><span itemprop="name">{$page_name}</span><meta itemprop="position" content="2" /><meta itemprop="item" content="{$smarty.const.FULL_BASE_URL}{page_url}" /></li>
    </ol>
</div>
{/if}
';
		
return $template;
}


function smarty_function_breadcrumbs($params, $template)
{
	global $content, $config;
	
	if ($content['Content']['parent_id'] > 0) {

	// Cache the output.
	$cache_name = 'vam_breadcrumbs_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

 	App::import('Model', 'Content');
	$Content = new Content();		
	$Content->unbindAll();	
	$Content->bindModel(
        array('hasOne' => array(
			'ContentDescription' => array(
                 'className' => 'ContentDescription',
				'conditions'   => 'language_id = ' . $_SESSION['Customer']['language_id']
             )
         )
        	)
    );
	$Content->bindModel(
        array('belongsTo' => array('ContentType'))
    );
	
	$page_data = $Content->find('first', array('conditions' => array('Content.id' => $content['Content']['parent_id'])));

	if(!$page_data)
		return;
		
	$default_page = $content['Content']['default'];
	$page_id = $content['Content']['id'];
	$page_alias = $content['Content']['alias'];
	$page_name = $content['ContentDescription']['name'];
	$page_url = BASE . '/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION'];
	$parent_id = $page_data['Content']['id'];
	$parent_alias = $page_data['Content']['alias'];
	$parent_name = $page_data['ContentDescription']['name'];
	$parent_url = BASE . '/' . $page_data['ContentType']['name'] . '/' . $page_data['Content']['alias'] . $config['URL_EXTENSION'];

	$assignments = array(
		'default_page' => $default_page,
		'page_id' => $page_id,
		'page_alias' => $page_alias,
		'page_name' => $page_name,
		'page_url' => $page_url,
		'parent_id' => $parent_id,
		'parent_alias' => $parent_alias,
		'parent_name' => $parent_name,
		'parent_url' => $parent_url
	);

	$display_template = $Smarty->load_template($params, 'breadcrumbs');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
	}
	
}

function smarty_help_function_breadcrumbs() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Creates a breadcrumbs.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{breadcrumbs}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_breadcrumbs() {
}
?>