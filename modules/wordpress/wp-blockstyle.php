<?php
$GLOBALS['blog'] = 1;
require(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
header('Content-type: text/css; charset='.$GLOBALS['blog_charset']);
if (wp_id()=='-') {
	echo block_style_get('', false, false);
} else {
	echo block_style_get(wp_id(), false, false);
}
?>
