<?php
/* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }
$wp_block_style = <<<EOD
/* Default WordPress by Dave Shea || http://mezzoblue.com
	Modifications by Matthew Mullenweg || http://photomatt.net
	This is just a basic layout, with only the bare minimum defined.
	Please tweak this and make it your own. :)
����
*/
#wpBlockContent$wp_num {
	padding-left: 5px;
	padding-right: 5px;
}

#wpBlockContent$wp_num h2 {
	font-size : 16px;
	font-family: "�ҥ饮�γѥ� Pro W3", Osaka, Verdana, "�ͣ� �Х����å�", sans-serif;;
	border-bottom: 1px solid #dcdcdc;
	margin-bottom: 5px;
}

#wpBlockContent$wp_num h3 {
	font-size : 14px;
	font-family: "�ҥ饮�γѥ� Pro W3", Osaka, Verdana, "�ͣ� �Х����å�", sans-serif;
	margin-bottom: 5px;
}

#wpBlockContent$wp_num .storytitle {
	margin: 0;
}

#wpBlockContent$wp_num .storytitle a {
	text-decoration: none;
}

#wpBlockContent$wp_num .meta {
	font-size: .75em;
}

#wpBlockContent$wp_num .meta,#wpBlockContent$wp_num .meta a {
	color: #808080;
	font-weight: normal;
	letter-spacing: 0;
}
#wpBlockContent$wp_num .meta ul {
	display: inline;
	margin: 0;
	padding: 0;
	list-style: none;
}

#wpBlockContent$wp_num .meta li {
	display: inline;
}


#wpBlockContent$wp_num .storycontent{
	font: 95% "�ҥ饮�γѥ� Pro W3", Osaka, Verdana, "�ͣ� �Х����å�", sans-serif;
}

#wpBlockContent$wp_num div.storycontent {
	clear:right;
}

#wpBlockContent$wp_num .feedback {
	color: #ccc;
	text-align: right;
}

#wpBlockContent$wp_num p,#wpBlockContent$wp_num  li,#wpBlockContent$wp_num .feedback {
	font: 80%/175% "�ҥ饮�γѥ� Pro W3", Osaka, Verdana, "�ͣ� �Х����å�", sans-serif;
}

#wpBlockContent$wp_num blockquote {
	border-left: 5px solid #ccc;
	margin-left: 1.5em;
	padding-left: 5px;
}

#wp-calendar {
	empty-cells: show;
	font-size: 14px;
	margin: 0;
	width: 90%;
}

#wp-calendar #next a {
	padding-right: 10px;
	text-align: right;
}

#wp-calendar #prev a {
	padding-left: 10px;
	text-align: left;
}

#wp-calendar a {
	display: block;
	color: #000000;
	text-decoration: none;
}

#wp-calendar a:hover {
	background: #A6C9E6;
	color: #333;
}

#wp-calendar caption {
	font-weight: bold;
	font-size: 110%;
	color: #632;
	text-align: left;
}

#wp-calendar td {
	color: #aaa;
	font: normal 12px "�ҥ饮�γѥ� Pro W3", Osaka, Verdana, "�ͣ� �Х����å�", sans-serif;
	letter-spacing: normal;
	padding: 2px 0;
	text-align: center;
}

#wp-calendar td.pad:hover {
	background: #fff;
}

#wp-calendar #today {
	background: #D85F7D;
	color: #ffffff;
}

#wp-calendar th {
	font-style: normal;
	font-size: 11px;
	text-transform: capitalize;
}

EOD;
?>
