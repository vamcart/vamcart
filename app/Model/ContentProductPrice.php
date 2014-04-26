<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Model', 'AppModel');
class ContentProductPrice extends AppModel {
	public $name = 'ContentProductPrice';
	public $belongsTo = array('ContentProduct');

}
