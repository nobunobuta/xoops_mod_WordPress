<?php

require_once('../wp-config.php');

/* checking login & pass in the database */
function veriflog() {
	global $HTTP_COOKIE_VARS,$cookiehash;
	global $tableusers, $wpdb;
	global $xoopsUser, $xoopsDB;
	if($xoopsUser){
		$sql = "select ID,user_login from $tableusers where ID = ".$xoopsUser->uid();
		$r = $xoopsDB->query($sql);
		if(list($id,$user_login) = $xoopsDB->fetchRow($r)){
			if ($xoopsUser->getVar('uname') != $user_login) {
				$sql = "UPDATE $tableusers SET user_login = ".$xoopsDB->quoteString($xoopsUser->getVar('uname'))." WHERE ID = ".$xoopsUser->uid();
				$xoopsDB->queryF($sql);
			}
		}else{
			$level = 0;
			$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
			$edit_groups = get_xoops_option('wordpress','wp_edit_authgrp');
			$admin_groups = get_xoops_option('wordpress','wp_admin_authgrp');
			if (count(array_intersect($group,$edit_groups)) > 0) {
				$level = 1;
			}
			if (count(array_intersect($group,$admin_groups)) > 0) {
				$level = 10;
			}
			$uname = $xoopsDB->quoteString($xoopsUser->getVar('uname'));
			$email = $xoopsDB->quoteString($xoopsUser->getVar('email'));
			$sql = "INSERT INTO $tableusers(ID, user_login,user_nickname,user_email, user_level,user_idmode) values(".$xoopsUser->uid().", $uname , $uname , $email , $level, 'nickname' )";
			$xoopsDB->queryF($sql);
		}
		return true;
	}
	return false;

	if (!empty($HTTP_COOKIE_VARS["wordpressuser_".$cookiehash])) {
		$user_login = $HTTP_COOKIE_VARS["wordpressuser_".$cookiehash];
		$user_pass_md5 = $HTTP_COOKIE_VARS["wordpresspass_".$cookiehash];
	} else {
		return false;
	}

	if (!($user_login != ''))
		return false;
	if (!$user_pass_md5)
		return false;

	$login = $wpdb->get_row("SELECT user_login, user_pass FROM $tableusers WHERE user_login = '$user_login'");

	if (!$login) {
		return false;
	} else {
		if ($login->user_login == $user_login && md5($login->user_pass) == $user_pass_md5) {
			return true;
		} else {
			return false;
		}
	}
}
//if ( $user_login!="" && $user_pass!="" && $id_session!="" && $adresse_ip==$REMOTE_ADDR) {
//	if ( !(veriflog()) AND !(verifcookielog()) ) {
	if (!(veriflog())) {
		header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		if (!empty($HTTP_COOKIE_VARS["wordpressuser_".$cookiehash])) {
			$error="<strong>Error</strong>: wrong login or password";
		}
		redirect_header($siteurl.'/',2,'まずログインしてください。');
		$redir = "Location: $siteurl/wp-login.php?redirect_to=" . urlencode($_SERVER["REQUEST_URI"]);
		header($redir);
		exit();
	}
//}
?>