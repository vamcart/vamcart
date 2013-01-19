<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_google_analytics($params, $template)
{
	
	global $order;		
	global $config;
	
	$params['checkout_success'] = (!isset($params['checkout_success'])) ? false : true;
	$result = '';
	
	if ($config['GOOGLE_ANALYTICS'] != '') {

	$_SERVER['QUERY_STRING'] = str_replace('url=','',$_SERVER['QUERY_STRING']);
	
	if (($_SERVER['QUERY_STRING'] == 'page/confirmation' . $config['URL_EXTENSION'])) {

// Prepare the Analytics "Transaction line" string

	$transaction_string = '\'' . $order['Order']['id'] . '\','."\n".'\'' . $config['SITE_NAME'] . '\','."\n".'\'' . $order['Order']['total'] . '\','."\n".'\'' . $order['Order']['tax'] . '\','."\n".'\'' . $order['Order']['shipping'] . '\','."\n".'\'' . $order['Order']['bill_city'] . '\','."\n".'\'' . $order['Order']['bill_state'] . '\','."\n".'\'' . $order['Order']['bill_country'] . '\'';

// Get products info for Analytics "Item lines"

	$item_string = '';
    foreach($order['OrderProduct'] AS $items) {
	  $item_string .=  '_gaq.push([\'_addItem\','."\n".'\'' . $order['Order']['id'] . '\','."\n".'\'' . $items['id'] . '\','."\n".'\'' . htmlspecialchars($items['name']) . '\','."\n".'\'' . htmlspecialchars($items['Content']['parent_id']) . '\','."\n".'\'' . $items['price'] . '\','."\n".'\'' . $items['quantity'] . '\''."\n".']);'."\n";
    }

			$result = '
			
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'' . $config['GOOGLE_ANALYTICS'] . '\']);
  _gaq.push([\'_trackPageview\']);
  _gaq.push([\'_trackPageLoadTime\']);

   _gaq.push([\'_addTrans\',
' . $transaction_string . '
]);

' . $item_string . '
  _gaq.push([\'_trackTrans\']); //submits transaction to the Analytics servers

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
			
			';
	} else {
			$result = '

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \''.$config['GOOGLE_ANALYTICS'].'\']);
  _gaq.push([\'_trackPageview\']);
  _gaq.push([\'_trackPageLoadTime\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>			
			
			';
	}
	}

	return $result;
}

function smarty_help_function_google_analytics() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the google analytics code.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{google_analytics}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_google_analytics() {
}
?>