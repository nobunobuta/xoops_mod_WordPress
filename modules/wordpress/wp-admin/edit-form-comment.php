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

$_wpTpl =& new WordPresTpl('wp-admin');
$_wpTpl->assign('user_level', $user_level);
$_wpTpl->assign('comment', $comment);
$_wpTpl->assign('commentdata', $commentdata);
$_wpTpl->assign('content', $content);
$_wpTpl->assign('use_quicktags', $use_quicktags);
$_wpTpl->assign('quicktags', $quicktags);
$_wpTpl->assign('referer', $referer);
$_wpTpl->assign('rows', $rows);
$_wpTpl->assign('saveasdraft', $saveasdraft);
$_wpTpl->assign('touchtime', $touchtime);
$_wpTpl->assign('ticket', $ticket);
$_wpTpl->display('edit-form-comment.html');
?>
