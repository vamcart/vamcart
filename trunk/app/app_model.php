<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.ru
   http://vamcart.com
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AppModel extends Model
{
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