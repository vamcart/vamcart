<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-world-edit');

echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array( __('Title'), __('Call (Template Placeholder)'),__('Action')));

foreach ($data AS $defined_language)
{
	echo $this->Admin->TableCells(
		  array(
			$this->Html->link($defined_language['DefinedLanguage']['key'],'/defined_languages/admin_edit/' . $defined_language['DefinedLanguage']['key']),
			'{lang}' . $defined_language['DefinedLanguage']['key'] . '{/lang}',
			array($this->Admin->ActionButton('edit','/defined_languages/admin_edit/' . $defined_language['DefinedLanguage']['key'],__('Edit')) . $this->Admin->ActionButton('delete','/defined_languages/admin_delete/' . $defined_language['DefinedLanguage']['key'],__('Delete')), array('align'=>'center'))
		   ));
}
echo '</table>';

?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php

echo $this->Admin->CreateNewLink();
echo $this->Admin->CreateExportLink();
echo $this->Admin->CreateImportLink();

echo $this->Admin->ShowPageHeaderEnd();

?>