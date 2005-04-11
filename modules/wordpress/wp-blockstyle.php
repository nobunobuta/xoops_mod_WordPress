<?php
$GLOBALS['blog'] = 1;
require(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
header("Content-type: text/css; charset=EUC-JP");
if (wp_id()=="-") {
	echo block_style_get('', false, false);
} else {
	echo block_style_get(wp_id(), false, false);
}
?>
