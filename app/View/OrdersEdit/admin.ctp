<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

    $this->Html->script(array(
            'jquery/plugins/jeditable/jquery.jeditable.js'
           ,'jquery/plugins/form/jquery.form.js'
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
    function saveform() {
        my_global_formNavigate = true;
    }
    
    function getNum(val) {
       if (isNaN(val)) {
         return 0;
       }
       return val;
    }
    
    function recount_total() {
        var shipping_sum = $("#price_shipping").html();     
        shipping_sum = Math.round(getNum(shipping_sum) *100)/100;
        
        var tax_sum = $("#price_tax").html();
        tax_sum = Math.round(getNum(tax_sum) *100)/100;
        
        var total_sum = 0;
        $.each($(".product_total"), function(key, value) {
            total_sum += $(this).html();
	});

        total_sum = Math.round(total_sum *100)/100;
        total_sum += shipping_sum + tax_sum;

        $("#price_total").html(total_sum);
    }

    function changeContentTable(id,value)
    {
        var old_sum = $("#price" + id).html();
        var new_sum = old_sum * value;
        new_sum = Math.round(new_sum *100)/100;
        $("#product_total" + id).html(new_sum);

        recount_total();
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
        echo $this->Admin->TableCells(array(__('Country')
                                 ,array($order['bill_country']['selected'],array('id' => 'bill_country','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('bill_country','/orders_edit/change_country/bill_country/bill_state',  array('tooltip' => 'bill_country'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['bill_country']['json_data']));

        echo $this->Admin->TableCells(array(__('State')
                                 ,array($order['bill_state']['selected'],array('id' => 'bill_state','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('bill_state'
                                ,'/orders_edit/change_shipORpay_method/'
                                ,array('tooltip' => 'bill_state'
                                      ,'type' => 'select'
                                      ,'onblur' => 'submit'
                                      ,'data' => 'function(value, settings){return $.ajax({url: "' 
                                                  . $this->Html->url('/orders_edit/ret_state_data/bill_state') 
                                                  . '",async: false}).responseText;}'));
       
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
        echo $this->Admin->TableCells(array(__('Country')
                                 ,array($order['ship_country']['selected'],array('id' => 'ship_country','class' => 'edit','width' => '50%'))
                                    ));
        echo $this->Ajax->editor('ship_country','/orders_edit/change_country/ship_country/ship_state',  array('tooltip' => 'ship_country'
                                                                                    ,'type' => 'select'
                                                                                    ,'onblur' => 'submit'
                                                                                    ,'data' => $order['ship_country']['json_data']));
       
        echo $this->Admin->TableCells(array(__('State')
                                 ,array($order['ship_state']['selected'],array('id' => 'ship_state','class' => 'edit','width' => '50%'))
                                    ));
         echo $this->Ajax->editor('ship_state'
                                ,'/orders_edit/change_shipORpay_method/'
                                ,array('tooltip' => 'ship_state'
                                      ,'type' => 'select'
                                      ,'onblur' => 'submit'
                                      ,'data' => 'function(value, settings){return $.ajax({url: "' 
                                                  . $this->Html->url('/orders_edit/ret_state_data/ship_state') 
                                                  . '",async: false}).responseText;}'));
        
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
                                 array(__($order['pay_metd']['selected']),array('id' => 'pay_metd','class' => 'edit','width' => '50%'))
                                ,array(__($order['ship_metd']['selected']),array('id' => 'ship_metd','class' => 'edit','width' => '50%'))
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
                                    array($product['price'],array('id' => 'price' . $k)),
                                    array($product['quantity'],array('id' => 'quantity' . $k,'class' => 'edit')),
                                    array($product['quantity'] * $product['price'],array('id' => 'product_total' . $k,'class' => 'product_total')),
                                    $this->Ajax->link($this->Html->tag('i', '',array('class' => 'cus-bin-empty')), 'null', $options = array('escape' => false, 'url' => '/orders_edit/admin_delete_product/' . $k, 'update' => 'content'), null, false),
                       ));
            echo $this->Ajax->editor('quantity' . $k,'/orders_edit/edit_field/OrderProduct/' . $k . '/quantity/',  array('callback' => 'function(value,settings){changeContentTable(' . $k . ',value);my_global_formNavigate = false;}'
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
        if ($order['tax'] > 0) {	  
        echo $this->Admin->TableCells(
                      array(
                                    '<strong>' . __('Tax') . '</strong>',
                                    '&nbsp;',
                                    '&nbsp;',
                                    '&nbsp;',
                                    array($order['tax'],array('id' => 'price_tax')),
                                    ''
                      ));		
        }  
       
        //if ($order['shipping'] > 0) {	  
        echo $this->Admin->TableCells(
                      array(
                                    '<strong>' . __('Shipping') . '</strong>',
                                    '&nbsp;',
                                    '&nbsp;',
                                    '&nbsp;',
                                    array($order['shipping'],array('id' => 'price_shipping','class' => 'edit')),
                                    ''
                      ));
            echo $this->Ajax->editor('price_shipping','/orders_edit/edit_shipping/',  array('callback' => 'function(value,settings){recount_total();my_global_formNavigate = false;}'
                                                                  ,'tooltip' => __('quantity')
                                                                  ,'placeholder' => '_'
                                                                  ,'onblur' => 'submit'));
        
        //}   
        echo $this->Admin->TableCells(
                      array(
                                    '<strong>' . __('Order Total') . '</strong>',
                                    '&nbsp;',
                                    '&nbsp;',
                                    '&nbsp;',
                                    array($order['total'],array('id' => 'price_total','class' => 'edit')),
                                    ''
                      ));		  
            echo $this->Ajax->editor('price_total','/orders_edit/edit_total/',  array('callback' => ''
                                                                  ,'tooltip' => __('quantity')
                                                                  ,'placeholder' => '_'
                                                                  ,'onblur' => 'submit'));

    }
    echo '</table>';
    echo '</td></tr>';
    
    echo '</table>';
    
    echo $this->Form->create('OrdersEdit', array('id' => 'saveForm','url' => '/orders_edit/save_order/'));
    echo $this->Admin->formButton(__('Save'), 'cus-disk', array('id' => 'saveButton', 'name' => 'saveButton', 'class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit','onclick' =>  'saveform();')) . $this->Admin->linkButton(__('Cancel'),'/orders/admin/','cus-cancel',array('escape' => false, 'class' => 'btn btn-default'));
    echo $this->Form->end();

    echo $this->Admin->ShowPageHeaderEnd();

	
?>
