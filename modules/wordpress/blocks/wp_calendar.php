<?php
function b_wp_calendar_show($option)
{
	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	ob_flush();
	ob_start();
	echo <<< EOD
	<style type="text/css" media="screen">
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
			font: normal 12px "ƒqƒ‰ƒMƒmŠpƒS Pro W3", Osaka, Verdana, "‚l‚r ‚oƒSƒVƒbƒN", sans-serif;
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
	</style>
EOD;
	get_calendar(2);
	$block['content'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>
