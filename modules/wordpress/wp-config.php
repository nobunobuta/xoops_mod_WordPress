<?php
define('ABSPATH', dirname(__FILE__).'/');
include_once ABSPATH.'../../mainfile.php';
/** WordPress's config file **/
/** http://wordpress.org/   **/
/** http://wordpress.xwd.jp/   **/

// It is influenced by environment.
mb_language("Japanese");
mb_internal_encoding("euc-jp");

// ** MySQL settings ** //
define('WP_DB_NAME', XOOPS_DB_NAME);      // データベース名
define('WP_DB_USER', XOOPS_DB_USER);      // データベースのユーザー名
define('WP_DB_PASSWORD', XOOPS_DB_PASS);  // データベースパスワード
define('WP_DB_HOST', XOOPS_DB_HOST);       // 99% このままでOK

// Change the prefix if you want to have multiple blogs in a single database.
global $xoopsDB,$xoopsUser,$wpdb;


$table_prefix  = $xoopsDB->prefix('wp_');   // example: 'wp_' or 'b2' or 'mylogin_'

$server = WP_DB_HOST;
$loginsql = WP_DB_USER;
$passsql = WP_DB_PASSWORD;
$base = WP_DB_NAME;

$my_pingserver[0]['server']="rpc.weblogs.com";
$my_pingserver[0]['path']="/RPC2";
$my_pingserver[0]['port']=80;
//$my_pingserver[1]['server']="ping.bloggers.jp";
//$my_pingserver[1]['path']="/rpc/";
//$my_pingserver[1]['port']=80;
//$my_pingserver[2]['server']="ping.myblog.jp";
//$my_pingserver[2]['path']="/";
//$my_pingserver[2]['port']=80;
//$my_pingserver[3]['server']="ping.cocolog-nifty.com";
//$my_pingserver[3]['path']="/xmlrpc";
//$my_pingserver[3]['port']=80;

// Get everything else
require_once(ABSPATH.'wp-settings.php');

// Language File - example: 'wp-lang/lang_en.php'
require_once(ABSPATH.'wp-lang/lang_ja.php');

/* Stop editing */
?>