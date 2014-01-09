<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('AppHelper', 'Helper');

class SmartyHelper extends AppHelper 
{
	public function load_smarty ()
	{
            App::uses('SmartyComponent', 'Controller/Component');
            $smarty =& new SmartyComponent(new ComponentCollection());       
            return $smarty;
	}

	public function display($str, $assigns = array())
	{
            $smarty = $this->load_smarty();
            $smarty->display($str, $assigns);
	}
}

?>