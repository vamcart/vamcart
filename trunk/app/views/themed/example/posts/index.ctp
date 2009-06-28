<h1><?php __('Blog posts') ?></h1>
<p><?php echo $html->link(__('Add Post',true), array('action'=>'add')); ?>
<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id',true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Title',true), 'title'); ?></th>
      <th><?php __('Action') ?></th>
		<th><?php echo $paginator->sort(__('Created',true), 'created'); ?></th>
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

<p>
<!-- Shows the page numbers -->
<?php echo $paginator->numbers(); ?>
<!-- Shows the next and previous links -->
</p>
<p>
<?php
	echo $paginator->prev(__('« Previous ',true), null, null, array('class' => 'disabled'));
	echo $paginator->next(__(' Next »',true), null, null, array('class' => 'disabled'));
?> 
</p>
<p>
<!-- prints X of Y, where X is current page and Y is number of pages -->
<?php echo $paginator->counter(); ?>
</p>

</table>