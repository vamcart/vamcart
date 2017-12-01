<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_page_description($params, $template)
{
	global $content;

	$page_content = '';

	if(isset($params['content_alias']) && $params['content_alias'] != '') {

	App::import('Model', 'Content');
	$Content = new Content();
		
	$content_id_query = $Content->find('first', array('conditions' => array('Content.alias' => $params['content_alias'])));
	$content_id = $content_id_query['Content']['id'];

	App::uses('ContentBaseComponent', 'Controller/Component');
	$ContentBase = new ContentBaseComponent(new ComponentCollection());
	
	$content_query = $ContentBase->get_content_description($content_id);

	$page_description = $content_query['ContentDescription']['description'];
	
	} else {
		
	$page_description = $content['ContentDescription']['description'];
	
	}
		
	return $page_description;
}

function smarty_help_function_page_description() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Display content of selected content_alias element.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{page_description content_alias="item-alias"}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(content_alias)') ?></em> - <?php echo __('Content alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_page_description() {
}
?>