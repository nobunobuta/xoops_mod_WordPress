<?php
function b_wp_categories_show($option)
{
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;
	ob_flush();
	ob_start();
	list_cats(0, 'All', 'name');
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
