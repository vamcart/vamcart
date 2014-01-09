<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_country_list($params, &$smarty)
{
    global $content;

    App::import('Model', 'Country');
        $Country =& new Country();
    
    $options = $Country->find('list', array('conditions' => array('active' => '1'),'order' => array('Country.name'), 'fields'=>'id, name'));
    $List = '';

		if(!isset ($params['selected']))
			$params['selected'] = 176;

    foreach($options as $key=>$value)
    {
        $List .= "<option value=\"$key\"";
        if (isset($params['selected']))
        {
            if ($key == $params['selected'])
                $List .= 'selected ';
        }
        $List .= ">".__($value)."</option>";
    }
    
    echo $List;
}

function smarty_help_function_country_list () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Generates Country list.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{country_list}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_country_list () {
}
?>