<?php
/*
Plugin Name: HTML Filter
Version: 1.0
Description:Content HTML Filter
Author: Nobunobu
Author URI: http://www.kowa.org
*/
if (!defined('WP_PLUGIN_HTMLFILTER')) {
	define('WP_PLUGIN_HTMLFILTER',1);
	global $fullcleantags;
	$fullcleantags = array(
		'a' => array(
			'href' => array(),
			'title' => array(),
			'rel' => array(),
			'rev' => array(),
			'name' => array()),
		'abbr' => array(
			'title' => array()),
		'acronym' => array(
			'title' => array()),
		'address' => array(
			'title' => array()),
		'area' => array(
			'shape' => array(),
			'coords' => array(),
			'href' => array(),
			'alt' => array()),
		'b' => array(),
		'basefont' => array('size' => array()),
		'bdo' => array('dir' => array()),
		'big' => array(),
		'blockquote' => array('cite' => array()),
		'br' => array(),
		'caption' => array('align' => array()),
		'code' => array(),
		'col' => array(
			'align' => array(),
			'char' => array(),
			'charoff' => array(),
			'span' => array(),
			'valign' => array(),
			'width' => array()),
		'del' => array('datetime' => array()),
		'dd' => array(),
		'div' => array('align' => array()),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'font' => array(
			'color' => array(),
			'face' => array(),
			'size' => array()),
		'h1' => array('align' => array()),
		'h2' => array('align' => array()),
		'h3' => array('align' => array()),
		'h4' => array('align' => array()),
		'h5' => array('align' => array()),
		'h6' => array('align' => array()),
		'hr' => array(
			'align' => array(),
			'noshade' => array(),
			'size' => array(),
			'width' => array()),
		'i' => array(),
		'img' => array(
			'alt' => array(),
			'align' => array(),
			'border' => array(),
			'height' => array(),
			'hspace' => array(),
			'ismap' => array(),
			'longdesc' => array(),
			'src' => array(),
			'usemap' => array(),
			'vspace' => array(),
			'width' => array()),
		'ins' => array('datetime' => array(), 'cite' => array()),
		'kbd' => array(),
		'li' => array(),
		'map' => array(
			'id' => array(),
			'name' => array()),
		'menu' => array(),
		'ol' => array(
			'compact' => array(),
			'start' => array(),
			'type' => array()),
		'p' => array('align' => array()),
		'pre' => array('width' => array()),
		'q' => array('cite' => array()),
		'rb' => array(),
		'rp' => array(),
		'rt' => array(),
		'ruby' => array(),
		's' => array(),
		'samp' => array(),
		'strike' => array(),
		'strong' => array(),
		'sub' => array(),
		'sup' => array(),
		'table' => array(
			'align' => array(),
			'bgcolor' => array(),
			'border' => array(),
			'cellpadding' => array(),
			'cellspacing' => array(),
			'frame' => array(),
			'rules' => array(),
			'summary' => array(),
			'width' => array()),
		'tbody' => array(
			'align' => array(),
			'char' => array(),
			'charoff' => array(),
			'valign' => array()),
		'td' => array(
			'abbr' => array(),
			'align' => array(),
			'axis' => array(),
			'bgcolor' => array(),
			'char' => array(),
			'charoff' => array(),
			'colspan' => array(),
			'headers' => array(),
			'height' => array(),
			'nowrap' => array(),
			'rowspan' => array(),
			'scope' => array(),
			'valign' => array(),
			'width' => array()),
		'tfoot' => array(
			'align' => array(),
			'char' => array(),
			'charoff' => array(),
			'valign' => array()),
		'th' => array(
			'abbr' => array(),
			'align' => array(),
			'axis' => array(),
			'bgcolor' => array(),
			'char' => array(),
			'charoff' => array(),
			'colspan' => array(),
			'headers' => array(),
			'height' => array(),
			'nowrap' => array(),
			'rowspan' => array(),
			'scope' => array(),
			'valign' => array(),
			'width' => array()),
		'thead' => array(
			'align' => array(),
			'char' => array(),
			'charoff' => array(),
			'valign' => array()),
		'tr' => array(
			'align' => array(),
			'bgcolor' => array(),
			'char' => array(),
			'charoff' => array(),
			'valign' => array()),
		'tt' => array(),
		'u' => array(),
		'ul' => array(),
		'var' => array()
	);
	function wp_html_filter($data) {
		global $fullcleantags;
		return wp_kses($data, $fullcleantags);
	}
}
add_filter('the_content', 'wp_html_filter');
add_filter('the_excerpt', 'wp_html_filter');
?>
