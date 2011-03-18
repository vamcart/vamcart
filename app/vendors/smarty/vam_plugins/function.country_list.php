<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   Copyright 2011 David Lednik
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2011 by David Lednik (david.lednik@gmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function smarty_function_country_list($params, &$smarty)
{
    global $content;

    App::import('Model', 'Country');
        $Country =& new Country();
    
    $options = $Country->find('list', array('fields'=>'iso_code_2, name'));
    $List = '';

    foreach($options as $key=>$value)
    {
        $List .= "<option value=\"$key\"";
        if (isset($params['selected']))
        {
            if ($key == $params['selected'])
                $List .= 'selected ';
        }
        $List .= ">$value</option>";
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
	?>
	<p><?php echo __('Author: David Lednik &lt;david.lednik@gmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>