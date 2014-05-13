<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_state_list($params, &$smarty)
{
        global $content;

			if(!isset ($params['country']))
				$params['country'] = 176;

			if(!isset ($params['selected']))
				$params['selected'] = 99;

        App::import('Model', 'CountryZone');
        $CountryZone =& new CountryZone();
        $options = $CountryZone->find('all', array('fields' => array('id', 'name'),
                                                   'conditions' => array('country_id' => $params['country'])
                                                  ));
        $List = '';

        foreach($options as $option) {
                $List .= "<option value=\"" . $option['CountryZone']['id'] . "\"";
                if (isset($params['selected'])) {
                        if ($option['CountryZone']['id'] == $params['selected']) {
                                $List .= ' selected';
                        }
                }
                $List .= ">" . $option['CountryZone']['name'] . "</option>";
        }

        echo $List;
}

function smarty_help_function_state_list () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Generates States list.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{state_list}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_state_list () {
}
?>