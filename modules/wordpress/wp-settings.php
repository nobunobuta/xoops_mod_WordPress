<?php
$HTTP_HOST = getenv('HTTP_HOST');  /* domain name */
$REMOTE_ADDR = getenv('REMOTE_ADDR'); /* visitor's IP */
$HTTP_USER_AGENT = getenv('HTTP_USER_AGENT'); /* visitor's browser */

// Change to E_ALL for development/debugging
//error_reporting(E_ALL ^ E_NOTICE);
global $siteurl;

if(!defined('WPINC')) define('WPINC', 'wp-includes');
require_once (ABSPATH . WPINC . '/wp-db.php');
// Table names
$wpdb->posts[$wp_id]               = $table_prefix[$wp_id] . 'posts';
$wpdb->users[$wp_id]               = $table_prefix[$wp_id] . 'users';
$wpdb->settings[$wp_id]            = $table_prefix[$wp_id] . 'settings'; // only used during upgrade
$wpdb->categories[$wp_id]          = $table_prefix[$wp_id] . 'categories';
$wpdb->post2cat[$wp_id]            = $table_prefix[$wp_id] . 'post2cat';
$wpdb->comments[$wp_id]            = $table_prefix[$wp_id] . 'comments';
$wpdb->links[$wp_id]               = $table_prefix[$wp_id] . 'links';
$wpdb->linkcategories[$wp_id]      = $table_prefix[$wp_id] . 'linkcategories';
$wpdb->options[$wp_id]             = $table_prefix[$wp_id] . 'options';
$wpdb->optiontypes[$wp_id]         = $table_prefix[$wp_id] . 'optiontypes';
$wpdb->optionvalues[$wp_id]        = $table_prefix[$wp_id] . 'optionvalues';
$wpdb->optiongroups[$wp_id]        = $table_prefix[$wp_id] . 'optiongroups';
$wpdb->optiongroup_options[$wp_id] = $table_prefix[$wp_id] . 'optiongroup_options';

// This is the name of the include directory. No "/" allowed.

require_once (ABSPATH . WPINC . '/functions.php');
require ('wp-config-extra.php');
require_once (ABSPATH . WPINC . '/template-functions.php');
require_once (ABSPATH . WPINC . '/class-xmlrpc.php');
require_once (ABSPATH . WPINC . '/class-xmlrpcs.php');
require_once (ABSPATH . WPINC . '/links.php');
require_once (ABSPATH . WPINC . '/kses.php');

//setup the old globals from b2config.php
//
// We should eventually migrate to either calling
// get_settings() wherever these are needed OR
// accessing a single global $all_settings var
if (!strstr($_SERVER['REQUEST_URI'], 'install.php') && !strstr($_SERVER['REQUEST_URI'], 'wp-admin/import')) {
    $siteurl = get_settings('siteurl');
	$siteurl = preg_replace('|/+$|', '', $siteurl);
	if (get_xoops_option('wordpress'.(($wp_id=='-')?'':$wp_id),'wp_use_xoops_smilies')) {
		$smilies_directory = XOOPS_URL."/uploads";
	} else {
		$smilies_directory = get_settings('smilies_directory');
	}
    $querystring_start = '?';
    $querystring_equal = '=';
    $querystring_separator = '&amp;';
}
// Used to guarantee unique cookies
$cookiehash = md5($siteurl);

require (ABSPATH . WPINC . '/vars.php');
?>