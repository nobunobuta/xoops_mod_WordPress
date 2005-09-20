<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_LINKS_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_LINKS_INCLUDED' , 1 ) ;
function the_permalink($echo = true) {
	return _echo(get_permalink(), $echo);
}

function permalink_link($echo = true) { // For backwards compatibility
	return _echo(get_permalink(), $echo);
}

function permalink_anchor($mode = 'id', $echo=true) {
	$permalink_anchor = '';
    switch(strtolower($mode)) {
        case 'title':
            $title = sanitize_title($GLOBALS['post']->post_title) . '-' . $GLOBALS['wp_post_id'];
            $permalink_anchor .= '<a id="'.$title.'"></a>';
            break;
        case 'id':
        default:
            $permalink_anchor .= '<a id="post-'.$GLOBALS['wp_post_id'].'"></a>';
            break;
    }
    return _echo($permalink_anchor, $echo);
}

function permalink_single($file = '', $echo = true) {
	return _echo(get_permalink(), $echo);
}

function permalink_single_rss($file = '', $echo = true) {
	return _echo(get_permalink(), $echo);
}

function get_permalink($id=false) {
	static $permalink_cache;
	$rewritecode = array(
		'%year%',
		'%monthnum%',
		'%day%',
		'%hour%',
		'%minute%',
		'%second%',
		'%postname%',
		'%post_id%',
		'%category%',
		'%author%',
		'%pagename%',
	);
	$permalink = get_settings('permalink_structure');
	$postHandler =& wp_handler('Post');
	if ($id) {
		$id = intval($id);
		if ($permalink == '') {
			return wp_siteurl() . '/index.php?p='.$id;
		}
		if (!isset($permalink_cache[wp_id()])||!isset($permalink_cache[wp_id()][$id])) {
			$postObject =& $postHandler->get($id);
			if (!$postObject) {
				return wp_siteurl();
			}
			$permalink_cache[wp_id()][$id] =& $postObject->exportWpObject();
		}
		$idpost = $permalink_cache[wp_id()][$id];
	} else {
		$idpost = $GLOBALS['post'];
	}

	if ('' != $permalink) {
		$unixtime = strtotime($idpost->post_date);
		$cats = get_the_category($idpost->ID);
		if ($cats) {
			$category = $cats[0]->category_nicename;
		} else {
			$category = '';
		}
		$authordata = get_userdata($idpost->post_author);
		$author = $authordata->user_login;
		$rewritereplace = array(
			date('Y', $unixtime),
			date('m', $unixtime),
			date('d', $unixtime),
			date('H', $unixtime),
			date('i', $unixtime),
			date('s', $unixtime),
			$idpost->post_name,
			$idpost->ID,
			$category,
			$author,
			$idpost->post_name,
		);
		return wp_siteurl() . str_replace($rewritecode, $rewritereplace, $permalink);
	} else {
		return wp_siteurl() . '/index.php?p='.$idpost->ID;
	}
}

function get_month_link($year, $month) {
	if (!$year) $year = date('Y', current_time('timestamp'));
	if (!$month) $month = date('m', current_time('timestamp'));
	if ('' != get_settings('permalink_structure')) {
        $permalink = get_settings('permalink_structure');

        // If the permalink structure does not contain year and month, make
        // one that does.
        if (! (strstr($permalink, '%year%') && strstr($permalink, '%monthnum%'))
            || preg_match('/%category%.*(%year%|%monthnum%|%day%)/', $permalink)) {
            $front = substr($permalink, 0, strpos($permalink, '%'));
            $permalink = $front . '%year%/%monthnum%/';
        }

        $off = strpos($permalink, '%monthnum%');
		$offset = $off + 11;
        $monthlink = substr($permalink, 0, $offset);
		if ('/' != substr($monthlink, -1)) $monthlink = substr($monthlink, 0, -1);
		$monthlink = str_replace('%year%', $year, $monthlink);
		$monthlink = str_replace('%monthnum%', zeroise(intval($month), 2), $monthlink);
		$monthlink = str_replace('%post_id%', '', $monthlink);
        $monthlink = str_replace('%category%', '', $monthlink);
		return wp_siteurl() . $monthlink;
	} else {
		return wp_siteurl().'/index.php?m='.$year.zeroise($month, 2);
	}
}

function get_day_link($year, $month, $day) {
	if (!$year) $year = date('Y', current_time('timestamp'));
	if (!$month) $month = date('m', current_time('timestamp'));
	if (!$day) $day = date('j', current_time('timestamp'));
	if ('' != get_settings('permalink_structure')) {
        $permalink = get_settings('permalink_structure');

        // If the permalink structure does not contain year, month, and day,
        // make one that does.
        if (! (strstr($permalink, '%year%') && strstr($permalink, '%monthnum%')&& strstr($permalink, '%day%'))
            || preg_match('/%category%.*(%year%|%monthnum%|%day%)/', $permalink)) {
            $front = substr($permalink, 0, strpos($permalink, '%'));
            $permalink = $front . '%year%/%monthnum%/%day%/';
        }

        $off = strpos($permalink, '%day%');
		$offset = $off + 6;
        $daylink = substr($permalink, 0, $offset);
		if ('/' != substr($daylink, -1)) $daylink = substr($daylink, 0, -1);
		$daylink = str_replace('%year%', $year, $daylink);
		$daylink = str_replace('%monthnum%', zeroise(intval($month), 2), $daylink);
		$daylink = str_replace('%day%', zeroise(intval($day), 2), $daylink);
		$daylink = str_replace('%post_id%', '', $daylink);
        $daylink = str_replace('%category%', '', $daylink);
		return wp_siteurl() . $daylink;
	} else {
		return wp_siteurl().'/index.php?m='.$year.zeroise($month, 2).zeroise($day, 2);
	}
}

function get_feed_link($feed='rss2') {
    $do_perma = 0;
    $feed_url = wp_siteurl();
    $comment_feed_url = $feed_url;

    $permalink = get_settings('permalink_structure');
    if ('' != $permalink) {
        $do_perma = 1;
        $feed_url = get_settings('home');
        $index = 'index.php';
        $prefix = '';
        if (using_index_permalinks()) {
            $feed_url .= '/' . $index;
        }
        $comment_feed_url = $feed_url;
        $feed_url .= '/feed';
        $comment_feed_url .= '/comments/feed';
    }
    switch($feed) {
        case 'rdf':
            $output = $feed_url .'/wp-rdf.php';
            if ($do_perma) $output = $feed_url . '/rdf/';
            break;
        case 'rss':
            $output = $feed_url . '/wp-rss.php';
            if ($do_perma) $output = $feed_url . '/rss/';
            break;
        case 'atom':
            $output = $feed_url .'/wp-atom.php';
            if ($do_perma) $output = $feed_url . '/atom/';
            break;        
        case 'comments_rss2':
            $output = $feed_url .'/wp-commentsrss2.php';
            if ($do_perma) $output = $comment_feed_url . '/rss2/';
            break;
        case 'rss2':
        default:
            $output = $feed_url .'/wp-rss2.php';
            if ($do_perma) $output = $feed_url . '/rss2/';
            break;
    }
    return $output;
}

function edit_post_link($link = _WP_TPL_EDIT_THIS, $before = '', $after = '', $echo = true) {
	get_currentuserinfo();
	if (!user_can_edit($GLOBALS['post']->post_author)) {
		return "";
	}
	$location = wp_siteurl() ."/wp-admin/post.php?action=edit&amp;post={$GLOBALS['post']->ID}";
	return _echo("$before <a href='$location'>$link</a> $after", $echo);
}

function edit_comment_link($link = _WP_TPL_EDIT_THIS, $before = '', $after = '', $echo = true) {
	get_currentuserinfo();
	if (!user_can_edit($GLOBALS['post']->post_author)) {
		return "";
	}
	$location = wp_siteurl() ."/wp-admin/post.php?action=editcomment&amp;comment={$GLOBALS['comment']->comment_ID}";
	return _echo("$before <a href='$location'>$link</a> $after", $echo);
}
}
?>