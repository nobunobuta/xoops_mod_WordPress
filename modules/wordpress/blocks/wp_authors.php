<?php
if( ! defined( 'WP_AUTHORS_INCLUDED' ) ) {

	define( 'WP_AUTHORS_INCLUDED' , 1 ) ;

	function b_wp_authors_edit($options)
	{
		$form = "<table width='100%'>";

		$form .= "<tr><td width='40%'>Listing with count:</td>";
		$chk = ( $options[0] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[0]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[0] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[0]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";

		$form .= "<tr><td>Show RSS2 feed icon:</td>";
		$chk = ( $options[1] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[1]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[1] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[1]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";

		$form .= "</table>";
		return $form;
	}

	function b_wp_authors_show($options, $wp_num="")
	{
		$with_count =  (empty($options[0]))? 0 : $options[0];
		$show_rss2_icon = (empty($options[1]))? 0 : $options[1];

		global $wpdb, $siteurl,  $wp_id, $wp_inblock ,$user_cache;

		$id=1;
		$use_cache=1;
		
		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		$optioncount = ($with_count == 1);
		$exclude_admin = false;
		$show_fullname = false;
		$hide_empty = true;
		$feed = ($show_rss2_icon == 1) ? 'rss2' : '' ;
		$feed_image = ($show_rss2_icon == 1) ? $siteurl.'/wp-images/rss-mini.gif' : '';
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
