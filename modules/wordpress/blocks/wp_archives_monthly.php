<?php
function b_wp_archives_monthly_show($option)
{
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;
	ob_flush();
	ob_start();
	get_archives('monthly');
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
