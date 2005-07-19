<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_AUTHORS_BLOCK_INCLUDED' ) ) {
	define( 'WP_AUTHORS_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_authors_edit($options)
	{
		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$optForm = new XoopsSimpleForm('Block Option Dummy Form', 'optionform', '');
		$optForm->addElement(new XoopsFormRadioYN('Listing with count:', 'options[0]', $options[0]));
		$optFormNameType = new XoopsFormSelect('Name Option:',  'options[1]', $options[1]);
		$optFormNameType->addOption('nickname', 'Nick Name');
		$optFormNameType->addOption('login', 'Login Name');
		$optFormNameType->addOption('firstname', 'First Name');
		$optFormNameType->addOption('lastname', 'Last Name');
		$optFormNameType->addOption('namefl', 'Full Name (First Last)');
		$optFormNameType->addOption('namelf', 'Full Name (Last First)');
		$optForm->addElement($optFormNameType);
		$optForm->addElement(new XoopsFormRadioYN('Show RSS2 feed icon:', 'options[2]', $options[2]));

		$_wpTpl =& new WordPresTpl('theme');
		$optForm->assign($_wpTpl);
		return $_wpTpl->fetch('wp_block_edit.html');
	}

	function _b_wp_authors_show($options, $wp_num="")
	{
		$with_count =  (empty($options[0]))? 0 : $options[0];
		$idmode = (empty($options[1]))? '' : $options[1];
		$show_rss2_icon = (empty($options[2]))? 0 : $options[2];

		$optioncount = ($with_count == 1);
		$exclude_admin = false;
		$show_fullname = false;
		$hide_empty = true;
		$feed = ($show_rss2_icon == 1) ? 'rss2' : '' ;
		$feed_image = ($show_rss2_icon == 1) ? wp_siteurl().'/wp-images/rss-mini.gif' : '';
		$block['style'] = block_style_get(false);
		$block['authors'] = list_authors2($optioncount,$exclude_admin,$idmode, $hide_empty,$feed,$feed_image,false);
		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		$block['content'] = $_wpTpl->fetch('wp_authors.html');
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'authors_edit($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_authors_edit($options));
	}
	function b_'.$_wp_my_prefix.'authors_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_authors_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
