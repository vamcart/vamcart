<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

 __('Stylesheet');  echo ': ' . $html->link($stylesheet['Stylesheet']['name'],'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']); ?>

<table class="contentTable">

<?php
//pr($stylesheet['Template']);die();
$attached_template = $stylesheet['Template'];

echo $html->tableHeaders(array( __('Current Template Associations', true), __('Action', true)));

foreach ($attached_template AS $template)
{

	echo $admin->TableCells(
		  array(
			$html->link($template['name'],'/templates/admin_edit/' . $template['id']),
			$admin->ActionButton('delete','/stylesheets/admin_delete_template_association/' . $template['id'] . '/' . $stylesheet['Stylesheet']['id'],__('Delete', true))
		   ));
}
?>
</table>

<?php
if(!empty( $available_templates))
{
	echo '<div class="attach_select">';
	echo $form->create('Stylesheet/Template', array('action' => '/stylesheets/admin_attach_templates/'.$stylesheet['Stylesheet']['id'], 'url' => '/stylesheets/admin_attach_templates/'.$stylesheet['Stylesheet']['id']));
	echo $form->select('Template/Template][', $available_templates, null, null, false);
	echo $form->submit( __('Attach Template', true), array('name' => 'attach_template'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo '</div>';
}
?>