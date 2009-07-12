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
	echo '<h4>' . __('current_images', true) . '</h4>';
	echo '<p>' . __('current_images_info', true) . '</p>';	
	echo '<ul id="content_images">';
	foreach($content_images AS $image)
	{
		$image_path = BASE . '/images/thumb?src=/content/' . $content_id . '/' . $image['ContentImage']['image'];
		echo '<li class="thumb">
				<a href="' . BASE . '/img/content/' . $content_id . '/' . $image['ContentImage']['image'] . '" target="blank"><img src="' . $image_path . '"  alt="' . __('click_to_enlarge', true) . '"  title="' . __('click_to_enlarge', true) . '"/></a><br />' . 
				$ajax->link($html->image('admin/cancel.png', array('alt' => __('delete', true),'title' => __('delete', true))),'null', $options = array('url' => 'admin_delete_content_image/' . $image['ContentImage']['id'], 'update' => 'content_images_holder'),null,false) 
		   . '</li>';
	}
	echo '</ul><div style="clear:both;">';
	
	if(empty($content_images))	
	{
		echo '<div class="no_data">' . __('no_data',true) . '</div>';
	}
?>