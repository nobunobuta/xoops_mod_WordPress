<?php
function b_wp_search_show($option)
{
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;
	$block['content'] = <<<EOD
	<form id="searchform" method="get" action="$PHP_SELF">
	<div>
		<input type="text" name="s" size="12" /> <input type="submit" name="submit" value="search" />
	</div>
	</form>
EOD;
	return $block;
}
?>
