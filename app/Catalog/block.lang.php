<?php
/**
 * block.lang.php - Smarty gettext block plugin
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package   smarty-gettext
 * @link      https://github.com/smarty-gettext/smarty-gettext
 * @author    Sagi Bashari <sagi@boom.org.il>
 * @author    Elan Ruusamäe <glen@delfi.ee>
 * @copyright 2004-2005 Sagi Bashari
 * @copyright 2010-2015 Elan Ruusamäe
 */

/**
 * Replaces arguments in a string with their values.
 * Arguments are represented by % followed by their number.
 *
 * @param string $str Source string
 * @param mixed mixed Arguments, can be passed in an array or through single variables.
 * @return string Modified string
 */
 
function smarty_block_lang($params, $text, $template, &$repeat)
{
	
	if (!isset($text)) {
		return $text;
	}

	// set escape mode, default html escape
	if (isset($params['escape'])) {
		$escape = $params['escape'];
		unset($params['escape']);
	} else {
		$escape = 'html';
	}

	// set plural parameters 'plural' and 'count'.
	if (isset($params['plural'])) {
		$plural = $params['plural'];
		unset($params['plural']);

		// set count
		if (isset($params['count'])) {
			$count = $params['count'];
			unset($params['count']);
		}
	}

	// get domain param
	if (isset($params['domain'])) {
		$domain = $params['domain'];
		unset($params['domain']);
	} else {
		$domain = null;
	}

	// get context param
	if (isset($params['context'])) {
		$context = $params['context'];
		unset($params['context']);
	} else {
		$context = null;
	}

	// use plural if required parameters are set
	if (isset($count) && isset($plural)) {
		// use specified textdomain if available
		if (isset($domain)) {
			$text = __dn($domain, $text, $plural, $count);
		} else {
			$text = __n($text, $plural, $count);
		}
	} else {
		// use specified textdomain if available
		if (isset($domain)) {
			$text = __d($domain, $text);
		} else {
			$text = __d('catalog', $text);
		}
	}

	// run strarg if there are parameters
	if (count($params)) {
		$text = smarty_gettext_strarg($text, $params);
	}

	switch ($escape) {
	case 'html':
		$text = nl2br(htmlspecialchars($text));
		break;
	case 'javascript':
	case 'js':
		// javascript escape
		$text = strtr($text, array('\\' => '\\\\', "'" => "\\'", '"' => '\\"', "\r" => '\\r', "\n" => '\\n', '</' => '<\/'));
		break;
	case 'url':
		// url escape
		$text = urlencode($text);
		break;
	}

	return $text;
}

function smarty_help_function_lang() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Outputs the correct language value specified by the key between the brackets.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{lang}<?php echo __('Language Text') ?>{/lang}</code></p>
	<p><?php echo __('Make sure you define the language key in /app/Locale/your-locale/LC_MESSAGES/catalog.po.') ?></p>
	<?php
}

function smarty_about_function_lang() {
}
?>