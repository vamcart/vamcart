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
<title><?php echo $title_for_layout; ?></title>
</head>

<body>
<?php echo $this->fetch('content'); ?>
</body>
</html>