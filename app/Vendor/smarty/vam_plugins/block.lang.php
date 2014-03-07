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

		global $config;		
		
	// Cache the output.
	$text_values_cache_name = 'vam_defined_language' .  '_' . $_SESSION['Customer']['language_id'];
	$text_values_cache_output = Cache::read($text_values_cache_name, 'catalog');

	if($text_values_cache_output === false)
	{

			App::import('Model', 'DefinedLanguage');
			$DefinedLanguage =& new DefinedLanguage();
	
			$defined_language_values = $DefinedLanguage->find('all', array('conditions' => array('language_id' => $_SESSION['Customer']['language_id'])));

			$text_values = array_combine(Set::extract($defined_language_values, '{n}.DefinedLanguage.key'),
						 		 Set::extract($defined_language_values, '{n}.DefinedLanguage.value'));	
						 		 
		Cache::write($text_values_cache_name, $text_values, 'catalog');		
	}

		if(array_key_exists($content,$text_values_cache_output))
		{
		echo $text_values_cache_output[$content];
		}	
		


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