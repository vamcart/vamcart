<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<div class="modal fade" id="copyAttrModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-primary" id="feature-title"><?php echo __('Copy Attributes Values');?></h4>
      </div>
      <div class="modal-body clearfix">
      
        <?php    
            echo $this->Form->create('Attr', array('id' => 'copyvaluesattributeform', 'name' => 'attributeform','enctype' => 'multipart/form-data', 'url' => '/admin_copy_attrvalues/'));
            echo $this->Form->input('Attr.id',array('type' => 'hidden','value' => $attribute_id));
            echo $this->Form->input('Attr.content_id',array('type' => 'hidden','value' => $content_id));
            
            echo $this->Form->input('Attr.parrent_id', 
                array(
                    'type' => 'select',
                    'label' => __('Attribute Value'),
                    'options' => $attributes,
                    'escape' => false
           ));
            
            echo $this->Js->link('<i class="cus-disk"></i> ' . __('Copy'), '/attrs/admin_copy_attrvalues/',
                array(
                    'class' => 'btn btn-default'
                   ,'escape' => false
                   ,'update' => '#view_attr'
                   ,'method' => 'post'
                   ,'data' => $this->Js->get('#copyvaluesattributeform')->serializeForm(array('isForm' => true,'inline' => true))
                   ,'dataExpression' => true
                   ,'success' => '$("#copyAttrModal").modal("hide");'
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
    echo $this->Html->scriptBlock('$("#copyAttrModal").modal("show").on("shown.bs.modal", function (){});');
?>

<script type="text/javascript">
    $(document).ready(function() {
  
        });    
</script>