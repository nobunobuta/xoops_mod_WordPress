<?php
function b_wp_archives_monthly_show($option)
{
	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $smilies_directory, $use_smilies, $wp_smiliessearch, $wp_smiliesreplace;
	global $wp_bbcode, $use_bbcode, $wp_gmcode, $use_gmcode, $use_htmltrans, $wp_htmltrans, $wp_htmltranswinuni;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	ob_start();
	get_archives('monthly');
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
