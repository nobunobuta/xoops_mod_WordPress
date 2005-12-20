<?php
/*
Plugin Name: PukiWiki
Version: 0.5
Plugin URI: http://www.kowa.org/
Description:PukiWiki Render
Author: nobunobu
Author URI: http://www.kowa.org/
*/
if (!defined('WP_PLUGIN_PUKIWIKI')) {
define('WP_PLUGIN_PUKIWIKI',1);
function pukiwiki($text) {
	$text = stripslashes($text);
	//Re-conver <!--more-->
	$text = preg_replace("/\s*<a href=\"(.*?)#more-(.*?)\">(.*?)<\/a>/","\n\nRIGHT:[[\\3>\\1#more-\\2]]",$text);
	$text = preg_replace("/\s*<a id=\"more-(.*?)\"><\/a>/","\n\n&aname(more-\\1);",$text);
	

	$render = &new PukiWikiRender('wordpress');
	$retstr = $render->transform($text);
	unset($render);
	return $retstr;
}

function pukiwiki_com($text) {
	$text=preg_replace("/^\<strong\>(.*?)\<\/strong\>\n/","''\\1''~\n",$text);
	return pukiwiki($text);
}
}
if (!class_exists('PukiWikiRender')) {
	if (file_exists(dirname(__FILE__).'/modPukiWiki/PukiWiki.php')) {
		include_once (dirname(__FILE__).'/modPukiWiki/PukiWiki.php');
	} else if (file_exists(XOOPS_ROOT_PATH.'/common/modPukiWiki/PukiWiki.php')) {
		include_once(XOOPS_ROOT_PATH.'/common/modPukiWiki/PukiWiki.php');
	} else if (file_exists(XOOPS_ROOT_PATH.'/class/modPukiWiki/PukiWiki.php')) {
		include_once(XOOPS_ROOT_PATH.'/class/modPukiWiki/PukiWiki.php');
	}
}
if (class_exists('PukiWikiRender')) {
	remove_filter('the_content', 'wpautop');
	remove_filter('the_content', 'wptexturize');
	remove_filter('the_content', 'convert_bbcode',5);
	remove_filter('the_content', 'convert_gmcode',5);
	remove_filter('the_content', 'convert_smilies',40);
	remove_filter('the_content', 'convert_chars');

	remove_filter('the_excerpt', 'wpautop');
	remove_filter('the_excerpt', 'wptexturize');
	remove_filter('the_excerpt', 'convert_bbcode',5);
	remove_filter('the_excerpt', 'convert_gmcode',5);
	remove_filter('the_excerpt', 'convert_smilies',40);
	remove_filter('the_excerpt', 'convert_chars');

	remove_filter('comment_text', 'wpautop',30);
	remove_filter('comment_text', 'wptexturize');
	remove_filter('comment_text', 'wp_filter_kses');
	remove_filter('comment_text', 'convert_bbcode',5);
	remove_filter('comment_text', 'convert_gmcode',5);
	remove_filter('comment_text', 'balanceTags',50);
	remove_filter('comment_text', 'convert_smilies',20);
	remove_filter('comment_text', 'convert_chars');
	remove_filter('comment_text', 'make_clickable');

	add_filter('the_content', 'pukiwiki', 6);
	add_filter('the_excerpt', 'pukiwiki', 6);
	add_filter('comment_text', 'pukiwiki_com', 6);
}
?>
