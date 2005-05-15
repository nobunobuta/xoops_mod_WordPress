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
		$form = "<table width='100%'>";

		$form .= "<tr><td width='40%'>Listing with count:</td>";
		$chk = ( $options[0] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[0]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[0] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[0]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";

		$form .= "<tr><td>Name Option:</td>";
		$form .= "<td><select name='options[1]'>";
        $form .= "<option value='nickname'";
		$form .= (($options[1] == 'nickname') ? " selected" : "") ."> Nick Name </option>";
        $form .= "<option value='login'";
		$form .= (($options[1] == 'login') ? " selected" : "") ."> Login Name </option>";
        $form .= "<option value='firstname'";
		$form .= (($options[1] == 'firstname') ? " selected" : "") ."> First Name </option>";
        $form .= "<option value='lastname'";
		$form .= (($options[1] == 'lastname') ? " selected" : "") ."> Last Name </option>";
        $form .= "<option value='namefl'";
		$form .= (($options[1] == 'namefl') ? " selected" : "") ."> Full Name (First Last) </option>";
        $form .= "<option value='namelf'";
		$form .= (($options[1] == 'namelf') ? " selected" : "") ."> Full Name (Last First)</option>";
		$form .= "</select></td></tr>";

		$form .= "<tr><td>Show RSS2 feed icon:</td>";
		$chk = ( $options[2] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[2]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[2] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[2]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "</table>";
		return $form;
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
		ob_start();
		block_style_get();
		echo "<ul class='wpBlockList'>\n";
		list_authors2($optioncount,$exclude_admin,$idmode, $hide_empty,$feed,$feed_image);
		echo "</ul>\n";
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'authors_edit($options) {
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
