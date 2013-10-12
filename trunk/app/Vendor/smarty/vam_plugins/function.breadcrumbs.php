<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_breadcrumbs()
{
$template = '
<section class="widget inner">
	<h3 class="widget-title">{lang}Currency{/lang}</h3>
	<form action="{base_path}/currencies/pick_currency/" method="post">
		<select name="currency_picker">
			{foreach from=$currencies item=currency}
				<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>
			{/foreach}
		</select>
	<button type="submit" class="btn btn-inverse">{lang}Go{/lang}</button>
	</form>
</section>
';		

return $template;
}

function smarty_function_breadcrumbs($params, $template)
{
	
	global $content;
	
	$content_id = $content['Content']['id'];	
	
		// Cache the output.
   		$cache_name = 'vam_currency_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'] . '_' . $_SESSION['Customer']['currency_id'];
    	$currency_output = Cache::read($cache_name);
   		if($currency_output === false)
    	{
    		ob_start();
			
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Currency');
		$Currency =& new Currency();
	
	$currencies = $Currency->find('all', array('conditions' => array('active' => '1')));
	
	if(count($currencies) == 1)
		return;
	
	$keyed_currencies = array();
	foreach($currencies AS $currency)
	{
		$keyed_currencies[] = $currency['Currency'];
	}

	$vars = array('currencies' => $keyed_currencies,
				  'currency_form_action' => BASE .'/currencies/pick_currency/');
	
	$display_template = $Smarty->load_template($params,'currency_box');	
	$Smarty->display($display_template,$vars);
		 
		// Write the output to cache and echo them
		$currency_output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $currency_output);		
	}
	echo var_dump(admin_categories_tree($content_id)).'test'.$currency_output;


}

function smarty_help_function_breadcrumbs() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the current breadcrumbs.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{currency_box}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_breadcrumbs() {
}


function admin_categories_tree($content_id)
	{
		
	App::import('Model', 'Content');
		$Content =& new Content();		
	
		$Content->unbindModel(array('hasMany' => array('ContentDescription')));

		$Content->bindModel(array('hasOne' => array(
								'ContentDescription' => array(
									'className' => 'ContentDescription',
									'conditions' => 'language_id = ' . $_SESSION['Customer']['language_id']
									)
								)
						)
		);
		
		$categories = $Content->find('threaded', array());
		$tree = array();
		foreach ($categories as $category) {
			_add_tree_node($tree, $category, 0);
		}
		return $tree;
	}

function _add_tree_node(&$tree, $node, $level)
	{
		$tree[] = array('id' => $node['Content']['id'],
				'name' => $node['ContentDescription']['name'],
				'level' => $level,
				'tree_prefix' => str_repeat('&nbsp;&nbsp;', $level));
				
		foreach ($node['children'] as $child) {
			_add_tree_node($tree, $child, $level + 1);
		}
	}
	
?>