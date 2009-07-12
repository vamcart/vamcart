<?php
/** SMS - Selling Made Simple
 * Original file from CMS - CMS Made Simple (www.cmsmadesimple.org)
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

function smarty_function_repeat($params, &$smarty)
{
	return (isset($params['times']) && intval($params['times']) > 0 ? str_repeat($params['string'], $params['times']) : '');
}

function smarty_help_function_repeat() {
	?>
	<h3>What does this do?</h3>
	<p>Repeats a given string a certain number of times.</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template like: <code>{repeat string="Hello!" times="3"}	</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(string)</em> - String to repeat.</li>
		<li><em>(times)</em> - Number of times to repeat the specified string.</li>
	</ul>
	<?php
}

function smarty_about_function_repeat() {
	?>
	<p>Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>
	<p>Version: 0.1</p>
	<p>
	Change History:<br/>
	None
	</p>
	<?php
}
?>
