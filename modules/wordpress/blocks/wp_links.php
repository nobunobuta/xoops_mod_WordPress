<?php
function b_wp_links_show($option)
{
	global $tablelinks,$tablelinkcategories;
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;
	ob_flush();
	ob_start();
	get_links_list();
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
