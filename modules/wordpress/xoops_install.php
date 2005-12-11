<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname( __FILE__ ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

function _xoops_module_install_wordpress($dirname, $prefix)
{
	$db =& Database::getInstance();

	$url = XOOPS_URL.'/modules/'.$dirname;
	$path = XOOPS_ROOT_PATH.'/modules/'.$dirname;

    $query= 'UPDATE '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." set option_value='$url' where option_id=1"; //siteurl
    $q = $GLOBALS['xoopsDB']->query($query);
    $query= 'UPDATE '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." set option_value='$url' where option_id=28"; //blodotgsping_url
    $q = $GLOBALS['xoopsDB']->query($query);
    $query= 'UPDATE '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." set option_value='$url/wp-images/smilies' where option_id=17"; //smilies_directory
    $q = $GLOBALS['xoopsDB']->query($query);
    $query= 'UPDATE '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." set option_value='$path/attach' where option_id=32"; //upload url
    $q = $GLOBALS['xoopsDB']->query($query);
    $query= 'UPDATE '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." set option_value='$url/attach' where option_id=33"; //upload url
    $q = $GLOBALS['xoopsDB']->query($query);

	$now = date('Y-m-d H:i:s');
	$query = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}posts")." (post_author, post_date, post_content, post_title, post_category, post_name, post_modified) VALUES ('".$GLOBALS['xoopsUser']->uid()."', '$now', "._MI_WORDPRESS_INST_POST_CONTENT.', '._MI_WORDPRESS_INST_POST_TITLE.", '1', 'wellcome', '$now')";

	$q = $GLOBALS['xoopsDB']->query($query);

	$query = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}comments")." (comment_post_ID, comment_author, comment_author_email, comment_author_url, comment_author_IP, comment_date, comment_content) VALUES ('1', 'NobuNobu Xoops', 'mail@example.com', 'http://www.kowa.org/', '127.0.0.1', '$now',"._MI_WORDPRESS_INST_COMMENT_CONTENT.")";

	$q = $GLOBALS['xoopsDB']->query($query);

	$query = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (22, 0, 'rss_language', 'Y', 3, "._MI_WORDPRESS_INST_OPTIONS_22.", 20, 8, '_LANG_INST_BASE_VALUE22', 8)";

	$q = $GLOBALS['xoopsDB']->query($query);
	
	$query = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (52, 0, 'date_format', 'Y', 3, "._MI_WORDPRESS_INST_OPTIONS_52.", 20, 8, '_LANG_INST_BASE_VALUE52', 4)";

	$q = $GLOBALS['xoopsDB']->query($query);
	
	$query = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}options")." (`option_id`, `blog_id`, `option_name`, `option_can_override`, `option_type`, `option_value`, `option_width`, `option_height`, `option_description`, `option_admin_level`) VALUES (53, 0, 'time_format', 'Y', 3, "._MI_WORDPRESS_INST_OPTIONS_53.", 20, 8, '_LANG_INST_BASE_VALUE53', 4)";

	$q = $GLOBALS['xoopsDB']->query($query);
	
	$query = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}optionvalues")." (`option_id`, `optionvalue`, `optionvalue_desc`, `optionvalue_max`, `optionvalue_min`, `optionvalue_seq`) VALUES (59, 'SELECT cat_id AS value, cat_name AS label FROM ".$GLOBALS['xoopsDB']->prefix("{$prefix}categories")." order by cat_name', '', NULL, NULL, 1)";

	$q = $GLOBALS['xoopsDB']->query($query);

	
	$level = 10;
	$uname = $GLOBALS['xoopsDB']->quoteString($GLOBALS['xoopsUser']->getVar('uname'));
	$email = $GLOBALS['xoopsDB']->quoteString($GLOBALS['xoopsUser']->getVar('email'));
	$sql = 'INSERT INTO '.$GLOBALS['xoopsDB']->prefix("{$prefix}users")." (ID, user_login,user_nickname,user_email, user_level,user_idmode) values(".$GLOBALS['xoopsUser']->uid().", $uname , $uname , $email , $level, 'nickname' )";
	$q = $GLOBALS['xoopsDB']->query($sql);

	return true;
}

eval ('
	function xoops_module_install_'.$_wp_my_dirname.'(&$module) {
		return (_xoops_module_install_wordpress("'.$_wp_my_dirname.'", "'.$_wp_my_prefix.'"));
	}
');
?>
