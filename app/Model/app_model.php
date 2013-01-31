<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class AppModel extends Model
{
	
	
    public $validate = array();

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $this->_validationRules();
    }

    function _validationRules() {
        //implemented on child classes
    }	
	
	/**
	* Called by Cake after every model is saved.  
	* This method clears the cache if we're saving to one of the specified models to check.
	*
	*/			
	function afterSave()
	{
		$check_models = array('Content','Template','Stylesheet','MicroTemplate','GlobalContentBlock');
		if(in_array($this->name,$check_models))
		{
			Cache::clear();
		}
	}


	/**
	* Unbinds all associated models that are attached to the current model.
	*
	* @param  array $params Array of models to un-associate
	*/		
	function unbindAll($params = array())
	{
	    foreach($this->__associations as $ass)
	    {
	      if(!empty($this->{$ass}))
	      {
	        $this->__backAssociation[$ass] = $this->{$ass};
	        if(isset($params[$ass]))
	        {
	          foreach($this->{$ass} as $model => $detail)
	          {
	            if(!in_array($model,$params[$ass]))
	            {
	              $this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
	              unset($this->{$ass}[$model]);
	            }
	          }
	        }else
	        {
	          $this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
	          $this->{$ass} = array();
	        }

      }
    }
    return true;
	}
  
}
?>