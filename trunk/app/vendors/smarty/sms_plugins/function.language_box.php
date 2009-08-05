<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

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
	$cache_name = 'sms_language_box_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'];
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
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template for the language_box plugin.') ?></li>
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