<?php
if (!function_exists('upgrade_wp_tables')){
	function upgrade_wp_tables() {
		global $xoopsDB;
		require_once dirname(dirname( __FILE__ )) . '/wp-config.php';
		if ($xoopsDB->query("SHOW COLUMNS FROM ".wp_table('postmeta'))==false) {
			$sql1 = "CREATE TABLE ".wp_table('postmeta')." (
						meta_id int(11) NOT NULL auto_increment,
						post_id int(11) NOT NULL default '0',
						meta_key varchar(255) default NULL,
						meta_value text,
						PRIMARY KEY	 (meta_id),
						KEY post_id (post_id),
						KEY meta_key (meta_key)
					)";
			$xoopsDB->query($sql1);
			$GLOBALS['msgs'][] = "TABLE ".wp_table('postmeta')." is added.";
		}

		if (!$xoopsDB->getRowsNum($xoopsDB->query("SHOW COLUMNS FROM ".wp_table('comments')." LIKE 'comment_type'"))) {
			$sql1 = "ALTER TABLE ".wp_table('comments')." ADD (
						comment_agent varchar(255) NOT NULL default '',
						comment_type varchar(20) NOT NULL default '',
						comment_parent int(11) NOT NULL default '0',
						user_id int(11) NOT NULL default '0'
					)";
			$xoopsDB->query($sql1);
			$GLOBALS['msgs'][] = "TABLE ".wp_table('comments')." is modified.";
		}
		
		$sql1 = "ALTER TABLE ".wp_table('options')." CHANGE 
					option_value option_value longtext NOT NULL default ''
				";
		$xoopsDB->query($sql1);
		$GLOBALS['msgs'][] = "TABLE ".wp_table('options')." is modified.";

		$xoopsDB->query("DELETE FROM ".wp_table('optiongroup_options')." WHERE group_id=6 AND option_id=1");
		$xoopsDB->query("DELETE FROM ".wp_table('optiongroup_options')." WHERE group_id=6 AND option_id=2");
		$xoopsDB->query("UPDATE ".wp_table('optiongroup_options')." SET seq=1 WHERE group_id=6 AND option_id=3");
		$xoopsDB->query("UPDATE ".wp_table('optiongroup_options')." SET seq=2 WHERE group_id=6 AND option_id=4");
		$xoopsDB->query("UPDATE ".wp_table('optiongroup_options')." SET seq=3 WHERE group_id=6 AND option_id=54");
		# --------------------------------------------------------
		if ($xoopsDB->query("DELETE FROM ".wp_table('options')." WHERE option_id =7 AND option_name ='new_users_can_blog'")) {
			$xoopsDB->query("DELETE FROM ".wp_table('optiongroup_options')." WHERE group_id=6 AND option_id =7");
		}

		if ($xoopsDB->query("DELETE FROM ".wp_table('options')." WHERE option_id =8 AND option_name ='users_can_register'")) {
			$xoopsDB->query("DELETE FROM ".wp_table('optiongroup_options')." WHERE group_id=6 AND option_id =8");
		}

		if ($xoopsDB->query("DELETE FROM ".wp_table('options')." WHERE option_id =91 AND option_name ='gzipcompression'")) {
			$xoopsDB->query("DELETE FROM ".wp_table('optiongroup_options')." WHERE group_id=6 AND option_id =91");
		}
		if(!get_settings('use_comment_preview')) {
			add_option('use_comment_preview','0', 2, "Display Preview Screen after comment posting.", 2, 8);
		}
		if(!get_settings('active_plugins')) {
			add_option('active_plugins',"\n");
		}
		if(!get_settings('check_trackback_content')) {
			add_option('check_trackback_content','0', 3, '_LANG_INST_BASE_VALUE95', 2, 8);
		}
	}
}

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
// referer check
$ref = xoops_getenv('HTTP_REFERER');
if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
	/* module specific part */

	upgrade_wp_tables();

	/* General part */

	// Keep the values of block's options when module is updated (by nobunobu)
	include dirname( __FILE__ ) . "/updateblock.inc.php" ;

}
?>