<?php
// This array constructs the admin menu bar.
//
// Menu item name
// The minimum level the user needs to access the item: between 0 and 10
// The URL of the item's file
$menu[5] = array(_LANG_ADMIN_MENU_WRITE, 1, 'post.php');
$menu[10] = array(_LANG_ADMIN_MENU_EDIT, 1, 'edit.php');
$menu[20] = array(_LANG_ADMIN_MENU_CATE, 3, 'categories.php');
$menu[25] = array(_LANG_ADMIN_MENU_LINK, 5, 'link-manager.php');
$menu[30] = array(_LANG_ADMIN_MENU_USER, 3, 'users.php');
$menu[35] = array(_LANG_ADMIN_MENU_OPTION, 6, 'options.php');
$menu[40] = array(_LANG_ADMIN_MENU_PLUG, 8, 'plugins.php');
$menu[45] = array(_LANG_ADMIN_MENU_PROFILE, 0, 'profile.php');
ksort($menu); // So other files can plugin

$submenu['edit.php'][5] = array(_LANG_E_LATEST_POSTS, 1, 'edit.php');
$submenu['edit.php'][20] = array(_LANG_E_LATEST_COMMENTS, 1, 'edit-comments.php');
$awaiting_mod = $wpdb->get_var("SELECT COUNT(*) FROM ".wp_table('comments')." WHERE comment_approved = '0'");
$submenu['edit.php'][25] = array(sprintf(_LANG_E_AWAIT_MODER." (%s)", $awaiting_mod), 1, 'moderation.php');

$submenu['link-manager.php'][5] = array(_LANG_WLA_MANAGE_LINK, 5, 'link-manager.php');
$submenu['link-manager.php'][10] = array(_LANG_WLA_ADD_LINK, 5, 'link-add.php');
$submenu['link-manager.php'][15] = array(_LANG_WLA_LINK_CATE, 5, 'link-categories.php');
$submenu['link-manager.php'][20] = array(_LANG_WLA_IMPORT_BLOG, 5, 'link-import.php');

$option_groups = $wpdb->get_results("
							SELECT group_id, group_name, group_desc, group_longdesc 
							FROM ".wp_table('optiongroups')." ORDER BY group_id
						");
$submenu['options.php'] = array();
foreach ($option_groups as $option_group) {
	$submenu['options.php'][] = array($option_group->group_name, 6,"options.php?option_group_id={$option_group->group_id}");
}
$submenu['options.php'][] = array(_LANG_WOP_PERM_LINKS,9,'options-permalink.php');

do_action('admin_menu', '');
?>