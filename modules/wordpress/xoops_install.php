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
	$query = "INSERT INTO ".$db->prefix("wp_posts")." (post_author, post_date, post_content, post_title, post_category) VALUES ('".$xoopsUser->uid()."', '$now', 'WordPress ME for Xoops2の導入成功おめでとうございます。<br /> . This is the first post. Edit or delete it, then start blogging!', 'ようこそ、WordPressの世界へ！', '1')";

	$q = $db->query($query);

	$query = "INSERT INTO ".$db->prefix("wp_comments")." (comment_post_ID, comment_author, comment_author_email, comment_author_url, comment_author_IP, comment_date, comment_content) VALUES ('1', 'NobuNobu Xoops', 'mail@example.com', 'http://www.kowa.org/', '127.0.0.1', '$now', 'コメントのサンプルです！<br />To delete a comment, just log in, and view the posts\' comments, there you will have the option to edit or delete them.')";
	$q = $db->query($query);

	$level = 10;
	$uname = $xoopsDB->quoteString($xoopsUser->getVar('uname'));
	$email = $xoopsDB->quoteString($xoopsUser->getVar('email'));
	$sql = "INSERT INTO ".$db->prefix("wp_users")." (ID, user_login,user_nickname,user_email, user_level,user_idmode) values(".$xoopsUser->uid().", $uname , $uname , $email , $level, 'nickname' )";
	$q = $db->query($sql);

	return true;
}
?>
