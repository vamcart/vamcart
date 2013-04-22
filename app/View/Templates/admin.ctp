<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Html->script('jquery/jquery.min', array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-layout');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array(__('Title'), __('Default'), __('Action'),'&nbsp;'));
foreach ($templates AS $template)
{

	if(in_array($template['Template']['id'], $user_prefs))
	{
		$arrow_link = $this->Ajax->link($this->Html->image('admin/icons/expand.png', array('alt' => __('Expand'))), 'null', $options = array('escape' => false, 'url' => '/templates/expand_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
		$collapse_style = "display:none;";
	}
	else
	{
		$collapse_style = " ";
		$arrow_link = $this->Ajax->link($this->Html->image('admin/icons/collapse.png', array('alt' => __('Collapse'))), 'null', $options = array('escape' => false, 'url' => '/templates/contract_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
	}

	$set_all_bug_fix =  __('Are you sure you want to set all products to this template?');
	
	echo $this->Admin->TableCells(
		  array(
			$arrow_link . '&nbsp;' .
			$this->Html->link(__($template['Template']['name']),'/templates/admin_edit/' . $template['Template']['id'], array('style' => 'font-weight:bold;')),
			array($this->Admin->DefaultButton($template['Template']), array('align'=>'center')),
			array($this->Admin->ActionButton('stylesheet','/templates/admin_attach_stylesheets/' . $template['Template']['id'],__('Attach Stylesheets')) . $this->Admin->ActionButton('copy','/templates/admin_copy/' . $template['Template']['id'],__('Copy')) . $this->Admin->ActionButton('edit','/templates/admin_edit_details/' . $template['Template']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/templates/admin_delete/' . $template['Template']['id'],__('Delete')), array('align'=>'center')),
			array($this->Admin->linkButton(__('Set All Products'), '/templates/admin_set_all_products/' . $template['Template']['id'], 'cus-table-add', array('escape' => false, 'class' => 'btn'),$set_all_bug_fix), array('align'=>'center'))
		   ));
	echo '<tr id=collapse_"' . $template['Template']['id'] . '" style="' . $collapse_style . '"><td colspan="4">';
	echo '<table class="contentTable">';
	
		foreach($template['children'] AS $micro)
		{
			echo $this->Admin->TableCells(
			  array(
					' - ' . $this->Html->link(__($micro['Template']['name']),'/templates/admin_edit/' . $micro['Template']['id'])
			   ));
		}
	
	echo '</table>';
	echo '</td></tr>';
}
echo '</table>';

echo $this->Admin->CreateNewLink(); 
echo $this->Admin->CreateExportLink();
echo $this->Admin->CreateImportLink();

echo $this->Form->end(); 

echo $this->Admin->ShowPageHeaderEnd();

?>