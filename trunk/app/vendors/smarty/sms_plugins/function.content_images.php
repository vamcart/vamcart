<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

function default_template_content_images()
{
$template = '
<ul class="content_images">
	{foreach from=$images item=image}		
		<li>
			{if $thumbnail == "true"}
				<a href="{$image.image_path}" target="blank"><img src="{$image.image_thumb}" alt="{$image.image}" /></a>	
				<div><a href="{$image.image_path}" target="blank">Click to Enlarge</a></div>
			{else}
				<img src="{$image.image_path}" width="{$thumbnail_size}" alt="{$image.image}" />			
			{/if}
		</li>			
	{foreachelse}	
		{if $thumbnail == "true"}
			<li><img src="{$noimg_thumb}" alt="No Image" /></li>
		{else}
			<li><img src="{$noimg_path}" width="{$thumbnail_size}" alt="No Image" /></li>
		{/if}		
	{/foreach}				
</ul>
';		

return $template;
}

function smarty_function_content_images($params, &$smarty)
{

	global $content;
	global $config;
	
	loadComponent('Smarty');
		$Smarty =& new SmartyComponent();
		
	loadModel('ContentImage');
		$ContentImage =& new ContentImage();
	
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
	
	$images = $ContentImage->findAll(array('content_id' => $content['Content']['id']));
	
	$keyed_images = array();
	foreach($images AS $image)
	{
		$content_id = $content['Content']['id'];
		$keyed_images[$content_id] = array('id' => $image['ContentImage']['id'],
										  'image' => $image['ContentImage']['image']
										  );
		$keyed_images[$content_id]['image_path'] = BASE . '/img/content/' . $content_id . '/' . $image['ContentImage']['image'];
		$keyed_images[$content_id]['image_thumb'] = BASE . '/images/thumb?src=/content/' . $content_id . '/' . $image['ContentImage']['image'] . '&w=' . $params['width'];
	}	
	
	$assignments = array('images' => $keyed_images,
						 'thumbnail' => $params['thumbnail'],
						 'noimg_thumb' => BASE . '/images/thumb?src=/noimage.jpg&w=' . $params['width'],
						 'noimg_path' => BASE . '/img/noimage.jpg',
						 'thumbnail_size' => $config['THUMBNAIL_SIZE']);

	$display_template = $Smarty->load_template($params,'content_images');
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_content_images() {
	?>
	<h3>What does this do?</h3>
	<p>Displays an unordered list of images for the current content page.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template/page like: <code>{content_images}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(number)</em> - Number of images to display</li>
		<li><em>(height)</em> - Maximum height of thumbnails/</li>
		<li><em>(width)</em> - Maximum width of thumbnails.</li>
		<li><em>(thumbnail)</em> - Set to false to disable thumbnailing of images. Defaults to true.</li>		
	</ul>
	<?php
}

function smarty_about_function_content_images() {
	?>
	<p>Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>
	<p>Version: 0.1</p>
	<p>
	Change History:<br/>
	None
	</p>
	<?php
}
?>
