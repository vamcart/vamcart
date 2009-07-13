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

$options = $this->requestAction('/contents/content_selflink_list/' . $data['ContentSelflink']['content_id']);


if(empty($options))
{
	echo '<p>' . __('There are no available content records. Please select a different content type.', true) . '</p>';
}
else
{


	echo '<div class="input">';
	echo '<label for="ContentSelflinkUrl">' . __('Link To', true) . '</label>';
	
	echo $form->select('ContentSelflink/url', $options, $data['ContentSelflink']['url'], null, $showEmpty = __('Select Internal Page', true));
	
	echo '</div>';
}

?>