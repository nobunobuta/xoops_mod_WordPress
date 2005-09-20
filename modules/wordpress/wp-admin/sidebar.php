<?php
require_once('admin.php');
$mode = 'sidebar';
$standalone = 1;
$title = "";
require_once('admin-header.php');

if ($user_level <= 0) {
	redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
}
init_param('GET', 'action', 'string','');

require_once(XOOPS_ROOT_PATH.'/class/template.php');

$_wpTpl =& new WordPresTpl('wp-admin');
$_wpTpl->assign('action', $action);
$_wpTpl->assign('admin_area_charset', $admin_area_charset);

if ($action != 'done') {
	$category_select = categories_nested_select(array(get_settings('default_post_category')));
    $ticket = $xoopsWPTicket->getTicketHtml(__LINE__, 10800);
	$_wpTpl->assign('user_ID', $user_ID);
	$_wpTpl->assign('category_select', $category_select);
	$_wpTpl->assign('ticket', $ticket);
}
$_wpTpl->display('sidebar.html');
require_once('admin-footer.php');
?>
