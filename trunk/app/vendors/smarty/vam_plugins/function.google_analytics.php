<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function smarty_function_google_analytics($params, $template)
{
	App::import('Component', 'OrderBase');
		$OrderBase =& new OrderBaseComponent();		
	
	App::import('Component', 'CurrencyBase');
		$CurrencyBase =& new CurrencyBaseComponent();		
		
	global $order;		
	global $config;

	switch ($params['checkout_success']) {
		case 'true' :
		$result = 'test true';
		break;		
		default :
		$result = 'test false';
	}

	return $result;
}

function smarty_help_function_google_analytics() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the google analytics code.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{google_analytics}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(checkout_success)') ?></em> - <?php echo __('(true or false) If set to true display the display google analytics ecommerce tracking code in checkout success page.') ?></li>		
	</ul>
	<?php
}

function smarty_about_function_google_analytics() {
	?>
	<p><?php echo __('Author: Alexandr Menovchicov &lt;vam@kypi.ru&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>