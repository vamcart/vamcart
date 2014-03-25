<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_content_images()
{
$template = '
<div class="span6 product-images">
{foreach from=$images item=image}
{if $image@first}
	<div class="thumbnail big text-center">
{/if}
{if $image@index > 0}
		<div class="span4 thumbnail">
{/if}
			<a href="{$image.image_path}" class="lightbox"><img itemprop="image" src="{$image.image_thumb}" alt="{$image.name}" title="{$image.name}"{if {$image.image_width} > 0} width="{$image.image_width}"{/if}{if {$image.image_height} > 0} height="{$image.image_height}"{/if} />
			<span class="frame-overlay"></span>
			<span class="zoom"><i class="fa fa-search-plus"></i></span>
			</a>
{if $image@index > 0}
		</div>
{/if}
{if $image@first}
	</div>
	<div class="row-fluid small">
{/if}
{if $image@last}
	</div>
{/if}
{foreachelse}   
	<div class="thumbnail big text-center">
			<img src="{$noimg_path}" alt="{lang}No Image{/lang}" title="{lang}No Image{/lang}" width="{$thumbnail_size}" height="{$thumbnail_size}" />
	</div>
{/foreach}    
</div>
';		

return $template;
}

function smarty_function_content_images($params, $template)
{

	global $content;
	global $config;

	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());
		
	App::import('Model', 'ContentImage');
		$ContentImage =& new ContentImage();
	
	if(!isset($params['number']))
		$params['number'] = null;		

	if(!isset ($params['content_id']))
		$params['content_id'] = $content['Content']['id'];
	
	$images = $ContentImage->find('all', array('limit' => $params['number'], 'conditions' => array('content_id' => $params['content_id'])));
	
	$keyed_images = array();
	foreach($images AS $key => $value)
	{
		$content_id = $params['content_id'];

			// Content Image

			if($value['ContentImage']['image'] != "") {
				$image_url = $content_id . '/' . $value['ContentImage']['image'];
				$thumb_name = substr_replace($value['ContentImage']['image'] , '', strrpos($value['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
				$thumb_path = IMAGES . 'content' . '/' . $content_id . '/' . $thumb_name;
				$thumb_url = BASE . '/img/content/' . $content_id . '/' . $thumb_name;

					if(file_exists($thumb_path) && is_file($thumb_path)) {
						list($width, $height, $type, $attr) = getimagesize($thumb_path);
						$keyed_images[$key]['image_path'] =  BASE . '/img/content/' . $content_id . '/' . $value['ContentImage']['image'];
						$keyed_images[$key]['image_thumb'] =  $thumb_url;
						$keyed_images[$key]['image_width'] = $width;
						$keyed_images[$key]['image_height'] = $height;
					} else {
						$keyed_images[$key]['image'] =  BASE . '/img/content/' . $content_id . '/' . $value['ContentImage']['image'];
						$keyed_images[$key]['image_thumb'] = BASE . '/images/thumb/' . $image_url;
						$keyed_images[$key]['image_width'] = null;
						$keyed_images[$key]['image_height'] = null;
					}

			} else { 

				$image_url = '0/noimage.png';
				$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
				$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
				$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;

					if(file_exists($thumb_path) && is_file($thumb_path)) {
						list($width, $height, $type, $attr) = getimagesize($thumb_path);
						$keyed_images[$key]['image_path'] =  BASE . '/img/noimage.png';
						$keyed_images[$key]['image_thumb'] =  $thumb_url;
						$keyed_images[$key]['image_width'] = $width;
						$keyed_images[$key]['image_height'] = $height;
					} else {
						$keyed_images[$key]['image'] =  BASE . '/img/noimage.png';
						$keyed_images[$key]['image_thumb'] = BASE . '/images/thumb/' . $image_url;
						$keyed_images[$key]['image_width'] = null;
						$keyed_images[$key]['image_height'] = null;
					}

			}
			
	}	
	
	$assignments = array('images' => $keyed_images,
						 'noimg_thumb' => BASE . '/images/thumb/0/noimage.png',
						 'noimg_path' => BASE . '/img/noimage.png',
						 'thumbnail_size' => $config['THUMBNAIL_SIZE']);

	$display_template = $Smarty->load_template($params,'content_images');
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_content_images() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays an unordered list of images for the current content page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{content_images}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(number)') ?></em> - <?php echo __('Number of images to display.') ?></li>
		<li><em><?php echo __('(content_id)') ?></em> - <?php echo __('Display images of selected content_id element.') ?></li>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_images() {
}
?>