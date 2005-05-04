<?php
$colspan = 3;
$rows = get_settings('default_post_edit_rows');
if (($rows < 3) || ($rows > 100)) {
    $rows = 10;
}
$category_select = categories_nested_select(array($default_post_cat));

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
//	include_once 'wysiwyg/formwysiwygtextarea.php';
//	$trans_tbl = get_html_translation_table (HTML_SPECIALCHARS);
//	$trans_tbl = array_flip ($trans_tbl);
//	$content = strtr ($content, $trans_tbl);
//	$wysiwyg_text_area = new XoopsFormWysiwygTextArea( $caption, 'wp_content', $content, '100%', '400px','');
//	$wysiwyg_text_area->setUrl(wp_siteurl()."/wp-admin/wysiwyg");
//	$spaw_form = $wysiwyg_text_area->render();
} else {
	$spaw_form = "";
}

$allowed_users = explode(" ", trim(get_settings('fileupload_allowedusers')));
$can_upload = ( (get_settings('use_fileupload')) && ($user_level >= get_settings('fileupload_minlevel')) && (in_array($user_login, $allowed_users) || (trim(get_settings('fileupload_allowedusers'))=="")) );

$use_pingback = get_settings('use_pingback');
if (!empty($post_pingback)) {
	$ping_checked = 'checked="checked"';
} else {
	$ping_checked = '';
}

$use_trackback = get_settings('use_trackback');
$pingedlist = array();
if ($pinged != '') {
	$already_pinged = explode("\n", trim($pinged));
	foreach ($already_pinged as $pinged_url) {
		$pingedlist[] = $pinged_url;
	}
}
ob_start();
do_action('simple_edit_form', '');
$form_addon = ob_get_contents();
ob_end_clean();

$ticket = $xoopsWPTicket->getTicketHtml(__LINE__, 10800);
if (!empty($_SERVER['HTTP_REFERER'])) {
	$referer = urlencode($_SERVER['HTTP_REFERER']);
} else {
	$referer = "";
}

$wpTpl =& new XoopsTpl;
$wpTpl->error_reporting = error_reporting();
$wpTpl->assign('user_ID', $user_ID);
$wpTpl->assign('user_level', $user_level);
$wpTpl->assign('mode', $mode);
$wpTpl->assign('edited_post_title', $edited_post_title);
$wpTpl->assign('category_select', $category_select);
$wpTpl->assign('use_quicktags', $use_quicktags);
$wpTpl->assign('smilies', $smilies);
$wpTpl->assign('use_spaw', $use_spaw);
$wpTpl->assign('use_koivi', false);
$wpTpl->assign('spaw_form', $spaw_form);
$wpTpl->assign('content', $content);
$wpTpl->assign('rows', $rows);
$wpTpl->assign('use_pingback', $use_pingback);
$wpTpl->assign('ping_checked', $ping_checked);
$wpTpl->assign('can_upload', $can_upload);
$wpTpl->assign('referer', $referer);
$wpTpl->assign('use_trackback', $use_trackback);
$wpTpl->assign('trackback_url', $trackback_url);
$wpTpl->assign('pinged', $pinged);
$wpTpl->assign('pingedlist', $pingedlist);
$wpTpl->assign('form_addon', $form_addon);
$wpTpl->assign('target_charset', $target_charset);
$wpTpl->assign('ticket', $ticket);
$wpTpl->template_dir = wp_base().'/wp-admin/templates/';
$wpTpl->display('edit-form.html');

return;
?>
