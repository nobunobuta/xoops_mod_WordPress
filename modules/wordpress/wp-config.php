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
define('DB_NAME', XOOPS_DB_NAME);      // データベース名
define('DB_USER', XOOPS_DB_USER);      // データベースのユーザー名
define('DB_PASSWORD', XOOPS_DB_PASS);  // データベースパスワード
define('DB_HOST', XOOPS_DB_HOST);       // 99% このままでOK

// Change the prefix if you want to have multiple blogs in a single database.
global $xoopsDB,$xoopsUser,$wpdb;


$table_prefix  = $xoopsDB->prefix('wp_');   // example: 'wp_' or 'b2' or 'mylogin_'

$server = DB_HOST;
$loginsql = DB_USER;
$passsql = DB_PASSWORD;
$base = DB_NAME;

define('ABSPATH', dirname(__FILE__).'/');

// Get everything else
require_once(ABSPATH.'wp-settings.php');

// Language File - example: 'wp-lang/lang_en.php'
require_once(ABSPATH.'wp-lang/lang_ja.php');

/* Stop editing */
?>