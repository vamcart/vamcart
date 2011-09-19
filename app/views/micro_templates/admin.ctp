<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'micro-templates.png');

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Alias', true), __('Call (Template Placeholder)', true),  __('Action', true)));

foreach ($micro_templates AS $micro_template)
{
	echo $admin->TableCells(
		  array(
			$html->link($micro_template['MicroTemplate']['alias'],'/micro_templates/admin_edit/' . $micro_template['MicroTemplate']['id']),
			'{' . $micro_template['MicroTemplate']['tag_name'] . ' template=\'' . $micro_template['MicroTemplate']['alias'] . '\'}',
			array($admin->ActionButton('edit','/micro_templates/admin_edit/' . $micro_template['MicroTemplate']['id'],__('Edit', true)) . $admin->ActionButton('delete','/micro_templates/admin_delete/' . $micro_template['MicroTemplate']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
}
echo '</table>';
echo $admin->CreateNewLink();

echo $admin->ShowPageHeaderEnd();

?>