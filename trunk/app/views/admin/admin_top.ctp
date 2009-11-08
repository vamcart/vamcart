<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

 echo $flashChart->begin(); 

 $flashChart->setTitle('Тест');
 $flashChart->setData(array(1,2,4,8),'{n}',false,'Apples','dig');		
 $flashChart->setData(array(3,4,6,9),'{n}',false,'Oranges','dig');
 echo $flashChart->chart('bar',array('colour'=>'#ff9900'),'Apples','dig');
 echo $flashChart->chart('line',array('colour'=>'#0077cc'),'Oranges','dig');	
 echo $flashChart->render('100%','300','dig');
 
?>