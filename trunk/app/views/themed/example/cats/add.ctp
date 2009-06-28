<!-- File: /app/views/cats/add.ctp -->	
<?php echo $html->css('forms', '', '', false); ?>
<?php echo $javascript->link('forms.js', false); ?>
<h1><?php __('Add Category') ?></h1>
<?php
echo $form->create('Cat');
?>

<?php for ($i=0; $i<sizeof($language); $i++) { ?>
<h3><?php echo $language[$i]['Language']['name']; ?></h3>
<?php
echo $form->input('name.'.$language[$i]['Language']['code'], array('label' => __('Name',true)));
echo $form->input('description.'.$language[$i]['Language']['code'], array('label' => __('Description',true),'rows' => '3'));
?>

<?php } ?>

<?php
echo $form->end(__('Save Category',true));
?>