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

			if(!isset ($params['country'])) {
			App::import('Model', 'Country');
			$country = new Country();
			$default_country = $country->find('first', array('conditions' => array('Country.default' => 1),'limit' => 1));			
			$params['country'] = $default_country['Country']['id'];
			}

			if(!isset($params['selected']) or !is_numeric($params['selected'])) {
			App::import('Model', 'CountryZone');
			$zone = new CountryZone();
			$default_state = $zone->find('first', array('conditions' => array('CountryZone.default' => 1),'limit' => 1));			
			$params['selected'] = $default_state['CountryZone']['id'];
			}

        App::import('Model', 'CountryZone');
        $CountryZone = new CountryZone();
        $options = $CountryZone->find('all', array('fields' => array('id', 'name'),
                                                   'conditions' => array('country_id' => $params['country']),
                                                   'order' => 'name'
                                                  ));
        $List = '';

        foreach($options as $option) {
                $List .= "<option value=\"" . $option['CountryZone']['id'] . "\"";
                if (isset($params['selected'])) {
                        if ($option['CountryZone']['id'] == $params['selected']) {
                                $List .= ' selected';
                        }
                }
                $List .= ">" . __($option['CountryZone']['name']) . "</option>";
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