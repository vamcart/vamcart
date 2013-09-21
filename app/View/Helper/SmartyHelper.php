<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
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