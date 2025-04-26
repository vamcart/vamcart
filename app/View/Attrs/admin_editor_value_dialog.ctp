<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<div class="modal fade" id="editAttrModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-primary" id="feature-title"><?php echo __('Add/Edit');?></h4>
      </div>
      <div class="modal-body clearfix">
        <?php
            echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-table');
            echo $this->Form->create('Attr', array('id' => 'valueform', 'name' => 'valueform','enctype' => 'multipart/form-data', 'url' => '/admin_editor_value/save'));
            echo $this->Form->input('content_id',array('type' => 'hidden',
                                                       'value' => $content_id
                                   ));
            echo $this->Form->input('parent_id',array('type' => 'hidden',
                                                       'value' => $parent_id
                                   ));     
            echo $this->Form->input('Content.id_groups',array(
                                    'type' => 'select'
                                    ,'label' => __('Product Grouping')
                                    ,'class' => 'select2'
                                    ,'multiple' => true
                                    ,'options' => $group_contents
                                    ,'selected' => array_keys($selected_group_contents)
                                    ,'data-placeholder' => __('Select Slave Products')
                                    ));
            
            foreach ($element_list AS $k => $element) {
                $this->Smarty->display($element['template_attribute'],array('id_attribute' => $element['id_attribute']
                                                                   ,'values_attribute' => $element['values_attribute']
                                                                   ,'name_attribute' => $element['name_attribute']
                                                                 ));
            }

            echo $this->Js->link('<i class="cus-disk"></i> ' . __('Apply'), '/attrs/admin_editor_value/save/',
                array(
                    'class' => 'btn btn-default'
                   ,'escape' => false
                   ,'update' => false
                   ,'method' => 'post'
                   ,'data' => $this->Js->get('#valueform')->serializeForm(array('isForm' => true,'inline' => true))
                   ,'dataExpression' => true
                   ,'success' => '$("#editAttrModal").modal("hide");'
                )
            );
            
            echo $this->Js->writeBuffer();  

                
            echo $this->Form->end();
            echo $this->Admin->ShowPageHeaderEnd();
        ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<?php 
    echo $this->Html->scriptBlock('$("#editAttrModal").modal("show").on("shown.bs.modal", function (){});');
?>