<?php
if( ! defined( 'WP_XOOPS_SEARCH_INCLUDED' ) ) {

	define( 'WP_XOOPS_SEARCH_INCLUDED' , 1 ) ;

	function wp_xoops_search($queryarray, $andor, $limit, $offset, $userid, $wp_num=""){
		global $xoopsDB,$siteurl;
	    global $month, $wpdb, $wp_id,$wp_inblock;
		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress/wp-config.php");
			$wp_inblock = 0;
		}
		$time_difference = get_settings('time_difference');
		$now = date('Y-m-d H:i:s',(time() + ($time_difference * 3600)));
		$where = "(post_status = 'publish') AND (post_date <= '".$now."')";
		
		if ( is_array($queryarray) && $count = count($queryarray) ) {
			$where .= " AND ((post_title LIKE '%$queryarray[0]%' OR post_content LIKE '%$queryarray[0]%')";
			for($i=1;$i<$count;$i++){
				$where .= " $andor ";
				$where .= "(post_title LIKE '%$queryarray[$i]%' OR post_content LIKE '%$queryarray[$i]%')";
			}
			$where .= ") ";
		}
		if ($userid) {
			$userid = intval($userid);
			$where  .= " AND (post_author=".$userid.")";
		}
		$request = "SELECT * FROM ".$xoopsDB->prefix("wp".$wp_num."_posts")." WHERE ".$where;
		$request .= " ORDER BY post_date DESC";
		$result = $xoopsDB->query($request,$limit,$offset);

		$ret = array();
		$i = 0;
		while($myrow = $xoopsDB->fetchArray($result)){
			$ret[$i]['link'] = str_replace($siteurl."/","",get_permalink(($myrow['ID'])));
			$ret[$i]['title'] = htmlspecialchars($myrow['post_title'], ENT_QUOTES);
			$ret[$i]['image'] = "wp-images/search.png";
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
	for ($i = 0; $i < 10; $i++) {
		eval ('
		function wp'.$i.'_xoops_search($queryarray, $andor, $limit, $offset, $userid) {
			global $xoopsDB,$siteurl;
		    global $month, $wpdb, $wp_id,$wp_inblock;
			$wp_id = '.$i.';
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (wp_xoops_search($queryarray, $andor, $limit, $offset, $userid, '.$i.'));
		}
	');
	}
}
?>