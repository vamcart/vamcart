<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_yandex_metrika($params, $template)
{
	
	global $order;		
	global $config;
	
	$params['checkout_success'] = (!isset($params['checkout_success'])) ? false : true;
	$result = '';
	
	if ($config['YANDEX_METRIKA'] != '') {

	if (($_SERVER['REQUEST_URI'] == BASE.'/page/confirmation' . $config['URL_EXTENSION'])) {

// Prepare the Analytics "Transaction line" string

	$transaction_string = 'order_id: "' . $order['Order']['id'] . '",'."\n".'order_price: ' . number_format($order['Order']['total'],2,'.','') . ','."\n".'currency: "' . $_SESSION['Customer']['currency_code'] . '",'."\n".'exchange_rate: 1,';

// Get products info for Analytics "Item lines"

	$item_string = '';
    foreach($order['OrderProduct'] AS $items) {
	  $item_string .=  '{'."\n".'id: "' . htmlspecialchars($items['id']) . '",'."\n".'name: "' . htmlspecialchars($items['name']) . '",'."\n".'price: ' . number_format($items['price'],2,'.','') . ','."\n".'quantity: ' . number_format($items['quantity']) . ''."\n".'},'."\n";
    }
    
			$result = '
<script>
window.dataLayer = window.dataLayer || [];
</script>			
<script>
dataLayer.push({
    "ecommerce": {
        "purchase": {
            "actionField": {
                "id" : "'.$order['Order']['id'].'"
            },
            "products": [
                '.$item_string.'	
            ]
        }
    }
});
	
</script>
<!-- Yandex.Metrika counter -->
<script>
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym('.$config['YANDEX_METRIKA'].', "init", {
        id:'.$config['YANDEX_METRIKA'].',
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>

<noscript><div><img src="https://mc.yandex.ru/watch/'.$config['YANDEX_METRIKA'].'?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
			
			';
	} else {
			$result = '

<!-- Yandex.Metrika counter -->
<script>
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym('.$config['YANDEX_METRIKA'].', "init", {
        id:'.$config['YANDEX_METRIKA'].',
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>

<noscript><div><img src="https://mc.yandex.ru/watch/'.$config['YANDEX_METRIKA'].'?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
		
			
			';
	}
	}

	return $result;
}

function smarty_help_function_yandex_metrika() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the yandex metrika code.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{yandex_metrika}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_yandex_metrika() {
}
?>