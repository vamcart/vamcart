<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_discount_group()
{
    $template = '    
		{if $discount != 0}
		<div class="inner">
			<b>{lang}Discount{/lang} - {$discount}%</b>
		</div>
		{/if}
    ';
    return $template;
}


function smarty_function_discount_group($params)
{    
    $discount = 0;    
    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty =& new SmartyComponent(new ComponentCollection());
    
    if(isset($_SESSION['Customer']['customer_id']))
    {
        App::import('Model', 'Customer');
        $Customer = new Customer();
        $discount_group = $Customer->find('first',array('conditions' => array('Customer.id' => $_SESSION['Customer']['customer_id'])));
        if(isset($discount_group['GroupsCustomer']['price'])) $discount = $discount_group['GroupsCustomer']['price'];
    }
    
    $assignments = array();
    $assignments = array('discount' => $discount);
    $display_template = $Smarty->load_template($params, 'discount_group');
    $Smarty->display($display_template, $assignments);
}

function smarty_help_function_discount_group()
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays discount for group.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{discount_group}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
            <li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>	
    </ul>
    <?php
}

function smarty_about_function_discount_group() 
{
}
?>
