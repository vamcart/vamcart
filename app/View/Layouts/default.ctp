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

<div class="container-fluid">

<!-- Header -->
<div class="row-fluid">
	<div class="span4">
		<?php echo $this->Html->image('admin/logo.png', array('alt' => __('VamShop',true)))?>
	</div>
</div>
<!-- /Header -->

	<div class="row-fluid">
		<div class="span12">

<!-- Content -->
<div id="wrapper">
<div id="content">

<?php if($this->Session->check('Message.flash')) echo $this->Session->flash(); ?>

<?php echo $this->fetch('content'); ?>

</div>
</div>
<!-- /Content -->

<!-- Footer -->
<div id="footer">
<p>
<a href="http://<?php echo __('vamshop.com'); ?>/"><?php echo __('Powered by'); ?></a> <a href="http://<?php echo __('vamshop.com'); ?>/"><?php echo __('VamShop'); ?></a>
</p>
</div>
<!-- /Footer -->

		</div>
	</div>
	
</div>

</body>
</html>