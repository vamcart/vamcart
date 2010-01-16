<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo '<table class="contentTable">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true),__('Action', true)));

foreach ($defined_languages AS $defined_language)
{
	echo $admin->TableCells(
		  array(
			$html->link($defined_language['DefinedLanguage']['key'],'/defined_languages/admin_edit/' . $defined_language['DefinedLanguage']['key']),
			'{lang}' . $defined_language['DefinedLanguage']['key'] . '{/lang}',
			array($admin->ActionButton('edit','/defined_languages/admin_edit/' . $defined_language['DefinedLanguage']['key'],__('Edit', true)) . $admin->ActionButton('delete','/defined_languages/admin_delete/' . $defined_language['DefinedLanguage']['key'],__('Delete', true)), array('align'=>'center'))
		   ));
}
echo '</table>';
echo $admin->EmptyResults($defined_languages);

echo $admin->CreateNewLink();
?>