<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
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
<?php echo $html->css('admin'); ?>
<title><?php __('VaM Cart') ?></title>
</head>

<body>
<!-- Container -->
<div id="container">

<!-- Header -->
<div id="header">
<?php echo $html->image('admin/logo.png', array('alt' => __('VaM Cart',true)))?>
</div>
<!-- /Header -->

<div id="menu">
&nbsp;
</div>

<!-- Navigation -->
<div id="navigation">
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
<a href="http://vamcart.com/"><?php __('PHP Shopping Cart') ?></a>: <a href="http://vamcart.com/"><?php __('VaM Cart') ?></a>
</p>
</div>
<!-- /Footer -->

</div>
<!-- /Container -->
</body>
</html>