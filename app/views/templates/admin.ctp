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

	echo $javascript->link('jquery/jquery.min', false);

echo '<table class="contentTable">';

echo $html->tableHeaders(array(__('Title', true), __('Default', true), __('Action', true)));
foreach ($templates AS $template)
{

	if(in_array($template['Template']['id'], $user_prefs))
	{
		$arrow_link = $ajax->link($html->image('admin/icons/expand.png', array('alt' => __('Expand', true))), 'null', $options = array('url' => '/templates/expand_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
		$collapse_style = "display:none;";
	}
	else
	{
		$collapse_style = " ";
		$arrow_link = $ajax->link($html->image('admin/icons/collapse.png', array('alt' => __('Collapse', true))), 'null', $options = array('url' => '/templates/contract_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
	}


	
	echo $admin->TableCells(
		  array(
			$arrow_link . '&nbsp;' .
			$html->link(__($template['Template']['name'],true),'/templates/admin_edit/' . $template['Template']['id'], array('style' => 'font-weight:bold;')),
			array($admin->DefaultButton($template['Template']), array('align'=>'center')),
			array($admin->ActionButton('stylesheet','/templates/admin_attach_stylesheets/' . $template['Template']['id'],__('Attach Stylesheets', true)) . $admin->ActionButton('copy','/templates/admin_copy/' . $template['Template']['id'],__('Copy', true)) . $admin->ActionButton('edit','/templates/admin_edit_details/' . $template['Template']['id'],__('Edit', true)) . $admin->ActionButton('delete','/templates/admin_delete/' . $template['Template']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
	echo '<tr id=collapse_"' . $template['Template']['id'] . '" style="' . $collapse_style . '"><td colspan="3">';
	echo '<table class="contentTable">';
	
		foreach($template['children'] AS $micro)
		{
			echo $admin->TableCells(
			  array(
					' - ' . $html->link(__($micro['Template']['name'],true),'/templates/admin_edit/' . $micro['Template']['id'])
			   ));
		}
	
	echo '</table>';
	echo '</td></tr>';
}
echo '</table>';

echo $admin->CreateNewLink(); 
echo $form->end(); 
?>