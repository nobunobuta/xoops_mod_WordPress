<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
$cat_tblname = "wp{$mydirnumber}_categories";
eval( '

function b_sitemap_'.$mydirname.'(){

	$db =& Database::getInstance();
    $block = sitemap_get_categoires_map($db->prefix("'.$cat_tblname.'"), "cat_ID", "category_parent", "cat_name", "index.php?cat=", "cat_name");
	return $block ;
}

' ) ;

?>