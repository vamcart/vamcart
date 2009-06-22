<h1><?php __('Configurations') ?></h1>
<p><?php echo $html->link(__('Add Configuration',true), array('action'=>'add')); ?>
<table>
	<tr>
		<th><?php __('Configuration Key') ?></th>
      <th><?php __('Configuration Value') ?></th>
		<th><?php __('Created') ?></th>
	</tr>

<?php echo Configure::read('Config.store.name'); ?>

<p>
<?php echo $html->link($html->image('eng.gif'), '/lang/eng', null, null, false); ?>
<?php echo $html->link($html->image('rus.gif'), '/lang/rus', null, null, false); ?>
</p>

<?php foreach ($configurations as $configuration): ?>
	<tr>
		<td>
			<?php echo $configuration['Configuration']['configuration_key'];?>
                </td>
                <td>
			<?php echo $configuration['Configuration']['configuration_value'];?> <?php echo $html->link(__('Edit',true), array('action'=>'edit', 'id'=>$configuration['Configuration']['id']));?>
		</td>
		<td><?php echo $configuration['Configuration']['created']; ?></td>
	</tr>
<?php endforeach; ?>

</table>