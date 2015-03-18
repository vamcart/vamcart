	<div id="ship_state_div">
		<label class="col-sm-3 control-label" for="ship_state"><?php echo __('State') ?>:</label>
		<div class="col-sm-9">
			<select class="form-control" name="ship_state" id="ship_state">
			<?php if (sizeof($zones) > 0) { ?>
			<?php foreach ($zones as $key => $value) { ?>
			    <option value="<?php echo $key ?>"><?php echo __($value); ?></option>
			<?php } ?>
			<?php } else { ?>
			    <option value="0"><?php echo __('Empty') ?></option>
			<?php } ?>
			</select>
		</div>
	</div>