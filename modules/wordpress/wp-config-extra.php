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
$weekday[0]=_CAL_SUNDAY;
$weekday[1]=_CAL_MONDAY;
$weekday[2]=_CAL_TUESDAY;
$weekday[3]=_CAL_WEDNESDAY;
$weekday[4]=_CAL_THURSDAY;
$weekday[5]=_CAL_FRIDAY;
$weekday[6]=_CAL_SATURDAY;

// the months, translate them if necessary - note: this isn't active everywhere yet
global $month;
$month['01']=_CAL_JANUARY;
$month['02']=_CAL_FEBRUARY;
$month['03']=_CAL_MARCH;
$month['04']=_CAL_APRIL;
$month['05']=_CAL_MAY;
$month['06']=_CAL_JUNE;
$month['07']=_CAL_JULY;
$month['08']=_CAL_AUGUST;
$month['09']=_CAL_SEPTEMBER;
$month['10']=_CAL_OCTOBER;
$month['11']=_CAL_NOVEMBER;
$month['12']=_CAL_DECEMBER;

// here's the conversion table, you can modify it if you know what you're doing
global $wpsmiliestrans;
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

?>