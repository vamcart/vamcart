<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $javascript->link('modified', false);
	echo $form->create('Stylesheet', array('id' => 'contentform', 'action' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'], 'url' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' =>  __('Copy Stylesheet', true),
					'Stylesheet.name' => array(
						'type' => 'text',
						'label' => __('Name the copy:', true),
	               ),								
					'Stylesheet.stylesheet' => array(
						'type' => 'hidden',
						'value' => $stylesheet['Stylesheet']['stylesheet']
	               ),												   																
			));
	echo $form->submit(__('Submit', true), array('name' => 'submit')) . $form->submit(__('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>