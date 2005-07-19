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
if ($GLOBALS['wp_use_spaw']) {
	if ($is_gecko || $is_winIE) {
		if (file_exists(dirname(__FILE__).'/spaw/spaw_control.class.php')) {
			$use_spaw = true;
			$spaw_root = dirname(__FILE__).'/spaw/';
		} else if (file_exists(XOOPS_ROOT_PATH.'/common/spaw/spaw_control.class.php')) {
			$use_spaw = true;
			$spaw_root = XOOPS_ROOT_PATH.'/common/spaw/';
		}
		if (!file_exists($spaw_root.'class/script_gecko.js.php') && $is_gecko) {
			$use_spaw = false;
		}
	}
} else {
	$use_spaw = false;
}
// $use_koivi = $GLOBALS['wp_use_koivi'];

$smilies = array();
foreach($GLOBALS['wpsmiliestrans'][wp_id()] as $smiley => $img) {
	$smile['id'] = str_replace("'","\'",$smiley);
	$smile['path'] = $smilies_directory.'/'.$img;
	$smile['name'] = $smiley;
	$smilies[] = $smile;
}

if ($use_spaw) {
	include_once $spaw_root."spaw_control.class.php";
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
	$_style = "";
	foreach($postmetaObjects as $postmetaObject) {
		$_style = ('class="odd"' == $_style) ? 'class="even"' : 'class="odd"';
		$postmetaRow =& $postmetaObject->getVarArray("e");
		$postmetaRow['style'] = $_style;
		$postmetaRows[] =& $postmetaRow;
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
		$postmetaKeys[] =  $postmetakeyObject->getVar('meta_key');
	}
}
$_wpTpl =& new WordPresTpl('wp-admin');
$_wpTpl->assign('user_ID', $user_ID);
$_wpTpl->assign('user_level', $user_level);
$_wpTpl->assign('post_ID', $post_ID);
$_wpTpl->assign('post_status', $post_status);
$_wpTpl->assign('post_password', $post_password);
$_wpTpl->assign('mode', $mode);
$_wpTpl->assign('edited_post_title', $edited_post_title);
$_wpTpl->assign('category_select', $category_select);
$_wpTpl->assign('comment_check_open', $comment_check_open);
$_wpTpl->assign('comment_check_close', $comment_check_close);
$_wpTpl->assign('ping_check_open', $ping_check_open);
$_wpTpl->assign('ping_check_close', $ping_check_close);
$_wpTpl->assign('excerpt', $excerpt);
$_wpTpl->assign('use_quicktags', $use_quicktags);
$_wpTpl->assign('smilies', $smilies);
$_wpTpl->assign('use_spaw', $use_spaw);
$_wpTpl->assign('use_koivi', false);
$_wpTpl->assign('spaw_form', $spaw_form);
$_wpTpl->assign('content', $content);
$_wpTpl->assign('rows', $rows);
$_wpTpl->assign('use_geo_positions', $use_geo_positions);
$_wpTpl->assign('edited_lat', $edited_lat);
$_wpTpl->assign('edited_lon', $edited_lon);
$_wpTpl->assign('use_pingback', $use_pingback);
$_wpTpl->assign('ping_checked', $ping_checked);
$_wpTpl->assign('can_upload', $can_upload);
$_wpTpl->assign('referer', $referer);
$_wpTpl->assign('use_trackback', $use_trackback);
$_wpTpl->assign('pinged', $pinged);
$_wpTpl->assign('pingedlist', $pingedlist);
$_wpTpl->assign('touchtime', $touchtime);
$_wpTpl->assign('form_addon', $form_addon);
$_wpTpl->assign('ticket', $ticket);
$_wpTpl->assign('postmetaRows', $postmetaRows);
$_wpTpl->assign('postmetaKeys', $postmetaKeys);
$_wpTpl->display('edit-form-advanced.html');
return;
?>
