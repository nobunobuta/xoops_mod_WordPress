<?php
function b_wp_search_show($option)
{
	$id=1;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $tableposts, $dateformat, $time_difference, $siteurl, $blogfilename;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	$act_url = XOOPS_URL."/modules/wordpress/";
	$block['content'] = <<<EOD
	<form id="searchform" method="get" action="$act_url">
	<div>
		<input type="text" name="s" size="12" /> <input type="submit" name="submit" value="search" />
	</div>
	</form>
EOD;
	return $block;
}
?>
