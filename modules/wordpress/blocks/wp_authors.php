<?php
if( ! defined( 'WP_AUTHORS_INCLUDED' ) ) {

	define( 'WP_AUTHORS_INCLUDED' , 1 ) ;

	function b_wp_authors_edit($options)
	{
		$form = "";
		return $form;
	}

	function b_wp_authors_show($options, $wp_num="")
	{
		global $wpdb, $siteurl,  $wp_id, $wp_inblock ,$user_cache;

		$id=1;
		$use_cache=1;
		
		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		$optioncount = true;
		$exclude_admin = false;
		$show_fullname = false;
		$hide_empty = true;
		$feed = 'rss2';
		$feed_image = $siteurl.'/wp-images/rss-mini.gif';
		ob_start();
		list_authors($optioncount,$exclude_admin,$show_fullname,$hide_empty,$feed,$feed_image);
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_authors_edit($options) {
			return (b_wp_authors_edit($options));
		}

		function b_wp'.$i.'_authors_show($options) {
		global $wpdb, $siteurl,  $wp_id, $wp_inblock ,$user_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_authors_show($options,"'.$i.'"));
		}
	');
	}
}
?>
