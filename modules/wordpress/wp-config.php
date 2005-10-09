<?php
$_wp_base_prefix = 'wp';
//************************************************
// You should not edit this file for customization.
//************************************************
include_once dirname( __FILE__ ).'/../../mainfile.php';
if (!defined('WP_INIT_DONE')) {
	$initvars = array(
		'cache_lastpostdate','cache_catnames', 'cache_categories', 'cache_userdata', 'cache_settings',
		'category_cache', 'category_posts', 'post_meta_cache',  'comment_count_cache', 'wpPostHandler',
		'wp_filter', 'wp_xoops_config', 'wpParams', 'wpcommentsjavascript', '_xoopsTableCache',
		'_xoopsTableQueryCount','permalink_cache',
	);
	foreach($initvars as $initvars) {
		$GLOBALS[$initvars] = array();
	}
	define('WP_INIT_DONE', 1);
}
// ** MySQL settings ** //
if (!defined('WP_DB_NAME')) {
	define('WP_DB_NAME', XOOPS_DB_NAME);
	define('WP_DB_USER', XOOPS_DB_USER);
	define('WP_DB_PASSWORD', XOOPS_DB_PASS);
	define('WP_DB_HOST', XOOPS_DB_HOST);
}
global $wpdb, $wp_id;
$_wp_my_dirname = basename( dirname( __FILE__ ) ) ;
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

$GLOBALS['wp_id'] = "".(($_wp_my_dirnumber!=='') ? $_wp_my_dirnumber : '-');
$GLOBALS['wp_mod'][$GLOBALS['wp_id']] = $_wp_my_dirname;
$GLOBALS['wp_prefix'][$GLOBALS['wp_id']] = $_wp_base_prefix.$_wp_my_dirnumber.'_';

$GLOBALS['wp_base'][$GLOBALS['wp_id']] = XOOPS_ROOT_PATH.'/modules/'.$GLOBALS['wp_mod'][$GLOBALS['wp_id']];
$GLOBALS['wp_siteurl'][$GLOBALS['wp_id']] = XOOPS_URL.'/modules/'.$GLOBALS['wp_mod'][$GLOBALS['wp_id']];
$GLOBALS['table_prefix'][$GLOBALS['wp_id']] = $GLOBALS['xoopsDB']->prefix($GLOBALS['wp_prefix'][$GLOBALS['wp_id']]);

//For compatiblity 
if(!defined('ABSBASE')) define ('ABSBASE' , '/modules/'.$GLOBALS['wp_mod'][$GLOBALS['wp_id']]. '/');
if(!defined('ABSPATH')) define ('ABSPATH' , $GLOBALS['wp_base'][$GLOBALS['wp_id']]. '/');

//Obsolute Variables, XOOPS Module Use XOOPS DB Connection
//$server = WP_DB_HOST;
//$loginsql = WP_DB_USER;
//$passsql = WP_DB_PASSWORD;
//$base = WP_DB_NAME;

$GLOBALS['wp_debug'] = false;
$GLOBALS['use_cache'] = 1; // No reason not to

require($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-settings.php');

// Language File
if (!defined('_LANGCODE')) {
	define('_LANGCODE', 'en');
}
if (file_exists($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-lang/lang_'._LANGCODE.'.php')) {
	require_once($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-lang/lang_'._LANGCODE.'.php');
} else {
	require_once($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-lang/lang_en.php');
}
?>