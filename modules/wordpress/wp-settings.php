<?php
$GLOBALS['HTTP_HOST'] = getenv('HTTP_HOST');  /* domain name */
$GLOBALS['REMOTE_ADDR'] = getenv('REMOTE_ADDR'); /* visitor's IP */
$GLOBALS['HTTP_USER_AGENT'] = getenv('HTTP_USER_AGENT'); /* visitor's browser */

if (preg_match('#/modules/'.$GLOBALS['wp_mod'][$GLOBALS['wp_id']].'(/|/wp-admin/users.php.*)?$#',$_SERVER['PHP_SELF'])) {
	$GLOBALS['__'.$GLOBALS['wp_prefix'][$GLOBALS['wp_id']].'dosync'] = true;
} else {
	$GLOBALS['__'.$GLOBALS['wp_prefix'][$GLOBALS['wp_id']].'dosync'] = false;
}

global $siteurl;

if(!defined('WPINC')) define('WPINC', 'wp-includes');

require_once ($GLOBALS['wp_base'][$GLOBALS['wp_id']]. '/wp-includes/wp-db.php');
// Table names
$GLOBALS['wpdb']->posts[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'posts';
$GLOBALS['wpdb']->users[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'users';
$GLOBALS['wpdb']->settings[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'settings'; // only used during upgrade
$GLOBALS['wpdb']->categories[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'categories';
$GLOBALS['wpdb']->post2cat[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'post2cat';
$GLOBALS['wpdb']->comments[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'comments';
$GLOBALS['wpdb']->links[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'links';
$GLOBALS['wpdb']->linkcategories[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'linkcategories';
$GLOBALS['wpdb']->options[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'options';
$GLOBALS['wpdb']->optiontypes[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'optiontypes';
$GLOBALS['wpdb']->optionvalues[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'optionvalues';
$GLOBALS['wpdb']->optiongroups[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'optiongroups';
$GLOBALS['wpdb']->optiongroup_options[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'optiongroup_options';
$GLOBALS['wpdb']->postmeta[$GLOBALS['wp_id']] = $GLOBALS['table_prefix'][$GLOBALS['wp_id']].'postmeta';

// This is the name of the include directory. No "/" allowed.

require ($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-ver.php');
require_once ($GLOBALS['wp_base'][$GLOBALS['wp_id']].'/wp-includes/functions.php');
require_once (wp_base().'/class/wp_classes.php');
if (empty($GLOBALS['wpPostHandler'][wp_prefix()])) {
	$GLOBALS['wpPostHandler'][wp_prefix()] =& new WordPressPostHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpPost2CatHandler'][wp_prefix()] =& new WordPressPost2CatHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpPostMetaHandler'][wp_prefix()] =& new WordPressPostMetaHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpCommentHandler'][wp_prefix()] =& new WordPressCommentHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpUserHandler'][wp_prefix()] =& new WordPressUserHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpCategoryHandler'][wp_prefix()] =& new WordPressCategoryHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpLinkHandler'][wp_prefix()] =& new WordPressLinkHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpLinkCategoryHandler'][wp_prefix()] =& new WordPressLinkCategoryHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpOptionGroup2OptionHandler'][wp_prefix()] =& new WordPressOptionGroup2OptionHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
	$GLOBALS['wpOptionHandler'][wp_prefix()] =& new WordPressOptionHandler($GLOBALS['xoopsDB'], wp_prefix(), wp_mod());
}
require_once (wp_base().'/wp-includes/wp-tickets.php');
require_once (wp_base().'/wp-includes/functions-formatting.php');
require_once (wp_base().'/wp-includes/functions-filter.php');
require_once (wp_base().'/wp-includes/kses.php');
if (get_settings('hack_file')) {
	include_once(wp_base().'/my-hacks.php');
}
require (wp_base().'/wp-config-extra.php');
require_once (wp_base().'/wp-includes/template-functions.php');
require_once (wp_base().'/wp-includes/class-xmlrpc.php');
require_once (wp_base().'/wp-includes/class-xmlrpcs.php');
require_once (wp_base().'/wp-includes/links.php');

if (empty($GLOBALS['cache_categories'][wp_id()])||(count($GLOBALS['cache_categories'][wp_id()])==0)) {
	$GLOBALS['cache_categories'][wp_id()] = array();
	$categoryHandler =& wp_handler('Category');
	$categoryObjects =& $categoryHandler->getObjects();
	foreach ($categoryObjects as $categoryObject) {
		$catt = $categoryObject->exportWpObject();
		$GLOBALS['cache_categories'][wp_id()][$catt->cat_ID] = $catt;
	}
}
// We should eventually migrate to either calling
// get_settings() wherever these are needed OR
// accessing a single global $all_settings var

if (get_xoops_option(wp_mod(),'wp_use_xoops_smilies')) {
	$GLOBALS['smilies_directory'] = XOOPS_URL."/uploads";
} else {
	$GLOBALS['smilies_directory'] = get_settings('smilies_directory');
}
//Keep compatibility with WordPress Plugin
$GLOBALS['siteurl'] = wp_siteurl();
update_option('siteurl',$GLOBALS['siteurl'],true);
$GLOBALS['querystring_start'] = '?';
$GLOBALS['querystring_equal'] = '=';
$GLOBALS['querystring_separator'] = '&amp;';
$GLOBALS['dateformat'] = stripslashes(get_settings('date_format'));
$GLOBALS['timeformat'] = stripslashes(get_settings('time_format'));
$GLOBALS['wpcommentsjavascript'] = 0;

// Used to guarantee unique cookies
$GLOBALS['cookiehash'] = md5(wp_siteurl());

require(wp_base().'/wp-includes/vars.php');
if (empty($GLOBALS['wp_inblock'])) {
	require(wp_base().'/wp-includes/wp-filter-setup.php');
	if (!defined('XOOPS_PULUGIN'.wp_id())) {
		define('XOOPS_PULUGIN'.wp_id(), 1);
		if (get_settings('active_plugins')) {
			$check_plugins = explode("\n", (get_settings('active_plugins')));
			foreach ($check_plugins as $check_plugin) {
				if (file_exists(wp_base() . '/wp-content/plugins/'. $check_plugin)) {
					if( ! defined( md5('WP_PLUGIN_'.strtoupper($check_plugin).'_INCLUDED') ) ) {
						define( md5('WP_PLUGIN_'.strtoupper($check_plugin).'_INCLUDED') , 1 ) ;
						require_once(wp_base(). '/wp-content/plugins/'. $check_plugin);
					} else {
						// It is very tricky!!
						if( ! defined( md5('WP_PLUGIN_'.strtoupper($check_plugin).wp_base().'_DEFINED') ) ) {
							define( md5('WP_PLUGIN_'.strtoupper($check_plugin).wp_base().'_DEFINED') , 1 ) ;
							if (preg_match_all('/(add|remove)_(action|filter)\s*\([^\)]+\)\s*\;/',
											implode('',file(wp_base(). '/wp-content/plugins/'. $check_plugin)),
											$matches,PREG_SET_ORDER)) {
								foreach($matches as $match) {
									eval($match[0]);
								}
							}
						}
					}
				}
			}
		}
		/* shutdouwn action hook is temporaly disabled
		if (!defined('SHUTDOWN_ACTION_HOOK')) {
			define('SHUTDOWN_ACTION_HOOK','1');
			function wp_shutdown_action_hook() {
				do_action('shutdown', '');
			}
			register_shutdown_function('wp_shutdown_action_hook');
		}
		*/
	}
}
?>