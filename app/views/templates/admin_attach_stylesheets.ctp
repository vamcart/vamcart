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

 __('Template');  echo ': ' . $html->link($template['Template']['name'],'/templates/admin_edit/' . $template['Template']['id']); ?>

<table class="contentTable">

<?php
$attached_stylesheet = $template['Stylesheet'];

echo $html->tableHeaders(array( __('Current Stylesheet Associations', true), __('Action', true)));

foreach ($attached_stylesheet AS $stylesheet)
{

	echo $admin->TableCells(
		  array(
			$html->link($stylesheet['name'],'/stylesheet/admin_edit/' . $stylesheet['id']),
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
	echo $form->select('Stylesheet.Stylesheet][', $available_stylesheets, null, null, false);
	echo $form->submit( __('Attach Stylesheet', true), array('name' => 'attach_stylesheet'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo '</div>';
}
?>