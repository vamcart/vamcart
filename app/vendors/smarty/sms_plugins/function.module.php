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

function smarty_function_module($params, &$smarty)
{
	if(!isset($params['alias']))
		return;
		
	// Make sure the module is still installed, if not exit
	loadModel('Module');
	$Module =& new Module();
	
	$this_module = $Module->find(array('alias' => $params['alias']));
	if(empty($this_module))
		return;
	
	// Do some error checking and null value handling
	if(!isset($params['action']))
		$params['action'] = 'default';
	
	if(!isset($params['controller']))
		$params['controller'] = 'action';
	

	
	loadComponent('Smarty');
	$Smarty =& new SmartyComponent();
	
	
	$assignments = $Smarty->requestAction('/module_' . $params['alias'] . '/' . $params['controller'] . '/' . $params['action'] .'/',array('return' => true));

	
	
	if(isset($params['template']))
	{
		loadModel('MicroTemplate');
			$MicroTemplate =& new MicroTemplate();
		
		$template = $MicroTemplate->find(array('alias' => $params['template']));
		$display_template = $template['MicroTemplate']['template'];
	}
	else
	{	
		ob_start();
		$Smarty->requestAction('/module_' . $params['alias'] . '/action/template/' . $params['action'],array('return' => true));	
		$display_template = @ob_get_contents();
		ob_end_clean();
	}
			
	
	
	$Smarty->display($display_template,$assignments);
	


}

function smarty_help_function_module() {
	?>
	<h3>What does this do?</h3>
	<p>Makes a call to the installed module.  If the module is not found, this does nothing.</p>
	<p>See the specific module documentation for more information.</p>
	<h3>What parameters does it take?</h3>
	<ul>
		<li><em>(controller)</em> - Controller to call.  Defaults to "action".</li>
		<li><em>(action)</em> - Method to call of the action controller.</li>
		<li><em>(template)</em> - Overrides the module's default template for the action specified.</li>
	</ul>	
	<?php
}

function smarty_about_function_module() {
	?>
	<p>Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>
	<p>Version: 0.1</p>
	<p>
	Change History:<br/>
	None
	</p>
	<?php
}
?>
