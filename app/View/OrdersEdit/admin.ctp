<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

    $this->Html->script(array(
            'jquery/plugins/jquery.jeditable.js'
           ,'jquery/plugins/jquery.form.js'
    ), array('inline' => false));
    
    echo $this->Html->scriptBlock('
        var my_global_formNavigate = true;
	$(document).ready(function(){
            window.onbeforeunload = function () {  
            if (my_global_formNavigate == true) {return null;} else{return "' . __('Order Changed! Click Save button to save your order!') . '";}
                                                }
            $(document).on("change","#pay_metd select",function(){$(this).blur();});
            $(document).on("change","#ship_metd select",function(){$(this).blur();});
            
            	});
', array('allowCache'=>false,'safe'=>false,'inline'=>false));

    
    echo $this->Html->scriptBlock('
        function saveform(){
                    my_global_formNavigate = true;
                }

        function changeContentTable(id,row,column_1,column_2,column_sum){
                                    var rows = document.getElementById(id).rows;
                                    var old_sum = rows[row].cells[column_sum].innerHTML;
                                    var new_sum = Math.round((rows[row].cells[column_1].innerHTML*rows[row].cells[column_2].innerHTML)*100)/100;
                                    rows[row].cells[column_sum].innerHTML = new_sum;
                                    var total_sum = 0;
                                    for(i=1;i<rows.length - 2;i++) total_sum += Number(rows[i].cells[column_sum].innerHTML);
                                    total_sum = Math.round(total_sum *100)/100;
                                    rows[rows.length - 1].cells[column_sum].innerHTML = "<strong>"+total_sum+"</strong>";
                                   }'
    , array('allowCache'=>false,'safe'=>false,'inline'=>false));

    echo $this->Admin->ShowPageHeaderStart(__('Edit Order #').' '.$order['id'], 'cus-cart-edit');
    
    echo '<table class="orderTable"><tr><td width="50%">';
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array('',__('Billing Information')));
    if(isset($order['bill_inf']))
    {
        foreach ($order['bill_inf'] AS $k => $bill_inf)
        {
            echo $this->Admin->TableCells(array(__(str_replace('_', ' ', $k)),array(__($bill_inf),array('id' => $k,'class' => 'edit','width' => '80%'))));
            echo $this->Ajax->editor($k,'/orders_edit/edit_field/bill_inf/',  array('callback' => 'function(value,settings){my_global_formNavigate = false;}'
                                                                      ,'tooltip' => __($k)
                                                                      ,'placeholder' => '_'
                                                                      ,'onblur' => 'submit'));
        }
        
        echo $this->Admin->TableCells(array(__('State')
                                 ,array($order['bill_state']['selected'],array('id' => 'bill_state','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('bill_state','/orders_edit/change_shipORpay_method/',  array('tooltip' => 'bill_state'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['bill_state']['json_data']));
        echo $this->Admin->TableCells(array(__('Country')
                                 ,array($order['bill_country']['selected'],array('id' => 'bill_country','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('bill_country','/orders_edit/change_shipORpay_method/',  array('tooltip' => 'bill_country'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['bill_country']['json_data']));
       
    }
    echo '</table>'; 
    echo '</td><td width="50%">';
    
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array('',__('Shipping Information')));
    if(isset($order['ship_inf']))
    {
        foreach ($order['ship_inf'] AS $k => $ship_inf)
        {
            echo $this->Admin->TableCells(array(__(str_replace('_', ' ', str_replace('Ship_', '', $k))),array(__($ship_inf),array('id' => $k,'class' => 'edit','width' => '80%'))));
            echo $this->Ajax->editor($k,'/orders_edit/edit_field/ship_inf/',  array('callback' => 'function(value,settings){my_global_formNavigate = false;}'
                                                                      ,'tooltip' => __($k)
                                                                      ,'placeholder' => '_'
                                                                      ,'onblur' => 'submit'));
        }
        
        echo $this->Admin->TableCells(array(__('Ship State')
                                 ,array($order['ship_state']['selected'],array('id' => 'ship_state','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('ship_state','/orders_edit/change_shipORpay_method/',  array('tooltip' => 'ship_state'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['ship_state']['json_data']));
        echo $this->Admin->TableCells(array(__('Ship Country')
                                 ,array($order['ship_country']['selected'],array('id' => 'ship_country','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('ship_country','/orders_edit/change_shipORpay_method/',  array('tooltip' => 'ship_country'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['ship_country']['json_data']));
       
        
    }
    echo '</table>';
    echo '</td></tr>';
    echo '<tr><td colspan="2">';
    
    echo '<table class="contentTable">';
    echo $this->Html->tableHeaders(array('',__('Contact Information')));
    if(isset($order['contact_inf']))
    {
        foreach ($order['contact_inf'] AS $k => $contact_inf)
        {
            echo $this->Admin->TableCells(array(__(str_replace('_', ' ', $k)),array(__($contact_inf),array('id' => $k,'class' => 'edit','width' => '80%'))));
            echo $this->Ajax->editor($k,'/orders_edit/edit_field/contact_inf/',  array('callback' => 'function(value,settings){my_global_formNavigate = false;}'
                                                                      ,'tooltip' => __($k)
                                                                      ,'placeholder' => '_'
                                                                      ,'onblur' => 'submit'));
        }
    }
    echo '</table>';
    echo '</td></tr>';
    
        
    echo '<tr><td colspan="2">';
    echo '<table class = "contentTable">';
    echo $this->Html->tableHeaders(array(__('Payment Methods'),__('Shipping Methods')));
    echo $this->Admin->TableCells(array(array(
                                 array($order['pay_metd']['selected'],array('id' => 'pay_metd','class' => 'edit','width' => '50%'))
                                ,array($order['ship_metd']['selected'],array('id' => 'ship_metd','class' => 'edit','width' => '50%'))
                                    )));

    echo $this->Ajax->editor('pay_metd','/orders_edit/change_shipORpay_method/',  array('tooltip' => 'pay_metd'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['pay_metd']['json_data']));
    echo $this->Ajax->editor('ship_metd','/orders_edit/change_shipORpay_method/',  array('tooltip' => 'ship_metd'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['ship_metd']['json_data']));
    echo '</table>';
    echo '</td></tr>';
    
    echo '<tr><td colspan="2">';
    echo '<table class = "contentTable" id = "content_t">';
    echo $this->Html->tableHeaders(array( __('Product Name'), __('Model'), __('Price'), __('Quantity'), __('Total'),''));
    if(isset($order['OrderProduct']))
    {
        foreach($order['OrderProduct'] AS $k => $product) 
        {
            echo $this->Admin->TableCells(
                      array(
                                    $product['name'],
                                    $product['model'],
                                    $product['price'],
                                    array($product['quantity'],array('id' => 'quantity' . $k,'class' => 'edit')),
                                    $product['quantity']*$product['price'],
                                    $this->Ajax->link($this->Html->tag('i', '',array('class' => 'cus-bin-empty')), 'null', $options = array('escape' => false, 'url' => '/orders_edit/admin_delete_product/' . $k, 'update' => 'content'), null, false),
                       ));
            echo $this->Ajax->editor('quantity' . $k,'/orders_edit/edit_field/OrderProduct/' . $k . '/quantity/',  array('callback' => 'function(value,settings){changeContentTable("content_t",' . ($k + 1) . ',2,3,4);my_global_formNavigate = false;}'
                                                                  ,'tooltip' => __('quantity')
                                                                  ,'placeholder' => '_'
                                                                  ,'onblur' => 'submit'));
        }
    }
        echo $this->Admin->TableCells(
                      array(
                                    $this->Ajax->link($this->Html->tag('i', '',array('class' => 'cus-add')).__('Add Product'), 'null', $options = array('escape' => false, 'url' => '/orders_edit/admin_add_product/group/', 'update' => 'content'), null, false),
                                    '_',
                                    '_',
                                    '_',
                                    '_',
                                    ''
                      ));
    if(isset($order['OrderProduct']))
    {
        echo $this->Admin->TableCells(
                      array(
                                    '<strong>' . __('Order Total') . '</strong>',
                                    '&nbsp;',
                                    '&nbsp;',
                                    '&nbsp;',
                                    '<strong>' . $order['total'] .'</strong>',
                                    ''
                      ));		  

    }
    echo '</table>';
    echo '</td></tr>';
    
    echo '</table>';
    
    echo $this->Form->create('OrdersEdit', array('id' => 'saveForm','action' => '/orders_edit/save_order/', 'url' => '/orders_edit/save_order/'));
    echo $this->Admin->formButton(__('Save'), 'cus-disk', array('id' => 'saveButton', 'name' => 'saveButton', 'class' => 'btn', 'type' => 'submit', 'name' => 'submit','onclick' =>  'saveform();')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton','onclick' => 'saveform();'));
    echo $this->Form->end();

    echo $this->Admin->ShowPageHeaderEnd();

	
?>