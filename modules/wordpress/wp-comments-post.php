<?php
require(dirname(__FILE__) . '/wp-config.php');
if (get_xoops_option($wp_mod[$wp_id],'wp_use_xoops_comments')) return;
param('author','string','');
param('email','string','');
param('url','string','');
param('comment','html','');
param('comment_post_ID','integer','');
param('redirect_to','string','');
param('action','string','');

$user_ip = $_SERVER['REMOTE_ADDR'];
$user_domain = gethostbyaddr($user_ip);

if (!is_email($email)) {
	$email = '';
}

$url_struct = parse_url($url);
if (!$url_struct) {
	$url = '';
} elseif (!isset($url_struct['scheme'])) {
	$url = 'http://'.$url;
} elseif (!preg_match('/^http[s]?$/',$url_struct['scheme'])) {
	$url = '';
}

$location = (!$redirect_to) ? $_SERVER['HTTP_REFERER'] : $redirect_to;
$url_struct = parse_url($location);
if (isset($url_struct['scheme']) && !preg_match('/^http[s]?$/',$url_struct['scheme'])) {
	$location = $siteurl;
}

$original_comment = $comment;

$commentstatus = $wpdb->get_var("SELECT comment_status FROM {$wpdb->posts[$wp_id]} WHERE ID = $comment_post_ID");
if ('closed' == $commentstatus) {
   	redirect_header($location ,5,_LANG_WPCP_SORRY_ITEM);
   	exit();
}
if (null == $commentstatus) {
   	redirect_header($location ,5,_LANG_P_OOPS_IDCOM);
   	exit();
}

if (get_settings('require_name_email') && ($email == '' || $author == '')) { //original fix by Dodo, and then Drinyth
   	redirect_header($location ,5,_LANG_WPCP_ERR_FILL);
   	exit();
}
if ($comment == 'comment' || $comment == '') {
   	redirect_header($location ,5,_LANG_WPCP_ERR_TYPE);
   	exit();
}

if ((get_settings('use_comment_preview'))&&($action!='confirm')) {
	$show_cblock =0;
	include('header.php');
	$comment = balanceTags($comment, 1);
	$comment = convert_chars($comment);
	$comment = apply_filters('post_comment_text', $comment);

	$comment_preview = apply_filters('comment_text', $comment);
	$author_preview = apply_filters('comment_author', $author);
	$author_preview = (empty($url))? $author_new : "<a href='$url' rel='external'>$author_new</a>";
	
	$author_edit = sanitize_text($author);
	$url_edit = sanitize_text($url,false,true);
	$email_edit = sanitize_text($email);
	$comment_edit = sanitize_text($comment);
	$redirect_to_edit = sanitize_text($redirect_to,false,true);
	include(get_custom_path('confirm-template.php'));
	include(XOOPS_ROOT_PATH."/footer.php");
	exit();
} else {
	if ((get_settings('use_comment_preview'))&&($action=='confirm')) {
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($location,3,$xoopsWPTicket->getErrors());
		}
	}
	$now = current_time('mysql');

	$comment = balanceTags($comment, 1);
	$comment = convert_chars($comment);
	$comment = format_to_post($comment);
	$comment = apply_filters('post_comment_text', $comment);

	$comment_author = $author;
	$comment_author_email = $email;
	$comment_author_url = $url;

	$author = addslashes($author);
	$email = addslashes($email);
	$url = addslashes($url);
	/* Flood-protection */
	$lasttime = $wpdb->get_var("SELECT comment_date FROM {$wpdb->comments[$wp_id]} 
								WHERE comment_author_IP = '$user_ip' 
								ORDER BY comment_date DESC LIMIT 1
							");
	if (!empty($lasttime)) {
		$time_lastcomment= mysql2date('U', $lasttime);
		$time_newcomment= mysql2date('U', "$now");
		if (($time_newcomment - $time_lastcomment) < 10) {
		   	redirect_header($location ,5,_LANG_WPCP_SORRY_SECONDS);
			exit;
		}
	}
	/* End flood-protection */

	$comment_moderation = get_settings('comment_moderation');
	$moderation_notify = get_settings('moderation_notify');
	// o42: this place could be the hook for further comment spam checking
	// $approved should be set according the final approval status
	// of the new comment
	if ('manual' == $comment_moderation) {
		$approved = 0;
	} else { // none
		$approved = 1;
	}
	$wpdb->query("INSERT INTO {$wpdb->comments[$wp_id]} 
					(comment_ID, comment_post_ID, comment_author, comment_author_email,
		 			 comment_author_url, comment_author_IP, comment_date, comment_content, comment_approved) 
	VALUES 
					('0', '$comment_post_ID', '$author', '$email',
					 '$url', '$user_ip', '$now', '$comment', '$approved')
	");

	$comment_ID = $wpdb->get_var('SELECT last_insert_id()');

	if (($moderation_notify) && (!$approved)) {
	    wp_notify_moderator($comment_ID);
	}

	if ((get_settings('comments_notify')) && ($approved)) {
	    wp_notify_postauthor($comment_ID, 'comment');
	}

	if ($email == '')
		$email = ' '; // this to make sure a cookie is set for 'no email'

	if ($url == '')
		$url = ' '; // this to make sure a cookie is set for 'no url'

	do_action('comment_post', $comment_ID);

	setcookie('comment_author_'.$cookiehash, $author, time()+30000000);
	setcookie('comment_author_email_'.$cookiehash, $email, time()+30000000);
	setcookie('comment_author_url_'.$cookiehash, $url, time()+30000000);

	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	if ($is_IIS) {
		header("Refresh: 0;url=$location");
	} else {
		header("Location: $location");
	}
}

?>