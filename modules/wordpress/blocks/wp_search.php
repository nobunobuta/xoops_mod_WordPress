<?php
if( ! defined( 'WP_SEARCH_INCLUDED' ) ) {

	define( 'WP_SEARCH_INCLUDED' , 1 ) ;

	function b_wp_search_show($option,$wp_num="")
	{
		$act_url = XOOPS_URL."/modules/wordpress".$wp_num."/";
		$block['content'] = <<<EOD
		<form id="searchform$wp_num" method="get" action="$act_url">
		<div>
			<input type="text" name="s" size="12" /> <input type="submit" name="submit" value="search" />
		</div>
		</form>
EOD;
		return $block;
	}
	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_search_show($options) {
			return (b_wp_search_show($options,'.$i.'));
		}
	');
	}
}
?>
