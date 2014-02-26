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
			{if $thumbnail == "true"}
			<a href="{$image.image_path}" class="lightbox"><img itemprop="image" src="{$image.image_thumb}" alt="{$image.name}" title="{$image.name}" />
			{else}
			<img src="{$image.image_path}" width="{$thumbnail_size}" alt="{$image.name}" title="{$image.name}" />
			{/if}
			<span class="frame-overlay"></span>
			<span class="zoom"><i class="icon-zoom-in"></i></span>
			{if $thumbnail == "true"}
			</a>
			{/if}
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
			{if $thumbnail == "true"}
			<img src="{$noimg_thumb}" alt="{lang}No Image{/lang}" title="{lang}No Image{/lang}" />
			{else}
			<img src="{$noimg_path}" width="{$thumbnail_size}" alt="{lang}No Image{/lang}" title="{lang}No Image{/lang}" />
			{/if}           
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
	
	if(!isset($params['width']))
		$params['width'] = $config['THUMBNAIL_SIZE'];
	
	if(!isset($params['height']))
		$params['height'] = 100;		
	
	if(!isset($params['thumbnail']))
		$params['thumbnail'] = true;
	elseif($params['thumbnail'] == 'false')
		$params['thumbnail'] = 'false';
	
	if($config['GD_LIBRARY'] == '0')
		$params['thumbnail'] = 'false';
	
	$images = $ContentImage->find('all', array('limit' => $params['number'], 'conditions' => array('content_id' => $content['Content']['id'])));
	
	$keyed_images = array();
	foreach($images AS $key => $value)
	{
		$content_id = $content['Content']['id'];
		$keyed_images[$key] = $value['ContentImage'];
		$keyed_images[$key]['name'] = $content['ContentDescription']['name'];
		$keyed_images[$key]['image_path'] = BASE . '/img/content/' . $content_id . '/' . $value['ContentImage']['image'];
		$keyed_images[$key]['image_thumb'] = BASE . '/images/thumb/' . $content_id . '/' . $value['ContentImage']['image'];
	}	
	
	$assignments = array('images' => $keyed_images,
						 'thumbnail' => $params['thumbnail'],
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
		<li><em><?php echo __('(height)') ?></em> - <?php echo __('Maximum height of thumbnails.') ?></li>
		<li><em><?php echo __('(width)') ?></em> - <?php echo __('Maximum width of thumbnails.') ?></li>
		<li><em><?php echo __('(thumbnail)') ?></em> - <?php echo __('Set to false to disable thumbnailing of images. Defaults to true.') ?></li>		
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_images() {
}
?>