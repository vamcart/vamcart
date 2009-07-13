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

// If we're on the top level then assign the rest of the elements as menu children
if($level == 1)
{
	$tmp_navigation = array();

	$navigation[1] = null; // Removes the home page from being displayed below
	
	foreach($navigation AS $tmp_nav)
	{
		if(!empty($tmp_nav))
			$tmp_navigation[$level]['children'][] = $tmp_nav;
	}
	$navigation = $tmp_navigation;

}

if(!empty($navigation[$level]['children']))
{
	$level_navigation = $navigation[$level]['children'];
	foreach($level_navigation AS $nav)
	{
		echo '<div class="page_menu_item" class="">
				<p class="heading">' . $admin->MenuLink($nav) . '</p>';
//		echo '<p>' . __($nav['text'].'_description', true) . '</p>';
		if(!empty($nav['children']))
		{
			$sub_items = __('Options', true) . ': ';
			foreach($nav['children'] AS $child)
			{
				$sub_items .= $admin->MenuLink($child) . ', ';
			}
			$sub_items = rtrim($sub_items, ', ');
			echo $sub_items;
		}
		echo '</div>';
	}
}
?>