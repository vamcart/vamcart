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

 $flashChart->setTitle(__('Orders', true),'{color:#000;font-size:18px;}');
 $flashChart->setData(array(1,2,4,8),'{n}',false,'Apples');		
 $flashChart->setData(array(3,4,6,9),'{n}',false,'Oranges');
 echo $flashChart->chart('bar',array('colour'=>'#ff9900'),'Apples');
 echo $flashChart->chart('line',array('colour'=>'#0077cc'),'Oranges');	
 echo $flashChart->render('100%','300');
 
?>