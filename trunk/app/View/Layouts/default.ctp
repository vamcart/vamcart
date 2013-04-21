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
<?php echo $this->Html->image('admin/logo.png', array('alt' => __('VamCart',true)))?>
</div>
<!-- /Header -->

<div id="menu">
&nbsp;
</div>

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