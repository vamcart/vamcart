<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/


 __('Stylesheet');  echo ': ' . $html->link($stylesheet['Stylesheet']['name'],'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']); ?>

<table class="pagetable" cellspacing="0">

<?php
//pr($stylesheet['Template']);die();
$attached_template = $stylesheet['Template'];

echo $html->tableHeaders(array( __('Current Associations', true), __('Action', true)));

foreach ($attached_template AS $template)
{

	echo $admin->TableCells(
		  array(
			$html->link($template['name'],'/templates/admin_edit/' . $template['id']),
			$admin->ActionButton('delete','/stylesheets/admin_delete_template_association/' . $template['id'] . '/' . $stylesheet['Stylesheet']['id'])
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
	echo '<div class="clearb"></div>';
	echo $form->end();
	echo '</div>';
}
?>