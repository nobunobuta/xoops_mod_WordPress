<?php
// this file contains customizable arrays for smilies, weekdays and month names.
global $xoopsConfig;
if ( file_exists(dirname(__FILE__)."/language/".$xoopsConfig['language']."/main.php") ) {
	include dirname(__FILE__)."/language/".$xoopsConfig['language']."/main.php";
} else {
	include dirname(__FILE__)."/language/english/main.php";
}

global $weekday;
// the weekdays and the months.. translate them if necessary
$weekday[0]=_WP_CAL_SUNDAY;
$weekday[1]=_WP_CAL_MONDAY;
$weekday[2]=_WP_CAL_TUESDAY;
$weekday[3]=_WP_CAL_WEDNESDAY;
$weekday[4]=_WP_CAL_THURSDAY;
$weekday[5]=_WP_CAL_FRIDAY;
$weekday[6]=_WP_CAL_SATURDAY;

// the months, translate them if necessary - note: this isn't active everywhere yet
global $month;
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

// here's the conversion table, you can modify it if you know what you're doing
global $wpsmiliestrans;
if (get_xoops_option('wordpress','wp_use_xoops_smilies')) {
    $wpsmiliestrans = array(
		':-D'   => 'smil3dbd4d4e4c4f2.gif',
		':-)'   => 'smil3dbd4d6422f04.gif',
		':-('   => 'smil3dbd4d75edb5e.gif',
		':-o'   => 'smil3dbd4d8676346.gif',
		':-?'   => 'smil3dbd4d99c6eaa.gif',
		'8-)'   => 'smil3dbd4daabd491.gif',
		':lol:'   => 'smil3dbd4dbc14f3f.gif',
		':-x'   => 'smil3dbd4dcd7b9f4.gif',
		':-P'   => 'smil3dbd4ddd6835f.gif',
		':oops:'   => 'smil3dbd4df1944ee.gif',
		':cry:'   => 'smil3dbd4e02c5440.gif',
		':evil:'   => 'smil3dbd4e1748cc9.gif',
		':roll:'   => 'smil3dbd4e29bbcc7.gif',
		';-)'   => 'smil3dbd4e398ff7b.gif',
		':pint:'   => 'smil3dbd4e4c2e742.gif',
		':hammer:'   => 'smil3dbd4e5e7563a.gif',
		':idea:'   => 'smil3dbd4e7853679.gif',
    );
} else {
	$wpsmiliestrans = array(
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
?>