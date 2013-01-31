<?php

$options = Set::combine($content_data, '{n}.id', array('{0}{1}', '{n}.tree_prefix', '{n}.name'));

echo $form->select('category', $options, null, array('escape' => false, 'empty' => __('Select target category', true)));
