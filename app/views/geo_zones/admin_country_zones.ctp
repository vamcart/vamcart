<?php
echo $form->select('countries', $countries, null, array('escape' => false, 'empty' => __('Select country', true)));
?>
<p><a href="#" id="selectAll"><?php echo __('Select All', true) ?></a> | <a href="#" id="deselectAll"><?php echo __('Deselect All', true) ?></a></p>
<?php
echo $form->select('country_zones', array(), null, array('escape' => false, 'empty' => __('Select regions', true)));
echo $javascript->codeBlock('$(\'select#countries\').change(function(){onCountriesChanged();});');
echo $javascript->blockEnd();