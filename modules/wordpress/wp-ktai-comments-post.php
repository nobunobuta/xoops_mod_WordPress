<?php
//   2004-07-05
//   WordPress Ktai Edition用コメントポストスクリプト
//   $authorと$commentをsjisから$blog_charsetに変換する改造のみ。

require( dirname(__FILE__) . '/wp-config.php' );

if (!defined('XOOPS_URL')) {
	$blog_charset = get_settings('blog_charset');
} else {
	$tableposts = $wpdb->posts[$wp_id];
	$tablecomments = $wpdb->comments[$wp_id];
}


function add_magic_quotes($array) {
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	return $array;
} 

if (!get_magic_quotes_gpc()) {
	$_POST   = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

$author = trim(strip_tags($_POST['author']));
$author = mb_convert_encoding($author, $blog_charset, "auto");

$email = trim(strip_tags($_POST['email']));
if (strlen($email) < 6)
	$email = '';

$url = trim(strip_tags($_POST['url']));
$url = ((!stristr($url, '://')) && ($url != '')) ? 'http://'.$url : $url;
if (strlen($url) < 7)
	$url = '';

$comment = trim($_POST['comment']);
$comment_post_ID = intval($_POST['comment_post_ID']);
$user_ip = $_SERVER['REMOTE_ADDR'];

if ( 'closed' ==  $wpdb->get_var("SELECT comment_status FROM $tableposts WHERE ID = '$comment_post_ID'") )
	die(_LANG_WPCP_SORRY_ITEM);

if ( get_settings('require_name_email') && ('' == $email || '' == $author) )
	die(_LANG_WPCP_ERR_FILL);

if ( '' == $comment )
	die(_LANG_WPCP_ERR_TYPE);


$now = current_time('mysql');

$comment = balanceTags($comment, 1);
$comment = format_to_post($comment);
$comment = apply_filters('post_comment_text', $comment);
$comment = mb_convert_encoding($comment, $blog_charset, "auto");

// Simple flood-protection
$lasttime = $wpdb->get_var("SELECT comment_date FROM $tablecomments WHERE comment_author_IP = '$user_ip' ORDER BY comment_date DESC LIMIT 1");
if (!empty($lasttime)) {
	$time_lastcomment= mysql2date('U', $lasttime);
	$time_newcomment= mysql2date('U', $now);
	if (($time_newcomment - $time_lastcomment) < 10)
		die(_LANG_WPCP_SORRY_SECONDS);
}

// If we've made it this far, let's post.

if(!defined('XOOPS_URL')) {
	$now_gmt = current_time('mysql', 1);

	if(check_comment($author, $email, $url, $comment, $user_ip)) {
		$approved = 1;
	} else {
		$approved = 0;
	}
	$moderation_notify;
	$wpdb->query("INSERT INTO $tablecomments 
	(comment_post_ID, comment_author, comment_author_email, comment_author_url, comment_author_IP, comment_date, comment_date_gmt, comment_content, comment_approved) 
	VALUES 
	('$comment_post_ID', '$author', '$email', '$url', '$user_ip', '$now', '$now_gmt', '$comment', '$approved')
	");
} else {
	$comment_moderation = get_settings('comment_moderation');
	$moderation_notify = get_settings('moderation_notify');
	if ('manual' == $comment_moderation) {
		$approved = 0;
	} else { // none
		$approved = 1;
	}
	$wpdb->query("INSERT INTO $tablecomments 
	(comment_post_ID, comment_author, comment_author_email, comment_author_url, comment_author_IP, comment_date, comment_content, comment_approved) 
	VALUES 
	('$comment_post_ID', '$author', '$email', '$url', '$user_ip', '$now', '$comment', '$approved')
	");
}

$comment_ID = $wpdb->get_var('SELECT last_insert_id()');

if (($moderation_notify) && (!$approved)) {
	wp_notify_moderator($comment_ID);
}

if ((get_settings('comments_notify')) && ($approved)) {
	wp_notify_postauthor($comment_ID, 'comment');
}

do_action('comment_post', $comment_ID);

setcookie('comment_author_' . $cookiehash, $author, time() + 30000000, COOKIEPATH);
setcookie('comment_author_email_' . $cookiehash, $email, time() + 30000000, COOKIEPATH);
setcookie('comment_author_url_' . $cookiehash, $url, time() + 30000000, COOKIEPATH);

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
$location = (empty($_POST['redirect_to'])) ? $_SERVER["HTTP_REFERER"] : $_POST['redirect_to'];
if ($is_IIS) {
	header("Refresh: 0;url=$location");
} else {
	header("Location: $location");
}

?>