<?php
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
	return $form;
}

function b_wp_categories_show($options)
{
	$block_style =  ($options[0])?$options[0]:0;
	$with_count =  ($options[1])?$options[1]:0;

	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $smilies_directory, $use_smilies, $wp_smiliessearch, $wp_smiliesreplace;
	global $wp_bbcode, $use_bbcode, $wp_gmcode, $use_gmcode, $use_htmltrans, $wp_htmltrans, $wp_htmltranswinuni;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	if ($block_style == 0) {
		// Simple Listing
		ob_start();
		list_cats(0, 'All', 'name','asc','',true,0,$with_count);
		$block['content'] = ob_get_contents();
		ob_end_clean();
	} else {
		// Dropdown Listing
		$file = "$siteurl/$blogfilename";
		$link = $file.$querystring_start.'cat'.$querystring_equal;
		ob_start();
		echo '<form name="listcatform" action="">';
		$select_str = '<select name="cat" onchange="window.location = (\''.$link.'\'+document.forms.listcatform.cat[document.forms.listcatform.cat.selectedIndex].value);"> ';
		dropdown_cats(1,_WP_LIST_CAT_ALL,'name','asc',0,$with_count);
		echo '</form>';
		$block_str = ob_get_contents();
		ob_end_clean();
		$block['content'] = ereg_replace('\<select name\=[^\>]*\>',$select_str,$block_str);
	}
	return $block;
}
?>
