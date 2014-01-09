<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

 App::uses('ExceptionRenderer', 'Error');

 class MyExceptionRenderer extends ExceptionRenderer 
 {
  protected function _outputMessage($template) {
    $this->controller->layout = 'error';
    parent::_outputMessage($template);
  }
 }