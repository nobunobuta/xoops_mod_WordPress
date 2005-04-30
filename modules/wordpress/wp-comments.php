<?php // Do not delete these lines
	if ('wp-comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if (!empty($withcomments) || !empty($c)) {
		if (get_xoops_option(wp_mod(),'wp_use_xoops_comments') == 0) {
	        $comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID = '$wp_post_id' AND comment_approved = '1' ORDER BY comment_date");
        	if (!empty($post->post_password)) { // if there's a password
        	    if ($_COOKIE['wp-postpass_'.$cookiehash] != $post->post_password) {  // and it doesn't match the cookie
        	        echo('<p>Enter your password to view comments.<p>');
        	        return;
        	    }
        	}
 			$comment_author = (isset($_COOKIE['comment_author_'.$cookiehash])) ? trim($_COOKIE['comment_author_'.$cookiehash]) : '';
        	$comment_author_email = (isset($_COOKIE['comment_author_email_'.$cookiehash])) ? trim($_COOKIE['comment_author_email_'.$cookiehash]) : '';
 			$comment_author_url = (isset($_COOKIE['comment_author_url_'.$cookiehash])) ? trim($_COOKIE['comment_author_url_'.$cookiehash]) : '';
			$id = $wp_post_id;
			include(get_custom_path('comments-template.php'));
		} else {
	        $comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID = '$wp_post_id' AND comment_approved = '1' AND (comment_content like '<trackback />%' OR comment_content like '<pingkback />%') ORDER BY comment_date");
			$id = $wp_post_id;
			include(get_custom_path('xoops-comments-template.php'));
		}
	}
?>
