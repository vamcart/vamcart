<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_downloadable_prices($params, &$smarty)
{
	global $content;

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());

	$prices  = '';
	$quantites = '';

	if (isset($content['ContentProductPrice'])) {
		$quantites = '<b>'.$content['ContentProduct']['moq'];
		if (sizeof($content['ContentProductPrice']) > 0) {
			for ($i=0; $i < sizeof($content['ContentProductPrice']); $i++) {
				$q = $content['ContentProductPrice'][$i]['quantity'];
				$quantites .= '-'.($q-1).(($i==0)?'</b>':'').'<br>'.$q;
			}
			$quantites .= '+<br />';
		} else {
			$quantites .= '</b>';
		}
	}

	$stock = 'full';
	$stock_text = $content['ContentDownloadable']['stock'] . ' ' . __('available', true);

	echo '<p class="left"><img src="/img/icons/stock/'.$stock.'.png" title="'.$stock_text.'" class="stock_image" /><br /><br />';

	echo '<b><span class="price calculated">' . $CurrencyBase->display_price($content['ContentDownloadable']['price']) . '</span></b><br>';

	echo '</p>';
	echo '<p class="right">';
	echo $stock_text.'<br /><br />';
	echo '</p>';
}

function smarty_help_function_downloadable_prices () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product prices for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{downloadable_prices}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_downloadable_prices () {
}
?>