<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>

<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css(array(
										'font-awesome.min.css',
										'bootstrap3/bootstrap.min.css',
										'bootstrap/cus-icons.css',
										'dynatree/ui.dynatree.css',
										'jquery/plugins/hoe/hoe.css',
										'admin.css',
											), null, array('inline' => true)); ?>

<?php echo $this->Html->script(array(
											'jquery/jquery.min.js',
											'bootstrap3/bootstrap.min.js',
											'jquery/plugins/hoe/hoe.js',
											'jquery/plugins/scrollup/jquery.scrollup.min.js',
											'admin.js',
												),
											array('inline' => true)); ?>
<?php echo $this->Html->scriptBlock('
//<![CDATA[
$(document).ready(function () {$(\'[rel=tooltip],input[data-title]\').tooltip();
});
//]]>
', array('allowCache'=>false,'safe'=>false,'inline'=>true)); ?>			
								
<?php echo $scripts_for_layout; ?>
</head>

<body hoe-navigation-type="vertical-compact" hoe-nav-placement="left" >
    <div id="hoeapp-wrapper" class="hoe-hide-lpanel" hoe-device-type="desktop">

 <header>    
  <div class="navbar navbar-default navigation">
   <div class="container-fluid">    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle toggle-menu menu-left" data-toggle="collapse" data-target="#navbar-collapse">
        <span class="sr-only"></span>                
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <?php echo $this->Html->link($this->Html->image('admin/logo.png', array('alt' => __('VamShop',true))), '/admin/admin_top/', array('escape'=>false));?> 
    </div>
    <div class="collapse navbar-collapse navbar-default" id="navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="http://apps.<?php echo __('vamshop.com'); ?>/" target="_blank" title="<?php echo __('Apps'); ?>"><i class="fa fa-th"></i> <?php echo __('Apps'); ?></a></li>
			<li><a href="http://support.<?php echo __('vamshop.com'); ?>/" target="_blank" title="<?php echo __('Support'); ?>"><i class="fa fa-question"></i> <?php echo __('Support'); ?></a></li>
			<li><?php echo $this->Html->link('<i class="fa fa-shopping-cart"></i> ' . __('Launch Site'), '/', array('escape'=> false, 'target' => 'blank', 'title' => __('Launch Site'))); ?></li>
			<li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i> ' . __('Logout'), '/users/admin_logout/', array('escape'=> false, 'target' => 'blank', 'title' => __('Logout'))); ?></li>
		</ul>

			<?php 
			echo $this->form->create('Search', array('class' => 'navbar-form navbar-right', 'action' => '/search/admin_global_search/', 'url' => '/search/admin_global_search/'));
			echo $this->form->input('Search.term',array('div' => false, 'class' => 'form-control input-medium', 'label' => false,'placeholder' => __('Global Record Search',true)));
			//echo $this->form->submit( __('Submit', true));
			echo $this->form->end();
			?> 

    </div>
   </div>
  </div>  
 </header>  
 

  
        <nav id="hoe-header" hoe-lpanel-effect="shrink" class="hoe-minimized-lpanel">
            <div class="hoe-left-header">
                <?php echo $this->Html->link('<i class="fa fa-home"></i> <span>' . __('VamShop',true) . '</span>', '/admin/admin_top/', array('escape'=>false)); ?>           	
                <span class="hoe-sidebar-toggle"><a href="#"></a></span>
            </div>

            <div class="hoe-right-header" hoe-position-type="relative" hoe-color-type="header-bg7" >
                <span class="hoe-sidebar-toggle"><a href="#"></a></span>
                <?php if(isset($current_crumb)) {  echo $this->admin->GenerateBreadcrumbs($navigation, $current_crumb); } ?>
                <ul class="right-navbar">
                </ul>
            </div>
        </nav>

        <div id="hoeapp-container" hoe-color-type="lpanel-bg2" hoe-lpanel-effect="overlay" class="hoe-minimized-lpanel">
<?php
if(isset($navigation)) { 
?>
            <aside id="hoe-left-panel" hoe-position-type="absolute">
                <?php echo $this->admin->DrawMenu($navigation); ?>				 
            </aside>
<?php
} 
?>

            <section id="main-content">
               
<!-- Content -->
<div id="wrapper">
<div id="content">

<?php if($this->Session->check('Message.flash')) echo $this->Session->flash(); ?>

<?php echo $this->fetch('content'); ?>

</div>
</div>
<!-- /Content -->
               
            </section> 
        </div>
    </div>

<!-- Footer -->
<div id="footer">
<p>
<a href="http://<?php echo __('vamshop.com'); ?>/"><?php echo __('Powered by'); ?></a> <a href="http://<?php echo __('vamshop.com'); ?>/"><?php echo __('VamShop'); ?></a>
</p>
</div>
<!-- /Footer -->

</body>
</html>