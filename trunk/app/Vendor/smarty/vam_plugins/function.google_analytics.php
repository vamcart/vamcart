<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_google_analytics($params, $template)
{
	
	global $order;		
	global $config;
	
	$params['checkout_success'] = (!isset($params['checkout_success'])) ? false : true;
	$result = '';

	if ($config['GOOGLE_ANALYTICS'] != '') {

	if (($_SERVER['REQUEST_URI'] == BASE.'/page/confirmation' . $config['URL_EXTENSION'])) {

// Prepare the Analytics "Transaction line" string

	$transaction_string = '
	
    \'id\': \'' . $order['Order']['id'] . '\','."\n".
    '\'affiliation\': \'' . $config['SITE_NAME'] . '\','."\n".
    '\'revenue\': \'' . $order['Order']['total'] . '\','."\n".
    '\'shipping\': \'' . $order['Order']['shipping'] . '\','."\n".
    '\'tax\': \'' . $order['Order']['tax'] . '\'
	
	';

// Get products info for Analytics "Item lines"

	$item_string = '';
    foreach($order['OrderProduct'] AS $items) {
	  $item_string .=  
	  
  'ga(\'ecommerce:addItem\', {'."\n".
	  
    '\'id\': \'' . $order['Order']['id'] . '\','."\n".
    '\'name\': \'' . htmlspecialchars($items['name']) . '\','."\n".
    '\'sku\': \'' . htmlspecialchars($items['model']) . '\','."\n".
    '\'category\': \'' . htmlspecialchars($items['Content']['parent_id']) . '\','."\n".
    '\'price\': \'' . $items['price'] . '\','."\n".
    '\'quantity\': \'' . $items['quantity'] . '\''."\n".
	  
  '});'."\n";
  
    }

			$result = '

<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \'' . $config['GOOGLE_ANALYTICS'] . '\', \'' . $_SERVER['HTTP_HOST'] . '\');
  ga(\'send\', \'pageview\');
  ga(\'require\', \'ecommerce\', \'ecommerce.js\');

  ga(\'ecommerce:addTransaction\', {
' . $transaction_string . '
});

' . $item_string . '

  ga(\'ecommerce:send\');

</script>
			
			';
	} else {
			$result = '

<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \'' . $config['GOOGLE_ANALYTICS'] . '\', \'' . $_SERVER['HTTP_HOST'] . '\');
  ga(\'send\', \'pageview\');

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