<?php
// this file contains customizable arrays for smilies, weekdays and month names.
global $xoopsConfig;
if ( file_exists(dirname(__FILE__)."/language/".$xoopsConfig['language']."/main.php") ) {
	include_once dirname(__FILE__)."/language/".$xoopsConfig['language']."/main.php";
} else {
	include_once dirname(__FILE__)."/language/english/main.php";
}

global $weekday, $s_weekday_length;
// the weekdays and the months.. translate them if necessary
$weekday[0]=_WP_CAL_SUNDAY;
$weekday[1]=_WP_CAL_MONDAY;
$weekday[2]=_WP_CAL_TUESDAY;
$weekday[3]=_WP_CAL_WEDNESDAY;
$weekday[4]=_WP_CAL_THURSDAY;
$weekday[5]=_WP_CAL_FRIDAY;
$weekday[6]=_WP_CAL_SATURDAY;

$s_weekday_length = _WP_CAL_SWEEK_LEN;

// the months, translate them if necessary - note: this isn't active everywhere yet
global $month, $s_month_length, $wp_month_format;
$month['01']=_WP_CAL_JANUARY;
$month['02']=_WP_CAL_FEBRUARY;
$month['03']=_WP_CAL_MARCH;
$month['04']=_WP_CAL_APRIL;
$month['05']=_WP_CAL_MAY;
$month['06']=_WP_CAL_JUNE;
$month['07']=_WP_CAL_JULY;
$month['08']=_WP_CAL_AUGUST;
$month['09']=_WP_CAL_SEPTEMBER;
$month['10']=_WP_CAL_OCTOBER;
$month['11']=_WP_CAL_NOVEMBER;
$month['12']=_WP_CAL_DECEMBER;

$s_month_length = _WP_CAL_SMONTH_LEN;
$wp_month_format = _WP_MONTH_FORMAT;

// here's the conversion table, you can modify it if you know what you're doing
global $wpsmiliestrans;
if (get_xoops_option('wordpress'.(($wp_id=='-')?'':$wp_id),'wp_use_xoops_smilies')) {
	// Get smilies infomation from XOOPS DB
	$db =& Database::getInstance();
	$getsmiles = $db->query("SELECT id, code, smile_url FROM ".$db->prefix("smiles")." ORDER BY id");
	if (($numsmiles = $db->getRowsNum($getsmiles)) == "0") {
		//EMPTY
	} else {
		while ($smiles = $db->fetchArray($getsmiles)) {
			$wpsmiliestrans[$wp_id][$smiles['code']] = $smiles['smile_url'];
		}
	}
} else {
	$wpsmiliestrans[$wp_id] = array(
	    ' :)'        => 'icon_smile.gif',
	    ' :D'        => 'icon_biggrin.gif',
	    ' :-D'       => 'icon_biggrin.gif',
	    ':grin:'    => 'icon_biggrin.gif',
	    ' :)'        => 'icon_smile.gif',
	    ' :-)'       => 'icon_smile.gif',
	    ':smile:'   => 'icon_smile.gif',
	    ' :('        => 'icon_sad.gif',
	    ' :-('       => 'icon_sad.gif',
	    ':sad:'     => 'icon_sad.gif',
	    ' :o'        => 'icon_surprised.gif',
	    ' :-o'       => 'icon_surprised.gif',
	    ':eek:'     => 'icon_surprised.gif',
	    ' 8O'        => 'icon_eek.gif',
	    ' 8-O'       => 'icon_eek.gif',
	    ':shock:'   => 'icon_eek.gif',
	    ' :?'        => 'icon_confused.gif',
	    ' :-?'       => 'icon_confused.gif',
	    ' :???:'     => 'icon_confused.gif',
	    ' 8)'        => 'icon_cool.gif',
	    ' 8-)'       => 'icon_cool.gif',
	    ':cool:'    => 'icon_cool.gif',
	    ':lol:'     => 'icon_lol.gif',
	    ' :x'        => 'icon_mad.gif',
	    ' :-x'       => 'icon_mad.gif',
	    ':mad:'     => 'icon_mad.gif',
	    ' :P'        => 'icon_razz.gif',
	    ' :-P'       => 'icon_razz.gif',
	    ':razz:'    => 'icon_razz.gif',
	    ':oops:'    => 'icon_redface.gif',
	    ':cry:'     => 'icon_cry.gif',
	    ':evil:'    => 'icon_evil.gif',
	    ':twisted:' => 'icon_twisted.gif',
	    ':roll:'    => 'icon_rolleyes.gif',
	    ':wink:'    => 'icon_wink.gif',
	    ' ;)'        => 'icon_wink.gif',
	    ' ;-)'       => 'icon_wink.gif',
	    ':!:'       => 'icon_exclaim.gif',
	    ':?:'       => 'icon_question.gif',
	    ':idea:'    => 'icon_idea.gif',
	    ':arrow:'   => 'icon_arrow.gif',
	    ' :|'        => 'icon_neutral.gif',
	    ' :-|'       => 'icon_neutral.gif',
	    ':neutral:' => 'icon_neutral.gif',
	    ':mrgreen:' => 'icon_mrgreen.gif',
	);
}

if (file_exists(dirname(__FILE__).'/themes/'.$xoopsConfig['theme_set'].'/wp-config-custom.php')) {
	$themes = $xoopsConfig['theme_set'];
} else {
	$themes = "default";
}
include(dirname(__FILE__).'/themes/'.$themes.'/wp-config-custom.php');

?>