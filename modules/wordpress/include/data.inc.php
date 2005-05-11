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
// get aritciles from module
// http://linux.ohwada.net/
// 2003.12.20 K.OHWADA
//================================================================
function _wordpress_new($mydirname, $limit=0, $offset=0) {
	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	$sql = "SELECT ID, post_title, post_content, post_date FROM ".$GLOBALS['xoopsDB']->prefix("wp".$mydirnumber."_posts")." ORDER BY post_date DESC";
	$result = $GLOBALS['xoopsDB']->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

	while($myrow = $GLOBALS['xoopsDB']->fetchArray($result)) {
		$ret[$i]['link'] = XOOPS_URL."/modules/".$mydirname."/index.php?p=".$myrow['ID'];
		$ret[$i]['title'] = $myrow['post_title'];
		$dt = $myrow['post_date'];
		$ret[$i]['time'] = mktime(substr($dt,11,2),substr($dt,14,2),substr($dt,17,2),substr($dt,5,2),substr($dt,8,2),substr($dt,0,4));

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
	$sql = "SELECT ID, post_title, post_date FROM ".$GLOBALS['xoopsDB']->prefix("wp".$mydirnumber."_posts")." ORDER BY ID";
	$result = $GLOBALS['xoopsDB']->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

	while($myrow = $GLOBALS['xoopsDB']->fetchArray($result)) {
		$id = $myrow['ID'];
		$ret[$i]['id'] = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/".$mydirname."/index.php?p=".$myrow['ID'];
		$ret[$i]['title'] = $myrow['post_title'];
		$dt = $myrow['post_date'];
		$ret[$i]['time'] = mktime(substr($dt,11,2),substr($dt,14,2),substr($dt,17,2),substr($dt,5,2),substr($dt,8,2),substr($dt,0,4));

		$i++;
	}

	return $ret;
}
}
?>
