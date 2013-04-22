<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo $this->Html->script('modified', array('inline' => false));
	
	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-layers');
        
 echo __('Stylesheet');  echo ': ' . $this->Html->link($stylesheet['Stylesheet']['name'],'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']); ?>

<table class="contentTable">

<?php
$attached_template = $stylesheet['Template'];

echo $this->Html->tableHeaders(array( __('Current Template Associations'), __('Action')));

foreach ($attached_template AS $template)
{

	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($template['name'],'/templates/admin_edit/' . $template['id']),
			array($this->Admin->ActionButton('delete','/stylesheets/admin_delete_template_association/' . $template['id'] . '/' . $stylesheet['Stylesheet']['id'],__('Delete')), array('align'=>'center'))
		   ));
}
?>
</table>

<?php
if(!empty( $available_templates))
{
	echo '<div class="attach_select">';
	echo $this->Form->create('Stylesheet.Template', array('action' => '/stylesheets/admin_attach_templates/'.$stylesheet['Stylesheet']['id'], 'url' => '/stylesheets/admin_attach_templates/'.$stylesheet['Stylesheet']['id']));
	echo $this->Form->select('Template.Template', $available_templates);
	echo $this->Admin->formButton(__('Attach Template'), 'cus-add', array('class' => 'btn', 'type' => 'submit', 'name' => 'attach_template'));	
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo '</div>';
}
?>
<?php echo $this->Admin->ShowPageHeaderEnd(); ?>