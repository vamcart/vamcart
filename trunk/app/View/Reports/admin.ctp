<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

//var_dump($this->session);

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
    echo '<table class="contentTable">';
          
    echo $this->flashChart->begin(); 
    $this->flashChart->setTitle(__('Sales Report', true).': '.__($period, true),'{color:#000;font-size:18px;}');
    //var_dump($result);
    if(isset($result['dat']))
    {
        $this->flashChart->setData($result['summ'],'{n}',false,'Sum');
        $this->flashChart->setData($result['cnt'],'{n}',false,'Count');
        
        $this->flashChart->axis('x',array('labels' => $result['dat']),array('vertical' => true));
        $this->flashChart->axis('y',array('range' => array(0,max($result['summ']),max($result['summ'])/10), 'colour'=>'#0077cc'));
        $this->flashChart->rightAxis(array('range' => array(0,max($result['cnt']),max($result['cnt'])/10), 'colour'=>'#ff9900'));

        echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'3','line_style' => 'solid-dot','set_key' => array(__('Total', true),14)),'Sum');
        echo $this->flashChart->chart('line',array('colour'=>'#ff9900','width'=>'3','right' => 'true','set_key' => array(__('Number of Orders', true),14)),'Count');
    }
    else 
    {
        $this->flashChart->setData(array('0'),'{n}',false,'null');
        echo $this->flashChart->chart('line',array('colour'=>'#0077cc','width'=>'2'),'null');
    }
    echo $this->flashChart->render('100%','300');
                        
    echo '</table>';
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