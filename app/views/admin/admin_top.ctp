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

	echo $javascript->link('jquery/jquery.min', false);
	echo $javascript->link('jquery/plugins/jquery-ui.min', false);
	echo $javascript->link('tabs', false);
	echo $html->css('jquery/plugins/ui/css/smoothness/jquery-ui','','', false);

	echo $admin->StartTabs();
			echo '<ul>';
			echo $admin->CreateTab('home',__('Home',true));
			echo $admin->CreateTab('orders',__('Orders',true));			
			echo '</ul>';
	
	echo $admin->StartTabContent('home');

			// If we're on the top level then assign the rest of the elements as menu children
			if($level == 1)
			{
				$tmp_navigation = array();
			
				$navigation[1] = null; // Removes the home page from being displayed below
				
				foreach($navigation AS $tmp_nav)
				{
					if(!empty($tmp_nav))
						$tmp_navigation[$level]['children'][] = $tmp_nav;
				}
				$navigation = $tmp_navigation;
			
			}
			
			if(!empty($navigation[$level]['children']))
			{
				$level_navigation = $navigation[$level]['children'];
				foreach($level_navigation AS $nav)
				{
					echo '<div class="page_menu_item" class="">
							<p class="heading">' . $admin->MenuLink($nav) . '</p>';
					if(!empty($nav['children']))
					{
						$sub_items = '';
						foreach($nav['children'] AS $child)
						{
							$sub_items .= $admin->MenuLink($child) . ', ';
						}
						$sub_items = rtrim($sub_items, ', ');
						echo $sub_items;
					}
					echo '</div>';
				}
			}

		echo $admin->EndTabContent();

		echo $admin->StartTabContent('orders');

			echo $flashChart->begin(); 

			$flashChart->setTitle(__('Orders', true),'{color:#000;font-size:18px;}');
			$flashChart->setData(array(1,2,4,8),'{n}',false,'Apples');		
			$flashChart->setData(array(3,4,6,9),'{n}',false,'Oranges');
			echo $flashChart->chart('bar',array('colour'=>'#ff9900'),'Apples');
			echo $flashChart->chart('line',array('colour'=>'#0077cc'),'Oranges');	
			echo $flashChart->render('100%','300');
	
		echo $admin->EndTabContent();

	echo $admin->EndTabs();
	
	
?>