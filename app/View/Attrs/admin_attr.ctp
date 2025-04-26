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

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
echo '<table class="contentTable">';
echo $this->Html->tableHeaders(array(__('Title'),__('Master product'),__('Slave from product'),__('Action')));

//var_dump($content_data);

foreach ($content_data AS $content)
{       
        echo $this->Admin->TableCells(array(($content['ContentDescription']['name'] )
                                       ,array($this->Ajax->link(($content['Content']['is_group'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'),'title' => __('True')))
                                                                                             :$this->Html->image('admin/icons/false.png', array('alt' => __('False'),'title' => __('False'))))
                                               , 'null'
                                               , $options = array('escape' => false, 'url' => '/attrs/set_group_content/' . $content['Content']['id'] , 'update' => 'content'), null, false), array('align'=>'center')
                                              )
                                       ,array(isset($content['ContentGroup']['ContentDescription']['name']) ? $content['ContentGroup']['ContentDescription']['name'] : __('Select'),array('id'=> 'id_group_' . $content['Content']['id'],'align'=>'center'))
                                       ,array($this->Html->link($this->Html->tag('i', '',array('class' => 'cus-sitemap-color')) . ' ' . __('Attribute Values'), '/attrs/admin_editor_value/edit/' . $content['Content']['id'], array('class' => 'btn btn-default', 'escape' => false)),array('align'=>'center'))
                                        ));
        if($content['Content']['id'] != $content['Content']['id_group'])
        echo $this->Ajax->editor('id_group_' . $content['Content']['id'],'/attrs/change_group_content/' . $content['Content']['id'],  array(
                                                                     'type' => 'select'
                                                                    ,'data' => 'function(value, settings){return $.ajax({url: "' 
                                                                                . $this->Html->url('/attrs/get_groups_content/' . $content['Content']['parent_id']) 
                                                                                . '",async: false}).responseText;}'
                                                                     ,'placeholder' => __('Select')
                                                                     ,'onblur' => 'submit'
                                                                     ,'style' => 'inherit')
                                );
}
echo '</table>';
?>

<table class="contentPagination">
    <tr>               
        <td><?php echo $this->Html->link($this->Html->tag('i', '',array('class' => 'cus-arrow-up')) . ' ' . __('Up One Level'), '/attrs/admin' , array('class' => 'btn btn-default', 'escape' => false)); ?></td>
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