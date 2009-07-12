<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

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