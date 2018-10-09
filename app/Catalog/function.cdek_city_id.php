<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_cdek_city_id($params, $template)
{
	global $config;	

	$sender_city = $params['city'];
	
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".$sender_city);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  if ($data_cdek['debug'] == 1) echo "ID номер для города отправителя посылки не найден.";
	    }
	    
	    $senderCity = json_decode($data, $assoc=true);
	    $senderCityId = $senderCity["geonames"][0]["id"];
	
	return $senderCityId;
}

function smarty_help_function_cdek_city_id() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Returns the city id number from API CDEK.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{cdek_city_id city="Ставрополь"}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(city)') ?></em> - <?php echo __('City name.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_cdek_city_id() {
}
?>