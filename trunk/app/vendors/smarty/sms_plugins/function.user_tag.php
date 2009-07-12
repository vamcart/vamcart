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

function smarty_function_user_tag($params, &$smarty)
{

	loadComponent('UserTagBase');
	$UserTagBase =& new UserTagBaseComponent();

	$UserTagBase->call_user_tag($params);

}

function smarty_help_function_user_tag() {
	?>
	<h3>What does this do?</h3>
	<p>Calls the user tag specified by 'alias'</p>
	<h3>How do I use it?</h3>
	<p>Just insert the tag into your template like: <code>{user_tag alias='user-agent'}</code></p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(alias)</em> - Alias of the user tag to call</li>
		<li><em>(var)</em> - Pass any other smarty variables or information to the user tag like: {user_tag alias='user-agent' var1='abcd' var2='1234'}.  These will be available for the user tag to use in the $params array.</li>		
	</ul>
	<?php
}

function smarty_about_function_user_tag() {
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
