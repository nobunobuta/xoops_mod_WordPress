<?php
function b_wp_archives_monthly_edit($options)
{
	$form = "";
	$form .= "Month List Style:&nbsp;";
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

function b_wp_archives_monthly_show($options)
{
	$block_style =  ($options[0])?$options[0]:0;
	$with_count =  ($options[1]==0)?false:true;

	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $smilies_directory, $use_smilies, $wp_smiliessearch, $wp_smiliesreplace;
	global $wp_bbcode, $use_bbcode, $wp_gmcode, $use_gmcode, $use_htmltrans, $wp_htmltrans, $wp_htmltranswinuni;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	ob_start();
	if ($block_style == 0) {
	// Simple Listing
		get_archives('monthly','','html', '','',$with_count);
	} else {
	// Dropdown Listing
		echo '<form name="archiveform" action="">';
		echo '<select name="archive_chrono" onchange="window.location = (document.forms.archiveform.archive_chrono[document.forms.archiveform.archive_chrono.selectedIndex].value);"> ';
		echo '<option value="">'._WP_BY_MONTHLY.'</option>';
		get_archives('monthly','','option', '','',$with_count);
		echo '</select>';
		echo '</form>';
	}
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
