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
								<div class="box_heading">{lang}language{/lang}</div>
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
	$cache_name = 'sms_language_box_output' . (isset($params['template'])?'_'.$params['template']:'');
	$language_box_output = Cache::read($cache_name);
	if($language_box_output === false)
	{
		ob_start();
		


	global $content;
	
	loadComponent('Smarty');
		$Smarty =& new SmartyComponent();

	loadModel('Language');
		$Language =& new Language();
	
	$languages = $Language->findAll(array('active' => '1'));
	
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
	<h3>What does this do?</h3>
	<p>Allows the user to select a language.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template like: <code>{language_box}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(template)</em> - Overrides the default template for the language_box plugin.</li>
	</ul>
	<?php
}

function smarty_about_function_language_box() {
	?>
	<p>Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>
	<p>Version: 0.1</p>
	<p>
	Change History:<br/>
	None
	</p>
	<?php
}
?>