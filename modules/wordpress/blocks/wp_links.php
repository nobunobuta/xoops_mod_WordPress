<?php
function b_wp_links_show($option)
{
	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	ob_flush();
	ob_start();
	get_links_list();
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
