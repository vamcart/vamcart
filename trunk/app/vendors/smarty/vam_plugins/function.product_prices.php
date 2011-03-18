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

    echo '<p class="left"><a rel="lightbox|450|320" href="/static/bubbles/" class="bubble bubble-in" title="'.$content['ContentProduct']['stock'].' '.__('available', true).'"><span>available</span></a><br><br>';
        //foreach echo price
        echo '<b><span class="price calculated">'.$CurrencyBase->display_price($content['ContentProduct']['price']).'</span></b><br>';
        foreach ($content['ContentProductPrice'] as $price)
            echo '<span class="price calculated">'.$CurrencyBase->display_price($price['price']).'</span><br>';
    echo '</p>';
    echo '<p class="right">';
        echo $content['ContentProduct']['stock'].' '.__('in stock', true).'<br><br>';
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