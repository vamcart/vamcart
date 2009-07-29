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

$options = $this->requestAction('/contents/content_selflink_list/' . $data['ContentSelflink']['content_id']);


if(empty($options))
{
	echo '<p>' . __('There are no available content records. Please select a different content type.', true) . '</p>';
}
else
{


	echo '<div class="input">';
	echo '<label for="ContentSelflinkUrl">' . __('Link To', true) . '</label>';
	
	echo $form->select('ContentSelflink.url', $options, $data['ContentSelflink']['url'], null, $showEmpty = __('Select Internal Page', true));
	
	echo '</div>';
}

?>