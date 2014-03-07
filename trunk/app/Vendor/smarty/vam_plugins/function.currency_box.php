<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_currency_box()
{
$template = '
<section class="widget inner">
	<h3 class="widget-title">{lang}Currency{/lang}</h3>
		<form action="{base_path}/currencies/pick_currency/" method="post">
			<div class="control-group">
				<div class="controls">
					<label class="select">				
					<select name="currency_picker">
						{foreach from=$currencies item=currency}
							<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>
						{/foreach}
					</select>
					</label>
					<button type="submit" class="btn btn-inverse"><i class="icon-ok"></i> {lang}Go{/lang}</button>
				</div>
			</div>
		</form>
</section>
';		

return $template;
}

function smarty_function_currency_box($params, $template)
{
		// Cache the output.
   		$cache_name = 'vam_currency_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $_SESSION['Customer']['language_id'] . '_' . $_SESSION['Customer']['currency_id'];
    	$currency_output = Cache::read($cache_name, 'catalog');
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
		Cache::write($cache_name, $currency_output, 'catalog');		
	}
	echo $currency_output;


}

function smarty_help_function_currency_box() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Allows the user to select a currency.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{currency_box}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_currency_box() {
}
?>