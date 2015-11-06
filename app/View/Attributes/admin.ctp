<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Title'),__('Attributes'),__('Action')));

foreach ($content_data AS $content)
{
        $val = '';
        foreach ($content['Attribute'] AS $attr)
        {
            $val = $val . $attr['name'] . ' ';
        }
        echo $this->Admin->TableCells(array($this->Html->image('admin/icons/folder.png', array('alt' => __(''))) . $content['ContentDescription']['name']
                                       ,$val
                                       ,array($this->Html->link($this->Html->tag('i', '',array('class' => 'cus-application-view-tile')) . ' ' . __('Attributes'), '/attributes/admin_viewer_attr/' . $content['Content']['id'], array('class' => 'btn btn-default', 'escape' => false)),array('align'=>'center'))
                                        ));
}
echo '</table>';
?>
<table class="contentPagination">
	<tr>
		<td><?php echo $this->Paginator->numbers(array('separator'=>' - ')); ?></td>
	</tr>
</table>

<?php
echo $this->Admin->ShowPageHeaderEnd();
?>