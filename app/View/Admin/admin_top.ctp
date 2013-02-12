<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'jquery/plugins/jquery-ui-min.js',
	'jquery/plugins/jquery.zrssfeed.min.js',
	'tabs.js'
), array('inline' => false));
?>
<?php echo $this->Html->scriptBlock('
$(document).ready(function () {
	$("#news").rssfeed("http://vamcart.com/modules/news/backendt.php?topicid=2", {
		header: false,
		date: false,
		content: false,
		limit: 1,
	});
});', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php
	echo $this->Html->css('ui.tabs', null, array('inline' => false));
	
	echo $this->admin->ShowPageHeaderStart(__('Home',true), 'home.png');

	echo '<div id="news"></div>';

	echo $this->admin->StartTabs();
			echo '<ul>';
			echo $this->admin->CreateTab('home',__('Menu',true), 'menu.png');
			echo $this->admin->CreateTab('orders',__('Orders',true), 'orders.png');			
			echo '</ul>';
	
	echo $this->admin->StartTabContent('home');

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
							<p class="heading">' . $this->admin->MenuLink($nav) . '</p>';
					if(!empty($nav['children']))
					{
						$sub_items = '';
						foreach($nav['children'] AS $child)
						{
							$sub_items .= $this->admin->MenuLink($child) . ', ';
						}
						$sub_items = rtrim($sub_items, ', ');
						echo $sub_items;
					}
					echo '</div>';
				}
			}

		echo $this->admin->EndTabContent();

		echo $this->admin->StartTabContent('orders');

			echo $this->flashChart->begin(); 

			$this->flashChart->setTitle(__('Orders', true),'{color:#000;font-size:18px;}');
			$this->flashChart->setData(array(1,2,4,8,16,32,45,54,68,82),'{n}',false,'Apples');		
			$this->flashChart->setData(array(3,4,6,9,13,18,24,31,39,48),'{n}',false,'Oranges');
			$this->flashChart->axis('y',array('range' => array(0,100,10)));
			echo $this->flashChart->chart('bar',array('colour'=>'#ff9900'),'Apples');
			echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'2'),'Oranges');	
			echo $this->flashChart->render('100%','300');
	
		echo $this->admin->EndTabContent();

	echo $this->admin->EndTabs();
	
	echo $this->admin->ShowPageHeaderEnd();
	
?>