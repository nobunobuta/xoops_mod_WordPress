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

$_author = get_param('author');
$_email = get_param('email');
$_url = get_param('url');
$_comment = get_param('comment');
$_comment_post_ID = get_param('comment_post_ID');
$_redirect_to = get_param('redirect_to');
$_action = get_param('action');

if (!is_email($_email)) {
	$_email = '';
}
$_url_struct = parse_url($_url);
if (!$_url_struct['host']) {
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

$postHandler =& wp_handler('Post');
$postObject =& $postHandler->get($_comment_post_ID);
if (!$postObject) {
   	redirect_header($_location ,5,_LANG_P_OOPS_IDCOM);
}
if ($postObject->getVar('comment_status') == 'closed') {
   	redirect_header($_location ,5,_LANG_WPCP_SORRY_ITEM);
}

if (get_settings('require_name_email') && ($_email == '' || $_author == '')) { //original fix by Dodo, and then Drinyth
   	redirect_header($_location ,5,_LANG_WPCP_ERR_FILL);
}
if ($_comment == 'comment' || $_comment == '') {
   	redirect_header($_location ,5,_LANG_WPCP_ERR_TYPE);
}

if ((get_settings('use_comment_preview'))&&($_action!='confirm')) {
	$GLOBALS['show_cblock'] =0;
	include('header.php');
	$_comment = balanceTags($_comment, 1);
	$_comment = convert_chars($_comment);
	$_comment = apply_filters('post_comment_text', $_comment);

	$comment_preview = apply_filters('comment_text', $_comment);
	$author_preview = apply_filters('comment_author', $_author);

	if (!empty($_url)) {
		$author_preview = '<a href="'.$_url.'" rel="external">'.$author_preview.'</a>';
	}

	include(get_custom_path('confirm-template.php'));

	include(XOOPS_ROOT_PATH.'/footer.php');
	exit();
} else {
	if ((get_settings('use_comment_preview'))&&($_action=='confirm')) {
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($_location, 3, $xoopsWPTicket->getErrors());
		}
	}
$_now = current_time('mysql',0);

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
		$approved = 0;
	} else { // none
		$approved = 1;
	}
	$commentObject =& $commentHandler->create();
	$commentObject->setVar('comment_post_ID', $_comment_post_ID, true);
	$commentObject->setVar('comment_author',$_author, true);
	$commentObject->setVar('comment_author_email',$_email, true);
	$commentObject->setVar('comment_author_url',$_url, true);
	$commentObject->setVar('comment_author_IP',$_user_ip, true);
	$commentObject->setVar('comment_date',$_now, true);
	$commentObject->setVar('comment_content',$_comment, true);
	$commentObject->setVar('comment_approved',$approved, true);
	$commentObject->setVar('comment_type','comment', true);
	if(!$commentHandler->insert($commentObject, get_settings('use_comment_preview'))) {
		redirect_header($_location, 3, $commentHandler->getErrors());
	}
	$_comment_ID = $commentObject->getVar('comment_ID');
	do_action('comment_post', $_comment_ID);
	if ((get_settings('moderation_notify')) && (!$approved)) {
	    wp_notify_moderator($_comment_ID);
	}
	if ((get_settings('comments_notify')) && ($approved)) {
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
	   	redirect_header($_location ,5,_LANG_WPCP_SORRY_SECONDS);
	}
}

?>