<?php 
/* Don't remove these lines. */
$blog = 1;
include("header.php");
// Uncomment the next line if you want to track blog updates from weblogs.com
//include_once(ABSPATH.WPINC.'/links-update-xml.php');
if (file_exists(ABSPATH.'/themes/'.$xoopsConfig['theme_set'].'/index-template.php')) {
	$themes = $xoopsConfig['theme_set'];
} else {
	$themes = "default";
}
include(ABSPATH.'/themes/'.$themes.'/index-template.php');
include(XOOPS_ROOT_PATH."/footer.php");
?>
