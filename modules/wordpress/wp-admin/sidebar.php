<?php
function selected($selected, $current) {
	if ($selected == $current) echo ' selected="selected"';
}

$mode = 'sidebar';

$standalone = 1;
require_once('admin-header.php');

get_currentuserinfo();

if ($user_level == 0)
	die (_LANG_P_CHEATING_ERROR);

$time_difference = get_settings('time_difference');

if ('b' == $_GET['a']) {

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress > Posted</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="wp-admin.css" type="text/css" />
</head>
<body
	<p><?php echo _LANG_WAS_SIDE_POSTED; ?></p>
	<p><?php echo _LANG_WAS_SIDE_AGAIN; ?></p>
</body>
</html><?php

} else {

?><html>
<head>
<title>WordPress > Sidebar</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $admin_area_charset ?>" />
<link rel="stylesheet" href="wp-admin.css" type="text/css" />
<link rel="shortcut icon" href="../wp-images/wp-favicon.png" />
<style type="text/css" media="screen">
form {
	padding: 3px;
}
.sidebar-categories {
    display: block;
    height: 6.6em;
    overflow: auto;
    background-color: #f4f4f4;
}
.sidebar-categories label {
	font-size: 10px;
    display: block;
    width: 90%;
}
</style>
</head>
<body id="sidebar">
<form name="post" action="post.php" method="POST">
<div><input type="hidden" name="action" value="post" />
<input type="hidden" name="user_ID" value="<?php echo $user_ID ?>" />
<input type="hidden" name="mode" value="sidebar" />
<p><?php echo _LANG_EF_AD_POSTTITLE; ?>
<input type="text" name="post_title" size="20" tabindex="1" style="width: 100%;" />
</p>
<p><?php echo _LANG_EF_AD_CATETITLE; ?>
<span class="sidebar-categories">
<?php dropdown_categories(); ?>
</span>
</p>
<p>
<?php echo _LANG_EF_AD_POSTAREA; ?>
<textarea rows="8" cols="12" style="width: 100%" name="content" tabindex="2"></textarea>
</p>
<p>
    <input name="saveasdraft" type="submit" id="saveasdraft" tabindex="9" value="<?php echo _LANG_EF_AD_DRAFT; ?>" /> 
    <input name="publish" type="submit" id="publish" tabindex="6" style="font-weight: bold;" value="<?php echo _LANG_EF_AD_PUBLISH; ?>" /> 
  
</p>
</div>
</form>

</body>
</html>
<?php
}
?>