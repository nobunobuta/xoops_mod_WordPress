<?php
$rows = get_settings('default_post_edit_rows');
if (($rows < 3) || ($rows > 100)) {
    $rows = 10;
}

$use_quicktags = (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx))));
ob_start();
include('quicktags.php');
$quicktags = ob_get_contents();
ob_end_clean();

$referer = urlencode($_SERVER['HTTP_REFERER']);

$touchtime = touch_time(0, false);

$ticket = $xoopsWPTicket->getTicketHtml(__LINE__);

$wpTpl =& new XoopsTpl;
$wpTpl->assign('user_level', $user_level);
$wpTpl->assign('comment', $comment);
$wpTpl->assign('commentdata', $commentdata);
$wpTpl->assign('content', $content);
$wpTpl->assign('use_quicktags', $use_quicktags);
$wpTpl->assign('quicktags', $quicktags);
$wpTpl->assign('referer', $referer);
$wpTpl->assign('rows', $rows);
$wpTpl->assign('saveasdraft', $saveasdraft);
$wpTpl->assign('touchtime', $touchtime);
$wpTpl->assign('ticket', $ticket);
$wpTpl->template_dir = wp_base().'/wp-admin/templates/';
$wpTpl->display('edit-form-comment.html');
?>
