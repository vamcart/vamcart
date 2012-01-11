<?php
if (sizeof($zones) > 0) {
		echo $form->select('country_zones', $zones, null, array('escape' => false, 'empty' => false));
} else {
	echo $form->select('country_zones', $zones, null, array('escape' => false, 'empty' => __('Empty', true)));
}