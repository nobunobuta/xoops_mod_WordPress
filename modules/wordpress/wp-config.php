<?php
include_once dirname( __FILE__ ).'/../../mainfile.php';
if(!defined('ABSBASE')) define ('ABSBASE' , '/modules/wordpress/');
if(!defined('ABSPATH')) define ('ABSPATH' , XOOPS_ROOT_PATH.ABSBASE);

// ** MySQL settings ** //
if (!defined('WP_DB_NAME')) {
	define('WP_DB_NAME', XOOPS_DB_NAME);
	define('WP_DB_USER', XOOPS_DB_USER);
	define('WP_DB_PASSWORD', XOOPS_DB_PASS);
	define('WP_DB_HOST', XOOPS_DB_HOST);
}
// Change the prefix if you want to have multiple blogs in a single database.
global $xoopsDB,$xoopsUser, $wpdb, $wp_id, $wp_inblock, $table_prefix, $wp_mod, $wp_base, $wp_prefix, $wp_siteurl;
if (!$GLOBALS['wp_inblock']) {
	$GLOBALS['wp_dir'] = basename( dirname( __FILE__ ) ) ;
	if (!preg_match('/wordpress(\d*)/', $GLOBALS['wp_dir'], $regs )) {
		echo ('Invalid dirname of WordPress: '. htmlspecialchars($mydirname));
	}
	$GLOBALS['wp_id'] = "$regs[1]" ;
}
if (($GLOBALS['wp_id']==="")||($GLOBALS['wp_id']==="-")) {
	$GLOBALS['wp_id'] = "-";
	$GLOBALS['wp_prefix'][$GLOBALS['wp_id']] = 'wp_';
	$GLOBALS['wp_mod'][$GLOBALS['wp_id']] = 'wordpress';
} else {
	$GLOBALS['wp_prefix'][$GLOBALS['wp_id']] = 'wp'.$GLOBALS['wp_id'].'_';
	$GLOBALS['wp_mod'][$GLOBALS['wp_id']] = 'wordpress'.$GLOBALS['wp_id'];
}

$GLOBALS['wp_base'][$GLOBALS['wp_id']] = XOOPS_ROOT_PATH.'/modules/'.$GLOBALS['wp_mod'][$GLOBALS['wp_id']];
$GLOBALS['wp_siteurl'][$GLOBALS['wp_id']] = XOOPS_URL.'/modules/'.$GLOBALS['wp_mod'][$GLOBALS['wp_id']];
$GLOBALS['table_prefix'][$GLOBALS['wp_id']] = $xoopsDB->prefix($GLOBALS['wp_prefix'][$GLOBALS['wp_id']]);

//Obsolute Variables, XOOPS Module Use XOOPS DB Connection
//$server = WP_DB_HOST;
//$loginsql = WP_DB_USER;
//$passsql = WP_DB_PASSWORD;
//$base = WP_DB_NAME;

$GLOBALS['wp_debug'] = true;
$GLOBALS['use_cache'] = 1; // No reason not to

require($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-settings.php');

// Language File
if (!defined('_LANGCODE')) {
	define('_LANGCODE', 'en');
}
if (file_exists(ABSPATH.'wp-lang/lang_'._LANGCODE.'.php')) {
	require_once(ABSPATH.'wp-lang/lang_'._LANGCODE.'.php');
} else {
	require_once(ABSPATH.'wp-lang/lang_en.php');
}
?>