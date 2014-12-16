<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Html->script(array(
	'jquery/plugins/jquery.zrssfeed.min.js',
	'jquery/plugins/jqplot/jquery.jqplot.js',
	'jquery/plugins/jqplot/plugins/jqplot.highlighter.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.canvasTextRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.dateAxisRenderer.min.js'
), array('inline' => false));

echo $this->Html->css(array(
	'jquery/plugins/jqplot/jquery.jqplot.min.css',
), null, array('inline' => true));

echo $this->Html->scriptBlock('
$(document).ready(function () {
	$("#news").rssfeed("http://support.'.__('vamshop.com',true).'/modules/news/backendt.php?topicid=2", {
		header: false,
		date: false,
		content: false,
		linktarget: "_blank",
		limit: 1,
	});

	$("#vamshop-rss").rssfeed("http://support.'.__('vamshop.com',true).'/modules/news/backendt.php?topicid=1", {
		header: false,
		date: true,
		content: true,
		linktarget: "_blank",
		limit: 5,
	});
});
', array('allowCache'=>false,'safe'=>false,'inline'=>false));

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

	echo $this->admin->ShowPageHeaderStart(__('Dashboard',true), 'cus-house');

	echo '<div id="news"></div>';

	echo '<div class="row-fluid">';
	echo '<div class="span5">';

	echo '
			<div class="row-fluid">
			<div class="panel panel-default span4">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-cart"></i> '.__('Total Orders').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$total_orders.(($pending_orders > 0) ? ' <sup><span title="'.__('Pending Orders').': '.$pending_orders.'" class="badge badge-important"> '.$this->Html->link($pending_orders,'/orders/admin/').' </span></sup>' : '').'</h4>
			  </div>
			</div>
			<div class="panel panel-default span4">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-calculator"></i> '.__('Total Sales').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$total_sales.'</h4>
			  </div>
			</div>
			<div class="panel panel-default span4">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="cus-user"></i> '.__('Total Customers').'</h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4>'.$total_customers.'</h4>
			  </div>
			</div>
			</div>
		';

			echo '<ul id="myTab" class="nav nav-tabs">';
			if($level == 1) {
			echo $this->admin->CreateTab('orders',__('Orders',true), 'cus-cart');
			echo $this->admin->CreateTab('top',__('Top Products',true), 'cus-chart-pie');
			}
			echo $this->admin->CreateTab('home',__('Menu',true), 'cus-chart-organisation');
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
							$this->Time->i18nFormat($order['Order']['created']),
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
									$thumb_url = BASE . '/img/content/' . $ordered['Content']['id'] . '/' . $thumb_name;
					
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
					
									$image_url = '0/noimage.png/40';
									$thumb_name = 'noimage-40.png';	
									$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
									$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;
					
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

		}
		
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
		
	echo $this->admin->EndTabs();

	echo '</div>';
	
	echo '<div class="span4">';

			echo '<ul id="myTabSales" class="nav nav-tabs">';
			echo $this->admin->CreateTab('sales',__('Sales Report',true), 'cus-chart-bar');
			echo '</ul>';

	echo $this->admin->StartTabs();
	
		echo $this->admin->StartTabContent('sales');

		echo '<div id="charts">';
		echo '<div id="chart1"></div>';
		echo '<div id="chart2"></div>';
		echo '</div>';
			
		echo $this->admin->EndTabContent();

	echo $this->admin->EndTabs();

	echo '</div>';	

	echo '<div class="span3">';

			echo '<ul id="myTabNews" class="nav nav-tabs">';
			echo $this->admin->CreateTab('vamshop-news',__('VamShop News',true), 'cus-newspaper');
			echo '</ul>';

	echo $this->admin->StartTabs('rss-news');
	
		echo $this->admin->StartTabContent('vamshop-news');

			echo '<div id="vamshop-rss"></div>';
			
		echo $this->admin->EndTabContent();

	echo $this->admin->EndTabs();

	echo '</div>';	
	
	echo '</div>';

	
	echo $this->admin->ShowPageHeaderEnd();