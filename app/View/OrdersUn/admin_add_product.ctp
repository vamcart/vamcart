<?php

    $search_form  = $this->Ajax->form(null,'post',$options = array('escape' => false, 'url' => '/orders_un/admin_add_product/product/0'
                                                                 , 'update' => 'content','before' => 'var temp_ = window.onbeforeunload; window.onbeforeunload = null','after' => 'window.onbeforeunload = temp_'));
    $search_form .= $this->Form->input('Search.term',array('id' => 'search_my','label' => __('Search'),'value' => __('Category Search'),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
    $search_form .= $this->Form->end();

    echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table', $search_form);
    
    echo '<table class="contentTable">';
    for($r = 0;$r <= 36;$r+=9)
    {
        echo '<tr>';
        for($c = 0;$c <= 9;$c++)
        {
            if(isset($data['content'][$c+$r]['ContentDescription']))
                echo '<td width="10%"><div>' . $this->Ajax->link($data['content'][$c+$r]['ContentDescription'][0]['name'], 'null', $options = array('escape' => false, 'url' => '/orders_un/admin_add_product/'  . $data['next_category'] . '/' . $data['content'][$c+$r]['Content']['id'], 'update' => 'content'), null, false) . '</div></td>';
            else echo '<td width="10%"></td>';
        }
        echo '</tr>';
    }
    
    echo '</table>';
    
    ?>
    <table class="contentPagination">
        <tr>               
               <td><?php echo $this->Ajax->link($this->Html->tag('i', '',array('class' => 'cus-arrow-undo')) . __('Up'), 'null', $options = array('escape' => false, 'url' => '/orders_un/admin_add_product/'  . $data['prev_category'], 'update' => 'content'), null, false); ?></td>
               <td></td>
               <td></td>
        </tr>
	<tr>
		<td><?php echo $this->Paginator->prev(__('<< Previous')); ?></td>
		<td>&nbsp;<?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $this->Paginator->next(__('Next >>')); ?></td>
	</tr>
    </table>

<?php
    echo $this->Admin->ShowPageHeaderEnd();
	
?>