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
        echo $form->create('Language', array('id' => 'contentform', 'action' => '/languages/admin_edit/', 'url' => '/languages/admin_edit/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Language Details', true),
				   'Language.id' => array(
				   		'type' => 'hidden'
	               ),
	               'Language.name' => array(
				   		'label' => __('Name', true)
	               ),
				   'Language.code' => array(
   				   		'label' => __('Code', true)
	               ),
				   'Language.iso_code_2' => array(
   				   		'label' => __('Flag Code', true)
	               )						   		     				   	   																									
			));
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>