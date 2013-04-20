<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css(array(
										'admin',
										'normalize.css',
										'bootstrap/bootstrap.css',
										'bootstrap/cus-icons.css',
										'bootstrap/bootstrap-responsive.css',
											), null, array('inline' => true)); ?>

<?php echo $this->Html->script(array(
											'jquery/jquery.min.js',
											'bootstrap/bootstrap.min.js'
												),
											array('inline' => true)); ?>
<?php echo $this->Html->scriptBlock('
//<![CDATA[
$(document).ready(function () {$(\'[rel=tooltip],input[data-title]\').tooltip();});
//]]>
', array('allowCache'=>false,'safe'=>false,'inline'=>true)); ?>			
								
<?php echo $scripts_for_layout; ?>
</head>

<body>
<!-- Container -->
<div id="container">

<!-- Header -->
<div id="header">
<div class="header-left">
<?php echo $this->Html->link($this->Html->image('admin/logo.png', array('alt' => __('VamCart',true))), '/admin/admin_top/', array('escape'=>false));?>
</div>
<div class="header-right">
<?php 
echo $this->form->create('Search', array('action' => '/search/admin_global_search/', 'url' => '/search/admin_global_search/'));
echo $this->form->input('Search.term',array('label' => __('Search',true),'value' => __('Global Record Search',true),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
echo $this->form->submit( __('Submit', true));
echo $this->form->end();
?>
<?php echo $this->admin->getHelpPage(); ?>
</div>
<div class="clear"></div>
</div>
<!-- /Header -->

<div id="menu">
<?php echo $this->admin->DrawMenu($navigation); ?>
</div>
 
<!-- Navigation -->
<div id="navigation">
<?php
if(isset($current_crumb)) { 
?>
<div class="breadCrumbs">
<?php
echo $this->admin->GenerateBreadcrumbs($navigation, $current_crumb);
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

<?php if($this->Session->check('Message.flash')) echo $this->Session->flash(); ?>

<?php echo $this->fetch('content'); ?>

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
<a href="http://vamcart.com/"><?php echo __('PHP Shopping Cart') ?></a> <a href="http://vamcart.com/"><?php echo __('VamCart') ?></a>
</p>
</div>
<!-- /Footer -->

</div>
<!-- /Container -->

</body>
</html>