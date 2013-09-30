<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

 App::uses('ExceptionRenderer', 'Error');

 class MyExceptionRenderer extends ExceptionRenderer 
 {
  protected function _outputMessage($template) {
    $this->controller->layout = 'error';
    parent::_outputMessage($template);
  }
 }