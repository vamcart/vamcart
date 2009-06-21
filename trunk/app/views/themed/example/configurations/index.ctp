<h1><?php __('Blog posts') ?></h1>
<p><?php echo $html->link(__('Add Post',true), array('action'=>'add')); ?>
<table>
	<tr>
		<th><?php __('Id') ?></th>
		<th><?php __('Title') ?></th>
      <th><?php __('Action') ?></th>
		<th><?php __('Created') ?></th>
	</tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

<?php echo Configure::read('Config.store.name'); ?>

<?php foreach ($posts as $post): ?>
	<tr>
		<td><?php echo $post['Post']['id']; ?></td>
		<td>
			<?php echo $html->link($post['Post']['title'],array('action'=>'view', 'id'=>$post['Post']['id']));?>
                </td>
                <td>
			<?php echo $html->link(
				__('Delete',true), 
				array('action'=>'delete', 'id'=>$post['Post']['id']), 
				null, 
				__('Are you sure?',true)
			)?>
			<?php echo $html->link(__('Edit',true), array('action'=>'edit', 'id'=>$post['Post']['id']));?>
		</td>
		<td><?php echo $post['Post']['created']; ?></td>
	</tr>
<?php endforeach; ?>

</table>