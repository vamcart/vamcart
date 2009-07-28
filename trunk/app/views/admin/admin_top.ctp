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