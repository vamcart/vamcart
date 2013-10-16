		<label class="control-label" for="bill_state"><?php echo __('State') ?>:</label>
		<div class="controls">
			<select name="bill_state" id="bill_state">
			<?php if (sizeof($zones) > 0) { ?>
			<?php foreach ($zones as $key => $value) { ?>
			    <option value="<?php echo $key ?>"><?php echo $value ?></option>
			<?php } ?>
			<?php } else { ?>
			    <option value="0"><?php echo __('Empty') ?></option>
			<?php } ?>
			</select>
		</div>