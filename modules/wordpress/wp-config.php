<?php
if (!defined('WP_INIT_DONE')) {
	if ( ini_get('register_globals') ) {
		$superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
		if ( isset($_SESSION) ) {
			array_unshift($superglobals, $_SESSION);
		}
		foreach ( $superglobals as $superglobal ) {
			foreach ( $superglobal as $global => $value ) {
				unset( $GLOBALS[$global] );
			}
		}
	}
	define('WP_INIT_DONE', 1);
}
include_once dirname( __FILE__ ).'/../../mainfile.php';
if(!defined('ABSPATH')) define ('ABSPATH' , XOOPS_ROOT_PATH.'/modules/wordpress/');
/** WordPress's config file **/
/** http://wordpress.org/   **/
/** http://wordpress.xwd.jp/   **/

// It is influenced by environment.
//mb_language("Japanese");
//mb_internal_encoding("euc-jp");

// ** MySQL settings ** //
if (!defined('WP_DB_NAME')) {
	define('WP_DB_NAME', XOOPS_DB_NAME);      // �ǡ����١���̾
	define('WP_DB_USER', XOOPS_DB_USER);      // �ǡ����١����Υ桼����̾
	define('WP_DB_PASSWORD', XOOPS_DB_PASS);  // �ǡ����١����ѥ����
	define('WP_DB_HOST', XOOPS_DB_HOST);       // 99% ���Τޤޤ�OK
}
// Change the prefix if you want to have multiple blogs in a single database.
global $xoopsDB,$xoopsUser,$wpdb, $wp_id, $wp_inblock, $table_prefix;
if (!$wp_inblock) {
	$wp_dir = basename( dirname( __FILE__ ) ) ;
	if( ! preg_match( '/wordpress(\d*)/' , $wp_dir , $regs ) ) echo ( "invalid dirname of WordPress: " . htmlspecialchars( $mydirname ) ) ;
	$wp_id = "$regs[1]" ;
}
if ($wp_id==="") {
	$table_prefix["-"] = $xoopsDB->prefix("wp_");
	$wp_id = "-";
} else {
	$table_prefix[$wp_id] = $xoopsDB->prefix("wp{$wp_id}_");
}
$server = WP_DB_HOST;
$loginsql = WP_DB_USER;
$passsql = WP_DB_PASSWORD;
$base = WP_DB_NAME;
// Get everything else
//require('wp-settings.php');
require(XOOPS_ROOT_PATH.'/modules/wordpress'.(($wp_id=='-') ?'':$wp_id).'/wp-settings.php');

// Language File
if (!defined('_LANGCODE')) {
	define("_LANGCODE","en");
}
if (file_exists(ABSPATH."wp-lang/lang_"._LANGCODE.".php")) {
	require_once(ABSPATH."wp-lang/lang_"._LANGCODE.".php");
} else {
	require_once(ABSPATH."wp-lang/lang_en.php");
}
if (!$wp_inblock) {
	if (get_xoops_option($wp_dir,'wp_use_spaw') == 1) {
		$wp_use_spaw=true;
	} else {
		$wp_use_spaw=false;
	}
}
?>