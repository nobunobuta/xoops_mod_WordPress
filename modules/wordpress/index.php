<?php 
/* Don't remove these lines. */
$blog = 1;
include("header.php");
if (preg_match('/DoCoMo/', $_SERVER['HTTP_USER_AGENT']) and file_exists(dirname(__FILE__)."/wp-ktai.php")) { 
	header('Location: ' . XOOPS_URL.'/modules/wordpress'.(($wp_id=='-') ?'':$wp_id)."/wp-ktai.php\n");
}
wp_head();
// Uncomment the next line if you want to track blog updates from weblogs.com
//include_once(ABSPATH.WPINC.'/links-update-xml.php');
include(get_custom_path('index-template.php'));
include(XOOPS_ROOT_PATH."/footer.php");
?>
