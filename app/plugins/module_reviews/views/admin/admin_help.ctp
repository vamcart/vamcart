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

?>
<h3>What does this do?</h3>
<p>The reviews module will allow customers to publish reviews and rate your products.</p>
<h3>How do I use this?</h3>
<p>Upon installation the Reviews Module will create a new Core Page for your store called Product Reviews.</p>

<h3>To create a link to a products reviews:</h3>
<p>{module alias='reviews' action='link'}</p>
<p>This call will create two links in your page/template.  One to read reviews of the current content, and the other to publish your own review.</p>

<h3>To create a listing of reviews:</h3>
<p>{module alias='reviews' action='display'}</p>
<p>Generally called from the core page.  If called from a template will display a listing of reviews for that content item.</p>