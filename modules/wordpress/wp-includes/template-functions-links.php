<?php

function the_permalink() {
	echo get_permalink();
}

function permalink_link() { // For backwards compatibility
	echo get_permalink();
}

function permalink_anchor($mode = 'id') {
    global $wp_post_id, $post;
    switch(strtolower($mode)) {
        case 'title':
            $title = sanitize_title($post->post_title) . '-' . $wp_post_id;
            echo '<a id="'.$title.'"></a>';
            break;
        case 'id':
        default:
            echo '<a id="post-'.$wp_post_id.'"></a>';
            break;
    }
}

function permalink_single($file = '') {
	echo get_permalink();
}

function permalink_single_rss($file = '') {
    echo get_permalink();
}

function get_permalink($id=false) {
	global $post, $wpdb, $wp_id;
	global $siteurl;
	$id = intval($id);
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

	if ($id) {
		$idpost = $wpdb->get_row("SELECT ID, post_date, post_name, post_status, post_author FROM {$wpdb->posts[$wp_id]}  WHERE ID = $id");
	} else {
		$idpost = $post;
	}

	if ($idpost->post_status == 'static') {
		return get_page_link();
	}
	$permalink = get_settings('permalink_structure');

	if ('' != $permalink) {
		$unixtime = strtotime($idpost->post_date);

		$cats = get_the_category($idpost->ID);
		$category = $cats[0]->category_nicename;
		$authordata = get_userdata($idpost->post_author);
		$author = $authordata->user_login;
		$rewritereplace = 
		array(
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
		return $siteurl . str_replace($rewritecode, $rewritereplace, $permalink);
	} else {
		return $siteurl . '/index.php?p='.$idpost->ID;
	}
}

function get_month_link($year, $month) {
	global $siteurl;
	if (!$year) $year = date('Y', time()+($time_difference * 3600));
	if (!$month) $month = date('m', time()+($time_difference * 3600));
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
		return $siteurl . $monthlink;
	} else {
		return $siteurl.'/index.php?m='.$year.zeroise($month, 2);
	}
}

function get_day_link($year, $month, $day) {
	global $siteurl;
	if (!$year) $year = date('Y', time()+($time_difference * 3600));
	if (!$month) $month = date('m', time()+($time_difference * 3600));
	if (!$day) $day = date('j', time()+($time_difference * 3600));
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
		return $siteurl . $daylink;
	} else {
		return $siteurl.'/index.php?m='.$year.zeroise($month, 2).zeroise($day, 2);
	}
}

function get_feed_link($feed='rss2') {
    $do_perma = 0;
    $feed_url = get_settings('siteurl');
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
            if ($do_perma) {
                $output = $feed_url . '/rdf/';
            }
            break;
        case 'rss':
            $output = $feed_url . '/wp-rss.php';
            if ($do_perma) {
                $output = $feed_url . '/rss/';
            }
            break;
        case 'atom':
            $output = $feed_url .'/wp-atom.php';
            if ($do_perma) {
                $output = $feed_url . '/atom/';
            }
            break;        
        case 'comments_rss2':
            $output = $feed_url .'/wp-commentsrss2.php';
            if ($do_perma) {
                $output = $comment_feed_url . '/rss2/';
            }
            break;
        case 'rss2':
        default:
            $output = $feed_url .'/wp-rss2.php';
            if ($do_perma) {
                $output = $feed_url . '/rss2/';
            }
            break;
    }

    return $output;
}

function edit_post_link($link = _WP_TPL_EDIT_THIS, $before = '', $after = '') {
	global $user_level, $post, $siteurl;

	get_currentuserinfo();

	if ($user_level > 0) {
		$authordata = get_userdata($post->post_author);
		if ($user_level < $authordata->user_level) {
			return;
		}
	} else {
		return;
	}

	$location = "$siteurl/wp-admin/post.php?action=edit&amp;post=$post->ID";
	echo "$before <a href='$location'>$link</a> $after";
}

function edit_comment_link($link = _WP_TPL_EDIT_THIS, $before = '', $after = '') {
	global $user_level, $post, $comment, $siteurl;

	get_currentuserinfo();

	if ($user_level > 0) {
		$authordata = get_userdata($post->post_author);
		if ($user_level < $authordata->user_level) {
			return;
		}
	} else {
		return;
	}

	$location = "$siteurl/wp-admin/post.php?action=editcomment&amp;comment=$comment->comment_ID";
	echo "$before <a href='$location'>$link</a> $after";
}

?>