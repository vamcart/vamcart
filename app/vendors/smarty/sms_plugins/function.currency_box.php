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

function default_template_currency_box()
{
$template = '
<div class="info_box">
	<div class="box_heading">{lang}currency{/lang}</div>
	<div class="box_content">
		<form action="{$currency_form_action}" method="post">
		<select name="currency_picker">
	 	{foreach from=$currencies item=currency}
	<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>
		{/foreach}
		</select>
		<input type="submit" value="Go" />
		</form>
	</div>
</div>
';		

return $template;
}

function smarty_function_currency_box($params, &$smarty)
{
		// Cache the output.
   		$cache_name = 'sms_currency_output' . (isset($params['template'])?'_'.$params['template']:'');
    	$currency_output = Cache::read($cache_name);
   		if($currency_output === false)
    	{
    		ob_start();
			
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();

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
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template for the currency_box plugin.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_currency_box() {
	?>
	<p><?php echo __('Author: Kevin Grandon &lt;kevingrandon@hotmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>