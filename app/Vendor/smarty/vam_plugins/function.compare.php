<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_compare()
{
$template = '
<section class="widget inner">
	<h3 class="widget-title">{lang}Comparison{/lang}</h3>
	<form name="" action="{$base_url}/compared/done/{$base_content}" method="post">
		<ul class="icons clearfix">
			{foreach from=$element_list item=element}
				<li>{$element.ContentDescription.name} 
					<a href="{$base_url}/delcmp/{$element.Content.alias}/{$base_content}"><img alt="{lang}Remove{/lang}" title="{lang}Remove{/lang}" src="{base_path}/img/icons/delete.png" /></a>
				</li>
         {/foreach}
		</ul>
	<button type="submit" class="btn btn-inverse"><i class="icon-bookmark"></i> {lang}Compare{/lang}</button>
	</form>
</section>
';
return $template;
}


function smarty_function_compare($params, $template)
{    
        global $compare_list;
        global $content;
        global $config;

	if (empty($content['CompareAttribute'])||$content['ContentType']['name'] != 'category') 
    	{
		return;
    	}
    
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());
        
        App::import('Model', 'Content');
	$Content =& new Content();
	
        $Content->unbindAll();
	$Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $_SESSION['Customer']['language_id']
                                        ))));
        $content_list_data = $Content->find('all', array('conditions' => array('Content.id' => $compare_list)));

	$assignments = array();
        $assignments = array('element_list' => $content_list_data
                        ,'base_url' => BASE . '/' . $content['ContentType']['name']
                        ,'base_content' => $content['Content']['alias'] . $config['URL_EXTENSION']
                        );
	$display_template = $Smarty->load_template($params, 'compare');
	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_compare() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays compare box.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{compare}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_compare() {
}
?>
