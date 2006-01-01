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
$GLOBALS['excluded_referers'][]="google.com";
$GLOBALS['excluded_referers'][]="google.co.jp";
$GLOBALS['excluded_referers'][]="search.msn.co.jp";
$GLOBALS['excluded_referers'][]='search.goo.ne.jp';
$GLOBALS['excluded_referers'][]='search.nifty.com';
$GLOBALS['excluded_referers'][]='search.yahoo.com';
$GLOBALS['excluded_referers'][]='search.yahoo.co.jp';
$GLOBALS['excluded_referers'][]='ocnsearch.goo.ne.jp';

//$excluded_referers[]="google.com";

function the_referers($num=5, $before='<li>', $after='</li>', $none='none yet'){
    $completed = 0;
    if ($referers = $GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']]['wp-refer']){
        $referers = array_reverse($referers);
        foreach ($referers as $referer) {
            $referer = explode(':!-!:', $referer);
            $title = mb_conv(sanitize_text($referer[0]), $GLOBALS['blog_charset'], 'auto');
			$url = sanitize_text($referer[1],false,true);
            echo $before.'<a href="'.$url.'">'.$title.'</a>'.$after;
            $completed++;
            if ($completed==$num) break;
        }
    } else {
        echo $before.$none.$after;
    }
}

function add_referer(){
    if (!empty($GLOBALS['single'])){
        if (isset($_SERVER['HTTP_REFERER'])){
        	$url=$_SERVER['HTTP_REFERER'];
            if (not_excluded($url)){
				require_once(XOOPS_ROOT_PATH.'/class/snoopy.php');
				$snoopy = New Snoopy;
				if ($snoopy->fetch($url)) {
					$page = $snoopy->results;
                    $matched = false;
                    $page = mb_conv($page, $GLOBALS['blog_charset'], 'auto');
                    if (preg_match_all('/<a\s[^>]*?href=[\"\']([^\"\']*?)[\"\'][^>]*>/',$page,$matches,PREG_PATTERN_ORDER)) {
                    	foreach($matches[1] as $match) {
                    		if (strstr($match, wp_siteurl())) $matched = true;
                    	}
                    }
                    if (!$matched) return;
                    preg_match('/<title>(.+)<\/title>/is', $page,$title);
                    $title = $title[1];
	                if (!$title) {
	                    preg_match('/^(http:\/\/)?([^\/]+)/i', $url, $matches);
	                    $host = $matches[2];
	                    preg_match('/[^\.\/]+\.[^\.\/]+$/', $host, $matches);
	                    $title = $matches[0];
	                }
	                $new_entry = addslashes($title.":!-!:".$url);
	            
	                add_post_meta($GLOBALS['wp_post_id'],'wp-refer',$new_entry);
	                $GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']]['wp-refer'][] = $new_entry;
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
