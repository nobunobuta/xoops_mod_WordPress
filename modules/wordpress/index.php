<?php 
/* Don't remove these lines. */
$GLOBALS['blog'] = 1;
include('header.php');
if (preg_match('/DoCoMo/', $_SERVER['HTTP_USER_AGENT']) and file_exists(dirname(__FILE__).'/wp-ktai.php')) { 
	header('Location: ' . wp_siteurl().'/wp-ktai.php');
}
wp_head();
include(get_custom_path('index-template.php'));
include(XOOPS_ROOT_PATH.'/footer.php');
?>
