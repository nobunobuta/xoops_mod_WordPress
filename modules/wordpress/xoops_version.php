<?php
$modversion['name'] = 'WordPress2';
$modversion['dirname'] = 'wp';
$modversion['description'] = $modversion['name'];
$modversion['version'] = "0.1";
$modversion['credits'] = "";
$modversion['author'] = '<a href="http://xoops-modules.sourceforge.jp/" target="_blank">xoops-modules project</a>';
$modversion['help'] = "help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "logo.gif";

$modversion['tables'] = array(
	"wp2_posts", 
	"wp2_users",
	"wp2_categories",
	"wp2_comments",
	"wp2_links",
	"wp2_linkcategories",
	"wp2_options",
	"wp2_optiontypes",
	"wp2_optionvalues",
	"wp2_optiongroups",
	"wp2_optiongroup_options"
	);


//Admin things
$modversion['hasAdmin'] = 0;
$modversion['hasMain'] = 1;

//if($xoopsUser){
	$modversion['sub'][1]['name'] = 'Blog¤ò½ñ¤¯';
	$modversion['sub'][1]['url'] = "wp-admin/edit.php";
//}

$modversion['templates'][1]['file'] = 'wp_dummy.html';
$modversion['templates'][1]['description'] = '';
//
$modversion['blocks'][1]['file'] = "wp_calendar.php";
$modversion['blocks'][1]['name'] = "WordPress Calendar";
$modversion['blocks'][1]['description'] = "WordPress Calendar";
$modversion['blocks'][1]['show_func'] = "b_wp_calendar_show";

$modversion['blocks'][2]['file'] = "wp_archives_monthly.php";
$modversion['blocks'][2]['name'] = "WordPress Monthly Archives";
$modversion['blocks'][2]['description'] = "WordPress Monthly Archives";
$modversion['blocks'][2]['show_func'] = "b_wp_archives_monthly_show";

$modversion['blocks'][3]['file'] = "wp_categories.php";
$modversion['blocks'][3]['name'] = "WordPress Categories Listing";
$modversion['blocks'][3]['description'] = "WordPress Categories Listing";
$modversion['blocks'][3]['show_func'] = "b_wp_categories_show";

$modversion['blocks'][4]['file'] = "wp_links.php";
$modversion['blocks'][4]['name'] = "WordPress Link Listing";
$modversion['blocks'][4]['description'] = "WordPress Link Listing";
$modversion['blocks'][4]['show_func'] = "b_wp_links_show";

$modversion['blocks'][5]['file'] = "wp_search.php";
$modversion['blocks'][5]['name'] = "WordPress Blog Search";
$modversion['blocks'][5]['description'] = "WordPress Blog Search";
$modversion['blocks'][5]['show_func'] = "b_wp_search_show";

$modversion['blocks'][6]['file'] = "wp_recent_posts.php";
$modversion['blocks'][6]['name'] = "WordPress Recent Posts";
$modversion['blocks'][6]['description'] = "WordPress Recent Posts";
$modversion['blocks'][6]['show_func'] = "b_wp_recent_posts_show";

$modversion['blocks'][7]['file'] = "wp_recent_comments.php";
$modversion['blocks'][7]['name'] = "WordPress Recent Comments";
$modversion['blocks'][7]['description'] = "WordPress Recent Comments";
$modversion['blocks'][7]['show_func'] = "b_wp_recent_comments_show";

$modversion['blocks'][8]['file'] = "wp_contents.php";
$modversion['blocks'][8]['name'] = "WordPress Contents";
$modversion['blocks'][8]['description'] = "WordPress Contents";
$modversion['blocks'][8]['show_func'] = "b_wp_contents_show";
$modversion['blocks'][8]['template'] = "wp_block_contents.html";
?>
