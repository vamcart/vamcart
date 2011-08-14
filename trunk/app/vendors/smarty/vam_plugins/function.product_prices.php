<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   Copyright 2011 David Lednik
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2011 by David Lednik (david.lednik@gmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function smarty_function_product_prices($params, &$smarty)
{
    global $content;

    App::import('Component', 'CurrencyBase');
		$CurrencyBase =& new CurrencyBaseComponent();

    $prices  = '';
    $quantites = '<b>'.$content['ContentProduct']['moq'];
    if (sizeof($content['ContentProductPrice'])>0)
    {
        for ($i=0; $i<sizeof($content['ContentProductPrice']); $i++)
        {
            $q = $content['ContentProductPrice'][$i]['quantity'];
            $quantites .= '-'.($q-1).(($i==0)?'</b>':'').'<br>'.$q;
        }
        $quantites .= '+<br>';
    }
    else
        $quantites .= '</b>';

    $stock = '';
    $stock_text = $content['ContentProduct']['stock'].' '.__('available', true);
    if ($content['ContentProduct']['stock'] > 5)
        $stock.='full';
    elseif ($content['ContentProduct']['stock'] == 0)
        $stock.='empty';
    elseif ($content['ContentProduct']['stock'] == -1)
    {
        $stock.='retired';
        $stock_text = __('retired', true);
    }
    else
        $stock.='low';

    echo '<p class="left"><img src="/img/icons/stock/'.$stock.'.png" title="'.$stock_text.'" class="stock_image" /><br><br>';
        if ($content['ContentProduct']['stock']>-1)
        {
            echo '<b><span class="price calculated">'.$CurrencyBase->display_price($content['ContentProduct']['price']).'</span></b><br>';
            foreach ($content['ContentProductPrice'] as $price)
                echo '<span class="price calculated">'.$CurrencyBase->display_price($price['price']).'</span><br>';
        }
    echo '</p>';
    echo '<p class="right">';
        echo $stock_text.'<br><br>';
        if ($content['ContentProduct']['stock']>-1)
            echo $quantites;
    echo '</p>';
}

function smarty_help_function_product_prices () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product discount prices for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_prices}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_prices () {
	?>
	<p><?php echo __('Author: David Lednik &lt;david.lednik@gmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>