<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_content_listing_search()
{
$template = '<div>
 {if $pages_number > 1 || $page=="all"}
    <div class="paginator">
          <ul>
            <li>{lang}Pages{/lang}:</li>
            {for $pg=1 to $pages_number}
            <li><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>
            {/for}
            <li><a href="{base_path}/page/search-result{$ext}?page=all&keyword={$keyword}" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
          </ul>
    </div>
  {/if}  
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
	<li class="no_items">{lang}No Items Found{/lang}</li>
{/foreach}
</ul>
<div class="clear"></div>
  {if $pages_number > 1 || $page=="all"}
    <div class="paginator">
          <ul>
            <li>{lang}Pages{/lang}:</li>
            {for $pg=1 to $pages_number}
            <li><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>
            {/for}
            <li><a href="{base_path}/page/search-result{$ext}?page=all&keyword={$keyword}" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
          </ul>
    </div>
  {/if}  
</div>
';		

return $template;
}

function smarty_function_content_listing_search($params, $template)
{
}


function smarty_help_function_content_listing_search() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a list of content items depending on the parent of those items.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{content_listing}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(type)') ?></em> - <?php echo __('Type of content to display. Seperate multiple values with commas, example:') ?> {content_listing type='category,page'}. <?php echo __('Defaults to') ?> 'all'.</li>
		<li><em><?php echo __('(parent)') ?></em> - <?php echo __('The parent of the content items to be shown. Accepts an alias or id, defaults to 0.') ?></li>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(page)') ?></em> - <?php echo __('Current page.') ?></li>
		<li><em><?php echo __('(on_page)') ?></em> - <?php echo __('Items per page.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_listing_search() {
}
?>