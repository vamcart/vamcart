<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css('admin', null, array('inline' => true)); ?>
<?php echo $this->Html->script(array('jquery/jquery.min.js'), array('inline' => true)); ?>
<?php echo $scripts_for_layout; ?>
</head>

<body>
<!-- Container -->
<div id="container">

<!-- Header -->
<div id="header">
<?php echo $this->html->image('admin/logo.png', array('alt' => __('VamCart',true)))?>
</div>
<!-- /Header -->

<div id="menu">
&nbsp;
</div>

<!-- Content -->
<div id="wrapper">
<div id="content">

<?php if($this->session->check('Message.flash')) echo $this->session->flash(); ?>

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