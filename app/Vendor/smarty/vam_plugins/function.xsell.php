<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_xsell()
{
    $template = '
<h2>{lang}Also purchased{/lang}</h2>
<div class="row shop-products">
  <ul class="thumbnails">
  {foreach from=$relations item=node}
    <li class="item col-sm-6 col-md-4">
      <div class="thumbnail text-center">
        {if $node.discount > 0}<div class="description"><span class="discount">-{$node.discount|round}%</span></div>{/if}
        <a href="{$node.url}" class="image"><img src="{$node.image.image}" alt="{$node.name}"{if {$node.image.image_width} > 0} width="{$node.image.image_width}"{/if}{if {$node.image.image_height} > 0} height="{$node.image.image_height}"{/if} />
        {if $node.price}<span class="frame-overlay"></span><span class="price">{$node.price}</span>{/if}
        {product_label label_id={$node.label_id}}
        </a>
        <div class="inner notop nobottom text-left">
          <h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>
          {if $node.reviews > 0}<div class="description"><span class="rating">{$node.star_rating}</span> <span class="reviews">{lang}Feedback{/lang}: {$node.reviews}</span></div>{/if}
          {if $node.old_price}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{$node.old_price}</del></span></div>{/if}
          {if $node.price_save}<div class="description">{lang}You Save{/lang}: <span class="save">{$node.price_save} ({$node.price_save_percent|round}%)</span></div>{/if}
          <div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>
          <div class="description">{attribute_list product_id=$node.id}</div>
        </div>
      </div>
      {product_form product_id={$node.id}}
      <div class="inner darken notop">
        <button class="btn btn-default btn-add-to-cart" type="submit" value="{lang}Buy{/lang}"><i class="fa fa-shopping-cart"></i> {lang}Buy{/lang}</button>
      </div>
      {/product_form}
    </li>
  {/foreach}
  </ul>
</div>
';
    return $template;
}

function smarty_function_xsell($params, &$smarty)
{
	global $content;
	global $config;

	if (!isset($content['ContentRelations']) || sizeof($content['ContentRelations']) < 1) {
		return;
	}

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CakeTime', 'Utility');

	App::import('Model', 'ContentImage');
	$ContentImage = new ContentImage();

	App::import('Model', 'Content');
	$Content = new Content();

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

	App::uses('ContentBaseComponent', 'Controller/Component');
	$ContentBase = new ContentBaseComponent(new ComponentCollection());

	$language_id = $content['ContentDescription']['language_id'];

	foreach ($content['ContentRelations'] as $key => $related) {
		$image = $ContentImage->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'])));

		// Content Image
		
		if($image['ContentImage']['image'] != "") {
			$image_url = $content['ContentRelations'][$key]['id'] . '/' . $image['ContentImage']['image'];
			$image_path = BASE . '/img/content/' . $content['ContentRelations'][$key]['id'] . '/' . $image['ContentImage']['image'];
			$thumb_name = substr_replace($image['ContentImage']['image'] , '', strrpos($image['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
			$thumb_path = IMAGES . 'content' . '/' . $content['ContentRelations'][$key]['id'] . '/' . $thumb_name;
			$thumb_url = BASE . '/img/content/' . $content['ContentRelations'][$key]['id'] . '/' . $thumb_name;

				if(file_exists($thumb_path) && is_file($thumb_path)) {
					list($width, $height, $type, $attr) = getimagesize($thumb_path);
					$content['ContentRelations'][$key]['image']['image'] =  $thumb_url;
					$content['ContentRelations'][$key]['image']['image_original'] =  $image_path;
					$content['ContentRelations'][$key]['image']['image_width'] = $width;
					$content['ContentRelations'][$key]['image']['image_height'] = $height;
				} else {
					$content['ContentRelations'][$key]['image']['image'] = BASE . '/images/thumb/' . $image_url;
					$content['ContentRelations'][$key]['image']['image_original'] =  $image_path;
					$content['ContentRelations'][$key]['image']['image_width'] = null;
					$content['ContentRelations'][$key]['image']['image_height'] = null;
				}

		} else { 

			$image_url = '0/noimage.png';
			$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
			$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
			$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;

				if(file_exists($thumb_path) && is_file($thumb_path)) {
					list($width, $height, $type, $attr) = getimagesize($thumb_path);
					$content['ContentRelations'][$key]['image']['image'] =  $thumb_url;
					$content['ContentRelations'][$key]['image']['image_width'] = $width;
					$content['ContentRelations'][$key]['image']['image_height'] = $height;
				} else {
					$content['ContentRelations'][$key]['image']['image'] = BASE . '/images/thumb/' . $image_url;
					$content['ContentRelations'][$key]['image']['image_width'] = null;
					$content['ContentRelations'][$key]['image']['image_height'] = null;
				}

		}

		$Content->unbindAll();	
		$Content->bindModel(array('hasOne' => array(
				'ContentDescription' => array(
                    'className' => 'ContentDescription',
					'conditions'   => 'language_id = '.$_SESSION['Customer']['language_id']
                ))));
		$Content->bindModel(array('belongsTo' => array(
				'ContentType' => array(
                    'className' => 'ContentType'
					))));			
		$Content->bindModel(array('hasOne' => array(
				'ContentImage' => array(
                    'className' => 'ContentImage',
                    'conditions'=>array('ContentImage.order' => '1')
					))));						
		$Content->bindModel(array('hasOne' => array(
				'ContentLink' => array(
                    'className' => 'ContentLink'
					))));		
		$Content->bindModel(array('hasOne' => array(
				'ContentProduct' => array(
                    'className' => 'ContentProduct'
					))));
		$Content->bindModel(array('hasOne' => array(
				'ContentDownloadable' => array(
                    'className' => 'ContentDownloadable'
					))));

		$Content->bindModel(array('hasOne' => array(
				'ContentSpecial' => array(
                    'className' => 'ContentSpecial'
					))));
											
		$product = $Content->find('first', array('recursive' => 1, 'conditions' => array('Content.id' => $content['ContentRelations'][$key]['id'])));
			$content_type = 'ContentProduct';
			$price = $product['ContentProduct']['price'];
	
			if ($content['ContentRelations'][$key]['content_type_id'] == 7) {
				$content_type = 'ContentDownloadable';
				$price = $product['ContentProduct']['price'];
			}
			$content['ContentRelations'][$key]['id']	= $content['ContentRelations'][$key]['id'];
			$content['ContentRelations'][$key]['alias']	= $content['ContentRelations'][$key]['alias'];
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['price']	= ($price > 0) ? $CurrencyBase->display_price($price) : false;	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['old_price']	= (($product[$content_type]['old_price'] > $price) ? $CurrencyBase->display_price($product[$content_type]['old_price']) : false);	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['price_save']	= (($product[$content_type]['old_price']-$price > 0) ? $CurrencyBase->display_price($product[$content_type]['old_price']-$price) : false);	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['price_save_percent']	= (($product[$content_type]['old_price'] > $price) ? 100-($price*100/$product[$content_type]['old_price']) : false);	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['discount']	= (($product[$content_type]['old_price'] > $price) ? 100-($price*100/$product[$content_type]['old_price']) : 0);	
			$content['ContentRelations'][$key]['rating']	= $ContentBase->getReviewsInfo($content['ContentRelations'][$key]['id'], 'average_rating');	
			$content['ContentRelations'][$key]['star_rating']	= $ContentBase->getReviewsInfo($content['ContentRelations'][$key]['id'], 'star_rating');	
			$content['ContentRelations'][$key]['reviews']	= $ContentBase->getReviewsInfo($content['ContentRelations'][$key]['id'], 'reviews_total');	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['stock']	= $product[$content_type]['stock'];	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['model']	= $product[$content_type]['model'];	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2) $content['ContentRelations'][$key]['weight']	= $product[$content_type]['weight'];	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['manufacturer']	= $ContentBase->getManufacturerName($product[$content_type]['manufacturer_id']);	
			if ($content['ContentRelations'][$key]['content_type_id'] == 2 or $content['ContentRelations'][$key]['content_type_id'] == 7) $content['ContentRelations'][$key]['label_id']	= $product[$content_type]['label_id'];	
			$content['ContentRelations'][$key]['date_added']	= CakeTime::i18nFormat($content['ContentRelations'][$key]['created']);	
			$content['ContentRelations'][$key]['date_modified']	= CakeTime::i18nFormat($content['ContentRelations'][$key]['modified']);	

			$content['ContentRelations'][$key]['url'] = BASE . '/' . $product['ContentType']['name'] . '/' . $content['ContentRelations'][$key]['alias'] . $config['URL_EXTENSION'];
	
			$product = $Content->ContentDescription->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'], 
										       'ContentDescription.language_id' => $language_id)));
			$content['ContentRelations'][$key]['name'] = $product['ContentDescription']['name'];
			$content['ContentRelations'][$key]['description'] = $product['ContentDescription']['description'];
			$content['ContentRelations'][$key]['short_description'] = $product['ContentDescription']['short_description'];
			$content['ContentRelations'][$key]['meta_title'] = $product['ContentDescription']['meta_title'];
			$content['ContentRelations'][$key]['meta_description'] = $product['ContentDescription']['meta_description'];
			$content['ContentRelations'][$key]['meta_keywords'] = $product['ContentDescription']['meta_keywords'];

	}

	$assignments = array('relations' => $content['ContentRelations']);

	$display_template = $Smarty->load_template($params, 'xsell');
	$Smarty->display($display_template, $assignments);
}

function smarty_help_function_xsell () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays also purchased products for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{xsell}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_xsell () {
}
?>