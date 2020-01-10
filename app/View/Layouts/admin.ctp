<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<!DOCTYPE html>
<html lang="<?php echo $this->Session->read('Customer.language'); ?>">
<head>
<?php echo $this->Html->charset(); ?>

<meta name="viewport" content="initial-scale=1.0, width=device-width" />

<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css(array(
										'font-awesome.min.css',
										'font-roboto.css',
										'bootstrap3/bootstrap.min.css',
										'jquery/plugins/hoe/hoe.css',
										'jquery/plugins/select2/select2.css',
										'admin/cus-icons.css',
										'admin/admin.css',
											), null, array('inline' => true)); ?>

<?php echo $this->Html->script(array(
											'jquery/jquery.min.js',
											'bootstrap3/bootstrap.min.js',
											'jquery/plugins/hoe/hoe.js',
											'jquery/plugins/hoe/hoe.js',
											'jquery/plugins/select2/select2.min.js',
											'jquery/plugins/select2/i18n/' . $this->Session->read('Customer.language') . '.js',
											'jquery/plugins/scrollup/jquery.scrollup.min.js',
											'admin/admin.js',
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

<body hoe-navigation-type="vertical-compact" hoe-nav-placement="left" theme-layout="wide-layout">
    <div id="hoeapp-wrapper" class="hoe-hide-lpanel" hoe-device-type="desktop">
        <header id="hoe-header" hoe-lpanel-effect="shrink" class="hoe-minimized-lpanel">
            <div class="hoe-left-header" hoe-position-type="fixed">
                <?php echo $this->Html->link('<i class="cus-house"></i> <span>' . __('VamShop',true) . '</span>', '/admin/admin_top/', array('escape'=>false)); ?>
                <span class="hoe-sidebar-toggle"><a href="#"></a></span>
            </div>

            <div class="hoe-right-header" data-spy="affix" data-offset-top="50" data-offset-bottom="0" hoe-position-type="fixed">
                <span class="hoe-sidebar-toggle"><a href="#"></a></span>

                <ul class="left-navbar breadcrumb">
                <?php if(isset($current_crumb)) {  echo $this->admin->GenerateBreadcrumbs($navigation, $current_crumb); } ?>
                </ul>
					                
                <ul class="right-navbar">
						<li class="dropdown hoe-rheader-submenu hoe-header-profile">
							<a href="#" class="dropdown-toggle icon-circle" data-toggle="dropdown">
	                    <span><i class=" fa fa-search"></i></span>
							</a> 
							<ul class="dropdown-menu ">
								<li>
									<?php 
									echo $this->form->create('Search', array('class' => 'search-form', 'url' => '/search/admin_global_search/'));
									echo $this->form->input('Search.term',array('div' => false, 'class' => 'form-control input-medium', 'label' => false,'placeholder' => __('Global Record Search',true)));
									//echo $this->form->submit( __('Submit', true));
									echo $this->form->end();
									?>								
								</li>
							</ul>
						</li>
						<li class="dropdown hoe-rheader-submenu hoe-header-profile">
							<a href="#" class="dropdown-toggle icon-circle" data-toggle="dropdown">
	                    <span><i class=" fa fa-question-circle"></i></span>
							</a> 
							<ul class="dropdown-menu ">
								<li><a href="http://apps.<?php echo __('vamshop.com'); ?>/" target="_blank" title="<?php echo __('Apps'); ?>"><i class="fa fa-th"></i> <?php echo __('Apps'); ?></a></li>
								<li><a href="http://support.<?php echo __('vamshop.com'); ?>/" target="_blank" title="<?php echo __('Support'); ?>"><i class="fa fa-question"></i> <?php echo __('Support'); ?></a></li>
								<li><?php echo $this->Html->link('<i class="fa fa-shopping-cart"></i> ' . __('Launch Site'), '/', array('escape'=> false, 'target' => 'blank', 'title' => __('Launch Site'))); ?></li>
							</ul>
						</li>
						<li class="dropdown hoe-rheader-submenu hoe-header-profile">
							<a href="#" class="dropdown-toggle icon-circle" data-toggle="dropdown">
	                    <span><i class=" fa fa-user"></i></span>
							</a> 
							<ul class="dropdown-menu ">
	                    <li><?php echo $this->Html->link('<i class="cus-group-add"></i> <span>' . __('Manage Accounts',true) . '</span>', '/users/admin/', array('escape'=>false)); ?></li>
	                    <li><?php echo $this->Html->link('<i class="cus-group-edit"></i> <span>' . __('My Account',true) . '</span>', '/users/admin_user_account/', array('escape'=>false)); ?></li>
	                    <li><?php echo $this->Html->link('<i class="cus-group-key"></i> <span>' . __('Prefences',true) . '</span>', '/users/admin_user_preferences/', array('escape'=>false)); ?></li>
	                    <li><?php echo $this->Html->link('<i class="cus-group-go"></i> <span>' . __('Logout',true) . '</span>', '/users/admin_logout/', array('escape'=>false)); ?></li>
							</ul>
						</li>
                </ul>				
            </div>
        </header>
        <div id="hoeapp-container" hoe-color-type="lpanel-bg2" hoe-lpanel-effect="shrink" class="hoe-minimized-lpanel">

<?php
if(isset($navigation)) { 
?>
            <aside id="hoe-left-panel" hoe-position-type="fixed">
            <ul class="nav panel-list">

                <?php echo $this->admin->DrawMenu($navigation); ?>

            </ul>				 
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
         
         <!--
			<div id="styleSelector">
                <div class="selector-toggle">
                    <a href="javascript:void(0)"></a>
                </div>
                <ul>
                    <li>
                        <p class="selector-title">Style Selector</p>
                    </li>
                    <li class="theme-option">
                        <span class="sub-title">Header BG Color Option</span>
                        <div id="theme-color">
                            <a href="#" class="header-bg" hoe-color-type="header-bg1">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg2">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg3">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg4">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg5">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg6">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg7">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg8">&nbsp;</a>
                            <a href="#" class="header-bg" hoe-color-type="header-bg9">&nbsp;</a>
                        </div>
                    </li>
                    <li class="theme-option">
                        <span class="sub-title">Left Panel BG Color Option</span>
                        <div id="theme-color">
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg1">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg2">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg3">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg4">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg5">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg6">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg7">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg8">&nbsp;</a>
                            <a href="#" class="lpanel-bg" hoe-color-type="lpanel-bg9">&nbsp;</a>
                        </div>
                    </li>
                    <li class="theme-option">
                        <span class="sub-title">Logo Color BG Option</span>
                        <div id="theme-color">
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg1">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg2">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg3">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg4">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg5">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg6">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg7">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg8">&nbsp;</a>
                            <a href="#" class="logo-bg" hoe-color-type="logo-bg9">&nbsp;</a>
                        </div>
                    </li>
                    <li class="theme-option">
                        <span class="sub-title">SideBar Effect</span>
                        <select id="leftpanel-effect" class="form-control minimal input-sm">
                            <option name="lpanel-effect" value="shrink">Default</option>
                            <option name="lpanel-effect" value="overlay">Overlay</option>
                            <option name="lpanel-effect" value="push">Push</option>
                        </select>
                    </li>
					<li class="theme-option">
                        <span class="sub-title">Navigation Type</span>
                        <select id="navigation-type" class="form-control minimal input-sm">
                            <option name="navigation-type" value="vertical-compact">Vertical Compact</option>
							<option name="navigation-type" value="vertical">Vertical</option>
                            <option name="navigation-type" value="horizontal">Horizontal</option>
							<option name="navigation-type" value="horizontal-compact">Horizontal compact</option>
                        </select>
                    </li>
					<li class="theme-option">
                        <span class="sub-title">Navigation Side</span>
                        <select id="navigation-side" class="form-control minimal input-sm">
                            <option name="navigation-side" value="leftside">Left</option>
							<option name="navigation-side" value="rightside">Right</option>
                        </select>
                    </li>
                    <li class="theme-option">
                        <span class="sub-title">Sidebar Position</span>
                        <select id="sidebar-position" class="form-control minimal input-sm">
                            <option name="sidebar-position" value="fixed">Fixed</option>
                            <option name="sidebar-position" value="default">Default</option>
                        </select>
                    </li>
                </ul>
            </div>         
               
            </div> 
        </div>
    </div>
    -->

<!-- Footer -->
<div id="footer">
<p>
<a href="http://<?php echo __('vamshop.com'); ?>/"><?php echo __('Powered by'); ?></a> <a href="http://<?php echo __('vamshop.com'); ?>/"><?php echo __('VamShop'); ?></a>
</p>
</div>
<!-- /Footer -->

</body>
</html>