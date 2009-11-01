<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.ru
   http://vamshop.com
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function default_template_language_box()
{
$template = '<div class="info_box">
								<div class="box_heading">{lang}Language{/lang}</div>
								<div class="box_content">
									{foreach from=$languages item=language}
										<a href="{$language.url}"><img src="{$language.image}" alt="{$language.name}" title="{$language.name}"/></a>
									{/foreach}
								</div>
							 </div>';		

return $template;
}

function smarty_function_language_box($params, &$smarty)
{
	// Cache the output.
	$cache_name = 'vam_language_box_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'];
	$language_box_output = Cache::read($cache_name);
	if($language_box_output === false)
	{
		ob_start();
		


	global $content;
	
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();

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