<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_STYLE_BLOCK_INCLUDED' ) ) {
	define( 'WP_STYLE_BLOCK_INCLUDED' , 1 ) ;
	
	function _b_wp_style_edit($options, $wp_num = "") {
		return 'You should not enable block cache<br>';
	}
	function _b_wp_style_show($options, $wp_num = "") {
		$block['content'] = block_style_get(false);
		if ($block['content']) return $block;
		else return '';
	}
}
eval ('
	function b_'.$_wp_my_prefix.'style_edit($options) {
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		return (_b_wp_style_edit($options,"'.$_wp_my_dirnumber.'"));
	}
	function b_'.$_wp_my_prefix.'style_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_style_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
