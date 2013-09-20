<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_value_filter($params)
{
    
    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty =& new SmartyComponent(new ComponentCollection());

    $assignments = array('id_attribute' => $params['id_attribute']
                        ,'name_attribute' => $params['name_attribute']
                        ,'values_attribute' => $params['values_attribute']);
    if(isset($params['is_active']))$assignments['is_active'] = $params['is_active'];
    if(isset($params['alias_micro_template']))
    {
        $params['template'] = $params['alias_micro_template'];
        $display_template = $Smarty->load_template($params, 'value_filter');
    }
    else $display_template = $params['template'];
    $Smarty->display($display_template, $assignments);

}

function smarty_help_function_value_filter() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays a filter value.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{value_filter}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
    <?php
}

function smarty_about_function_value_filter() 
{
}
?>
