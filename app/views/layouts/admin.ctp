<?php
header('Content-Type: text/html; charset=utf-8'); 
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->meta('icon'); ?> 
<?php echo $html->charset(); ?>
<title><?php __('VaM Shop Admin') ?></title>
<?php echo $javascript->link('jquery/jquery.min');  ?>
<?php echo $javascript->link('jquery/plugins/jquery-ui.min');  ?>
<?php echo $javascript->link('jquery/plugins/jquery.form');  ?>
<?php echo $javascript->link('jquery/plugins/jquery.jeditable');  ?>
<?php echo $javascript->link('admin');  ?>	
<?php echo $html->css('admin');  ?>
<?php echo $html->css('jquery/plugins/ui/css/smoothness/jquery-ui');  ?>
</head>

<body>
<!-- Container -->
<div id="container">

<!-- Header -->
<div id="header">
<div class="header-left">
<?php echo $html->image('admin/logo.png', array('alt' => __('VaM Shop',true)))?>
</div>
<div class="header-right">
<?php 
echo $form->create('Search', array('action' => '/search/admin_global_search/', 'url' => '/search/admin_global_search/'));
echo $form->input('Search.term',array('label' => __('Search',true),'value' => __('Global Record Search',true),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
echo $form->submit( __('Submit', true));
echo $form->end();
?>
</div>
<div class="clear"></div>
</div>
<!-- /Header -->

<div id="menu">
<?php echo $admin->DrawMenu($navigation); ?>
</div>

<!-- Navigation -->
<div id="navigation">
<?php
if(isset($current_crumb)) { 
?>
<div class="breadCrumbs">
<?php
echo $admin->GenerateBreadcrumbs($navigation, $current_crumb);
?>
</div>
<?php
} 
?>
</div>
<!-- /Navigation -->

<!-- Content -->
<div id="wrapper">
<div id="content">

<?php if($session->check('Message.flash')) $session->flash(); ?>

<?php echo $content_for_layout ?>

</div>
</div>
<!-- /Content -->

<!-- Left column -->
<div id="left">
</div>
<!-- /Left column -->

<!-- Right column -->
<div id="right">
</div>
<!-- /Right column -->

<!-- Footer -->
<div id="footer">
<p>
<a href="http://vamshop.ru/" target="blank"><?php __('Powered by VaM Shop') ?></a>
</p>
</div>
<!-- /Footer -->

</div>
<!-- /Container -->
</body>
</html>