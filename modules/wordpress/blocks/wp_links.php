<?php
if( ! defined( 'WP_LINKS_INCLUDED' ) ) {

	define( 'WP_LINKS_INCLUDED' , 1 ) ;

	function b_wp_links_show($option,$wp_num="")
	{
		global $wpdb;
		global $wp_id, $wp_inblock, $use_cache;

		$id=1;
		$use_cache = 1;

		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		ob_start();
		block_style_get($wp_num);
		echo "<ul class='wpBlockList'>\n";
		get_links_list();
		echo "</ul>\n";
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_links_show($options) {
			global $wp_id, $wp_inblock, $use_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_links_show($options,"'.$i.'"));
		}
	');
	}
}
?>
