<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function smarty_function_yandex_metrika($params, $template)
{
	
	global $order;		
	global $config;
	
	$params['checkout_success'] = (!isset($params['checkout_success'])) ? false : true;
	$result = '';
	
	if ($config['YANDEX_METRIKA'] != '') {

	$_SERVER['QUERY_STRING'] = str_replace('url=','',$_SERVER['QUERY_STRING']);
	
		switch ($params['checkout_success']) {
			case 'true' :

// Prepare the Analytics "Transaction line" string

	$transaction_string = 'order_id: "' . $order['Order']['id'] . '",'."\n".'order_price: ' . number_format($order['Order']['total'],2,'.','') . ','."\n".'currency: "' . $_SESSION['Customer']['currency_code'] . '",'."\n".'exchange_rate: 1,';

// Get products info for Analytics "Item lines"

	$item_string = '';
    foreach($order['OrderProduct'] AS $items) {
	  $item_string .=  '{'."\n".'id: "' . htmlspecialchars($items['id']) . '",'."\n".'name: "' . htmlspecialchars($items['name']) . '",'."\n".'price: ' . number_format($items['price'],2,'.','') . ','."\n".'quantity: ' . number_format($items['quantity']) . ''."\n".'},'."\n";
    }
    
			$result = '
			
<script type="text/javascript">
var yaParams = {
	
'.$transaction_string.'	
  goods: 
     [
'.$item_string.'	
      ]
	};
</script>
<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter' . $config['YANDEX_METRIKA'] . ' = new Ya.Metrika({id:' . $config['YANDEX_METRIKA'] . ', enableAll: true,ut:"noindex",params:window.yaParams||{ }});
        }
        catch(e) { }
    });
})(window, \'yandex_metrika_callbacks\');
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/' . $config['YANDEX_METRIKA'] . '" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			
			';
			break;		
			default :
			if (($_SERVER['QUERY_STRING'] != 'page/confirmation' . $config['URL_EXTENSION'])) {
			$result = '

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
var yaParams = {};
</script>

<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter'.$config['YANDEX_METRIKA'].' = new Ya.Metrika({id:'.$config['YANDEX_METRIKA'].', enableAll: true,ut:"noindex",params:window.yaParams||{ }});
        }
        catch(e) { }
    });
})(window, \'yandex_metrika_callbacks\');
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/'.$config['YANDEX_METRIKA'].'" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
		
			
			';
			}
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
		<li><em><?php echo __('(checkout_success)') ?></em> - <?php echo __('(true or false) If set to true display the display yandex metrika ecommerce tracking code in checkout success page.') ?></li>		
	</ul>
	<?php
}

function smarty_about_function_yandex_metrika() {
	?>
	<p><?php echo __('Author: Alexandr Menovchicov &lt;vam@kypi.ru&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>