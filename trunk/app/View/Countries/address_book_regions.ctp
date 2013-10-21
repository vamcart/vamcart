		<label class="control-label" for="ship_state"><?php echo __('State') ?>:</label>
		<div class="controls">
			<select name="AddressBook[ship_state]" id="ship_state">
			<?php if (sizeof($zones) > 0) { ?>
			<?php foreach ($zones as $key => $value) { ?>
			    <option value="<?php echo $key ?>"><?php echo __($value); ?></option>
			<?php } ?>
			<?php } else { ?>
			    <option value="0"><?php echo __('Empty') ?></option>
			<?php } ?>
			</select>
		</div>