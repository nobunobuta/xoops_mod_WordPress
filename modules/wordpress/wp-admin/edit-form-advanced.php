<?php
$rows = get_settings('default_post_edit_rows');
if (($rows < 3) || ($rows > 100)) {
    $rows = 10;
}
$category_select = categories_nested_select($post_categories);

$comment_check_open = checked($comment_status, 'open', false);
$comment_check_close = checked($comment_status, 'closed', false);
$ping_check_open = checked($ping_status, 'open', false);
$ping_check_close = checked($ping_status, 'closed', false);

$use_quicktags = (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx)))&&($mode != 'bookmarklet')) ;
$use_spaw = ($GLOBALS['wp_use_spaw']);
// $use_koivi = $GLOBALS['wp_use_koivi'];

$smilies = array();
foreach($wpsmiliestrans[$wp_id] as $smiley => $img) {
	$smile['id'] = str_replace("'","\'",$smiley);
	$smile['path'] = $smilies_directory.'/'.$img;
	$smile['name'] = $smiley;
	$smilies[] = $smile;
}

if ($use_spaw) {
	include_once "spaw/spaw_control.class.php";
	$trans_tbl = get_html_translation_table (HTML_SPECIALCHARS);
	$trans_tbl = array_flip ($trans_tbl);
	$content = strtr ($content, $trans_tbl);
	$sw = new SPAW_Wysiwyg( 'wp_content', $content, _LANGCODE, 'full', 'default', '70%', '400px' );
	$spaw_form = $sw->getHtml();
//} else if ($use_koivi) {
//	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
//	include_once "wysiwyg/formwysiwygtextarea.php";
//	$trans_tbl = get_html_translation_table (HTML_SPECIALCHARS);
//	$trans_tbl = array_flip ($trans_tbl);
//	$content = strtr ($content, $trans_tbl);
//	$wysiwyg_text_area = new XoopsFormWysiwygTextArea( $caption, 'wp_content', $content, '100%', '400px','');
//	$wysiwyg_text_area->setUrl(wp_siteurl(). "/wp-admin/wysiwyg");
//	$spaw_form = $wysiwyg_text_area->render();
} else {
	$spaw_form = "";
}
$allowed_users = explode(" ", trim(get_settings('fileupload_allowedusers')));
$can_upload = ( (get_settings('use_fileupload')) && ($user_level >= get_settings('fileupload_minlevel')) && (in_array($user_login, $allowed_users) || (trim(get_settings('fileupload_allowedusers'))=="")) );

$use_pingback = get_settings('use_pingback');
$ping_checked = '';

$use_trackback = get_settings('use_trackback');
$pingedlist = array();
if ($pinged != '') {
	$already_pinged = explode("\n", trim($pinged));
	foreach ($already_pinged as $pinged_url) {
		$pingedlist[] = $pinged_url;
	}
}

ob_start();
do_action('edit_form_advanced', '');
$form_addon = ob_get_contents();
ob_end_clean();

$ticket = $xoopsWPTicket->getTicketHtml(__LINE__, 10800);

$use_geo_positions = get_settings('use_geo_positions');
if ($use_geo_positions) {
    if (empty($edited_lat)) {
        if (get_settings('use_default_geourl')) {
            $edited_lat = get_settings('default_geourl_lat');
            $edited_lon = get_settings('default_geourl_lon');
        }
    }
}

$touchtime = touch_time(1,false);

if (!empty($_SERVER['HTTP_REFERER'])) {
	$referer = urlencode($_SERVER['HTTP_REFERER']);
} else {
	$referer = "";
}

$criteria = new Criteria('post_id',$post_ID);
$criteria->setSort(array('meta_key','meta_id'));
$postmetaObjects =& $postmetaHandler->getObjects($criteria);
$postmetaRows = array();
if ($postmetaObjects) {
	foreach($postmetaObjects as $postmetaObject) {
		$postmetaRows[] =& $postmetaObject->getVarArray("e");
	}
}
$criteria = new Criteria(1,1);
$criteria->setSort('meta_id');
$criteria->setOrder('DESC');
$criteria->setGroupby('meta_key');
$postmetaKeys = array();
$postmetakeyObjects =& $postmetaHandler->getObjects($criteria, false);
if ($postmetakeyObjects) {
	foreach($postmetakeyObjects as $postmetakeyObject) {
		$postmetaKeys[] = $postmetakeyObject->getVar('meta_key');
	}
}
$wpTpl =& new XoopsTpl;
$wpTpl->error_reporting  = error_reporting();
$wpTpl->assign('user_ID', $user_ID);
$wpTpl->assign('user_level', $user_level);
$wpTpl->assign('post_ID', $post_ID);
$wpTpl->assign('post_status', $post_status);
$wpTpl->assign('post_password', $post_password);
$wpTpl->assign('mode', $mode);
$wpTpl->assign('edited_post_title', $edited_post_title);
$wpTpl->assign('category_select', $category_select);
$wpTpl->assign('comment_check_open', $comment_check_open);
$wpTpl->assign('comment_check_close', $comment_check_close);
$wpTpl->assign('ping_check_open', $ping_check_open);
$wpTpl->assign('ping_check_close', $ping_check_close);
$wpTpl->assign('excerpt', $excerpt);
$wpTpl->assign('use_quicktags', $use_quicktags);
$wpTpl->assign('smilies', $smilies);
$wpTpl->assign('use_spaw', $use_spaw);
$wpTpl->assign('use_koivi', false);
$wpTpl->assign('spaw_form', $spaw_form);
$wpTpl->assign('content', $content);
$wpTpl->assign('rows', $rows);
$wpTpl->assign('use_geo_positions', $use_geo_positions);
$wpTpl->assign('edited_lat', $edited_lat);
$wpTpl->assign('edited_lon', $edited_lon);
$wpTpl->assign('use_pingback', $use_pingback);
$wpTpl->assign('ping_checked', $ping_checked);
$wpTpl->assign('can_upload', $can_upload);
$wpTpl->assign('referer', $referer);
$wpTpl->assign('use_trackback', $use_trackback);
$wpTpl->assign('pinged', $pinged);
$wpTpl->assign('pingedlist', $pingedlist);
$wpTpl->assign('touchtime', $touchtime);
$wpTpl->assign('form_addon', $form_addon);
$wpTpl->assign('ticket', $ticket);
$wpTpl->assign('postmetaRows', $postmetaRows);
$wpTpl->assign('postmetaKeys', $postmetaKeys);
$wpTpl->template_dir = wp_base().'/wp-admin/templates/';
$wpTpl->display('edit-form-advanced.html');
return;
?>
