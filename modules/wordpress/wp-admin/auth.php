<?php

require_once('../wp-config.php');

/* checking login & pass in the database */
function veriflog() {
	global $cookiehash;
	global  $wpdb ,$wp_id;
	global $xoopsUser, $xoopsDB;
	if($xoopsUser){
		$sql = "select ID,user_login from {$wpdb->users[$wp_id]} where ID = ".$xoopsUser->uid();
		$r = $xoopsDB->query($sql);
		if(list($id,$user_login) = $xoopsDB->fetchRow($r)){
			if ($xoopsUser->getVar('uname') != $user_login) {
				$sql = "UPDATE {$wpdb->users[$wp_id]} SET user_login = ".$xoopsDB->quoteString($xoopsUser->getVar('uname'))." WHERE ID = ".$xoopsUser->uid();
				$xoopsDB->queryF($sql);
			}
		}else{
			$level = 0;
			$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
			if ($wp_id == "-") {
				$edit_groups = get_xoops_option('wordpress','wp_edit_authgrp');
				$admin_groups = get_xoops_option('wordpress','wp_admin_authgrp');
			} else {
				$edit_groups = get_xoops_option('wordpress'.$wp_id,'wp_edit_authgrp');
				$admin_groups = get_xoops_option('wordpress'.$wp_id,'wp_admin_authgrp');
			}
			if (count(array_intersect($group,$edit_groups)) > 0) {
				$level = 1;
			}
			if (count(array_intersect($group,$admin_groups)) > 0) {
				$level = 10;
			}
			$uname = $xoopsDB->quoteString($xoopsUser->getVar('uname'));
			$email = $xoopsDB->quoteString($xoopsUser->getVar('email'));
			$sql = "INSERT INTO {$wpdb->users[$wp_id]} (ID, user_login,user_nickname,user_email, user_level,user_idmode) values(".$xoopsUser->uid().", $uname , $uname , $email , $level, 'nickname' )";
			$xoopsDB->queryF($sql);
		}
		return true;
	}
	return false;
}

if (!(veriflog())) {
	redirect_header($siteurl.'/',2,'まずログインしてください。');
	exit();
}

?>