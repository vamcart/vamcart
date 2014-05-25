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

echo $this->Html->scriptBlock('
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = ['.implode(",",$result['jq_plot_summ']).'];
        var l2 = ['.implode(",",$result['jq_plot_cnt']).'];

        var plot1 = $.jqplot("report", [l1, l2],  {
          animate: true,
          animateReplot: true,         	
          title: "'.__('Sales Report', true).': '.__($period, true).'",
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
          tickInterval: "1 '.$period.'",

          tickOptions: {
              formatString: "'.$format.'"
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

$(\'a[href="#chart"]\').on(\'shown\', function(e) {
            if (plot1._drawCount === 0) {
                plot1.replot();
            }
});

});
', array('allowCache'=>false,'safe'=>false,'inline'=>false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-chart-curve');

echo '<table class="orderTable">';
    echo '<tr>';
    echo '<td align="right">'
        .$this->Html->link(__('hour',true),'/reports/admin_change_date/hour')
        .' | '.$this->Html->link(__('day',true),'/reports/admin_change_date/day')
        .' | '.$this->Html->link(__('week',true),'/reports/admin_change_date/week')
        .' | '.$this->Html->link(__('month',true),'/reports/admin_change_date/month')
        .' | '.$this->Html->link(__('year',true),'/reports/admin_change_date/year')
        .'</td>';
    echo '</tr>';
echo '</table>';

echo '<ul id="myTab" class="nav nav-tabs">';
        
	echo $this->admin->CreateTab('chart',__('Chart',true), 'cus-chart-curve');
        echo $this->admin->CreateTab('table',__('Table',true), 'cus-table');
	echo $this->admin->CreateTab('options',__('Order Status',true), 'cus-cart-edit');

echo '</ul>';

echo $this->admin->StartTabs();

    echo $this->admin->StartTabContent('chart');

		echo '<div id="report"></div>';

    echo $this->admin->EndTabContent();
   
    echo $this->admin->StartTabContent('table');
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array( __('Date'), __('Number of Orders'),  __('Average Sum'), __('Total')));
    $summ = array('Average Sum' => 0
                ,'Total' => 0 );
    if(isset($result['dat']))
    {
        foreach ($result['dat'] AS $k => $dat)
        {
            echo $this->Admin->TableCells(array($dat,$result['cnt'][$k],round($result['summ'][$k]/$result['cnt'][$k],2),$result['summ'][$k]));
        }
        $summ['Total'] = array_sum($result['summ']);
        $summ['Average Sum'] = round(array_sum($result['summ'])/array_sum($result['cnt']),2);
    }
    echo '</table>';
    
    echo '<table class="orderTable">';
    foreach ($summ AS $k => $sum)
    {
        echo '<tr><td align="right"><b>'.__($k).' ('.__($period, true).'): '.$sum.'</b></td></tr>';
    }
    echo '</table>';
    
    echo $this->admin->EndTabContent();
        
    echo $this->admin->StartTabContent('options');
    echo '<table class="orderTable">';
    echo $this->Html->tableHeaders(array( __('Status'), __('Value')),null,array('align'=>'left'));
    foreach ($statuses AS $k => $status)
    {   
        echo $this->Admin->TableCells(array(
              $status['OrderStatusDescription']['name']
             ,array($this->Html->link(($status['OrderStatus']['default'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False')))), '/reports/admin_change_active_status/' . $k, array('escape' => false)), array('align'=>'left')),
             ));
    }
    echo '</table>';
    echo $this->admin->EndTabContent();

    echo $this->admin->EndTabs();
        
echo $this->Admin->ShowPageHeaderEnd();