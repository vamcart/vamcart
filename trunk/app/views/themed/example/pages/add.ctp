<!-- File: /app/views/pages/add.ctp -->	
<?php echo $html->css('forms', '', '', false); ?>
<?php echo $javascript->link('forms.js', false); ?>
<h1><?php __('Add Page') ?></h1>
<?php
echo $form->create('Page');
?>

<?php for ($i=0; $i<sizeof($language); $i++) { ?>
<h3><?php echo $language[$i]['Language']['name']; ?></h3>
<?php
echo $form->input('title.'.$language[$i]['Language']['code'], array('label' => __('Title',true)));
echo $form->input('body.'.$language[$i]['Language']['code'], array('label' => __('Body',true),'rows' => '3'));
?>

<?php } ?>

<?php
echo $form->end(__('Save Page',true));
?>