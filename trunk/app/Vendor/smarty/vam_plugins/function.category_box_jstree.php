<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_category_box_jstree()
{
$template = '
<link href="{base_path}/js/jquery/plugins/jstree/themes/default/style.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{base_path}/js/jquery/plugins/jstree/jstree.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

$("#jstree").jstree().delegate("a","click", function(e) {
            if ($("#jstree").jstree("is_leaf", this)) {
                document.location.href = this;
            }
            else {
                $("#jstree").jstree("toggle_node", this);
            }
        });
    
});
</script>

{function name=menu parent_id=0}
	{if $data[$parent_id].childs|@sizeof > 0}
	<ul>
		{foreach $data[$parent_id].childs as $child_id}
			<li{if $data[$child_id].children} class="collapsible"{/if}><a href="{$data[$child_id].url}">{$data[$child_id].name}</a>
				{call name=menu parent_id=$child_id}</li>
		{/foreach}
	</ul>
	{/if}
{/function}

<section class="widget inner categories-widget">
	<h3 class="widget-title">{lang}Categories{/lang}</h3>
		<nav id="jstree">
			{call name=menu data=$tree}
		</nav>
</section>
';
		
return $template;
}


function smarty_function_category_box_jstree($params, $template)
{
	global $content, $config;

	// Cache the output.
	$cache_name = 'vam_category_box_jstree_output' . (isset($params['template'])?$params['template']:'') . '_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Content');
		$Content =& new Content();		
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
	$categories = $Content->find('threaded', array('conditions' => array('Content.active' => 1,'Content.show_in_menu' => 1,'Content.content_type_id' => 1),'order' => array('Content.order ASC')));

	$tree = array();
	foreach ($categories as $category) {
		_add_tree_node_jstree($tree, $category, 0);
	}

	$cats_tree_data = array();
	if ( $tree ) {
		foreach ($tree as $ar) {
	    $cats_tree_data[$ar['id']] = $ar;
	    $cats_tree_data[$ar['parent_id']]['childs'][] = $ar['id'];
	  }
	}

	$assignments = array(
		'tree' => $cats_tree_data
	);

	$display_template = $Smarty->load_template($params, 'category_box_jstree');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
}

function smarty_help_function_category_box_jstree() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a list of categories.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{category_box_jstree}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	<?php
}

function smarty_about_function_category_box_jstree() {
}

function _add_tree_node_jstree(&$tree, $node, $level)
{
	global $config;
	
	$tree[] = array('id' => $node['Content']['id'],
			'alias' => $node['Content']['alias'],
			'parent_id' => $node['Content']['parent_id'],
			'children' => $node['children'],
			'name' => $node['ContentDescription']['name'],
			'url' => BASE . '/' . $node['ContentType']['name'] . '/' . $node['Content']['alias'] . $config['URL_EXTENSION'],
			'level' => $level,
			'tree_prefix' => str_repeat('&nbsp;&nbsp;', $level));
			
	foreach ($node['children'] as $child) {
		_add_tree_node_jstree($tree, $child, $level + 1);
	}
}

?>