<?php
/* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }
/* Don't remove this line */ $wp_block_style = <<<EOD
/* ÈþÆý */
#wpBlockContent$wp_num {
	padding-left: 5px;
	padding-right: 5px;
}

#wpBlockContent$wp_num h2 {
	font-size : 16px;
	font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;;
	border-bottom: 1px solid #dcdcdc;
	margin-bottom: 5px;
}

#wpBlockContent$wp_num h3 {
	font-size : 14px;
	font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
	margin-bottom: 5px;
}

#wpBlockContent$wp_num a {
	color: #9B9FAE;
}

#wpBlockContent$wp_num a img {
	border: none;
}

#wpBlockContent$wp_num a:visited {
	color: #9B9FAE;
}

#wpBlockContent$wp_num a:hover {
	color: #7AA0CF;
}

#wpBlockContent$wp_num .storytitle {
	margin: 0;
}

#wpBlockContent$wp_num .storytitle a {
	text-decoration: none;
}

#wpBlockContent$wp_num .meta {
	font-size: 0.9em;
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
	font: 95% "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
}

#wpBlockContent$wp_num div.storycontent {
	clear:right;
}

#wpBlockContent$wp_num .feedback {
	color: #ccc;
	text-align: right;
}

#wpBlockContent$wp_num p,#wpBlockContent$wp_num  li,#wpBlockContent$wp_num .feedback {
	font: 95%/175% "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
}

#wpBlockContent$wp_num blockquote {
	border-left: 5px solid #ccc;
	margin-left: 1.5em;
	padding-left: 5px;
}

EOD;
/* Don't remove this line */ if (!defined("WP_BLOCK_CSS_READ")) { define("WP_BLOCK_CSS_READ","1");$wp_block_style .= <<<EOD

#wpRecentPost {
	font-size: 90%;
	word-break: break-all;
}
#wpRecentPost #postDate {
	font-weight: bold;
	font-size:110%;
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
	font: normal 12px "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
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
/* Don't remove this line */ }
?>
