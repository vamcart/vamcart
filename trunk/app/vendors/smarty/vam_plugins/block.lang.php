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

function smarty_block_lang($params, $content, &$smarty)
{
	
    if (is_null($content)) 
	{
        return;
    }
	
		// Start caching
		$cache_name = 'vam_lang_' .  $_SESSION['Customer']['language_id'] . '_' . $content;
		$output = Cache::read($cache_name);
		if($output === false)
		{
			ob_start();	
	
	
	App::import('Model', 'DefinedLanguage');
	$DefinedLanguage =& new DefinedLanguage();

	$language_content = $DefinedLanguage->find(array('language_id' => $_SESSION['Customer']['language_id'], 'key' => $content));
	if(empty($language_content['DefinedLanguage']['value']))
		//$output = "Error! Empty language value for: " . $content;
		$lang_output = $content;		
	else
		$lang_output = $language_content['DefinedLanguage']['value'];
		
		echo $lang_output;
		
			// End cache
			$output = @ob_get_contents();
			ob_end_clean();
			Cache::write($cache_name, $output);
		}
		echo $output;
	
}

function smarty_help_function_lang() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Outputs the correct language value specified by the key between the brackets.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{lang}<?php echo __('Language Text') ?>{/lang}</code></p>
	<p><?php echo __('Make sure you define the language key in the admin area.') ?></p>
	<?php
}

function smarty_about_function_lang() {
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