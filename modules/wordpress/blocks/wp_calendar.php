<?php
if( ! defined( 'WP_CALENDAR_POSTS_INCLUDED' ) ) {

	define( 'WP_CALENDAR_POSTS_INCLUDED' , 1 ) ;

	function b_wp_calendar_show($option, $wp_num = "")
	{
		$id=1;
		$GLOBALS['use_cache'] = 1;
		if ($wp_num == "") {
			$GLOBALS['wp_id'] = $wp_num;
			$GLOBALS['wp_inblock'] = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$GLOBALS['wp_inblock'] = 0;
		}
		if (current_wp()) {
			init_param('GET', 'm','integer','');
			init_param('GET', 'w','integer','');
			init_param('GET', 'monthnum','integer','');
			init_param('GET', 'year','integer','');
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
			$GLOBALS["wp_id"] = "'.$i.'";
			$GLOBALS["wp_inblock"] = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$GLOBALS["wp_inblock"] = 0;
			return (b_wp_calendar_show($options,"'.$i.'"));
		}
	');
	}
}
?>
