<?php

$options = Set::combine($content_data, '{n}.id', array('{0}{1}', '{n}.tree_prefix', '{n}.name'));

echo $this->Form->select('category', $options, array('escape' => false, 'empty' => __('Select target category')));
