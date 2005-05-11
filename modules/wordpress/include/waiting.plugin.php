<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '

function b_waiting_'.$mydirname.'(){
	return b_waiting_wordpress_base( "'.$mydirname.'" ) ;
}

' ) ;

if( ! function_exists( 'b_waiting_wordpress_base' ) ) {

function b_waiting_wordpress_base( $mydirname )
{
	$xoopsDB =& Database::getInstance();
	$block = array();

	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("wp".$mydirnumber."_comments")." WHERE comment_approved='0'");
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/wp-admin/moderation.php" ;
		list($block['pendingnum']) = $xoopsDB->fetchRow($result);
		$block['lang_linkname'] = _PI_WAITING_COMMENTS ;
	}

	return $block;
}

}

?>