<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_geo_city($params, $template)
{
  global $content;
  App::import('Vendor', 'GeoCity', array('file' => 'GeoCity'.DS.'SxGeo.php'));
  $SxGeo= new SxGeo(APP.'Vendor/GeoCity/SxGeo.dat');
  $city = $SxGeo->get($_SERVER['REMOTE_ADDR']);
  $city_name = '';

  // Cloud flare original user ip
  if (array_key_exists('HTTP_CF_CONNECTING_IP',$_SERVER) && $_SERVER['HTTP_CF_CONNECTING_IP'] != '') $city = $SxGeo->get($_SERVER['HTTP_CF_CONNECTING_IP']);
  
  if (is_array($city))  
  $city_name = ($_SESSION['Customer']['language'] == 'ru') ? $city['city']['name_ru'] : $city['city']['name_en'];

	return $city_name;
}

function smarty_help_function_geo_city() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the current user city name.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{geo_city}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_geo_city() {
}
?>