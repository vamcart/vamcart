<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_admin_panel()
{
$template = '
 <nav id="nav" data-spy="affix" data-offset-top="138" data-offset-bottom="0">    
  <div class="navbar navbar-default navigation">
   <div class="container">    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle toggle-menu menu-left" data-toggle="collapse" data-target="#navbar-collapse">
        <span class="sr-only"></span>                
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <a class="navbar-brand" href="{base_path}/">
         <i class="fa fa-home"></i>
     </a>
    </div>
    <div class="collapse navbar-collapse navbar-default cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="navbar-collapse">
   <ul class="nav navbar-nav">
     <li class="dropdown">
       <a data-toggle="dropdown" class="dropdown-toggle" href="">{lang}Categories{/lang} <b class="caret"></b></a>
         <ul class="dropdown-menu">
           {content_listing template="links" parent="0" type="category"}
         </ul>
     </li>
   </ul>
     <form class="navbar-form navbar-left" role="search" action="{base_path}/page/search-result{config value=url_extension}" method="get">
       <div class="input-group">
           <input type="text" class="form-control" placeholder="{lang}Search{/lang}" name="keyword">
           <div class="input-group-btn">
               <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
           </div>
       </div>
     </form>
      <ul class="nav navbar-nav navbar-right">
         <li><a href="{base_path}/page/account{config value=url_extension}" title="{lang}My Orders{/lang}"><i class="fa fa-user"></i> {lang}My Orders{/lang}</a></li>
         <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle cart" data-target="#" href="{base_path}/page/cart-contents{config value=url_extension}" title="{lang}Cart{/lang}"><i class="fa fa-shopping-cart"></i> {lang}Cart{/lang} {if {shopping_cart_total} > 0}<sup><span title="{shopping_cart_total}" class="badge progress-bar-danger">{shopping_cart_total}</span></sup>{/if} <span class="caret"></span></a>
	         <ul class="dropdown-menu cart">
	           <li><div id="shopping-cart-box">{shopping_cart template="cart-content-box" showempty="true"}</div></li>
	         </ul>
         </li>
      </ul>
    </div>
   </div>
  </div>  
 </nav>
';
		
return $template;
}


function smarty_function_admin_panel($params, $template)
{
	global $content, $config;

	if(empty($_SESSION['User']))
	{ 
		return;
	}
	
	if (!empty($_SESSION['User'])) {

	// Cache the output.
	$cache_name = 'vam_admin_panel_output' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

 	App::import('Model', 'Content');
	$Content = new Content();		
	$Content->unbindAll();	
	$Content->bindModel(
        array('hasOne' => array(
			'ContentDescription' => array(
                 'className' => 'ContentDescription',
				'conditions'   => 'language_id = ' . $_SESSION['Customer']['language_id']
             )
         )
        	)
    );
	$Content->bindModel(
        array('belongsTo' => array('ContentType'))
    );
	
	$default_page = $content['Content']['default'];
	$page_id = $content['Content']['id'];
	$page_alias = $content['Content']['alias'];
	$page_name = $content['ContentDescription']['name'];
	$page_url = BASE . '/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION'];
	$parent_id = $page_data['Content']['id'];
	$parent_alias = $page_data['Content']['alias'];
	$parent_name = $page_data['ContentDescription']['name'];
	$parent_url = BASE . '/' . $page_data['ContentType']['name'] . '/' . $page_data['Content']['alias'] . $config['URL_EXTENSION'];

	$assignments = array(
		'default_page' => $default_page,
		'page_id' => $page_id,
		'page_alias' => $page_alias,
		'page_name' => $page_name,
		'page_url' => $page_url,
		'parent_id' => $parent_id,
		'parent_alias' => $parent_alias,
		'parent_name' => $parent_name,
		'parent_url' => $parent_url
	);

	$display_template = $Smarty->load_template($params, 'admin_panel');
	$Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
	}
	
}

function smarty_help_function_admin_panel() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays admin panel.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{admin_panel}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_admin_panel() {
}
?>