<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(array(__('Title') => 'rowspan=2'),array(__('Attribute') => 'colspan=2')));
echo $this->Html->tableHeaders(array(__('Value'),__('Action')));

foreach ($content_data AS $content)
{
    if($content['ContentType']['name']=='category')
    {
        $val = '| ';
        foreach ($content['Attribute'] AS $attr)
        {
            $val = $val . $attr['name'] . ' | ';
        }
        echo $this->Admin->TableCells(array(($this->Html->link($this->Html->image('admin/icons/folder.png') . $content['ContentDescription']['name'], '/Attributes/admin/' . $content['Content']['id'] . '/' . $content['Content']['parent_id'], array('escape' => false)))
                                       ,$val
                                       ,array($this->Html->link($this->Html->tag('i', '',array('class' => 'cus-application-view-tile')), '/attributes/admin_viewer_attr/' . $content['Content']['id'] , array('escape' => false)),array('align'=>'center'))
                                        ));
    }
    else 
    {        
        echo $this->Admin->TableCells(array(($content['ContentDescription']['name'] )
                                       ,' -> '
                                       ,array($this->Html->link($this->Html->tag('i', '',array('class' => 'cus-sitemap-color')), '/attributes/admin_editor_value/edit/' . $content['Content']['id'] , array('escape' => false)),array('align'=>'center'))
                                        ));
    }
}
echo '</table>';
?>
    <table class="contentPagination">
        <tr>               
               <td><?php echo $this->Html->link($this->Html->tag('i', '',array('class' => 'cus-arrow-undo')) . __('Up'), '/attributes/admin/' . $prev_level , array('escape' => false)); ?></td>             
               <td></td>
               <td></td>
        </tr>
	<tr>
                <?php //$this->Paginator->options(array('url' => array('controller' => 'attributes', 'action' => 'admin', $current_level))); ?>
		<td><?php echo $this->Paginator->prev(__('<< Previous')); ?></td>
		<td>&nbsp;<?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?>&nbsp;</td>
		<td><?php echo $this->Paginator->next(__('Next >>')); ?></td>
	</tr>
    </table>

<?php
echo $this->Admin->ShowPageHeaderEnd();
?>