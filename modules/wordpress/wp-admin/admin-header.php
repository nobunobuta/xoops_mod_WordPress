<?php
$show_rblock =0;
$show_cblock =0;
$wpvarstoreset = array('profile','standalone','redirect','redirect_url','a','popuptitle','popupurl','text', 'trackback', 'pingback');
for ($i=0; $i<count($wpvarstoreset); $i += 1) {
	$wpvar = $wpvarstoreset[$i];
	if (!isset($$wpvar)) {
		if (empty($_POST["$wpvar"])) {
			if (empty($_GET["$wpvar"])) {
				$$wpvar = '';
			} else {
				$$wpvar = $_GET["$wpvar"];
			}
		} else {
			$$wpvar = $_POST["$wpvar"];
		}
	}
}
if ($standalone == 0) {
	if ($profile == 0) {
		include_once (dirname(__FILE__)."/../../../mainfile.php");
		include(XOOPS_ROOT_PATH.'/header.php');
	}
}

global $wp_inblock;
$wp_inblock = 0;
require('../wp-config.php');
require('admin-functions.php');
require_once(ABSPATH.'/wp-admin/auth.php');
function gethelp_link($this_file, $helptag) {
    $url = 'http://wordpress.org/docs/reference/links/#'.$helptag;
    $s = ' <a href="'.$url.'" title="Click here for help">?</a>';
    return $s;
}

if (!isset($use_cache))	$use_cache=1;
if (!isset($blogID))	$blog_ID=1;
if (!isset($debug))		$debug=0;
timer_start();

get_currentuserinfo();

$posts_per_page = get_settings('posts_per_page');
$what_to_show = get_settings('what_to_show');
$archive_mode = get_settings('archive_mode');
$time_difference = get_settings('time_difference');
$date_format = stripslashes(get_settings('date_format'));
$time_format = stripslashes(get_settings('time_format'));

$admin_area_charset = (!isset($admin_area_charset)) ? 'iso-8859-15' : $admin_area_charset;

if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/wp-admin.css')) {
	$themes = $xoopsConfig['theme_set'];
} else {
	$themes = "default";
}
$css_file = $siteurl.'/themes/'.$themes.'/wp-admin.css';

if ($standalone == 0) {
	if ($profile == 0) {
//		include(XOOPS_ROOT_PATH.'/header.php');
		ob_start();
		echo  bloginfo('name');
		$blog_name =  ob_get_contents();
		ob_end_clean();
		$module_title = $blog_name ." : ".$title;
		$xoopsTpl->assign('xoops_module_header', '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />');
		$xoopsTpl->assign("xoops_pagetitle",$module_title);
	}else{
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress &rsaquo; <?php bloginfo('name') ?> &rsaquo; <?php echo $title; ?></title>
<link rel="stylesheet" href="<?php echo $css_file;?>" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset ?>" />
<?php
if ($redirect==1) {
	$redirect_url = sanitize_text($redirect_url);
?>
<script language="javascript" type="text/javascript">
<!--
function redirect() {
  window.location = "<?php echo $redirect_url; ?>";
}
setTimeout("redirect();", 600);
//-->
</script>
<?php
}
} // redirect
?>
<script language="javascript" type="text/javascript">
//<![CDATA[

	function profile(userID) {
		window.open ("profile.php?action=viewprofile&profile=1&user="+userID, "Profile", "width=500, height=450, location=0, menubar=0, resizable=0, scrollbars=1, status=1, titlebar=0, toolbar=0, screenX=60, left=60, screenY=60, top=60");
	}

	function launchupload() {
		window.open ("upload.php", "wpupload", "width=550,height=360,location=0,menubar=0,resizable=1,scrollbars=yes,status=1,toolbar=0");
	}

    function helpWindow(url) {
		window.open(url, "Help", "width=640, height=450, location=0, menubar=0, resizable=0, scrollbars=1, status=1, titlebar=0, toolbar=0, screenX=60, left=60, screenY=60, top=60");
	}

<?php if (isset($xfn)) : ?>
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
			   var rel = document.getElementById('rel');
			   var inputs = '';
			   for (i = 0; i < inputColl.length; i++) {
				   if (inputColl[i].checked) {
					   if (inputColl[i].value != '') inputs += inputColl[i].value + ' ';
					   }
				   }
			   inputs = inputs.substr(0,inputs.length - 1);
			   rel.value = inputs;
		   }
	
		   aInputs[i].onkeyup = function() {
			   var inputColl = GetElementsWithClassName('input','valinp');
			   var rel = document.getElementById('rel');
			   var inputs = '';
			   for (i = 0; i < inputColl.length; i++) {
				   if (inputColl[i].checked) {
					   inputs += inputColl[i].value + ' ';
					   }
				   }
			   inputs = inputs.substr(0,inputs.length - 1);
			   rel.value = inputs;
		   }
	   
	   }
	}
	
	window.onload = blurry;
<?php endif; ?>
//]]>
</script>
<?php do_action('admin_head', ''); ?>
<?php
if ($profile==0) {
	include('menu.php');
} else {
	echo "</head><body>";
}
?>

<?php
}
?>