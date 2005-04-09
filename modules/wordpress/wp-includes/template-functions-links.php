<?php

function the_permalink() {
	echo get_permalink();
}

function permalink_link() { // For backwards compatibility
	echo get_permalink();
}

function permalink_anchor($mode = 'id') {
    global $id, $post;
    switch(strtolower($mode)) {
        case 'title':
            $title = sanitize_title($post->post_title) . '-' . $id;
            echo '<a id="'.$title.'"></a>';
            break;
        case 'id':
        default:
            echo '<a id="post-'.$id.'"></a>';
            break;
    }
}

function permalink_single($file = '') {
	echo get_permalink();
}

function permalink_single_rss($file = '') {
	global $siteurl;
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
		'%post_id%'
	);
	if (!$id) {
		if ('' != get_settings('permalink_structure')) {
			$unixtime = strtotime($post->post_date);
			$rewritereplace = array(
				date('Y', $unixtime),
				date('m', $unixtime),
				date('d', $unixtime),
				date('H', $unixtime),
				date('i', $unixtime),
				date('s', $unixtime),
				$post->post_name,
				$post->ID
			);
			return $siteurl . str_replace($rewritecode, $rewritereplace, get_settings('permalink_structure'));
		} else { // if they're not using the fancy permalink option
			return $siteurl . '/index.php?p='.$post->ID;
		}
	} else { // if an ID is given
		$idpost = $wpdb->get_row("SELECT post_date, post_name FROM {$wpdb->posts[$wp_id]} WHERE ID = $id");
		if ('' != get_settings('permalink_structure')) {
			$unixtime = strtotime($idpost->post_date);
			$rewritereplace = array(
				date('Y', $unixtime),
				date('m', $unixtime),
				date('d', $unixtime),
				date('H', $unixtime),
				date('i', $unixtime),
				date('s', $unixtime),
				$idpost->post_name,
				$id
			);
			return $siteurl . str_replace($rewritecode, $rewritereplace, get_settings('permalink_structure'));
		} else {
			return $siteurl . '/index.php?p='.$id;
		}
	}
}

function get_month_link($year, $month) {
	global $siteurl;
	if (!$year) $year = date('Y', time()+($time_difference * 3600));
	if (!$month) $month = date('m', time()+($time_difference * 3600));
	if ('' != get_settings('permalink_structure')) {
		$off = strpos(get_settings('permalink_structure'), '%monthnum%');
		$offset = $off + 11;
		$monthlink = substr(get_settings('permalink_structure'), 0, $offset);
		if ('/' != substr($monthlink, -1)) $monthlink = substr($monthlink, 0, -1);
		$monthlink = str_replace('%year%', $year, $monthlink);
		$monthlink = str_replace('%monthnum%', zeroise(intval($month), 2), $monthlink);
		$monthlink = str_replace('%post_id%', '', $monthlink);
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
		$off = strpos(get_settings('permalink_structure'), '%day%');
		$offset = $off + 6;
		$daylink = substr(get_settings('permalink_structure'), 0, $offset);
		if ('/' != substr($daylink, -1)) $daylink = substr($daylink, 0, -1);
		$daylink = str_replace('%year%', $year, $daylink);
		$daylink = str_replace('%monthnum%', zeroise(intval($month), 2), $daylink);
		$daylink = str_replace('%day%', zeroise(intval($day), 2), $daylink);
		$daylink = str_replace('%post_id%', '', $daylink);
		return $siteurl . $daylink;
	} else {
		return $siteurl.'/index.php?m='.$year.zeroise($month, 2).zeroise($day, 2);
	}
}

function edit_post_link($link = _WP_TPL_EDIT_THIS, $before = '', $after = '') {
	global $user_level, $post, $siteurl;

	get_currentuserinfo();

	if ($user_level > 0) {
		if (!user_can_edit($post->post_author)) {
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
		if (!user_can_edit($post->post_author)) {
			return;
		}
	} else {
		return;
	}

	$location = "$siteurl/wp-admin/post.php?action=editcomment&amp;comment=$comment->comment_ID";
	echo "$before <a href='$location'>$link</a> $after";
}

?>