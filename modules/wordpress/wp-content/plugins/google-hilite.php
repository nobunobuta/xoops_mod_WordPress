<?php
/*
Plugin Name: Search Hilite
Plugin URI: http://wordpress.org/#
Description:_LANG_PG_GOOGLE_HILITE
Version: 1.2
Author: Ryan Boren
Author URI: http://rboren.nu
*/ 
if (!defined('WP_PLUGIN_GOOGLE_HILITE')) {
define('WP_PLUGIN_GOOGLE_HILITE',1);
/* Highlighting code c/o Ryan Boren */
function get_search_query_terms($engine = 'google') {
    global $s, $s_array, $blog_charset;
	$referer = urldecode($_SERVER['HTTP_REFERER']);
	$query_array = array();
	switch ($engine) {
	case 'google':
		// Google query parsing code adapted from Dean Allen's
		// Google Hilite 0.3. http://textism.com
		$query_terms = preg_replace('/^.*q=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		if (function_exists('mb_convert_encoding')) {
			$query_terms = mb_convert_encoding($query_terms, $blog_charset, "auto");
		}
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;

	case 'lycos':
		$query_terms = preg_replace('/^.*query=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		if (function_exists('mb_convert_encoding')) {
			$query_terms = mb_convert_encoding($query_terms, $blog_charset, "auto");
		}
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;

	case 'yahoo':
		$query_terms = preg_replace('/^.*p=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		if (function_exists('mb_convert_encoding')) {
			$query_terms = mb_convert_encoding($query_terms, $blog_charset, "auto");
		}
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
		break;

    case 'wordpress':
        // Check the search form vars if the search terms
        // aren't in the referer.
        if ( ! preg_match('/^.*s=/i', $referer)) {
            if (isset($s_array)) {
                $query_array = $s_array;
            } else if (isset($s)) {
                $query_array = array($s);
            }

            break;
        }

		$query_terms = preg_replace('/^.*s=([^&]+)&?.*$/i','$1', $referer);
		$query_terms = preg_replace('/\'|"/', '', $query_terms);
		$query_array = preg_split ("/[\s,\+\.]+/", $query_terms);
        break;
	}

	return $query_array;
}

function is_referer_search_engine($engine = 'google') {
	global $siteurl;
	$referer = urldecode($_SERVER['HTTP_REFERER']);
    //echo "referer is: $referer<br />";
	if ( ! $engine ) {
		return 0;
	}

	switch ($engine) {
	case 'google':
		if (preg_match('|^http://(www)?\.?google.*|i', $referer)) {
			return 1;
		}
		break;

    case 'lycos':
		if (preg_match('|^http://search\.lycos.*|i', $referer)) {
			return 1;
		}
        break;

    case 'yahoo':
		if (preg_match('|^http://search\.yahoo.*|i', $referer)) {
			return 1;
		}
        break;

    case 'wordpress':
        if (preg_match("#^$siteurl#i", $referer)) {
            return 1;
        }
        break;
	}

	return 0;
}

function hilite($text) {
	$search_engines = array('wordpress', 'google', 'lycos', 'yahoo');

	foreach ($search_engines as $engine) {
		if ( is_referer_search_engine($engine)) {
			$query_terms = get_search_query_terms($engine);
			foreach ($query_terms as $term) {
				if (!empty($term) && $term != ' ') {
					if (!preg_match('/<.+>/',$text)) {
						$text = preg_replace('/('.$term.')/i','<span class="hilite">$1</span>',$text);
					} else {
						$text = preg_replace('/(?<=>)([^<]+)?('.$term.')/i','$1<span class="hilite">$2</span>',$text);
					}
				}
			}
			break;
		}
	}

	return $text;
}

function hilite_head() {
	echo "
<style type='text/css'>
.hilite {
	color: #000;
	background-color: #ff8;
}
</style>
";
}
}
// Highlight text and comments:
add_filter('the_content', 'hilite');
add_filter('comment_text', 'hilite');
add_action('wp_head', 'hilite_head');

?>