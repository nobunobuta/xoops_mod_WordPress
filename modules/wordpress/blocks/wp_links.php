<?php
function b_wp_links_show($option)
{
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $tablelinks,$tablelinkcategories;
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	ob_flush();
	ob_start();
	get_links_list();
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
