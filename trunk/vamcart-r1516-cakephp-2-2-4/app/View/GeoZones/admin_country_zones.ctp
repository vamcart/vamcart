<?php
echo $this->Form->select('countries', $countries, null, array('escape' => false, 'empty' => __('Select country')));
?>
<p><a href="#" id="selectAll"><?php echo __('Select All') ?></a> | <a href="#" id="deselectAll"><?php echo __('Deselect All') ?></a></p>
<?php
echo $this->Form->select('country_zones', array(), null, array('escape' => false, 'empty' => __('Select regions')));
echo $this->Html->codeBlock('$(\'select#countries\').change(function(){onCountriesChanged();});');
echo $this->Html->blockEnd();