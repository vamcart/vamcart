<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_cdek_pvz()
{
$template = '
<!-- Button trigger modal -->
<!--<span><u><a href="" data-toggle="modal" data-target="#myModalPvz">{if {cookie name="vamshop-city"}}{cookie name="vamshop-city"}{else}{$city}{/if}</a></span></u>-->

<!-- Modal -->
<div class="modal fade" id="myModalPvz" tabindex="-1" role="dialog" aria-labelledby="myModalPvzLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalPvzLabel">Список пунктов выдачи заказов <u>{if {cookie name="vamshop-city"}}{cookie name="vamshop-city"}{else}{$city}{/if}</u></h4>
      </div>
      <div class="modal-body">

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
<thead>
<tr>
<th class="ship-title">{lang}Name{/lang}</th>
<th class="ship-title">{lang}Address Line 1{/lang}</th>
<th class="ship-title">{lang}Phone{/lang}</th>
</tr>
</thead>
<tbody>
{foreach from=$cdek_pvz item=pvz}
<tr>
<td>{lang}{$pvz.name}{/lang}</td>
<td>{lang}{$pvz.address}{/lang}</td>
<td class="text-left">{$pvz.phone}</td>
</tr>
{/foreach}
</tbody>
</table>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>  
';
		
return $template;
}


function smarty_function_cdek_pvz($params, $template)
{
	global $content, $config, $order;

   $ip = $_SERVER['REMOTE_ADDR'];
   //$ip = '178.34.161.115';
	
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, "https://ru.sxgeo.city/json/".$ip);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $data = curl_exec($curl);
    
   curl_close($curl);
   if($data === false) {
	 echo "Город не определён.";
   }
    
   $ip_geo = json_decode($data, $assoc=true);
    
	$city = $ip_geo["city"]["name_ru"];
	
	$state = $ip_geo["region"]["name_ru"];
	$country = $ip_geo["country"]["name_ru"];
	
	// Cache the output.
	$cache_name = 'vam_cdek_pvz_output' . (isset($params['template'])?'_'.$params['template']:'') . (isset($city)?'_'.$city:'') . '_' . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

	App::import('Model', 'ShippingMethod');
		$ShippingMethod = new ShippingMethod();

	if(!isset($params['city'])) {
		$params['city'] = $city;	
	} else {
		$city = $params['city'];	
	}	

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".$city);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    
    curl_close($curl);
    if($data === false) {
	  if ($data_cdek['debug'] == 1) echo "ID номер для города отправителя посылки не найден.";
    }
    
    $senderCity = json_decode($data, $assoc=true);
    $senderCityId = $senderCity["geonames"][0]["id"];
    
     $cdek_pvz = "https://integration.cdek.ru/pvzlist.php?cityid=".$senderCityId;

     // create curl resource
     $ch = curl_init();

     // set url
     curl_setopt($ch, CURLOPT_URL, $cdek_pvz);

     //return the transfer as a string
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

     // $output contains the output string
     $output = curl_exec($ch);

     // close curl resource to free up system resources
     curl_close($ch);  

     $cdek_contents = $output;
     $cdek_results = simplexml_load_string($cdek_contents);
     
     //echo var_dump($cdek_results);
        
	$keyed_cdek_pvz = array();
	$pvz_id = 0;
	foreach($cdek_results AS $pvz)
	{
		$keyed_cdek_pvz[$pvz_id] = array(
										  'id' => $pvz['Code'],
										  'name' => $pvz['Name'],
										  'address' => $pvz['FullAddress'],
										  'phone' => $pvz['Phone'],
										  );
										  
   $pvz_id++;
	}	
	
	$assignments = array(
		'city' => $city,
		'state' => $state,
		'country' => $country,
		'cdek_pvz' => $keyed_cdek_pvz
	);

	$display_template = $Smarty->load_template($params, 'cdek_pvz');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
}

function smarty_help_function_cdek_pvz() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the cdek shipping offices.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{cdek_pvz}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(city)') ?></em> - <?php echo __('City name.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_cdek_pvz() {
}
?>