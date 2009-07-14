<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $html->css('admin'); ?>
<title><?php __('VaM Shop') ?></title>
</head>

<body>
<!-- Container -->
<div id="container">

<!-- Header -->
<div id="header">
<img src="/img/logo.gif" alt="<?php __('VaM Shop') ?>" />
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
<a href="http://vamshop.ru/" target="blank"><?php __('Powered by VaM Shop') ?></a>
</p>
</div>
<!-- /Footer -->

</div>
<!-- /Container -->
</body>
</html>