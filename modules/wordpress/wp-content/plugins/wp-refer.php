<?php
/*
Plugin Name: WP-Refer
Plugin URI: http://www.noprerequisite.com/wp-refer/
Description: Stores referers to posts in a custom <strong>wp-refer</strong> field. <code>&lt;?php add_referer(); ?&gt;</code> has to be in 'the loop' for new referers to be added. <code>&lt;?php the_referers(); ?&gt;</code> displays these referers, defaulting to a semantic list of the most recent five.
Version: .5
Author: Jason
Author URI: http://www.noprerequisite.com/
*/
$GLOBALS['excluded_referers']=array();
$GLOBALS['excluded_referers'][]=XOOPS_URL;

//$excluded_referers[]="google.com";

function the_referers($num=5, $before="<li>", $after="</li>", $none="none yet"){
    global $post_meta_cache, $id, $wp_id, $blog_charset;
    $completed = 0;
    if ($referers = $post_meta_cache[$wp_id][$id]['wp-refer']){
        $referers = array_reverse($referers);
        foreach ($referers as $referer) {
            $referer = explode(":!-!:", $referer);
            $title = mb_conv(sanitize_text($referer[0]),$blog_charset,"auto");
			$url = sanitize_text($referer[1],false,true);
            echo $before."<a href=\"$url\">$title</a>".$after;
            $completed++;
            if ($completed==$num) break;
        }
    } else {
        echo $before.$none.$after;
    }
}

function add_referer(){
    global $single, $post_meta_cache, $wp_post_id, $wp_id, $blog_charset, $siteurl;
    if ($single){
        if (isset($_SERVER["HTTP_REFERER"])){
        	$url=$_SERVER["HTTP_REFERER"];
            if (not_excluded($url)){
                if ($referer = fopen($url, "rb")){
                    $page = '';
                    while (!feof($referer)) {
                          $page .= fread($referer, 8192);
                    }
                    fclose($referer);
                    $matched = false;
                    $page = mb_conv($page,$blog_charset,"auto");
                    if (preg_match_all("/<a\s[^>]*?href=[\"\']([^\"\']*?)[\"\'][^>]*>/",$page,$matches,PREG_PATTERN_ORDER)) {
                    	foreach($matches[1] as $match) {
                    		if (strstr($match,$siteurl)) $matched = true;
                    	}
                    }
                    if (!$matched) return;
                    preg_match("/<title>(.+)<\/title>/is",$page,$title);
                    $title = $title[1];
	                if (!$title) {
	                    preg_match("/^(http:\/\/)?([^\/]+)/i",$url, $matches);
	                    $host = $matches[2];
	                    preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
	                    $title = $matches[0];
	                }
	                $new_entry = addslashes($title.":!-!:".$url);
	            
	                add_post_meta($wp_post_id,'wp-refer',$new_entry);
	                $post_meta_cache[$wp_id][$wp_post_id]['wp-refer'][]=$new_entry;
                }
            }
        }
    }
}

function not_excluded($url){
    $not_excluded = TRUE;
    $url = strtolower($url);
    foreach ($GLOBALS['excluded_referers'] as $test){
        $test=strtolower($test);
        if (!(strpos($url, $test)===FALSE)) $not_excluded=FALSE;
    }
    return $not_excluded;
}
?>
