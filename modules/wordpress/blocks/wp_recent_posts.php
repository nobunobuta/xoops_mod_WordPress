<?
function b_wp_recent_posts_show($options)	
{
	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
	global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	$no_posts = 10;
	$skip_posts = 0;
	$now = date('Y-m-d H:i:s',(time() + ($time_difference * 3600)));
	$request = "SELECT * FROM $tableposts WHERE post_status = 'publish' ";
	$request .= " AND post_date <= '".$now."'";
	$request .= " ORDER BY post_date DESC LIMIT $skip_posts, $no_posts";
	$lposts = $wpdb->get_results($request);
	$output = '';
	foreach ($lposts as $lpost) {
		$post_title = stripslashes($lpost->post_title);
		$permalink = get_permalink($lpost->ID);
		$output .= '<li style="font-size:90%"><a href="' . $permalink . '" rel="bookmark" title="Permanent Link: ' . $post_title . '">' . $post_title . '</a></li>';
	}
	$block['content'] = $output;
	return $block;
}
?>
