<?php
if( ! defined( 'WP_CALENDAR_POSTS_INCLUDED' ) ) {

	define( 'WP_CALENDAR_POSTS_INCLUDED' , 1 ) ;

	function b_wp_calendar_show($option, $wp_num = "")
	{
		global $wpdb, $siteurl, $wp_id, $wp_inblock, $xoopsConfig, $use_cache;
		$id=1;
		$use_cache = 1;

		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			include(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/wp-blocks.css.php')) {
			$themes = $xoopsConfig['theme_set'];
		} else {
			$themes = "default";
		}
		include_once(XOOPS_ROOT_PATH."/modules/wordpress". (($wp_id=='-')?'':$wp_id) ."/themes/".$themes."/wp-blocks.css.php");
		ob_start();
		echo <<< EOD
		<style type="text/css" media="screen">
				$wp_block_style
		</style>
EOD;
		get_calendar(1);
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_calendar_show($options) {
			global $wpdb, $wp_id, $wp_inblock, $xoopsConfig, $use_cache;

			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			include(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_calendar_show($options,"'.$i.'"));
		}
	');
	}
}
?>
