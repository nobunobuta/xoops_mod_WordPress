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
if (!$_url_struct) {
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

	$_comment_new = apply_filters('comment_text', $_comment);
	$_author_new = apply_filters('comment_author', $_author);
?>
<div id="wpMainContent">
<h2 id="comments"><?php echo _LANG_WPCM_COM_TITLE." (Preview)"; ?></h2>
<ol id="commentlist">
	<li id="comment-prev ?>">
	<?php echo $_comment_new; ?> by 
<?php 
	if (empty($_url)) {
		echo $_author;
	} else {
		echo "<a href='$_url' rel='external'>$_author_new</a>";
	}
?>
	</li>
</ol>
<form action="<?php echo wp_siteurl(); ?>/wp-comments-post.php" method="post" id="commentform">
	<input type="hidden" name="author" id="author" class="textarea" value="<?php echo $_author; ?>" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $_comment_post_ID; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo $_redirect_to; ?>" />
	<input type="hidden" name="email" id="email" value="<?php echo $_email; ?>" />
	<input type="hidden" name="url" id="url" value="<?php echo $_url; ?>" />
	<input type="hidden" name="comment" id="comment" value="<?php echo htmlspecialchars($_comment); ?>" />
	<?php echo $xoopsWPTicket->getTicketHtml(__LINE__) ?>
	<input type="hidden" name="action" id="action"  value="confirm" />
	<p>
	  <input name="submit" type="submit" tabindex="5" value="Confirm" />
	</p>
</form>
<h2><?php echo _LANG_WPCM_COM_LEAVE; ?></h2>
<p><?php echo _LANG_WPCM_HTML_ALLOWED; ?><code><?php echo allowed_tags(); ?></code></p>
<form action="<?php echo wp_siteurl(); ?>/wp-comments-post.php" method="post" id="commentform">
	<p>
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo $_author; ?>" size="28" tabindex="1" />
	  <label for="author"><?php echo _LANG_WPCM_COM_NAME ?></label>
	  <input type="hidden" name="comment_post_ID" value="<?php echo $_comment_post_ID; ?>" />
	  <input type="hidden" name="redirect_to" value="<?php echo $_redirect_to; ?>" />
	</p>
	<p>
	  <input type="text" name="email" id="email" value="<?php echo $_email; ?>" size="28" tabindex="2" />
	  <label for="email"><?php echo _LANG_WUS_AU_MAIL; ?></label>
	</p>
	<p>
	  <input type="text" name="url" id="url" value="<?php echo $_url; ?>" size="28" tabindex="3" />
	  <label for="url"><?php echo _LANG_WUS_AU_URI; ?></label>
	</p>
	<p>
	  <label for="comment"><?php echo _LANG_WPCM_COM_YOUR; ?></label>
	<br />
	  <textarea name="comment" id="comment" cols="70" rows="4" tabindex="4" ><?php echo $_comment; ?></textarea>
	</p>
	<p>
	  <input name="submit" type="submit" tabindex="5" value="<?php echo _LANG_WPCM_COM_SAYIT; ?>" />
	</p>
</form>
</div>
<?php
	include(XOOPS_ROOT_PATH."/footer.php");
	exit();
} else {
	if ((get_settings('use_comment_preview'))&&($_action=='confirm')) {
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($_location, 3, $xoopsWPTicket->getErrors());
		}
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
	$commentHandler->insert($commentObject);
	if(!$commentHandler->insert($postObject)) {
		redirect_header($_location, 3, $commentHandler->getErrors());
	}
	$_comment_ID = $commentObject->getVar('comment_ID');
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

	do_action('comment_post', $_comment_ID);
	setcookie('comment_author_'.$GLOBALS['cookiehash'], $_author, time()+30000000);
	setcookie('comment_author_email_'.$GLOBALS['cookiehash'], $_email, time()+30000000);
	setcookie('comment_author_url_'.$GLOBALS['cookiehash'], $_url, time()+30000000);
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	if ($GLOBALS['is_IIS']) {
		header("Refresh: 0;url=$_location");
	} else {
		header("Location: $_location");
	}
} else {
	   	redirect_header($_location ,5,_LANG_WPCP_SORRY_SECONDS);
	}
}

?>