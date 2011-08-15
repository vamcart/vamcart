<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'templates.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array(__('Title', true), __('Default', true), __('Action', true),'&nbsp;'));
foreach ($templates AS $template)
{

	if(in_array($template['Template']['id'], $user_prefs))
	{
		$arrow_link = $ajax->link($html->image('admin/icons/expand.png', array('alt' => __('Expand', true))), 'null', $options = array('escape' => false, 'url' => '/templates/expand_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
		$collapse_style = "display:none;";
	}
	else
	{
		$collapse_style = " ";
		$arrow_link = $ajax->link($html->image('admin/icons/collapse.png', array('alt' => __('Collapse', true))), 'null', $options = array('escape' => false, 'url' => '/templates/contract_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
	}

	$set_all_bug_fix =  __('Are you sure you want to set all products to this template?',true);
	
	echo $admin->TableCells(
		  array(
			$arrow_link . '&nbsp;' .
			$html->link(__($template['Template']['name'],true),'/templates/admin_edit/' . $template['Template']['id'], array('style' => 'font-weight:bold;')),
			array($admin->DefaultButton($template['Template']), array('align'=>'center')),
			array($admin->ActionButton('stylesheet','/templates/admin_attach_stylesheets/' . $template['Template']['id'],__('Attach Stylesheets', true)) . $admin->ActionButton('copy','/templates/admin_copy/' . $template['Template']['id'],__('Copy', true)) . $admin->ActionButton('edit','/templates/admin_edit_details/' . $template['Template']['id'],__('Edit', true)) . $admin->ActionButton('delete','/templates/admin_delete/' . $template['Template']['id'],__('Delete', true)), array('align'=>'center')),
			array($html->link($this->Html->image('admin/icons/buttons/set_all.png', array('width' => '12', 'height' => '12', 'alt' => '')).'&nbsp;' .__('Set All Products',true), '/templates/admin_set_all_products/' . $template['Template']['id'], array('escape' => false, 'class' => 'button'),$set_all_bug_fix), array('align'=>'center'))
		   ));
	echo '<tr id=collapse_"' . $template['Template']['id'] . '" style="' . $collapse_style . '"><td colspan="4">';
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

echo $admin->ShowPageHeaderEnd();

?>