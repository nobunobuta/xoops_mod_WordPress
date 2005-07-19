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
			init_param('GET', 'p','integer','');
			init_param('GET', 'm','integer','');
			init_param('GET', 'w','integer','');
			init_param('GET', 'monthnum','integer','');
			init_param('GET', 'year','integer','');
			if (test_param('p') && !(test_param('m') || test_param('monthnum') || test_param('w'))) {
				$postHandler =& wp_handler('Post');
				$postObject =& $postHandler->get(get_param('p'));
				$GLOBALS['m'] = mysql2date('Ym', $postObject->getVar('post_date'));
			}
		}
		$block['wp_num'] = $wp_num;
		$block['divid'] = 'wpCalendar'.$wp_num;
		$block['style'] = block_style_get(false);
		$block['calendar'] = get_calendar(1,false);
		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		$block['content'] = $_wpTpl->fetch('wp_calendar.html');
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'calendar_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_calendar_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
