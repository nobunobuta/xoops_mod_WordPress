<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_CALENDAR_BLOCK_INCLUDED' ) ) {
	define( 'WP_CALENDAR_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_calendar_show($option, $wp_num = "")
	{
		if (current_wp()) {
			if ( !empty( $_SERVER['PATH_INFO'] ) ) {
				permlink_to_param();
			}
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
}

eval ('
	function b_'.$_wp_my_prefix.'calendar_show($options) {
		$GLOBALS["use_cache"] = 1;
		$GLOBALS["wp_id"] = "'.(($_wp_my_dirnumber!=='') ? $_wp_my_dirnumber : '-').'";
		$GLOBALS["wp_inblock"] = 1;
		$GLOBALS["wp_mod"][$GLOBALS["wp_id"]] ="'.$_wp_my_dirname.'";
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_calendar_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
