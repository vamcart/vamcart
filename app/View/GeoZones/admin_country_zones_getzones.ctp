<?php
if (sizeof($zones) > 0) {
	echo $this->Form->select('country_zones[]', $zones, array('id' => 'country_zones', 'escape' => false, 'empty' => false));
} else {
	echo $this->Form->select('country_zones[]', $zones, array('id' => 'country_zones', 'escape' => false, 'empty' => __('Empty')));
}