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

function default_template_content_listing()
{
$template = '<div>
<ul class="listing">
{foreach from=$content_list item=node}
	<li
	{if $node.alias == $content_alias}
		class="active"
	{/if}
	>
	<div><a href="{$node.url}"><img src="{$node.image}" alt="{$node.name}" 
	{if isset($thumbnail_width)}
	 width="{$thumbnail_width}"
	{/if}
	/></a></div>
	<div><a href="{$node.url}">{$node.name}</a></div></li>
{foreachelse}
	<li class="no_items">{lang}no-sub-items{/lang}</li>
{/foreach}
</ul>
<div class="clearb"></div>
</div>
';		

return $template;
}

function smarty_function_content_listing($params, &$smarty)
{
	global $content;
	
	// Cache the output.
	$cache_name = 'sms_content_listing_output_' . $content['Content']['id'] .  (isset($params['template'])?'_'.$params['template']:'') .  (isset($params['parent'])?'_'.$params['parent']:'') . '_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name);
	if($output === false)
	{
		ob_start();
		
	global $config;
		
	// Load some necessary components & models
	loadComponent('Smarty');
		$Smarty =& new SmartyComponent();
	loadComponent('Session');
		$Session =& new SessionComponent();		

	loadModel('Content');
		$Content =& new Content();		
		$Content->unbindAll();	
		$Content->bindModel(array('hasOne' => array(
				'ContentDescription' => array(
                    'className' => 'ContentDescription',
					'conditions'   => 'language_id = '.$Session->read('Customer.language_id')
                ))));
		$Content->bindModel(array('belongsTo' => array(
				'ContentType' => array(
                    'className' => 'ContentType'
					))));			
		$Content->bindModel(array('hasOne' => array(
				'ContentImage' => array(
                    'className' => 'ContentImage'
					))));						
		$Content->bindModel(array('hasOne' => array(
				'ContentLink' => array(
                    'className' => 'ContentLink'
					))));		
	// Make sure parent is valid, if it's not a number get the correct parent number
	if(!isset($params['parent']))
		$params['parent'] = 0;
	if(!is_numeric($params['parent']))
	{
		$get_content = $Content->findByAlias($params['parent']);
		$params['parent'] = $get_content['Content']['id'];
	}
	
	// Loop through the values in $params['type'] and set some more condiitons
	$allowed_types = array();
	if((!isset($params['type'])) || ($params['type'] == 'all'))
	{
		// Set the default conditions if all or nothing was passed
		$allowed_types[] = 'category';
		$allowed_types[] = 'product';
		$allowed_types[] = 'page';
		$allowed_types[] = 'link';
		$allowed_types[] = 'selflink';
	}
	else
	{
		$types = explode(',',$params['type']);
		
		foreach($types AS $type)
			$allowed_types[] =  $type;
	}
	
	$content_list_data_conditions = array('Content.parent_id' => $params['parent'],'Content.show_in_menu' => '1');
	$Content->recursive = 2;
	$content_list_data = $Content->findAll($content_list_data_conditions,null,'Content.order ASC');
	

	// Loop through the content list and create a new array with only what the template needs
	$content_list = array();
	$count = 0;

	foreach($content_list_data AS $raw_data)
	{
		if(in_array(strtolower($raw_data['ContentType']['name']),$allowed_types))
		{
			$content_list[$count]['name']	= $raw_data['ContentDescription']['name'];
			$content_list[$count]['alias']	= $raw_data['Content']['alias'];	
	
			if($raw_data['ContentImage']['image'] != "")
				$image_url = 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			else 
				$image_url = 'noimage.jpg';
				
			if($config['GD_LIBRARY'] == 0)
				$content_list[$count]['image'] =  BASE . '/img/' . $image_url;
			else
				$content_list[$count]['image'] = BASE . '/images/thumb?src=/' . $image_url . '&w=' . $config['THUMBNAIL_SIZE'];
			
			if($raw_data['ContentType']['name'] == 'Link')
			{
				$content_list[$count]['url'] = $raw_data['ContentLink']['url'];
			}
			else
			{
				$content_list[$count]['url']	= BASE . '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
			}
			$count ++;
		}
	}
	$vars = $smarty->_tpl_vars;
	$vars['content_list'] = $content_list;
	$vars['count'] = $count;

	if($config['GD_LIBRARY'] == 0)
		$vars['thumbnail_width'] = $config['THUMBNAIL_SIZE'];

	$display_template = $Smarty->load_template($params,'content_listing');	
	$Smarty->display($display_template,$vars);
	
		
		// Write the output to cache and echo them
		$output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $output);		
	}
	echo $output;
}

function smarty_help_function_content_listing() {
	?>
	<h3>What does this do?</h3>
	<p>Displays a list of content items depending on the parent of those items.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template like: <code>{content_listing}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(type)</em> - Type of content to display in the menu.  Can be any of: category, product, page, link, selflink, or all.  Seperate multiple values with commas, example: {content_listing type='category,page'}.  Defaults to 'all'.</li>
		<li><em>(parent)</em> - The parent of the content items to be shown.  Accepts an alias or id, defaults to 0.</li>
		<li><em>(template)</em> - Useful if you want to override the default content listing template.  Setting this will utilize the template that matches this alias.</li>
	</ul>
	<?php
}

function smarty_about_function_content_listing() {
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
