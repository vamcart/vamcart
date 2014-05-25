<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'jquery/plugins/jquery.zrssfeed.min.js',
	'jquery/plugins/jqplot/jquery.jqplot.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.highlighter.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.cursor.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.dateAxisRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.canvasTextRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.barRenderer.min.js',
	'jquery/plugins/jqplot/plugins/jqplot.dateAxisRenderer.min.js'
), array('inline' => false));
?>
<?php echo $this->Html->css(array(
										'jquery/plugins/jqplot/jquery.jqplot.min.css',
											), null, array('inline' => true)); ?>

<?php echo $this->Html->scriptBlock('
$(document).ready(function () {
	$("#news").rssfeed("http://support.'.__('vamshop.com',true).'/modules/news/backendt.php?topicid=2", {
		header: false,
		date: false,
		content: false,
		limit: 1,
	});
});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>

<?php echo $this->Html->scriptBlock('
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = ['.implode(",",$result['day']['jq_plot_summ']).'];
        var l2 = ['.implode(",",$result['day']['jq_plot_cnt']).'];

        var plot1 = $.jqplot("chart1", [l1, l2],  {
          animate: true,
          animateReplot: true,         	
          title: "'.__('Sales Report', true).': '.__('day', true).'",
          legend:{show:true,labels:["'.__('Total', true).'","'.__('Number of Orders', true).'"]},
          series:[
          {},
          {yaxis:"y2axis"}, 
          {yaxis:"y3axis"},
          ],
          axesDefaults:{padMin: 1.5,useSeriesColor:true, rendererOptions: { alignTicks: true}},

      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,

          tickOptions: {
              // labelPosition: "middle",
              angle: 15
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

$(\'a[href="#chart"]\').on(\'shown\', function(e) {
            if (plot1._drawCount === 0) {
                plot1.replot();
            }
});

});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>

<?php echo $this->Html->scriptBlock('
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = ['.implode(",",$result['month']['jq_plot_summ']).'];
        var l2 = ['.implode(",",$result['month']['jq_plot_cnt']).'];

        var plot2 = $.jqplot("chart2", [l1, l2],  {
          animate: true,
          animateReplot: true,         	
          title: "'.__('Sales Report', true).': '.__('month', true).'",
          legend:{show:true,labels:["'.__('Total', true).'","'.__('Number of Orders', true).'"]},
          series:[
          {},
          {yaxis:"y2axis"}, 
          {yaxis:"y3axis"},
          ],
          axesDefaults:{padMin: 1.5,useSeriesColor:true, rendererOptions: { alignTicks: true}},

      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,

          tickOptions: {
              // labelPosition: "middle",
              angle: 15,
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

$(\'a[href="#chart"]\').on(\'shown\', function(e) {
            if (plot2._drawCount === 0) {
                plot2.replot();
            }
});

});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>

<?php
	echo $this->admin->ShowPageHeaderStart(__('Dashboard',true), 'cus-house');

	echo '<div id="news"></div>';

			echo '<ul id="myTab" class="nav nav-tabs">';
			if($level == 1) {
			echo $this->admin->CreateTab('orders',__('Orders',true), 'cus-cart');
			echo $this->admin->CreateTab('sales',__('Sales Report',true), 'cus-chart-bar');
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
							$order['OrderStatus']['OrderStatusDescription']['name'],
							array($this->Admin->ActionButton('view','/orders/admin_view/' . $order['Order']['id'],__('View')).$this->Admin->ActionButton('edit','/orders_edit/admin/edit/' . $order['Order']['id'],__('Edit')), array('align'=>'center'))
					   ));
					   	
			}
			echo '</table>';

		echo $this->admin->EndTabContent();
				
		echo $this->admin->StartTabContent('sales');
?>


<?php

echo '<div id="charts">';
echo '<div id="chart1"></div>';
echo '<div id="chart2"></div>';
echo '</div>';

?>

<?php
                echo $this->flashChart->begin(); 
                if(isset($result['day']['dat']))
                {
                    $this->flashChart->setData($result['day']['summ'],'{n}',false,'Sum_1','stat_day');		
                    $this->flashChart->setData($result['day']['cnt'],'{n}',false,'Count_1','stat_day');              
                } 
                else $this->flashChart->setData(array('0'),'{n}',false,'null','stat_day');
                if(isset($result['month']['dat']))
                {
                    $this->flashChart->setData($result['month']['summ'],'{n}',false,'Sum_2','stat_month');		
                    $this->flashChart->setData($result['month']['cnt'],'{n}',false,'Count_2','stat_month');
                }
                else $this->flashChart->setData(array('0'),'{n}',false,'null','stat_month'); 
                
                echo '<table class="contentTable"><tr><td><div id="stat_day">';
			
			$this->flashChart->setTitle(__('Sales Report', true).': '.__('day', true),'{color:#000;font-size:18px;}');
			$this->flashChart->axis('x',array('labels' => $result['day']['dat']),array('vertical' => true));
                        $this->flashChart->axis('y',array('range' => array(0,max($result['day']['summ']),max($result['day']['summ'])/10), 'colour'=>'#0077cc'));
                        $this->flashChart->rightAxis(array('range' => array(0,max($result['day']['cnt']),max($result['day']['cnt'])/10), 'colour'=>'#ff9900'));
			if(isset($result['day']['dat']))
                        {
                            echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'3','line_style' => 'solid-dot','set_key' => array(__('Total', true),14)),'Sum_1','stat_day');
                            echo $this->flashChart->chart('line',array('colour'=>'#ff9900','width'=>'3','right' => 'true','set_key' => array(__('Number of Orders', true),14)),'Count_1','stat_day');	
                        }
                        else echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'2'),'null','stat_day');
			echo $this->flashChart->render('100%','300','stat_day','stat_day');
                        
                echo '</div></td><td><div id="stat_month">';                       
			
                        $this->flashChart->setTitle(__('Sales Report', true).': '.__('month', true),'{color:#000;font-size:18px;}');
                        $this->flashChart->axis('x',array('labels' => $result['month']['dat']),array('vertical' => true));
                        $this->flashChart->axis('y',array('range' => array(0,max($result['month']['cnt']),max($result['month']['cnt'])/10), 'colour'=>'#ff9900'));
                        $this->flashChart->rightAxis(array('range' => array(0,max($result['month']['summ']),max($result['month']['summ'])/10), 'colour'=>'#0077cc'));
                        if(isset($result['month']['dat']))
                        {
                            echo $this->flashChart->chart('bar',array('colour'=>'#ff9900','set_key' => array(__('Number of Orders', true),14)),'Count_2','stat_month');
                            echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'3','line_style' => 'solid-dot','right' => 'true','set_key' => array(__('Total', true),14)),'Sum_2','stat_month');	
                        } 
                        else echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'2'),'null','stat_month');
			echo $this->flashChart->render('100%','300','stat_month','stat_month');
                echo '</div></td></tr></table>';
                
		echo $this->admin->EndTabContent();
                                
                echo $this->admin->StartTabContent('top');
                
                    echo '<table class="orderTable"><tr><td>';
                        echo '<table class="contentTable"><tr><td colspan="3">';
                        echo __('Top 10 Ordered');
                        echo $this->Html->tableHeaders(array( __('Image'), __('Name'),  __('Ordered')));
                        foreach ($result['content_ordered'] AS $k => $ordered)
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
	
	echo $this->admin->ShowPageHeaderEnd();