<?php
function b_wp_archives_monthly_show($option)
{
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $tableposts, $dateformat, $time_difference, $siteurl, $blogfilename;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	ob_flush();
	ob_start();
	get_archives('monthly');
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
