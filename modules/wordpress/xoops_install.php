<?PHP
function xoops_module_install_WordPress(&$module)
{
	global $xoopsDB, $xoopsUser, $xoopsConfig;
	$db =& Database::getInstance();

	$url = XOOPS_URL."/modules/".$module->getVar('dirname');
    $query= "UPDATE ".$db->prefix("wp_options")." set option_value='$url' where option_id=1"; //siteurl
    $q = $db->query($query);
    $query= "UPDATE ".$db->prefix("wp_options")." set option_value='$url' where option_id=28"; //blodotgsping_url
    $q = $db->query($query);
    $query= "UPDATE ".$db->prefix("wp_options")." set option_value='$url/wp-images/smilies' where option_id=17"; //smilies_directory
    $q = $db->query($query);

	$now = date('Y-m-d H:i:s');
	$query = "INSERT INTO ".$db->prefix("wp_posts")." (post_author, post_date, post_content, post_title, post_category) VALUES ('".$xoopsUser->uid()."', '$now', "._MI_WORDPRESS_INST_POST_CONTENT.", "._MI_WORDPRESS_INST_POST_TITLE.", '1')";

	$q = $db->query($query);

	$query = "INSERT INTO ".$db->prefix("wp_comments")." (comment_post_ID, comment_author, comment_author_email, comment_author_url, comment_author_IP, comment_date, comment_content) VALUES ('1', 'NobuNobu Xoops', 'mail@example.com', 'http://www.kowa.org/', '127.0.0.1', '$now',"._MI_WORDPRESS_INST_COMMENT_CONTENT.")";

	$q = $db->query($query);

	$query = "INSERT INTO ".$db->prefix("wp_options")." (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (22, 0, 'rss_language', 'Y', 3, "._MI_WORDPRESS_INST_OPTIONS_22.", 20, 8, '_LANG_INST_BASE_VALUE22', 8)";

	$q = $db->query($query);
	
	$query = "INSERT INTO ".$db->prefix("wp_options")." (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (52, 0, 'date_format', 'Y', 3, "._MI_WORDPRESS_INST_OPTIONS_52.", 20, 8, '_LANG_INST_BASE_VALUE52', 4)";

	$q = $db->query($query);
	
	$query = "INSERT INTO ".$db->prefix("wp_options")." (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (53, 0, 'time_format', 'Y', 3, "._MI_WORDPRESS_INST_OPTIONS_53.", 20, 8, '_LANG_INST_BASE_VALUE53', 4)";

	$q = $db->query($query);
	
	$query = "INSERT INTO ".$db->prefix("wp_optionvalues")." (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (59, 'SELECT cat_id AS value, cat_name AS label FROM ".$db->prefix("wp_categories")." order by cat_name', '', NULL, NULL, 1)";

	$q = $db->query($query);

	
	$level = 10;
	$uname = $xoopsDB->quoteString($xoopsUser->getVar('uname'));
	$email = $xoopsDB->quoteString($xoopsUser->getVar('email'));
	$sql = "INSERT INTO ".$db->prefix("wp_users")." (ID, user_login,user_nickname,user_email, user_level,user_idmode) values(".$xoopsUser->uid().", $uname , $uname , $email , $level, 'nickname' )";
	$q = $db->query($sql);

	return true;
}
?>
