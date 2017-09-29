<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Html->script(array(
	'jquery/plugins/jqplot/jquery.jqplot.js',
	'jquery/plugins/jqplot/plugins/jqplot.highlighter.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.canvasTextRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.dateAxisRenderer.min.js'
), array('inline' => false));

echo $this->Html->css(array(
	'jquery/plugins/jqplot/jquery.jqplot.min.css',
), null, array('inline' => true));

if($level == 1) {
if ($result) {
echo $this->Html->scriptBlock('
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = ['.implode(",",$result['day']['jq_plot_summ']).'];
        var l2 = ['.implode(",",$result['day']['jq_plot_cnt']).'];

        var plot1 = $.jqplot("chart1", [l1, l2],  {
          animate: true,
          animateReplot: true,         	
          title: "'.__('Sales Report', true).': '.__('day', true).'",
          legend:{show:true,location:"se",labels:["'.__('Total', true).'","'.__('Number of Orders', true).'"]},
          series:[
          {color:"#0077cc"},
          {yaxis:"y2axis",color:"#ff9900"} 
          ],
          axesDefaults:{padMin: 1.5,useSeriesColor:true, rendererOptions: { alignTicks: true}},

      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          tickInterval: "1 day",

          tickOptions: {
              formatString: "%m/%d"
          }
           
        },
        y2axis: {
          tickOptions: {
              formatString: "%01.0f"
          }
           
        }
      },

          highlighter: {
          show: true,
          sizeAdjust: 7.5,
          tooltipLocation: "ne"
          },
          
          cursor: {
          show: false
          }          
        });

$(\'a[href="#sales"]\').on(\'shown\', function(e) {
            if (plot1._drawCount === 0) {
                plot1.replot();
            }
});

});
', array('allowCache'=>false,'safe'=>false,'inline'=>false));
}
}

if($level == 1) {
if ($result) {
echo $this->Html->scriptBlock('
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = ['.implode(",",$result['month']['jq_plot_summ']).'];
        var l2 = ['.implode(",",$result['month']['jq_plot_cnt']).'];

        var plot2 = $.jqplot("chart2", [l1, l2],  {
          animate: true,
          animateReplot: true,         	
          title: "'.__('Sales Report', true).': '.__('month', true).'",
          legend:{show:true,location:"se",labels:["'.__('Total', true).'","'.__('Number of Orders', true).'"]},
          
          series:[
          {color:"#0077cc"},
          {yaxis:"y2axis",color:"#ff9900"} 
          ],
          axesDefaults:{padMin: 1.5,useSeriesColor:true, rendererOptions: { alignTicks: true}},

      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          tickInterval: "1 month",

          tickOptions: {
              formatString: "%Y/%m"
          }
           
        },
        y2axis: {
          tickOptions: {
              formatString: "%01.0f"
          }
           
        }
      },

          highlighter: {
          show: true,
          sizeAdjust: 7.5,
          tooltipLocation: "ne"
          },
          
          cursor: {
          show: false
          }          
        });

$(\'a[href="#sales"]\').on(\'shown\', function(e) {
            if (plot2._drawCount === 0) {
                plot2.replot();
            }
});

});
', array('allowCache'=>false,'safe'=>false,'inline'=>false));
}
}

	echo $this->admin->ShowPageHeaderStart();


		// SimplePie instance
		$feed = new SimplePie();

		// We'll process this feed with all of the default options.
		$url = array(CheckServer.'feed/'.$_SERVER['HTTP_HOST'], 'http://support.'.__('vamshop.com',true).'/modules/news/backendt.php?topicid=2');
		
		// Set which feed to process.
		$feed->set_cache_location(CACHE);
		 
		// Set which feed to process.
		$feed->set_feed_url($url);
		
		// Run SimplePie.
		$feed->init();
		
		$feed->handle_content_type();
		
			echo '<div class="rssFeed" id="news">';
		   echo '<ul>';
		
			foreach ($feed->get_items(0,1) as $item) {
				echo '<li class="rssRow">';
				echo '<h3><strong><a href="' . $item->get_permalink() .'" target="_blank">' . $item->get_title() .'</a></strong></h3>';
				echo '<p>' . CakeText::truncate($item->get_description(),200,array('html' => true)) . '</p>';
				echo '</li>';
		 
			}
			
			echo '</ul>';
			echo '</div>';	

	if($level == 1) {


	echo '<br />

			<div class="row-fluid">
			<div class="col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-cart"></i> '.__('Quick links').'</h3>
			  </div>
			  <div class="panel-body text-left">
			'.$this->Admin->linkButton(__('New Order'),'/orders_edit/admin/','cus-cart-add',array('escape' => false, 'class' => 'btn btn-default')).'
			'.$this->Admin->linkButton(__('All Orders'),'/orders/admin/','cus-cart-go',array('escape' => false, 'class' => 'btn btn-default')).'
			'.$this->Admin->linkButton(__('Categories/Products'),'/contents/admin/','cus-book-add',array('escape' => false, 'class' => 'btn btn-default')).'
			'.$this->Admin->linkButton(__('Reset Cache'),'/configuration/admin_clear_cache/','cus-arrow-refresh-small',array('escape' => false, 'class' => 'btn btn-default')).'
			  </div>
			</div>
			</div>
			</div>
			
			<div class="clear"></div>
			
			<div class="row-fluid">
			<div class="col-sm-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-cart"></i> '.__('Total Orders').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$total_orders.(($pending_orders > 0) ? ' <sup><span title="'.__('Pending Orders').': '.$pending_orders.'" class="badge"> '.$this->Html->link($pending_orders,'/orders/admin/').' </span></sup>' : '').'</h4>
			  </div>
			</div>
			</div>
			<div class="col-sm-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-calculator"></i> '.__('Average Order').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$average_order.'</h4>
			  </div>
			</div>
			</div>
			<div class="col-sm-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-report"></i> '.__('Total Sales').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$total_sales.'</h4>
			  </div>
			</div>
			</div>
			<div class="col-sm-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-user"></i> '.__('Total Customers').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$total_customers.'</h4>
			  </div>
			</div>
			</div>
			<div class="clear"></div>
		';

	echo '<div class="row-fluid">';
	echo '<div class="col-sm-5">';

	}

			echo '<ul id="myTab" class="nav nav-tabs">';
			if($level == 1) {
			echo $this->admin->CreateTab('orders',__('Orders',true), 'cus-cart');
			echo $this->admin->CreateTab('top',__('Top Products',true), 'cus-chart-pie');
			} else {
			echo $this->admin->CreateTab('home',__('Menu',true), 'cus-chart-organisation');
			}
			echo '</ul>';

	echo $this->admin->StartTabs();
	
		if($level == 1) {

		echo $this->admin->StartTabContent('orders');

			echo '<table class="contentTable">';
			
			echo $this->Html->tableHeaders(array(__('Customer'),__('Order Number'),__('Total'), __('Date'), __('Status'), __('Action')));
			
			foreach ($data AS $order)
			{
				echo $this->Admin->TableCells(
					  array(
							$this->Html->link($order['Order']['bill_name'],'/orders/admin_view/' . $order['Order']['id']),
							$order['Order']['id'],
							$order['Order']['total'],
							$this->Time->i18nFormat($order['Order']['created'], "%e %b %Y, %H:%M"),
							$order_status_list[$order['OrderStatus']['id']],
							array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')).$this->Admin->ActionButton('edit','/orders_edit/admin/edit/' . $order['Order']['id'],__('Edit')), array('align'=>'center'))
					   ), ($order['OrderStatus']['id'] == 1 ? 'highlight' : null), ($order['OrderStatus']['id'] == 1 ? 'highlight' : null));
					   	
			}
			echo '</table>';

		echo $this->admin->EndTabContent();
				
                echo $this->admin->StartTabContent('top');
                
                    echo '<table class="orderTable"><tr><td>';
                        echo '<table class="contentTable"><tr><td colspan="3">';
                        echo __('Top 10 Ordered');
                        echo $this->Html->tableHeaders(array( __('Image'), __('Name'),  __('Ordered')));
                        if ($top_products) {
                        foreach ($top_products AS $k => $ordered)
                        {
                        	
								// Content Image
								
								if($ordered['ContentImage']['image'] != "") {
									$image_url = $ordered['Content']['id'] . '/' . $ordered['ContentImage']['image'] . '/40';
									$thumb_name = substr_replace($ordered['ContentImage']['image'] , '', strrpos($ordered['ContentImage']['image'] , '.')).'-40.png';	
									$thumb_path = IMAGES . 'content' . '/' . $ordered['Content']['id'] . '/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$image =  $thumb_url;
											$image_width = $width;
											$image_height = $height;
										} else {
											$image = BASE . '/images/thumb/' . $image_url;
											$image_width = null;
											$image_height = null;
										}
					
								} else { 
					
									$image_url = 'noimage.png/40';
									$thumb_name = 'noimage-40.png';	
									$thumb_path = IMAGES . 'content/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$image =  $thumb_url;
											$image_width = $width;
											$image_height = $height;
										} else {
											$image = BASE . '/images/thumb/' . $image_url;
											$image_width = null;
											$image_height = null;
										}
					
								}
								                        	
                            echo $this->Admin->TableCells(array(
                                                                $this->Html->image($image, array('alt' => __('True'),'width' => $image_width,'height' => $image_height))                                                               
                                                                ,$ordered['ContentDescription']['name']
                                                               ,array($ordered['ContentProduct']['ordered'],array('height' => '40'))
                                                               ));
                        }
                        }
                   echo '</td></tr></table>';
                    echo '</td></tr></table>';
                    
                echo $this->admin->EndTabContent();

		} else {
		
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
							<p class="heading">' . $this->admin->MenuLink($nav, array('escape' => false)) . '</p>';
					if(!empty($nav['children']))
					{
						$sub_items = '';
						foreach($nav['children'] AS $child)
						{
							$sub_items .= $this->admin->MenuLink($child, array('escape' => false)) . ', ';
						}
						$sub_items = rtrim($sub_items, ', ');
						echo $sub_items;
					}
					echo '</div>';
				}
			}

		echo $this->admin->EndTabContent();
		
	}
		
	echo $this->admin->EndTabs();

	echo '</div>';
	
	if($level == 1) {

	echo '<div class="col-sm-5">';

			echo '<ul id="myTabSales" class="nav nav-tabs">';
			echo $this->admin->CreateTab('sales',__('Sales Report',true), 'cus-chart-bar');
			echo '</ul>';

	echo $this->admin->StartTabs();
	
		//echo $this->admin->StartTabContent('sales');

		echo '<div id="charts">';
		echo '<div id="chart1"></div>';
		echo '<div id="chart2"></div>';
		echo '</div>';
			
		//echo $this->admin->EndTabContent();

	echo $this->admin->EndTabs();

	echo '</div>';	


	echo '<div class="col-sm-2">';

			echo '<ul id="myTabNews" class="nav nav-tabs">';
			echo $this->admin->CreateTab('vamshop-news',__('VamShop News',true), 'cus-newspaper');
			echo '</ul>';

		echo $this->admin->StartTabs('rss-news');
	
		echo $this->admin->StartTabContent('vamshop-news');

		// SimplePie instance
		$feed = new SimplePie();
		
		// We'll process this feed with all of the default options.
		$url = 'http://support.'.__('vamshop.com',true).'/modules/news/backendt.php?topicid=1';
		
		// Set which feed to process.
		$feed->set_cache_location(CACHE);
		 
		// Set which feed to process.
		$feed->set_feed_url($url);
		
		// Run SimplePie.
		$feed->init();
		
		$feed->handle_content_type();
		
			echo '<div id="vamshop-rss">';
		   echo '<ul>';
		
			foreach ($feed->get_items(0,5) as $item) {
				echo '<li class="item">';
				echo '<h3><a href="' . $item->get_permalink() .'" target="_blank">' . $item->get_title() .'</a></h3>';
				echo '<p>' . CakeText::truncate($item->get_description(),90,array('html' => true)) . '</p>';
				echo '</li>';
		 
			}
			
			echo '</ul>';
			echo '</div>';	
				
		echo $this->admin->EndTabContent();

	echo $this->admin->EndTabs();			

	echo '</div>';


	}

	echo $this->admin->ShowPageHeaderEnd();