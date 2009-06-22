<h1><?php __('Languages') ?></h1>
<p><?php echo $html->link(__('Add Language',true), array('action'=>'add')); ?>
<table>
	<tr>
		<th><?php __('Id') ?></th>
		<th><?php __('Name') ?></th>
      <th><?php __('Code') ?></th>
		<th><?php __('Created') ?></th>
	</tr>

<?php echo Configure::read('Config.store.name'); ?>

<p>
<?php echo $html->link($html->image('eng.gif'), '/lang/eng', null, null, false); ?>
<?php echo $html->link($html->image('rus.gif'), '/lang/rus', null, null, false); ?>
</p>

<?php foreach ($languages as $language): ?>
	<tr>
		<td><?php echo $language['Language']['id']; ?></td>
		<td>
			<?php echo $html->link($language['Language']['name'],array('action'=>'view', 'id'=>$language['Language']['id']));?>
                </td>
                <td>
			<?php echo $html->link(
				__('Delete',true), 
				array('action'=>'delete', 'id'=>$language['Language']['id']), 
				null, 
				__('Are you sure?',true)
			)?>
			<?php echo $html->link(__('Edit',true), array('action'=>'edit', 'id'=>$language['Language']['id']));?>
		</td>
		<td><?php echo $language['Language']['created']; ?></td>
	</tr>
<?php endforeach; ?>

</table>