<?php
if( ! defined( 'WP_CALENDAR_POSTS_INCLUDED' ) ) {

	define( 'WP_CALENDAR_POSTS_INCLUDED' , 1 ) ;

	function b_wp_calendar_show($option, $wp_num = "")
	{
		global $wpdb, $siteurl, $wp_id, $wp_inblock, $xoopsConfig, $use_cache, $m,$monthnum,$year;
		$id=1;
		$m = array_key_exists('m',$_GET) ? $_GET['m']: '';
		$monthnum = array_key_exists('monthnum',$_GET) ? $_GET['monthnum'] : '';
		$year = array_key_exists('year',$_GET) ? $_GET['year'] : '';
		$use_cache = 1;
		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			include(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		ob_start();
		block_style_get($wp_num);
		get_calendar(1);
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_calendar_show($options) {
			global $wpdb, $siteurl, $wp_id, $wp_inblock, $xoopsConfig, $use_cache, $m,$monthnum,$year;

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
