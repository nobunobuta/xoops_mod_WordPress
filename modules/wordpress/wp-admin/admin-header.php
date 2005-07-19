<?php
$GLOBALS['show_rblock'] =0;
$GLOBALS['show_cblock'] =0;

init_param('GET', 'profile', 'integer', 0);
init_param('GET', 'redirect', 'integer', 0);
if (($GLOBALS['standalone'] == 0)&&(get_param('profile') == 0)) {
	$_wp_id_keep = $GLOBALS['wp_id'];
	$_wp_mod_keep = $GLOBALS['wp_mod'][$GLOBALS['wp_id']];
	include_once (dirname(__FILE__)."/../../../mainfile.php");
	include(XOOPS_ROOT_PATH.'/header.php');
	$GLOBALS['wp_id'] = $_wp_id_keep;
	$GLOBALS['wp_mod'][$GLOBALS['wp_id']] = $_wp_mod_keep;
	$GLOBALS['wp_inblock'] = 1;
	require('../wp-config.php');
	$GLOBALS['wp_inblock'] = 0;
}

require_once('admin-functions.php');
require_once('auth.php');

if (get_xoops_option(wp_mod(),'wp_use_spaw') == 1) {
	$GLOBALS['wp_use_spaw']=true;
} else {
	$GLOBALS['wp_use_spaw']=false;
}
//if (get_xoops_option(wp_mod(),'wp_use_spaw') == 2) {
//	$GLOBALS['wp_use_koivi']=true;
//} else {
//	$GLOBALS['wp_use_koivi']=false;
//}

if (!isset($use_cache))	$GLOBALS['use_cache'] = 1;
if (!isset($blogID))	$GLOBALS['blog_ID'] = 1;
if (!isset($debug))		$GLOBALS['debug'] = 0;
timer_start();

get_currentuserinfo();

$GLOBALS['posts_per_page'] = get_settings('posts_per_page');
$GLOBALS['what_to_show'] = get_settings('what_to_show');
$GLOBALS['archive_mode'] = get_settings('archive_mode');
$GLOBALS['time_difference'] = get_settings('time_difference');
$GLOBALS['date_format'] = get_settings('date_format');
$GLOBALS['time_format'] = get_settings('time_format');

$GLOBALS['admin_area_charset'] = $blog_charset;

$_css_file = get_custom_url('wp-admin.css');
$_xoops_css = xoops_getcss($xoopsConfig['theme_set']);
$_module_title = get_bloginfo('name') ." : ".$title;

if (($GLOBALS['standalone'] == 0)&&(get_param('profile') == 0)) {
	$GLOBALS['xoopsTpl']->assign('xoops_module_header', '<link rel="stylesheet" href="'.$_css_file.'" type="text/css" />');
	$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $_module_title);
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress : <?php echo $_module_title; ?></title>
<link rel="stylesheet" href="<?php echo $_xoops_css ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $_css_file;?>" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['blog_charset'] ?>" />
<?php } ?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	function profile(userID) {
		window.open ("profile.php?action=viewprofile&profile=1&user="+userID, "Profile", "width=500, height=520, location=0, menubar=0, resizable=0, scrollbars=1, status=1, titlebar=0, toolbar=0, screenX=60, left=60, screenY=60, top=60");
	}

	function launchupload() {
		window.open ("upload.php", "wpupload", "width=550,height=360,location=0,menubar=0,resizable=1,scrollbars=yes,status=1,toolbar=0");
	}

    function helpWindow(url) {
		window.open(url, "Help", "width=640, height=450, location=0, menubar=0, resizable=0, scrollbars=1, status=1, titlebar=0, toolbar=0, screenX=60, left=60, screenY=60, top=60");
	}
<?php if (isset($GLOBALS['xfn'])) { ?>
	function GetElementsWithClassName(elementName, className) {
	   var allElements = document.getElementsByTagName(elementName);
	   var elemColl = new Array();
	   for (i = 0; i < allElements.length; i++) {
		   if (allElements[i].className == className) {
			   elemColl[elemColl.length] = allElements[i];
		   }
	   }
	   return elemColl;
	}

	function blurry() {
	   if (!document.getElementById) return;
	
	   var aInputs = document.getElementsByTagName('input');
	
	   for (var i = 0; i < aInputs.length; i++) {      
	
		   aInputs[i].onclick = function() {
			   var inputColl = GetElementsWithClassName('input','valinp');
			   var link_rel = document.getElementById('link_rel');
			   var inputs = '';
			   for (i = 0; i < inputColl.length; i++) {
				   if (inputColl[i].checked) {
					   if (inputColl[i].value != '') inputs += inputColl[i].value + ' ';
					   }
				   }
			   inputs = inputs.substr(0,inputs.length - 1);
			   link_rel.value = inputs;
		   }
	
		   aInputs[i].onkeyup = function() {
			   var inputColl = GetElementsWithClassName('input','valinp');
			   var link_rel = document.getElementById('link_rel');
			   var inputs = '';
			   for (i = 0; i < inputColl.length; i++) {
				   if (inputColl[i].checked) {
					   inputs += inputColl[i].value + ' ';
					   }
				   }
			   inputs = inputs.substr(0,inputs.length - 1);
			   link_rel.value = inputs;
		   }
	   
	   }
	}
	
	window.onload = blurry;
<?php } ?>
//]]>
</script>
<?php do_action('admin_head', ''); ?>
<?php
if (($GLOBALS['standalone'] == 0)&&(get_param('profile') == 0)) {
	include('menu-header.php');
} else {
	echo '</head><body>';
}
?>
