<?php
/*
Plugin Name: Wrap Long Word
Version: 1.0
Description:Filter for wrapping long word.(Experimental)
Author: Nobunobu
Author URI: http://www.kowa.org
*/
if (!defined('WP_PLUGIN_WRAPLONGWORD')) {
    define('WP_PLUGIN_WRAPLONGWORD',1);
    function wp_wrap_longword($str) {
        $strs = preg_split('/(<[^>]+>)/',$str,-1 ,PREG_SPLIT_DELIM_CAPTURE);
        $ret = '';
        foreach($strs as $str) {
            if (!preg_match('/(<[^>]+>)/',$str)) {
                $ret .=  preg_replace('/([a-zA-Z0-9\.\/:%\?\-\+&;]{15})/ms','\\1&#8203;',$str);
            } else {
                $ret .= $str;
            }
        }
        return $ret;
    }
}

add_filter('the_content', 'wp_wrap_longword',99);
add_filter('the_excerpt', 'wp_wrap_longword',99);
add_filter('comment_text', 'wp_wrap_longword',99);
add_filter('comment_author', 'wp_wrap_longword',99);
add_filter('the_title', 'wp_wrap_longword',99);
?>
