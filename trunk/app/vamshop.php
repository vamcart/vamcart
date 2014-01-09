<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamshop.ru
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamshop.ru/license.html
   ---------------------------------------------------------------------------------------*/
function ioncube_event_handler($err_code,$params) { 
		switch ($err_code) {
			case '6' :
				echo 'License File Not Found. Get New License at <a href="http://vamshop.ru">http://vamshop.ru</a>';
				break;
			case '7' :
				echo 'License File Corrupt. Get New License at <a href="http://vamshop.ru">http://vamshop.ru</a>';
				break;
			case '8' :
				echo 'License Has Expired. Get New License at <a href="http://vamshop.ru">http://vamshop.ru</a>';
				break;
			case '9' :
				echo 'License Invalid. Get New License at <a href="http://vamshop.ru">http://vamshop.ru</a>';
				break;
			case '10' :
				echo 'License Invalid. Get New License at <a href="http://vamshop.ru">http://vamshop.ru</a>';
				break;
			case '11' :
				echo 'License Invalid For This Domain. Get New License at <a href="http://vamshop.ru">http://vamshop.ru</a>';
				break;
		}

} 
