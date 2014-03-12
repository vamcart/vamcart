<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_shopping_cart()
{
$template = '
{if $order_items}
<div class="cart">
<form name="cart_qty" action="{base_path}/cart/update_cart_qty" method="post">
	<table class="contentTable">
		<tr>
			<th></th>
			<th>{lang}Product{/lang}</th>
			<th>{lang}Price Ea.{/lang}</th>
			<th>{lang}Qty{/lang}</th>
			<th>{lang}Total{/lang}</th>
		</tr>

{foreach from=$order_items item=product}
		<tr>
			<td align="center"><img class="media-object" src="{$product.image.image_thumb}" alt="" title=""{if {$product.image.image_width} > 0} width="{$product.image.image_width}"{/if}{if {$product.image.image_height} > 0} height="{$product.image.image_height}"{/if} /></td>
			<td><a href="{$product.link}">{$product.name}</a> <a href="{base_path}/cart/remove_product/{$product.id}/1" class="remove" title="{lang}Remove{/lang}"><i class="fa fa-trash-o"></i></a></td>
			<td>{$product.price}</td>
			<td><input type="text" name="qty[{$product.id}]" class="input-small" value="{$product.qty}" size="3" /></td>
			<td>{$product.line_total}</td>
		</tr>
{foreachelse}
		<tr>
			<td colspan="5">{lang}No Cart Items{/lang}</td>
		</tr>
{/foreach}

		<tr class="cart_total">
			<td colspan="3" width="100%">&nbsp;</td>
			<td class="total-name">{lang}Shipping{/lang}:</td>
			<td class="total-value"><nobr>{$shipping_total}</nobr></td>
		</tr>
		<tr class="cart_total">
			<td colspan="3">&nbsp;</td>
			<td class="total-name"><strong>{lang}Total{/lang}:</strong></td>
			<td class="total-value"><nobr>{$order_total}</nobr></td>
		</tr>
	</table>
	<a class="btn btn-inverse" href="{$checkout_link}"><i class="fa fa-shopping-cart"></i> {lang}Checkout{/lang}</a>
		<button class="btn btn-inverse" type="submit" name="updatebutton"><i class="fa fa-check"></i> {lang}Update{/lang}</button>
</form>
</div>
{else}
	{lang}No Cart Items{/lang}
{/if}
';

return $template;
}


function smarty_function_shopping_cart($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	App::uses('OrderBaseComponent', 'Controller/Component');
	$OrderBase =& new OrderBaseComponent(new ComponentCollection());

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());

	App::uses('ContentBaseComponent', 'Controller/Component');
	$ContentBase =& new ContentBaseComponent(new ComponentCollection());

	global $order;
	global $config;
	global $content;


	$order_items = array();
	if (!isset($order['OrderProduct'])) {
		// Quit if we passed the param and the cart is empty
		if ((!isset($params['showempty']))||($params['showempty'] == false)) {
			//echo '<div id="shopping-cart-box"></div>';
			return;
		}

		$order['Order']['total'] = 0;
		$order['OrderProduct'] = array();
	}

	foreach($order['OrderProduct'] AS $cart_item)
	{
		$content_id = $cart_item['content_id'];
		$total_quantity += $cart_item['quantity'];
		$total_weight += $cart_item['weight']*$cart_item['quantity'];
		$image = array();
		$content_image = $ContentBase->get_content_image($cart_item['content_id']);

		// Content Image
		
		if($content_image != "") {
			$image_url = $content_id . '/' . $content_image . '/40';
			$thumb_name = substr_replace($content_image , '', strrpos($content_image , '.')).'-40.png';	
			$thumb_path = IMAGES . 'content' . '/' . $content_id . '/' . $thumb_name;
			$thumb_url = BASE . '/img/content/' . $content_id . '/' . $thumb_name;

				if(file_exists($thumb_path) && is_file($thumb_path)) {
					list($width, $height, $type, $attr) = getimagesize($thumb_path);
					$image['image'] = true;
					$image['image_thumb'] =  $thumb_url;
					$image['image_width'] = $width;
					$image['image_height'] = $height;
				} else {
					$image['image'] = true;
					$image['image_thumb'] = BASE . '/images/thumb/' . $image_url;
					$image['image_width'] = null;
					$image['image_height'] = null;
				}

		} else { 

			$image_url = '0/noimage.png/40';
			$thumb_name = 'noimage-40.png';	
			$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
			$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;

				if(file_exists($thumb_path) && is_file($thumb_path)) {
					list($width, $height, $type, $attr) = getimagesize($thumb_path);
					$image['image'] = true;
					$image['image_thumb'] =  $thumb_url;
					$image['image_width'] = $width;
					$image['image_height'] = $height;
				} else {
					$image['image'] = true;
					$image['image_thumb'] = BASE . '/images/thumb/' . $image_url;
					$image['image_width'] = null;
					$image['image_height'] = null;
				}

		}
		
		$order_items[$content_id] = array(
			'id' => $cart_item['content_id'],
			'link' => BASE . '/product/' . $content_id . $config['URL_EXTENSION'],
			'name' => $cart_item['name'],
			'image' => $image,
			'price' => $CurrencyBase->display_price($cart_item['price']),
			'qty' => $cart_item['quantity'],
			'url' => BASE . '/product/' . $cart_item['content_id'] . $config['URL_EXTENSION'],
			'line_total' => $CurrencyBase->display_price($cart_item['quantity']*$cart_item['price'])
		);
	}

	$assignments = array(
		'checkout_link' => BASE . '/page/checkout' . $config['URL_EXTENSION'],
		'order_total' => $CurrencyBase->display_price($order['Order']['total']),
		'total_quantity' => $total_quantity,
		'total_weight' => $total_weight,
		'shipping_total' => $CurrencyBase->display_price($order['Order']['shipping']),
		'order_items' => $order_items,
		'page_alias' => $content['Content']['alias'],
		'cart_link' => BASE . '/page/cart-contents' . $config['URL_EXTENSION']
	);

	$display_template = $Smarty->load_template($params, 'shopping_cart');
	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_shopping_cart() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a more detailed version of the user\'s cart.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{shopping_cart}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
		<li><em><?php echo __('(showempty)') ?></em> - <?php echo __('(true or false) If set to false does not display the cart if the user has not added any items.  Defaults to false.') ?></li>		
	</ul>
	<?php
}

function smarty_about_function_shopping_cart() {
}
?>