<?php
include_once dirname( __FILE__ ).'/../../mainfile.php';
if(!defined('ABSPATH')) define ('ABSPATH' , XOOPS_ROOT_PATH.'/modules/wordpress/');

// ** MySQL settings ** //
if (!defined('WP_DB_NAME')) {
	define('WP_DB_NAME', XOOPS_DB_NAME);
	define('WP_DB_USER', XOOPS_DB_USER);
	define('WP_DB_PASSWORD', XOOPS_DB_PASS);
	define('WP_DB_HOST', XOOPS_DB_HOST);
}
// Change the prefix if you want to have multiple blogs in a single database.
global $xoopsDB,$xoopsUser, $wpdb, $wp_id, $wp_inblock, $table_prefix, $wp_mod, $wp_base, $wp_prefix, $wp_siteurl;
if (!$wp_inblock) {
	$wp_dir = basename( dirname( __FILE__ ) ) ;
	if( ! preg_match( '/wordpress(\d*)/' , $wp_dir , $regs ) ) echo ( "invalid dirname of WordPress: " . htmlspecialchars( $mydirname ) ) ;
	$wp_id = "$regs[1]" ;
}
if (($wp_id==="")||($wp_id==="-")) {
	$wp_id = "-";
	$wp_prefix[$wp_id] = 'wp_';
	$wp_mod[$wp_id] = 'wordpress';
} else {
	$wp_prefix[$wp_id] = "wp{$wp_id}_";
	$wp_mod[$wp_id] = 'wordpress'.$wp_id;
}

$wp_base[$wp_id]=XOOPS_ROOT_PATH.'/modules/'.$wp_mod[$wp_id];
$wp_siteurl[$wp_id]=XOOPS_URL.'/modules/'.$wp_mod[$wp_id];
$table_prefix[$wp_id] = $xoopsDB->prefix($wp_prefix[$wp_id]);

$server = WP_DB_HOST;
$loginsql = WP_DB_USER;
$passsql = WP_DB_PASSWORD;
$base = WP_DB_NAME;

$wp_debug = false;
$use_cache = 1; // No reason not to
// Get everything else
//require('wp-settings.php');
require($wp_base[$wp_id].'/wp-settings.php');

// Language File
if (!defined('_LANGCODE')) {
	define("_LANGCODE","en");
}
if (file_exists(ABSPATH."wp-lang/lang_"._LANGCODE.".php")) {
	require_once(ABSPATH."wp-lang/lang_"._LANGCODE.".php");
} else {
	require_once(ABSPATH."wp-lang/lang_en.php");
}
?>