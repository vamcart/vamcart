<?php
header('Content-Type: text/html; charset=utf-8'); 
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php __('VaM Shop Admin') ?></title>
	<?php echo $javascript->link('scriptaculous/prototype');  ?>	
	<?php echo $javascript->link('scriptaculous/scriptaculous');  ?>
	<?php echo $javascript->link('admin');  ?>	
	<?php echo $html->css('admin');  ?>
</head>

<body>
	<div id="header">
		<h1><img src="/img/logo.gif" alt="<?php __('VaM Shop Admin') ?>" /></h1>
		<div id="global_search">
		<?php 
			echo $form->create('Search', array('action' => '/search/admin_global_search/', 'url' => '/search/admin_global_search/'));
			echo $form->input('Search/term',array('value' => __('Global Record Search',true),"onblur" => "if(this.value=='') this.value=this.defaultValue;","onfocus" => "if(this.value==this.defaultValue) this.value='';"));
			echo $form->submit();
			echo $form->end();
		?>
		</div>
	</div>
	<div id="under_header_bar"></div>
	<div id="menu_container">
		<?php echo $admin->DrawMenu($navigation); ?>
	</div>
	<div id="content_body">
		<div id="breadcrumbs">
			<?php
			if(isset($current_crumb))
				echo $admin->GenerateBreadcrumbs($navigation, $current_crumb);
			?>
		</div>
		<div id="content">
			<?php if($session->check('Message.flash')) $session->flash(); ?> 
			<div class="pageheader">
				<?php 
				if(isset($current_crumb)) 
				{
					echo $current_crumb;
					if(isset($current_crumb_info)) 
					{
						echo ': ' . $current_crumb_info;
					}
				}
				?>
			</div>
			<div id="inner-content">
				<?php echo $content_for_layout ?>
			</div>
		</div><!-- End #content -->
	</div><!-- End #content_body -->
	<div id="footer">
		<a id="footer_text" href="http://vamshop.ru/" target="blank"><?php __('Powered by VaM Shop') ?></a>
	</div>
</body>
</html>