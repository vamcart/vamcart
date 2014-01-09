<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_block_lang($params, $content, $template, &$repeat)
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

	$language_content = $DefinedLanguage->find('first', array('conditions' => array('language_id' => $_SESSION['Customer']['language_id'], 'key' => $content)));
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
}
?>