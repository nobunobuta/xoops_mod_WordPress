<?php
// this file contains customizable arrays for smilies, weekdays and month names.

global $weekday;
// the weekdays and the months.. translate them if necessary
$weekday[0]='日曜日';
$weekday[1]='月曜日';
$weekday[2]='火曜日';
$weekday[3]='水曜日';
$weekday[4]='木曜日';
$weekday[5]='金曜日';
$weekday[6]='土曜日';

// the months, translate them if necessary - note: this isn't active everywhere yet
global $month;
$month['01']='January';
$month['02']='February';
$month['03']='March';
$month['04']='April';
$month['05']='May';
$month['06']='June';
$month['07']='July';
$month['08']='August';
$month['09']='September';
$month['10']='October';
$month['11']='November';
$month['12']='December';

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