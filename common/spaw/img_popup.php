<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Main control class
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003-2004 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0.5, 2004-07-16
// ================================================
require_once dirname(__FILE__).'/config/spaw_control.config.php';
if (empty($spaw_img_popup_url)) exit();
//Verifing Parameter
$img_url = htmlspecialchars($_GET['img_url'],ENT_QUOTES);
if (ini_get('allow_url_fopen')) {
	$img_size = getimagesize($img_url);
} else { //following part depends to XOOPS Dir structure.
	if (file_exists('../../class/snoopy.php')) {
		require_once '../../class/snoopy.php';
		$snoopy =& new Snoopy;
		$snoopy->fetch($img_url);
		$tname = tempnam(XOOPS_ROOT_PATH.'/cache', 'spaw_img_popup'); 
		$fp=fopen($tname,'w');
		fwrite($fp, $snoopy->results);
		fclose($fp);
		$img_size = getimagesize($tname);
		unlink($tname);
	} else {
		$img_size = false;
	}
}
if (!($img_size && $img_size[2] >0 && $img_size[2] < 3)) {
	exit();
}

?>
<html>
<head>
<title>Img</title>
<meta name="Author" content="Solmetra (www.solmetra.com)">
<link rel="stylesheet" type="text/css" href="lib/style.css">
<script language="JavaScript">
function resizeOuterTo(w,h) {
 if (parseInt(navigator.appVersion)>3) {
   if (navigator.appName=="Netscape") {
    top.outerWidth=w+8;
    top.outerHeight=h+29;
   }
   else 
   {
    top.resizeTo(400,300);
    wd = 400-document.body.clientWidth;
    hd = 300-document.body.clientHeight;
    top.resizeTo(w+wd,h+hd);
   }
 }
}

function init()
{
  resizeOuterTo(document.images['LargeImg'].width, document.images['LargeImg'].height);
}
</script>
</head>
<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" onLoad="init();" bgcolor="black">
<img name="LargeImg" src="<?php echo $img_url?>" border="0"/>
</body>
</html>
