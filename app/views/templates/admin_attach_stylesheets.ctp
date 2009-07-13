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


 __('Template');  echo ': ' . $html->link($template['Template']['name'],'/templates/admin_edit/' . $template['Template']['id']); ?>

<table class="pagetable" cellspacing="0">

<?php
$attached_stylesheet = $template['Stylesheet'];

echo $html->tableHeaders(array( __('Current Stylesheet Associations', true), __('Action', true)));

foreach ($attached_stylesheet AS $stylesheet)
{

	echo $admin->TableCells(
		  array(
			$html->link($stylesheet['name'],'/stylesheet/admin_edit/' . $stylesheet['id']),
			$admin->ActionButton('delete','/templates/admin_delete_stylesheet_association/' . $template['Template']['id'] . '/' . $stylesheet['id'])
		   ));
}
?>
</table>

<?php
if(!empty( $available_stylesheets))
{
	echo '<div class="attach_select">';
	echo $form->create('Template/Stylesheet', array('action' => '/templates/admin_attach_stylesheets/'.$template['Template']['id'], 'url' => '/templates/admin_attach_stylesheets/'.$template['Template']['id']));
	echo $form->select('Stylesheet/Stylesheet][', $available_stylesheets, null, null, false);
	echo $form->submit( __('Attach Stylesheet', true), array('name' => 'attach_stylesheet'));
	echo '<div class="clearb"></div>';
	echo $form->end();
	echo '</div>';
}
?>