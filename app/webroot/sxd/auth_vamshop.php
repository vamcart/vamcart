<?php
  $path = '../../../config.php';
  include $path;

  if (isset($_GET['sid'])) {
    session_name($_GET['sid']);
    session_start();
    if (isset($_SESSION['User']['username'])) {
      $conf = new DATABASE_CONFIG();
      $this->CFG['host'] = $conf->default['host'];
      $this->CFG['my_db'] = $conf->default['database'];
      $this->CFG['my_user'] = $conf->default['login'];
      $this->CFG['my_pass'] = $conf->default['password'];
      $this->CFG['exitURL'] = '../admin/admin_top/';
      $auth = 1;
    } else {
      $auth = 0;
    }
  } else {
    $auth = 0;
  }