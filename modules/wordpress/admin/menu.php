<?php
$adminmenu[0]['title'] = _MI_WORDPRESS_AD_MENU1;
$adminmenu[0]['link'] = "wp-admin/options.php";
if (strstr(XOOPS_VERSION, "XOOPS 2.2")) {
	$adminmenu[1]['title'] = _MI_WORDPRESS_AD_MENU2;
	$adminmenu[1]['link'] = "admin/admin_blocks22.php";
	$adminmenu[2]['title'] = _MI_WORDPRESS_AD_MENU3;
	$adminmenu[2]['link'] = "admin/myblocksadmin.php";
} else {
	$adminmenu[1]['title'] = _MI_WORDPRESS_AD_MENU2;
	$adminmenu[1]['link'] = "admin/myblocksadmin.php";
}
?>