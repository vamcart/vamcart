<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo '<h4>' . __('Current Images For This Content Item', true) . '</h4>';
	echo '<p>' . __('Uploaded new images? Press apply to view them.', true) . '</p>';	
	echo '<ul id="content_images">';
	foreach($content_images AS $image)
	{
		$image_path = BASE . '/images/thumb?src=/content/' . $content_id . '/' . $image['ContentImage']['image'];
		echo '<li class="thumb">
				<a href="' . BASE . '/img/content/' . $content_id . '/' . $image['ContentImage']['image'] . '" target="blank"><img src="' . $image_path . '"  alt="' . __('Click to Enlarge', true) . '"  title="' . __('Click to Enlarge', true) . '"/></a><br />' . 
				$ajax->link($html->image('admin/swfupload/cancel.png', array('alt' => __('Delete', true),'title' => __('Delete', true))),'null', $options = array('escape' => false, 'url' => 'admin_delete_content_image/' . $image['ContentImage']['id'], 'update' => 'content_images_holder'),null,false) 
		   . '</li>';
	}
	echo '</ul><div class="clear"></div>';
	
	if(empty($content_images))	
	{
		echo '<div class="noData">' . __('No Data',true) . '</div>';
	}
?>