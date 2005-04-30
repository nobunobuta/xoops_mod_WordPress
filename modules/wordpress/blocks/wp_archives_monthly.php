<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_ARCHIVES_MONTHLY_BLOCK_INCLUDED' ) ) {
	define( 'WP_ARCHIVES_MONTHLY_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_archives_monthly_edit($options)
	{
		$form = '';
		$form .= 'Month List Style:&nbsp;';
		if ( $options[0] == 0 ) {
			$chk = ' checked="checked"';
		}
		$form .= '<input type="radio" name="options[]" value="0"'.$chk.' />&nbsp;Simple List';
		$chk = '';
		if ( $options[0] == 1 ) {
			$chk = ' checked="checked"';
		}
		$form .= '&nbsp;<input type="radio" name="options[]" value="1"'.$chk.' />&nbsp;Dropdown List';
		$form .= '<br />Listing with count:&nbsp;';
		if ( $options[1] == 1 ) {
			$chk = ' checked="checked"';
		}
		$form .= '<input type="radio" name="options[1]" value="1"'.$chk.' />&nbsp;'._YES;
		$chk = "";
		if ( $options[1] == 0 ) {
			$chk = ' checked="checked"';
		}
		$form .= '&nbsp;<input type="radio" name="options[1]" value="0"'.$chk.' />'._NO;
		return $form;
	}

	function _b_wp_archives_monthly_show($options, $wp_num='')
	{
		$block_style =  ($options[0])?$options[0]:0;
		$with_count =  ($options[1]==0)?false:true;

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
			echo '<ul class="wpBlockList">'."\n";
			get_archives('monthly','','html', '','',$with_count);
			echo '</ul>'."\n";
		} else {
		// Dropdown Listing
			echo '<form name="archiveform'.$wp_num.'" id="archiveform'.$wp_num.'" action="#">';
			echo '<select name="archive_chrono" onchange="window.location = (document.forms.archiveform'.$wp_num.'.archive_chrono[document.forms.archiveform'.$wp_num.'.archive_chrono.selectedIndex].value);"> ';
			echo '<option value="'.wp_siteurl().'">'._WP_BY_MONTHLY.'</option>';
			get_archives('monthly','','option', '','',$with_count, $sel_value);
			echo '</select>';
			echo '</form>';
		}
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'archives_monthly_edit($options) {
		return (_b_wp_archives_monthly_edit($options));
	}
	function b_'.$_wp_my_prefix.'archives_monthly_show($options) {
		$GLOBALS["use_cache"] = 1;
		$GLOBALS["wp_id"] = "'.(($_wp_my_dirnumber!=='') ? $_wp_my_dirnumber : '-').'";
		$GLOBALS["wp_inblock"] = 1;
		$GLOBALS["wp_mod"][$GLOBALS["wp_id"]] ="'.$_wp_my_dirname.'";
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_archives_monthly_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
