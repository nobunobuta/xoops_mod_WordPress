<?php
if( ! defined( 'WP_ARCHIVES_MONTHLY_INCLUDED' ) ) {

	define( 'WP_ARCHIVES_MONTHLY_INCLUDED' , 1 ) ;

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

	function b_wp_archives_monthly_show($options, $wp_num="")
	{
		$block_style =  ($options[0])?$options[0]:0;
		$with_count =  ($options[1]==0)?false:true;

		$id=1;
		$GLOBALS['use_cache'] = 1;
		if ($wp_num == "") {
			$GLOBALS['wp_id'] = $wp_num;
			$GLOBALS['wp_inblock'] = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$GLOBALS['wp_inblock'] = 0;
		}
		$sel_value = '';
		if (current_wp()) {
			init_param('GET', 'm','string','');
			init_param('GET', 'year','integer', '');
			init_param('GET', 'monthnum','integer','');
			if (strlen(get_param('m')) == 6 ) {
				$sel_value = get_param('m');
			} else if (test_param('year') && test_param('monthnum')) {
				$sel_value = get_param('year').zeroise(get_param('monthnum'),2);
			}
		}
		ob_start();
		block_style_get($wp_num);
		if ($block_style == 0) {
		// Simple Listing
			echo "<ul class='wpBlockList'>\n";
			get_archives('monthly','','html', '','',$with_count);
			echo "</ul>\n";
		} else {
		// Dropdown Listing
			echo '<form name="archiveform'.$wp_num.'" action="">';
			echo '<select name="archive_chrono" onchange="window.location = (document.forms.archiveform'.$wp_num.'.archive_chrono[document.forms.archiveform'.$wp_num.'.archive_chrono.selectedIndex].value);"> ';
			echo '<option value="">'._WP_BY_MONTHLY.'</option>';
			get_archives('monthly','','option', '','',$with_count, $sel_value);
			echo '</select>';
			echo '</form>';
		}
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_archives_monthly_edit($options) {
			return (b_wp_archives_monthly_edit($options));
		}

		function b_wp'.$i.'_archives_monthly_show($options) {
			$GLOBALS["wp_id"] = "'.$i.'";
			$GLOBALS["wp_inblock"] = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$GLOBALS["wp_inblock"] = 0;
			return (b_wp_archives_monthly_show($options,"'.$i.'"));
		}
	');
	}
}
?>
