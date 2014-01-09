<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

	echo '<h4>' . __('Current Images For This Content Item') . '</h4>';
	echo '<p>' . __('Uploaded new images? Press apply to view them.') . '</p>';	
	echo '<ul id="content_images">';
	foreach($content_images AS $image)
	{
		$image_path = BASE . '/images/thumb/' . $content_id . '/' . $image['ContentImage']['image'];
		echo '<li class="thumb">
				<a href="' . BASE . '/img/content/' . $content_id . '/' . $image['ContentImage']['image'] . '" target="blank"><img src="' . $image_path . '"  alt="' . __('Click to Enlarge') . '"  title="' . __('Click to Enlarge') . '"/></a><br />' . 
				$this->Ajax->link($this->Html->image('admin/swfupload/cancel.png', array('alt' => __('Delete'),'title' => __('Delete'))),'null', $options = array('escape' => false, 'url' => 'admin_delete_content_image/' . $image['ContentImage']['id'], 'update' => 'content_images_holder'),null,false) 
		   . '</li>';
	}
	echo '</ul><div class="clear"></div>';
	
	if(empty($content_images))	
	{
		echo '<div class="noData">' . __('No Data') . '</div>';
	}
?>