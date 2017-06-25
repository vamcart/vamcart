<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * 
 * Smarty {bender} function plugin
 *
 * Type:     function<br>
 * Name:     bender<br>
 * Date:     October 27, 2013<br>
 * Purpose:  combines and compresses javascript & css<br>
 * Input:
 *         - src    = path to javascript or css file (can be an array)
 *         - output = path to output js / css file (optional)
 *
 * Examples:<br>
 * <pre>
 * {bender src="templates/default/css/style-main.css"} // add first css file
 * {bender src="templates/default/css/style-additional.css"} // add second css file
 * {bender src="templates/default/js/jquery.js"}             // add first javascript file
 * {bender src="templates/default/js/bootstrap.js"}          // add second javascript file
 * {bender output="css/allcss.min.css"} // combine previously added css files, minify and put them into css/allcss.min.css, and insert link to result css file
 * {bender output="js/alljs.min.js"}    // combine previously added js files, minify and put them into js/alljs.min.css, and insert link to result js file
 * </pre>
 * @link http://smarty.php.net/manual/en/language.function.cycle.php {cycle}
 *       (Smarty online manual)
 * @author Alex Raven <bugrov at gmail dot com>
 * @version 0.1
 * @param array
 * @param Smarty
 * @return string|null
 */

function smarty_function_bender($params, $template)
{
	
	App::import('Vendor', 'Bender', array('file' => 'Bender'.DS.'Bender.class.php'));
			
    $bender = new Bender();
    $bender->cssmin =  "cssmin";
    $bender->jsmin =  "jshrink";
    $bender->ttl =  -1;
    $bender->root_dir =  WWW_ROOT;
    $src = isset( $params['src'] ) ? $params['src'] : "";
    $output = isset( $params['output'] ) ? $params['output'] : "";

    // enqueue javascript or css
    if ( $src )
    {
        $bender->enqueue( $src );
    }
    elseif ( $output )
    {
        return $bender->output($output);
    }
}

function smarty_help_function_bender() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Сombines and compress javascript & css.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?></p> 
	<pre>
		{bender src="{base_path}/css/bootstrap/bootstrap.css"}
		{bender src="{base_path}/css/style.css"}

		{bender output="{base_path}/css/vamshop-packed.css"}

		{bender src="{base_path}/js/bootstrap/bootstrap.min.js"}
		{bender src="{base_path}/js/vamshop.js"}

		{bender output="{base_path}/js/vamshop-packed.js"}
	</pre>	
	
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(src)') ?></em> - <?php echo __('Path to js / css file.') ?></li>
		<li><em><?php echo __('(output)') ?></em> - <?php echo __('Path to output js / css file.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_bender() {
}
?>