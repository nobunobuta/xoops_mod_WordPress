<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Configuration file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-03-27
// ================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) {
	include_once( '../../../../../mainfile.php' ) ;
	if( file_exists( "../../../language/{$xoopsConfig['language']}/admin.php") ) {
		include_once("../../../language/{$xoopsConfig['language']}/admin.php");
	} else {
		include_once("../../../language/english/admin.php");
	}
	include_once("../../../wp-config.php");
}

// directory where spaw files are located
// $spaw_dir = 'spaw/';
global $xoopsModule;
$spaw_dir = XOOPS_URL . '/modules/wordpress'.(($wp_id=='-') ?'':$wp_id).'/wp-admin/spaw/' ;

// base url for images
$spaw_base_url = XOOPS_URL.'/';

// $spaw_root = dirname( dirname( __FILE__ ) ) . '/' ;
$spaw_root = XOOPS_ROOT_PATH . '/modules/wordpress'.(($wp_id=='-') ?'':$wp_id).'/wp-admin/spaw/' ;

$spaw_default_toolbars = 'full';
$spaw_default_theme = 'default';
$spaw_default_lang = _LANGCODE ;
$spaw_default_css_stylesheet = $spaw_dir.'wysiwyg.css';

// add javascript inline or via separate file
$spaw_inline_js = true;

// use active toolbar (reflecting current style) or static
$spaw_active_toolbar = true;

// default dropdown content
$spaw_dropdown_data['style']['default'] = 'Normal';

$spaw_dropdown_data['font']['Arial'] = 'Arial';
$spaw_dropdown_data['font']['Courier'] = 'Courier';
$spaw_dropdown_data['font']['Tahoma'] = 'Tahoma';
$spaw_dropdown_data['font']['Times New Roman'] = 'Times';
$spaw_dropdown_data['font']['Verdana'] = 'Verdana';

$spaw_dropdown_data['fontsize']['1'] = '1';
$spaw_dropdown_data['fontsize']['2'] = '2';
$spaw_dropdown_data['fontsize']['3'] = '3';
$spaw_dropdown_data['fontsize']['4'] = '4';
$spaw_dropdown_data['fontsize']['5'] = '5';
$spaw_dropdown_data['fontsize']['6'] = '6';

$spaw_dropdown_data['paragraph']['Normal'] = 'Normal';
$spaw_dropdown_data['paragraph']['Heading 1'] = 'Heading 1';
$spaw_dropdown_data['paragraph']['Heading 2'] = 'Heading 2';
$spaw_dropdown_data['paragraph']['Heading 3'] = 'Heading 3';
$spaw_dropdown_data['paragraph']['Heading 4'] = 'Heading 4';
$spaw_dropdown_data['paragraph']['Heading 5'] = 'Heading 5';
$spaw_dropdown_data['paragraph']['Heading 6'] = 'Heading 6';

// image library related config

// allowed extentions for uploaded image files
$spaw_valid_imgs = array('gif', 'jpg', 'jpeg', 'png');

// allow upload in image library
$spaw_upload_allowed = false;

$i=0;

$spaw_imglibs = array(
  array(
  	'type'    =>  'Dir',
  	'value'   => ereg_replace(XOOPS_URL.'\/(.*)',"\\1",get_settings('fileupload_url'))."/" ,
    'text'    => 'Uploads[WordPress]',
	'catID'   => 0,
	'storetype' => 'file',
	'autoID' => 0
  )
);

global $xoopsDB;

$result = $xoopsDB->query("SELECT imgcat_name, imgcat_id, imgcat_storetype FROM " . $xoopsDB->prefix('imagecategory') . " ORDER BY imgcat_name ASC");

$i=count($spaw_imglibs);

while($imgcat = $xoopsDB->fetcharray($result)){
	$spaw_imglibs[$i]["type"]  = "XoopsImage";
	$spaw_imglibs[$i]["value"] = 'uploads/';
	$spaw_imglibs[$i]["text"] = $imgcat["imgcat_name"]."[XOOPS]";
	$spaw_imglibs[$i]["catID"] = $imgcat["imgcat_id"];
	$spaw_imglibs[$i]["storetype"] = $imgcat["imgcat_storetype"];
	$spaw_imglibs[$i]["autoID"] = $i;

	$i++;
}

if (file_exists(XOOPS_ROOT_PATH."/modules/myalbum/xoops_version.php")) {

$result = $xoopsDB->query("SELECT title, cid FROM ".$xoopsDB->prefix('myalbum_cat')." ORDER BY title ASC");

while($imgcat = $xoopsDB->fetcharray($result)){
	$spaw_imglibs[$i]["type"]  = "MyAlbum";
	$spaw_imglibs[$i]["value"] = 'uploads/';
	$spaw_imglibs[$i]["text"] = $imgcat["title"]."[MyAlbum]";
	$spaw_imglibs[$i]["catID"] = $imgcat["cid"]+$i;
	$spaw_imglibs[$i]["autoID"] = $imgcat["cid"];

	$i++;
}

}
?>
