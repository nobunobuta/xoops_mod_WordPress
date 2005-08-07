<?php
/* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }
//Debug Log 出力モード
//$GLOBALS['wp_debug'] = true;
//
// PINGサーバの指定
$GLOBALS['my_pingserver'][0]['server']="rpc.weblogs.com";
$GLOBALS['my_pingserver'][0]['path']="/RPC2";
$GLOBALS['my_pingserver'][0]['port']=80;
//$GLOBALS['my_pingserver'][1]['server']="ping.bloggers.jp";
//$GLOBALS['my_pingserver'][1]['path']="/rpc/";
//$GLOBALS['my_pingserver'][1]['port']=80;
//$GLOBALS['my_pingserver'][2]['server']="ping.myblog.jp";
//$GLOBALS['my_pingserver'][2]['path']="/";
//$GLOBALS['my_pingserver'][2]['port']=80;
//$GLOBALS['my_pingserver'][3]['server']="bulkfeeds.net";
//$GLOBALS['my_pingserver'][3]['path']="/rpc";
//$GLOBALS['my_pingserver'][3]['port']=80;

// 日本語環境で曜日を英語で出したいとき。
/*
$GLOBALS['weekday'][0]='Sunday';
$GLOBALS['weekday'][1]='Monday';
$GLOBALS['weekday'][2]='Tuesday';
$GLOBALS['weekday'][3]='Wednesday';
$GLOBALS['weekday'][4]='Thursday';
$GLOBALS['weekday'][5]='Friday';
$GLOBALS['weekday'][6]='Saturday';

$GLOBALS['s_weekday_length'] = 3; //曜日を省略形で表示するときの文字数 "Sunday"は"Sun"になる。"日曜日"を"日"にする場合は1を指定。
*/
// 日本語環境で月名を英語で出したいとき。
/*
$GLOBALS['month']['01']='January';
$GLOBALS['month']['02']='February';
$GLOBALS['month']['03']='March';
$GLOBALS['month']['04']='April';
$GLOBALS['month']['05']='May';
$GLOBALS['month']['06']='June';
$GLOBALS['month']['07']='July';
$GLOBALS['month']['08']='August';
$GLOBALS['month']['09']='September';
$GLOBALS['month']['10']='October';
$GLOBALS['month']['11']='November';
$GLOBALS['month']['12']='December';

$GLOBALS['s_month_length'] = 3; //月名を省略形で表示するときの文字数 "January"は"Jan"になる。
$GLOBALS['wp_month_format'] = '%MONTH %YEAR'; 年月表示の表示形式
*/

//Customize nkarchives.php settings
//$GLOBALS['wp_arc_posts_per_page'] = 50;       // Max number for listing (-1 means no limit)
//$GLOBALS['wp_arc_display_authors'] = 1;       // 0:Don't show Autor list  1:Show Autor list.
//$GLOBALS['wp_arc_display_categories'] = 1;    // 0:Don't show Category list  1:Show Category list.
//$GLOBALS['wp_arc_display_keyword'] = 1;       // 0:Don't show Keyword input  1:Show Keyword input.
//$GLOBALS['wp_arc_defaultorderby'] = 'date';
//$GLOBALS['wp_arc_defaultorder']   = 'DESC';
?>
