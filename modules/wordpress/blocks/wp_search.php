<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_SEARCH_BLOCK_INCLUDED' ) ) {
	define( 'WP_SEARCH_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_search_show($option,$wp_num="")
	{
		$block['wp_num'] = $wp_num;
		$block['divid'] = 'wpSearch'.$wp_num;
		$block['style'] = block_style_get(false);
		$block['act_url'] = wp_siteurl().'/';
		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		$block['content'] = $_wpTpl->fetch('wp_search.html');
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'search_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_search_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
