<?php
/** WordPress's config file **/
/** http://wordpress.org/   **/
/** http://wordpress.xwd.jp/   **/

// It is influenced by environment.
// mb_language("Japanese");
// mb_internal_encoding("euc-jp");

// ** MySQL settings ** //
define('DB_NAME', 'wordpress');     // The name of the database
define('DB_USER', 'username');     // Your MySQL username
define('DB_PASSWORD', 'password'); // ...and password
define('DB_HOST', 'localhost');     // 99% chance you won't need to change this value

// Change the prefix if you want to have multiple blogs in a single database.

$table_prefix  = 'wp_';   // example: 'wp_' or 'b2' or 'mylogin_'

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