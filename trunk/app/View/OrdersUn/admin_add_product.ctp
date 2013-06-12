<?php

    echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
    
    echo '<table class="contentTable">';
    
    for($r = 0;$r <= 36;$r+=9)
    {
        echo '<tr>';
        for($c = 0;$c <= 9;$c++)
        {
            if(isset($data['content'][$c+$r]['ContentDescription']))
                echo '<td width="10%"><div>' . $this->Html->link($data['content'][$c+$r]['ContentDescription'][0]['name'], '/orders_un/admin_add_product/' . $data['category'] . '/' . $data['content'][$c+$r]['Content']['id']) . '</div></td>';
            else echo '<td width="10%"></td>';
        }
        echo '</tr>';
    }
    
    echo '</table>';
    
    ?>
    <table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->prev(__('<< Previous')); ?></td>
		<td>&nbsp;<?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $this->Paginator->next(__('Next >>')); ?></td>
	</tr>
    </table>

<?php
    echo $this->Admin->ShowPageHeaderEnd();
	
?>