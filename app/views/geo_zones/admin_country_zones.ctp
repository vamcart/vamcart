<?php
echo $form->select('countries', $countries, null, array('escape' => false, 'empty' => __('Select country', true)));
echo $form->select('country_zones', array(), null, array('escape' => false, 'empty' => __('Select region', true)));
echo $javascript->codeBlock('$(\'select#countries\').change(function(){onCountriesChanged();});');
echo $javascript->blockEnd();