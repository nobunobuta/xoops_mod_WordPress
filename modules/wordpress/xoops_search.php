<?PHP
function wp_xoops_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB,$siteurl;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;

	require_once(dirname(__FILE__).'/wp-config.php');

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
		$where  .= " AND (post_author=".$userid.")";
	}
	$request = "SELECT * FROM ".$xoopsDB->prefix("wp_posts")." WHERE ".$where;
	$request .= " ORDER BY post_date DESC";
	$result = $xoopsDB->query($request);

	$ret = array();
	$i = 0;
//	if (!$queryarray) $queryarray = array();
//	$word_url = rawurlencode(join(' ',$queryarray));
	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['link'] = rawurlencode( str_replace($siteurl."/","",get_permalink(($myrow['ID']))));
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
		$i++;
	}
	return $ret;
}
?>