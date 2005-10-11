<?php // Do not delete these lines
	if ('wp-comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if (($withcomments) or ($c)) {
        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_'.$cookiehash] != $post->post_password) {  // and it doesn't match the cookie
                echo("<p>Enter your password to view comments.<p>");
                return;
            }
        }

 		$comment_author = (isset($_COOKIE['comment_author_'.$cookiehash])) ? trim($_COOKIE['comment_author_'.$cookiehash]) : '';
        if (!$comment_author) {
            if (!empty($xoopsUser)) {
                $comment_author = $xoopsUser->getVar('name') ? $xoopsUser->getVar('name') :$xoopsUser->getVar('uname');
            }
        }
        $comment_author_email = (isset($_COOKIE['comment_author_email_'.$cookiehash])) ? trim($_COOKIE['comment_author_email_'.$cookiehash]) : '';
 		$comment_author_url = (isset($_COOKIE['comment_author_url_'.$cookiehash])) ? trim($_COOKIE['comment_author_url_'.$cookiehash]) : '';

        $comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID = '$id' AND comment_approved = '1' ORDER BY comment_date");

		if (file_exists(dirname(__FILE__).'/themes/'.$xoopsConfig['theme_set'].'/comments-template.php')) {
			$themes = $xoopsConfig['theme_set'];
		} else {
			$themes = "default";
		}
		include(dirname(__FILE__).'/themes/'.$themes.'/comments-template.php');
	}
?>
