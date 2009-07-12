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

class Content extends AppModel {
	var $name = 'Content';
	var $belongsTo = array('ContentType','Template');
	var $hasMany = array('ContentImage','ContentDescription' => array('dependent' => true));
	var $hasOne = array('ContentLink' => array('dependent' => true),'ContentSelflink' => array('dependent' => true),'ContentProduct' => array('dependent' => true),'ContentPage' => array('dependent' => true),'ContentCategory' => array('dependent' => true));
}

?>