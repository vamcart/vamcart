<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_language_box()
{
$template = '
<section class="widget inner">
	<h3 class="widget-title">{lang}Language{/lang}</h3>
		<ul class="icons clearfix">
			{foreach from=$languages item=language}
				<li><a href="{$language.url}"><img src="{$language.image}" alt="{$language.name}" title="{$language.name}"/></a> <a href="{$language.url}">{$language.name}</a></li>
			{/foreach}
		</ul>
</section>
';		

return $template;
}

function smarty_function_language_box($params, $template)
{
	// Cache the output.
	$cache_name = 'vam_language_box_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'];
	$language_box_output = Cache::read($cache_name);
	if($language_box_output === false)
	{
		ob_start();
		


	global $content;
	
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Language');
		$Language =& new Language();
	
	$languages = $Language->find('all', array('conditions' => array('active' => '1')));
	
	if(count($languages) == 1)
		return;
	
	$keyed_languages = array();
	foreach($languages AS $language)
	{
		$language['Language']['url'] = BASE . '/languages/pick_language/' . $language['Language']['id'];
		$language['Language']['image'] = BASE . '/img/flags/' . $language['Language']['iso_code_2'] .'.png';
		$keyed_languages[] = $language['Language'];
	}

	$vars = array('languages' => $keyed_languages);
	
	$display_template = $Smarty->load_template($params,'language_box');	
	$Smarty->display($display_template,$vars);
	
		// Write the output to cache and echo them
		$language_box_output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $language_box_output);		
	}
	echo $language_box_output;	

}

function smarty_help_function_language_box() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Allows the user to select a language.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{language_box}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_language_box() {
}
?>