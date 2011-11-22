<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'attach_stylesheet.png');

 __('Template');  echo ': ' . $html->link($template['Template']['name'],'/templates/admin_edit/' . $template['Template']['id']); ?>

<table class="contentTable">

<?php
$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

$attached_stylesheet = $template['Stylesheet'];

echo $html->tableHeaders(array( __('Current Stylesheet Associations', true), __('Action', true)));

foreach ($attached_stylesheet AS $stylesheet)
{

	echo $admin->TableCells(
		  array(
			$html->link($stylesheet['name'],'/stylesheets/admin_edit/' . $stylesheet['id']),
			array($admin->ActionButton('delete','/templates/admin_delete_stylesheet_association/' . $template['Template']['id'] . '/' . $stylesheet['id'],__('Delete', true)), array('align'=>'center'))
		   ));
}
?>
</table>

<?php
if(!empty( $available_stylesheets))
{
	echo '<div class="attach_select">';
	echo $form->create('Template.Stylesheet', array('action' => '/templates/admin_attach_stylesheets/'.$template['Template']['id'], 'url' => '/templates/admin_attach_stylesheets/'.$template['Template']['id']));
	echo $form->select('Stylesheet.Stylesheet', $available_stylesheets);
	echo $admin->formButton(__('Attach Stylesheet', true), 'css_add.png', array('type' => 'submit', 'name' => 'attach_stylesheet'));	
	echo '<div class="clear"></div>';
	echo $form->end();
	echo '</div>';
}

echo $admin->ShowPageHeaderEnd();

?>