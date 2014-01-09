<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-palette');

 echo __('Template');  echo ': ' . $this->Html->link(__($template['Template']['name']),'/templates/admin_edit/' . $template['Template']['id']); ?>

<table class="contentTable">

<?php
$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

$attached_stylesheet = $template['Stylesheet'];

echo $this->Html->tableHeaders(array( __('Current Stylesheet Associations'), __('Action')));

foreach ($attached_stylesheet AS $stylesheet)
{

	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($stylesheet['name'],'/stylesheets/admin_edit/' . $stylesheet['id']),
			array($this->Admin->ActionButton('delete','/templates/admin_delete_stylesheet_association/' . $template['Template']['id'] . '/' . $stylesheet['id'],__('Delete')), array('align'=>'center'))
		   ));
}
?>
</table>

<?php
if(!empty( $available_stylesheets))
{
	echo '<div class="attach_select">';
	echo $this->Form->create('Template.Stylesheet', array('action' => '/templates/admin_attach_stylesheets/'.$template['Template']['id'], 'url' => '/templates/admin_attach_stylesheets/'.$template['Template']['id']));
	echo $this->Form->select('Stylesheet.Stylesheet', $available_stylesheets);
	echo $this->Admin->formButton(__('Attach Stylesheet'), 'cus-add', array('class' => 'btn', 'type' => 'submit', 'name' => 'attach_stylesheet'));	
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo '</div>';
}

echo $this->Admin->ShowPageHeaderEnd();

?>