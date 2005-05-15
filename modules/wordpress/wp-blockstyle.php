<?php
$GLOBALS['blog'] = 1;
$cur_PATH = $_SERVER['SCRIPT_FILENAME'];
require(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
header('Content-type: text/css; charset='.$GLOBALS['blog_charset']);
$_SERVER['SCRIPT_FILENAME'] = 'XXXXX'; //trick for force reading some style and keep comatibility.
echo block_style_get(false, false);
?>
