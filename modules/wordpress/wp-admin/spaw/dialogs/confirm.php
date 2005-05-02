<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Confirmation dialog
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// $Revision$, $Date$
// ================================================

// include wysiwyg config
include '../config/spaw_control.config.php';
include $spaw_root.'class/lang.class.php';

// Security Patch nobunobu (2005/05/02)
$theme = !empty($_GET['theme'])&&file_exists("{$spaw_root}lib/themes/{$_GET['theme']}/css/dialog.css")?$_GET['theme']:$spaw_default_theme;
$theme_path = $spaw_dir.'lib/themes/'.$theme.'/';

$block = $_GET['block'];
$message = $_GET['message'];

$l = new SPAW_Lang(htmlspecialchars($_GET['lang']));
$l->setBlock($block);
// Security Patch nobunobu end
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<meta http-equiv="Pragma" content="no-cache">
  <title><?php echo $l->m('title')?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path.'css/'?>dialog.css">
  <script language="javascript" src="utils.js"></script>
  
  <script language="javascript">
  <!--  
  function Init() {
    cur_color = window.dialogArguments;
    resizeDialogToContent();
  }
  
  function okClick() {
    window.returnValue = true;
    window.close();
  }

  function cancelClick() {
    window.returnValue = false;
    window.close();
  }
  //-->
  </script>
</head>

<body onLoad="Init()" dir="<?php echo $l->getDir();?>">

<p align="center">
<br>
<?php echo $l->m($message)?>
<br><br>
<form name="colorpicker">
<input type="button" value="<?php echo $l->m('ok')?>" onClick="okClick()" class="bt">
<input type="button" value="<?php echo $l->m('cancel')?>" onClick="cancelClick()" class="bt"><br><br>
</form>
</p>

</body>
</html>
