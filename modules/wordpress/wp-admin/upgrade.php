<?php
/* ÈþÆý */
$_wp_installing = 1;
if (!file_exists('../wp-config.php')) die(_LANG_UPG_STEP_INFO);
require('../wp-config.php');
require('upgrade-functions.php');

$step = $HTTP_GET_VARS['step'];
if (!$step) $step = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>WordPress &rsaquo; Upgrade WordPress</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset; ?>" />
<style media="screen" type="text/css">
	body {
		font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
		margin-left: 15%;
		margin-right: 15%;
	}
	#logo {
		margin: 0;
		padding: 0;
		background-image: url(../wp-images/wordpress.gif);
		background-repeat: no-repeat;
		height: 60px;
		border-bottom: 1px solid #dcdcdc;
	}
	#logo a {
		display: block;
		text-decoration: none;
		text-indent: -100em;
		height: 60px;
	}
	p {
		line-height: 140%;
	}
	</style>
</head><body> 
<h1 id="logo"><a href="http://wordpress.xwd.jp/"><span>WordPress Japan</span></a></h1>
<?php
switch($step) {

	case 0:
	echo _LANG_UPG_STEP_INFO2;
	break;
	
	case 1:
	upgrade_all();
?>
<h2>Step 1</h2> 
<?php echo _LANG_UPG_STEP_INFO3; ?>
<?php
	break;
}
?> 
</body>
</html>
