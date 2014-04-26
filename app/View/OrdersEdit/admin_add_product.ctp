<style>
.list_column li.column {
        /*line-height:1.5em;*/
        /*border-bottom:1px solid #ccc;*/
        border-left:1px solid #ccc;
        float:left;
        display:inline;
        width:10%;
}
</style>
<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

    $search_form  = $this->Ajax->form(null,'post',$options = array('escape' => false, 'url' => '/orders_edit/admin_add_product/product/0'
                                                                 , 'update' => 'content','before' => 'var temp_ = window.onbeforeunload; window.onbeforeunload = null','after' => 'window.onbeforeunload = temp_'));
    $search_form .= $this->Form->input('Search.term',array('id' => 'search_my','label' => __('Search'),'value' => __('Search'),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
    $search_form .= $this->Form->end();

    echo $this->Admin->ShowPageHeaderStart(__('Add Product'), 'cus-cart-add', $search_form);
    
    echo '<ul class="list_column">';
    foreach ($data['content'] AS $content)
    {
        echo '<li class="column">';
        echo $this->Ajax->link($content['ContentDescription'][0]['name'], 'null', $options = array('escape' => false, 'url' => '/orders_edit/admin_add_product/'  . $data['next_category'] . '/' . $content['Content']['id'], 'update' => 'content'), null, false);
        echo $this->Smarty->display('<div>{attribute_list product_id=$product_id}</div>',array('product_id' => $content['Content']['id']));
        echo '</li>';
        
        
    }
    echo '</ul> <div class="clear"></div>';
    /*echo '<table class="contentTable">';
    for($r = 0;$r <= 36;$r+=9)
    {
        echo '<tr>';
        for($c = 0;$c <= 9;$c++)
        {
            if(isset($data['content'][$c+$r]['ContentDescription']))
                echo '<td width="10%"><div>' . $this->Ajax->link($data['content'][$c+$r]['ContentDescription'][0]['name'], 'null', $options = array('escape' => false, 'url' => '/orders_edit/admin_add_product/'  . $data['next_category'] . '/' . $data['content'][$c+$r]['Content']['id'], 'update' => 'content'), null, false) . '</div></td>';
            else echo '<td width="10%"></td>';
        }
        echo '</tr>';
    }
    
    echo '</table>';*/
    
    ?>
    <table class="contentPagination">
        <tr>               
               <td><?php echo $this->Ajax->link($this->Html->tag('i', '',array('class' => 'cus-arrow-up')) . __('Up One Level'), 'null', $options = array('escape' => false, 'url' => '/orders_edit/admin_add_product/'  . $data['prev_category'], 'update' => 'content'), null, false); ?></td>
               <td></td>
               <td></td>
        </tr>
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
    </table>

<?php
    echo $this->Admin->ShowPageHeaderEnd();
	
?>