<?php
$modversion['name'] = 'WordPress';
$modversion['dirname'] = 'wordpress';

$modversion['description'] = $modversion['name'];
$modversion['version'] = "0.1";
$modversion['credits'] = "";
$modversion['author'] = '<a href="http://www.kowa.org/" target="_blank">nobunobu</a>';
$modversion['help'] = "help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "logo.gif";
$modversion['onInstall'] = 'xoops_install.php';

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'] = array(
	"wp_posts", 
	"wp_users",
	"wp_categories",
	"wp_comments",
	"wp_links",
	"wp_linkcategories",
	"wp_options",
	"wp_optiontypes",
	"wp_optionvalues",
	"wp_optiongroups",
	"wp_optiongroup_options",
	"wp_post2cat"
	);

//Admin things
$modversion['hasAdmin'] = 0;
$modversion['hasMain'] = 1;
//if($xoopsUser){
	$modversion['sub'][1]['name'] = 'Blog���';
	$modversion['sub'][1]['url'] = "wp-admin/post.php";
//}

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
?>
