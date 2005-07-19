<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname( __FILE__ ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_XOOPS_SEARCH_INCLUDED' ) ) {
	define( 'WP_XOOPS_SEARCH_INCLUDED' , 1 ) ;

	function _wp_xoops_search($queryarray, $andor, $limit, $offset, $userid){
		$now = current_time('mysql');
		$where = '(post_status = \'publish\') AND (post_date <= \''.$now.'\')';
		
		if ( is_array($queryarray) && $count = count($queryarray) ) {
			$where .= " AND ((post_title LIKE '%$queryarray[0]%' OR post_content LIKE '%$queryarray[0]%')";
			for($i=1;$i<$count;$i++){
				$where .= " $andor ";
				$where .= "(post_title LIKE '%$queryarray[$i]%' OR post_content LIKE '%$queryarray[$i]%')";
			}
			$where .= ') ';
		}
		if ($userid) {
			$userid = intval($userid);
			$where  .= ' AND (post_author='.$userid.')';
		}
		$request = 'SELECT * FROM '.wp_table('posts').' WHERE '.$where;
		$request .= ' ORDER BY post_date DESC';
		$result = $GLOBALS['xoopsDB']->query($request,$limit,$offset);

		$ret = array();
		$i = 0;
		while($myrow = $GLOBALS['xoopsDB']->fetchArray($result)){
			$ret[$i]['link'] = str_replace(wp_siteurl().'/', '', get_permalink(($myrow['ID'])));
			$ret[$i]['title'] = htmlspecialchars($myrow['post_title'], ENT_QUOTES);
			$ret[$i]['image'] = 'wp-images/search.png';
			$date_str = $myrow['post_date'];
			$yyyy = substr($date_str,0,4);
			$mm   = substr($date_str,5,2);
			$dd   = substr($date_str,8,2);
			$hh   = substr($date_str,11,2);
			$nn   = substr($date_str,15,2);
			$ss   = substr($date_str,17,2);
			$ret[$i]['time'] = mktime( $hh,$nn,$ss,$mm,$dd,$yyyy);
			$ret[$i]['uid'] = $myrow['post_author'];
			$ret[$i]['page'] = $myrow['post_title'];
			if (!empty($myrow['post_content']) && function_exists('xoops_make_context')) {
				$ret[$i]['context'] = xoops_make_context(strip_tags($myrow['post_content']),$queryarray);
			}

			$i++;
		}
		return $ret;
	}
}
eval ('
	function '.$_wp_my_prefix.'xoops_search($queryarray, $andor, $limit, $offset, $userid) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return _wp_xoops_search($queryarray, $andor, $limit, $offset, $userid);
	}
');
?>