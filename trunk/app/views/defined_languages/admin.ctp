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

echo '<table class="pagetable" cellspacing="0">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true),__('Action', true)));

foreach ($defined_languages AS $defined_language)
{
	echo $admin->TableCells(
		  array(
			$html->link($defined_language['DefinedLanguage']['key'],'/defined_languages/admin_edit/' . $defined_language['DefinedLanguage']['key']),
			'{lang}' . $defined_language['DefinedLanguage']['key'] . '{/lang}',
			$admin->ActionButton('edit','/defined_languages/admin_edit/' . $defined_language['DefinedLanguage']['key']) . $admin->ActionButton('delete','/defined_languages/admin_delete/' . $defined_language['DefinedLanguage']['key'])
		   ));
}
echo '</table>';
echo $admin->EmptyResults($defined_languages);

echo $admin->CreateNewLink();
?>