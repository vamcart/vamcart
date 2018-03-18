<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class TranslitComponent extends CakeObject 
{

	public function beforeFilter ()
	{
	}

	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}

	public function beforeRender(Controller $controller){
	}
	
	public function beforeRedirect(Controller $controller, $url, $status = NULL, $exit = true){
	}
	
	public function convert ($alias)
	{

		//Replace cyrillic symbols to translit
		$trdic = array(
		"ё"=>"jo",
		"ж"=>"zh",
		"ф"=>"ph",
		"х"=>"kh",
		"ц"=>"ts",
		"ч"=>"ch",
		"ш"=>"sh",
		"щ"=>"sch",
		"э"=>"je",
		"ю"=>"ju",
		"я"=>"ja",
		
		"а"=>"a",
		"б"=>"b",
		"в"=>"v",
		"г"=>"g",
		"д"=>"d",
		"е"=>"e",
		"з"=>"z",
		"и"=>"i",
		"й"=>"j",
		"к"=>"k",
		"л"=>"l",
		"м"=>"m",
		"н"=>"n",
		"о"=>"o",
		"п"=>"p",
		"р"=>"r",
		"с"=>"s",
		"т"=>"t",
		"у"=>"u",
		"х"=>"h",
		"ц"=>"c",
		"ы"=>"y",
		
		"Ё"=>"E",
		"Ж"=>"ZH",
		"Ф"=>"PH",
		"Х"=>"KH",
		"Ц"=>"TS",
		"Ч"=>"CH",
		"Ш"=>"SH",
		"Щ"=>"SCH",
		"Э"=>"JE",
		"Ю"=>"JU",
		"Я"=>"JA",
		
		"А"=>"A",
		"Б"=>"B",
		"В"=>"V",
		"Г"=>"G",
		"Д"=>"D",
		"Е"=>"E",
		"З"=>"Z",
		"И"=>"I",
		"Й"=>"J",
		"К"=>"K",
		"Л"=>"L",
		"М"=>"M",
		"Н"=>"N",
		
		"О"=>"O",
		"П"=>"P",
		"Р"=>"R",
		"С"=>"S",
		"Т"=>"T",
		"У"=>"U",
		"Х"=>"H",
		"Ц"=>"C",
		"Ы"=>"Y",
		
		// -----------------------
		"Ъ" => "",
		"Ь" => "",
		"ъ" => "",
		"ь" => ""
		);			

		$alias = strtr(stripslashes($alias), $trdic);

		return $alias;
	}
	
}
?>