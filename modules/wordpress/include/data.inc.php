<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '

function '.$mydirname.'_new($limit=0, $offset=0){
	return _wordpress_new("'.$mydirname.'" ,$limit=0, $offset=0 ) ;
}

function '.$mydirname.'_num(){
	return _wordpress_num("'.$mydirname.'") ;
}

function '.$mydirname.'_data($limit=0, $offset=0){
	return _wordpress_data("'.$mydirname.'" ,$limit=0, $offset=0 ) ;
}
' ) ;
if (!function_exists('_wordpress_new')) {
//================================================================
// What's New Module
// get aritciles from module
// http://geomag.tea4you.net
// 2004-11-19 Hiroshi Uei
//================================================================
function _wordpress_new($mydirname, $limit=0, $offset=0) {
	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	$sql = "SELECT ID, post_title, post_content, UNIX_TIMESTAMP(post_date) AS unix_post_date FROM ".$GLOBALS['xoopsDB']->prefix("wp".$mydirnumber."_posts")." WHERE post_status='publish' ORDER BY post_date DESC";
	$result = $GLOBALS['xoopsDB']->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

	while($myrow = $GLOBALS['xoopsDB']->fetchArray($result)) {
		$ret[$i]['link'] = XOOPS_URL."/modules/".$mydirname."/index.php?p=".$myrow['ID'];
		$ret[$i]['title'] = $myrow['post_title'];
		$ret[$i]['time']  = $myrow['unix_post_date'];
		$ret[$i]['description'] = $myrow['post_content'];
		$i++;
	}

	return $ret;
}

function _wordpress_num($mydirname) {
	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
	$sql = "SELECT count(*) FROM ".$GLOBALS['xoopsDB']->prefix("wp".$mydirnumber."_posts")." ORDER BY ID";
	$array = $GLOBALS['xoopsDB']->fetchRow( $GLOBALS['xoopsDB']->query($sql) );
	$num = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function _wordpress_data($mydirname,$limit=0, $offset=0) {
	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
	$sql = "SELECT ID, post_title, UNIX_TIMESTAMP(post_date) AS unix_post_date FROM ".$GLOBALS['xoopsDB']->prefix("wp".$mydirnumber."_posts")." WHERE post_status='publish' ORDER BY ID";
	$result = $GLOBALS['xoopsDB']->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

	while($myrow = $GLOBALS['xoopsDB']->fetchArray($result)) {
		$id = $myrow['ID'];
		$ret[$i]['id'] = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/".$mydirname."/index.php?p=".$myrow['ID'];
		$ret[$i]['title'] = $myrow['post_title'];
		$ret[$i]['time'] = $myrow['unix_post_date'];

		$i++;
	}

	return $ret;
}
}
?>
