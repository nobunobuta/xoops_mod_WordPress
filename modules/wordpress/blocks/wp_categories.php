<?php
if( ! defined( 'WP_CATEGORIES_INCLUDED' ) ) {

	define( 'WP_CATEGORIES_INCLUDED' , 1 ) ;

	function b_wp_categories_edit($options)
	{
		$form = "";
		$form .= "Category List Style:&nbsp;";
		if ( $options[0] == 0 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[]' value='0'".$chk." />&nbsp;Simple List";
		$chk = "";
		if ( $options[0] == 1 ) {
			$chk = " checked=\"checked\"";
		}
		
		$form .= "&nbsp;<input type='radio' name='options[]' value='1'".$chk." />&nbsp;Dropdown List";
		$form .= "<br />Listing with count:&nbsp;";
		if ( $options[1] == 1 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[1]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		if ( $options[1] == 0 ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[1]' value='0'".$chk." />"._NO."";
		
		$form .= "<br />Sorting Key:&nbsp;";
		if ( $options[2] == 'ID' ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[2]' value='ID'".$chk." />&nbsp;".ID."";
		$chk = "";
		if ( $options[2] == 'name' ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[2]' value='name'".$chk." />".Name."";
		$chk = "";
		if ( $options[2] == 'description' ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[2]' value='description'".$chk." />".Description."";

		$form .= "<br />Sorting Order:&nbsp;";
		if ( $options[3] == 'asc' ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[3]' value='asc'".$chk." />&nbsp;".Ascending."";
		$chk = "";
		if ( $options[3] == 'desc' ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[3]' value='desc'".$chk." />".Descending."";

		return $form;
	}

	function b_wp_categories_show($options, $wp_num="")
	{
		$block_style =  ($options[0])?$options[0]:0;
		$with_count =  ($options[1])?$options[1]:0;
		$sorting_key = ($options[2])?$options[2]:'name';
		$sorting_order = ($options[3])?$options[3]:'asc';
		
		global $wpdb, $siteurl,  $wp_id, $wp_inblock ,$user_cache;

		$id=1;
		$use_cache=1;
		
		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}

		if ($block_style == 0) {
			// Simple Listing
			ob_start();
			list_cats(0, 'All', $sorting_key, $sorting_order,'',true,0,$with_count);
			$block['content'] = ob_get_contents();
			ob_end_clean();
		} else {
			// Dropdown Listing
			$file = "$siteurl/index.php";
			$link = $file.'?cat=';
			ob_start();
			echo '<form name="listcatform'.$wp_num.'" action="">';
			$select_str = '<select name="cat" onchange="window.location = (\''.$link.'\'+document.forms.listcatform'.$wp_num.'.cat[document.forms.listcatform'.$wp_num.'.cat.selectedIndex].value);"> ';
			dropdown_cats(1,_WP_LIST_CAT_ALL,$sorting_key,$sorting_order,0,$with_count);
			echo '</form>';
			$block_str = ob_get_contents();
			ob_end_clean();
			$block['content'] = ereg_replace('\<select name\=[^\>]*\>',$select_str,$block_str);
		}
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_categories_edit($options) {
			return (b_wp_categories_edit($options));
		}

		function b_wp'.$i.'_categories_show($options) {
			global $wpdb, $wp_id, $wp_inblock ,$user_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_categories_show($options,"'.$i.'"));
		}
	');
	}
}
?>
