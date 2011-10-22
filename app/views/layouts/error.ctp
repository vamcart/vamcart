<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<?php echo $html->css('admin', null, array('inline' => false)); ?>
<?php echo $html->script(array('jquery/jquery.min.js'), array('inline' => false)); ?>
<?php echo $asset->scripts_for_layout(); ?>
<title><?php echo $title_for_layout; ?></title>
</head>

<body>
<!-- Container -->
<div id="container">

<!-- Header -->
<div id="header">
<?php echo $html->image('admin/logo.png', array('alt' => __('VamCart',true)))?>
</div>
<!-- /Header -->

<div id="menu">
&nbsp;
</div>

<!-- Content -->
<div id="wrapper">
<div id="content">

<?php if($session->check('Message.flash')) echo $session->flash(); ?>

<?php echo $content_for_layout; ?>

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
<a href="http://vamcart.com/"><?php __('PHP Shopping Cart') ?></a> <a href="http://vamcart.com/"><?php __('VamCart') ?></a>
</p>
</div>
<!-- /Footer -->

</div>
<!-- /Container -->
</body>
</html>