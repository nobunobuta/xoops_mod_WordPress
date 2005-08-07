<?php
require(dirname(__FILE__) . '/wp-config.php');
if (get_xoops_option(wp_mod(), 'wp_use_xoops_comments')) return;
init_param('POST', 'author', 'string','');
init_param('POST', 'email', 'string','');
init_param('POST', 'url', 'string','');
init_param('POST', 'comment', 'html','');
init_param('POST', 'comment_post_ID', 'integer','');
init_param('POST', 'redirect_to', 'string','');
init_param('POST', 'action', 'string','');
init_param('POST', 'use_session', 'integer','');

$_author = get_param('author');
$_email = get_param('email');
$_url = get_param('url');
$_comment = get_param('comment');
$_comment_post_ID = get_param('comment_post_ID');
$_redirect_to = get_param('redirect_to');
$_action = get_param('action');
$_use_session = get_param('use_session');

if (!is_email($_email)) {
	$_email = '';
}
$_url_struct = parse_url($_url);
if (!$_url_struct['path']) {
	$_url = '';
} elseif (!isset($_url_struct['scheme'])) {
	$_url = 'http://'.$_url;
} elseif (!preg_match('/^http[s]?$/',$_url_struct['scheme'])) {
	$_url = '';
}

$_location = (!$_redirect_to) ? $_SERVER['HTTP_REFERER'] : $_redirect_to;
$_url_struct = parse_url($_location);
if (isset($_url_struct['scheme']) && !preg_match('/^http[s]?$/',$_url_struct['scheme'])) {
	$_location = wp_siteurl();
}

$_user_ip = $_SERVER['REMOTE_ADDR'];
if ($_use_session) {
	if ( ! $xoopsWPTicket->check() ) {
		display_error($_location, 3, $xoopsWPTicket->getErrors());
	}
}
$postHandler =& wp_handler('Post');
$postObject =& $postHandler->get($_comment_post_ID);
if (!$postObject) {
   	display_error($_location ,5,_LANG_P_OOPS_IDCOM);
}
if ($postObject->getVar('comment_status') == 'closed') {
   	display_error($_location ,5,_LANG_WPCP_SORRY_ITEM);
}

if (get_settings('require_name_email') && ($_email == '' || $_author == '')) { //original fix by Dodo, and then Drinyth
   	display_error($_location ,5,_LANG_WPCP_ERR_FILL);
}
if ($_comment == 'comment' || $_comment == '') {
   	display_error($_location ,5,_LANG_WPCP_ERR_TYPE);
}

$_now = current_time('mysql');

$_comment = balanceTags($_comment, 1);
$_comment = convert_chars($_comment);
$_comment = apply_filters('post_comment_text', $_comment);
$_comment_author = $_author;
$_comment_author_email = $_email;
$_comment_author_url = $_url;

$commentHandler =& wp_handler('Comment');

/* Flood-protection */
$_ok = true;
$_criteria = new Criteria('comment_author_IP', $_user_ip);
$_criteria->setSort('comment_date');
$_criteria->setOrder('DESC');
$_criteria->setLimit(1);
$commentObjects = $commentHandler->getObjects($_criteria);
if (count($commentObjects) > 0) {
	$_lasttime = $commentObjects[0]->getVar('comment_date');
	if ((mysql2date('U', "$_now") - mysql2date('U', $_lasttime)) < 10)
		$_ok = false;
}
/* End flood-protection */

if ($_ok) { // if there was no comment from this IP in the last 10 seconds
	// o42: this place could be the hook for further comment spam checking
	// $_approved should be set according the final approval status
	// of the new comment
	if (get_settings('comment_moderation') == 'manual') {
		$_approved = 0;
	} else { // none
		$_approved = 1;
	}
	$commentObject =& $commentHandler->create();
	$commentObject->setVar('comment_post_ID',$_comment_post_ID);
	$commentObject->setVar('comment_author',$_author);
	$commentObject->setVar('comment_author_email',$_email);
	$commentObject->setVar('comment_author_url',$_url);
	$commentObject->setVar('comment_author_IP',$_user_ip);
	$commentObject->setVar('comment_date',$_now);
	$commentObject->setVar('comment_content',$_comment);
	$commentObject->setVar('comment_approved',$_approved);
	if(!$commentHandler->insert($commentObject)) {
		display_error($_location, 3, $commentHandler->getErrors());
	}
	$_comment_ID = $commentObject->getVar('comment_ID');
	do_action('comment_post', $_comment_ID);
	if ((get_settings('moderation_notify')) && (!$_approved)) {
	    wp_notify_moderator($_comment_ID);
	}
	if ((get_settings('comments_notify')) && ($_approved)) {
	    wp_notify_postauthor($_comment_ID, 'comment');
	}
	if ($_email == '')
		$_email = ' '; // this to make sure a cookie is set for 'no email'
	if ($_url == '')
		$_url = ' '; // this to make sure a cookie is set for 'no url'

	setcookie('comment_author_'.$GLOBALS['cookiehash'], $_author, time()+30000000);
	setcookie('comment_author_email_'.$GLOBALS['cookiehash'], $_email, time()+30000000);
	setcookie('comment_author_url_'.$GLOBALS['cookiehash'], $_url, time()+30000000);
	if ($GLOBALS['is_IIS']) {
		header('Refresh: 0;url='.$_location);
	} else {
		header('Location: '.$_location);
	}
} else {
	display_error($_location ,5,_LANG_WPCP_SORRY_SECONDS);
}
function display_error($url, $dum, $mess) {
	$blogname = get_bloginfo('name'); //ブログのタイトル
	$echostring  = '<html>';
	$echostring .= '<!--美乳-->';
	$echostring .= '<head>';
	$echostring .= '<title>'.$blogname.' Ktai edition</title>';
	$echostring .= '<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />';
	$echostring .= '</head>';
	$echostring .= '<body>';
	$echostring .= '<center>'.$blogname.'<br />Ktai edition</center><hr />';
	$echostring .= 'Error : '.$mess.'<hr>';
	$echostring .= '<a href="'.$url.'">戻る</a>';
	$echostring .= '</body>';
	$echostring .= '</html>';
	header("Content-Type: text/html; charset=Shift_JIS");
	echo mb_convert_encoding($echostring, "sjis", "auto");
	exit();
}
?>