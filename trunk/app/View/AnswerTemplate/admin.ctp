<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-email');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Name'), __('Alias'),  __('Action')));

foreach ($answer_template_data AS $answer_template)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($answer_template['AnswerTemplateDescription']['name'], '/answer_template/admin_edit/' . $answer_template['AnswerTemplate']['id']),
				$answer_template['AnswerTemplate']['alias'],
				array($this->Admin->ActionButton('edit','/answer_template/admin_edit/' . $answer_template['AnswerTemplate']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/answer_template/admin_delete/' . $answer_template['AnswerTemplate']['id'],__('Delete')), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>