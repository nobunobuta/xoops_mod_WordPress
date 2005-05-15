<?php
if (!defined('_LANGCODE')) {
	define('_LANGCODE','en');
}
if (file_exists('wp-lang/lang_'._LANGCODE.'.php')) {
	require_once('wp-lang/lang_'._LANGCODE.'.php');
} else {
	require_once('wp-lang/lang_en.php');
}
global $blog_charset;

$GLOBALS['use_cache'] = 1; // No reason not to
/* Including config and functions files */
$GLOBALS['wp_inblock'] = 0;
require(dirname(__FILE__).'/wp-config.php');

if ( !empty( $_SERVER['PATH_INFO'] ) ) {
	permlink_to_param();
}

init_param('', 'm','integer',NO_DEFAULT_PARAM);  //Month Param   (YYYY[MM[DD[hh[mm[ss]]]]])
init_param('', 'year','integer',NO_DEFAULT_PARAM);
init_param('', 'monthnum','integer',NO_DEFAULT_PARAM);
init_param('', 'w','integer',NO_DEFAULT_PARAM);  //WeekNum Param
init_param('', 'day','integer',NO_DEFAULT_PARAM);

init_param('', 'p','string',NO_DEFAULT_PARAM);  //PostID Param ('All' for All);
init_param('', 'name','string',NO_DEFAULT_PARAM);  //PostName Param

init_param('', 'cat','string',NO_DEFAULT_PARAM);  // Category ID (Start with '-' means Exclude this.).
init_param('', 'category_name','string',NO_DEFAULT_PARAM);  // Category Name

init_param('', 'author','string',NO_DEFAULT_PARAM);// Author ID (Start with '-' means Exclude this.).
init_param('', 'author_name','string',NO_DEFAULT_PARAM);// Author Name

init_param('', 's','html',NO_DEFAULT_PARAM);    //Search String
init_param('', 'exact','integer',0);   //Search Exactly matching flag
init_param('', 'sentence','integer',0);   //Search Sentence matching flag

init_param('', 'poststart','integer',0); // Query Limt Start number
init_param('', 'postend','integer',0); // Query Limt End number

init_param('', 'order','string','DESC');
init_param('', 'orderby','string','date');

init_param('', 'page','integer',NO_DEFAULT_PARAM);   // Content Page number;
init_param('', 'paged','integer',NO_DEFAULT_PARAM); // Index Page number;

init_param('', 'c','integer', 0);   //With Comment (=1:yes)
init_param('', 'withcomments','integer', 0); //With Comment (=1:yes)
init_param('', 'preview','integer',NO_DEFAULT_PARAM); //Preview Flag
init_param('', 'debug','integer',NO_DEFAULT_PARAM); //Debug Flag
init_param('', 'more','integer',NO_DEFAULT_PARAM); // Display More Content;
init_param('', 'feed','string',NO_DEFAULT_PARAM);
init_param('', 'tb','integer',NO_DEFAULT_PARAM);

/* Getting settings from db */
if (!empty($GLOBALS['doing_rss'])) {
    $GLOBALS['posts_per_page']=get_settings('posts_per_rss');
}
if (empty($GLOBALS['posts_per_page'])) {
    $GLOBALS['posts_per_page'] = get_settings('posts_per_page');
}
$GLOBALS['what_to_show'] = get_settings('what_to_show');

/* First let's clear some variables */
$_distinct = '';
$_criteria =& new CriteriaCompo();
$_joinCriteria = false;
$_criteria_order = '';
$_criteria_sort = '';
$_criteria_limit = '';
$_criteria_start = '';


if ($GLOBALS['pagenow'] != 'post.php') { timer_start(); }

if (!empty($GLOBALS['showposts'])) {
	$GLOBALS['posts_per_page'] = intval($GLOBALS['showposts']);
}

// if a month is specified in the querystring, load that month
if (test_param('m')) {
	$GLOBALS['m'] = ''.get_param('m');
	$_criteria->add(new Criteria('YEAR(post_date)', substr($GLOBALS['m'],0,4)));
	if (strlen($GLOBALS['m'])>5)
		$_criteria->add(new Criteria('MONTH(post_date)', substr($GLOBALS['m'],4,2)));
	if (strlen($GLOBALS['m'])>7)
		$_criteria->add(new Criteria('DAYOFMONTH(post_date)', substr($GLOBALS['m'],6,2)));
	if (strlen($GLOBALS['m'])>9)
		$_criteria->add(new Criteria('HOUR(post_date)', substr($GLOBALS['m'],8,2)));
	if (strlen($GLOBALS['m'])>11)
		$_criteria->add(new Criteria('MINUTE(post_date)', substr($GLOBALS['m'],10,2)));
	if (strlen($GLOBALS['m'])>13)
		$_criteria->add(new Criteria('SECOND(post_date)', substr($GLOBALS['m'],12,2)));
}
if (test_param('year')) {
	$GLOBALS['year'] = ''.get_param('year');
	$_criteria->add(new Criteria('YEAR(post_date)', $GLOBALS['year']));
}
if (test_param('monthnum')) {
	$GLOBALS['monthnum'] = ''.get_param('monthnum');
	$_criteria->add(new Criteria('MONTH(post_date)', $GLOBALS['monthnum']));
}
if (test_param('day')) {
	$GLOBALS['day'] = ''.get_param('day');
	$_criteria->add(new Criteria('DAYOFMONTH(post_date)', $GLOBALS['day']));
}
if (test_param('w')) {
	$GLOBALS['w'] = ''.get_param('w');
	$_criteria->add(new Criteria('WEEK(post_date)', $GLOBALS['w']));
}
if (test_param('name')) {
	$GLOBALS['name'] = get_param('name');
	$_criteria->add(new Criteria('post_name', $GLOBALS['name']));
}
if (test_param('p') && (get_param('p') != 'all')) {
	$GLOBALS['p'] = intval(get_param('p'));
	unset($_criteria);
	$_criteria =& new CriteriaCompo(new Criteria('ID', $GLOBALS['p']));
}
// if a search pattern is specified, load the posts that match
if (test_param('s')) {
	$GLOBALS['s'] = addslashes_gpc(get_param('s'));

	// puts spaces instead of commas
	$GLOBALS['s'] = preg_replace('/, +/', ' ', $GLOBALS['s']);
	$GLOBALS['s'] = str_replace(array(',', '"'), array(' ', ' '), $GLOBALS['s']);
	$GLOBALS['s'] = htmlspecialchars(trim($GLOBALS['s']));
	if (get_param('exact')) {
		$_n = '';
	} else {
		$_n = '%';
	}
	$_searchCriteria =& new CriteriaCompo();
	if (!get_param('sentence')) {
		$GLOBALS['s_array'] = explode(' ',$GLOBALS['s']);
		for ( $_i = 0; $_i < count($GLOBALS['s_array']); $_i++) {
			$_wCriteria =& new CriteriaCompo(new Criteria('post_title', $_n.$GLOBALS['s_array'][$_i].$_n, 'like'));
			$_wCriteria->add(new Criteria('post_content', $_n.$GLOBALS['s_array'][$_i].$_n, 'like'),'OR');
			$_searchCriteria->add($_wCriteria, 'AND');
			unset($_wCriteria);
		}
		if (count($GLOBALS['s_array']) > 1) {
			$_wCriteria =& new CriteriaCompo(new Criteria('post_title', $_n.$GLOBALS['s'].$_n, 'like'));
			$_wCriteria->add(new Criteria('post_content', $_n.$GLOBALS['s'].$_n, 'like'),'OR');
			$_searchCriteria->add($_wCriteria, 'OR');
			unset($_wCriteria);
		}
	} else {
		$_wCriteria =& new CriteriaCompo(new Criteria('post_title', $_n.$GLOBALS['s'].$_n, 'like'));
		$_wCriteria->add(new Criteria('post_content', $_n.$GLOBALS['s'].$_n, 'like'),'OR');
		$_searchCriteria->add($_wCriteria);
		unset($_wCriteria);
	}
	$_criteria->add($_searchCriteria);
	unset($_searchCriteria);
}
// category stuff
if (test_param('cat') && (get_param('cat') != 'all')) {
	$GLOBALS['cat'] = addslashes_gpc(urldecode(get_param('cat')));
	if (stristr($GLOBALS['cat'], '-')) {
		$_eq = '!=';
		$_andor = 'AND';
		$GLOBALS['cat'] = explode('-', $GLOBALS['cat']);
		$GLOBALS['cat'] = $GLOBALS['cat'][1];
	} else {
		$_eq = '=';
		$_andor = 'OR';
	}
	$_joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'ID', 'post_id');
	$_wCriteria =& new CriteriaCompo();
	$_cat_array = explode(' ', $GLOBALS['cat']);
    for ($_i = 0; $_i < (count($_cat_array)); $_i++) {
		$_wCriteria->add(new Criteria('category_id', intval($_cat_array[$_i]), $_eq), $_andor);
		$_catc = trim(get_category_children($_cat_array[$_i], '', ' '));
		if ($_catc!=="") {
			$_catc_array = explode(' ',$_catc);
		    for ($_j = 0; $_j < (count($_catc_array)); $_j++) {
				$_wCriteria->add(new Criteria('category_id', intval($_catc_array[$_j]), $_eq), $_andor);
		    }
		}
	}
	$_criteria->add($_wCriteria);
	unset($_wCriteria);
}

// Category stuff for nice URIs
if (test_param('category_name')) {
    if (stristr(get_param('category_name'),'/')) {
        $GLOBALS['category_name'] = explode('/',get_param('category_name'));
        if ($GLOBALS['category_name'][count($GLOBALS['category_name'])-1]) {
        	$GLOBALS['category_name'] = $GLOBALS['category_name'][count($GLOBALS['category_name'])-1]; // no trailing slash
        } else {
        	$GLOBALS['category_name'] = $GLOBALS['category_name'][count($GLOBALS['category_name'])-2]; // there was a trailling slash
        }
    }
	$GLOBALS['category_name'] = preg_replace('|[^a-z0-9-]|', '', $GLOBALS['category_name']);
	$_joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'ID', 'post_id');
	$_joinCriteria->cascade(new XoopsJoinCriteria(wp_table('categories'), 'category_id', 'cat_ID'));
	$_wCriteria =& new CriteriaCompo(new Criteria('category_nicename', $GLOBALS['category_name']));
	$categoryHandler =& wp_handler('Category');
	$categoryObject =& $categoryHandler->getByNiceName($GLOBALS['category_name']);
	$GLOBALS['cat'] = $categoryObject->getVar('cat_ID');
	$_catc = trim(get_category_children($GLOBALS['cat'], '', ' '));
	$_catc_array = explode(' ',$_catc);
    for ($_i = 0; $_i < (count($_catc_array)); $_i++) {
		$_wCriteria->add(new Criteria('category_id', intval($_catc_array[$_i])),'OR');
    }
	$_criteria->add($_wCriteria);
	unset($_wCriteria);
}

// author stuff
if (test_param('author') && (get_param('author') != 'all')) {
	$GLOBALS['author'] = ''.urldecode(get_param('author')).'';
	$GLOBALS['author'] = addslashes_gpc($GLOBALS['author']);
	if (stristr($GLOBALS['author'], '-')) {
		$_eq = '!=';
		$_andor = 'AND';
		$GLOBALS['author'] = explode('-', $GLOBALS['author']);
		$GLOBALS['author'] = ''.$GLOBALS['author'][1];
	} else {
		$_eq = '=';
		$_andor = 'OR';
	}
	$_wCriteria =& new CriteriaCompo();
	$_author_array = explode(' ', $GLOBALS['author']);
	for ($_i = 0; $_i < (count($_author_array)); $_i++) {
		$_wCriteria->add(new Criteria('post_author', intval($_author_array[$_i]), $_eq), $_andor);
	}
	$_criteria->add($_wCriteria);
	unset($_wCriteria);
}
// Author stuff for nice URIs
if (test_param('author_name')) {
	$GLOBALS['author_name'] = rawurldecode(get_param('author_name'));
    if (stristr($GLOBALS['author_name'],'/')) {
        $GLOBALS['author_name'] = explode('/',$GLOBALS['author_name']);
        if ($GLOBALS['author_name'][count($GLOBALS['author_name'])-1]) {
	        $GLOBALS['author_name'] = $GLOBALS['author_name'][count($GLOBALS['author_name'])-1];#no trailing slash
        } else {
    	    $GLOBALS['author_name'] = $GLOBALS['author_name'][count($GLOBALS['author_name'])-2];#there was a trailling slash
        }
    }
	$_criteria->add(new Criteria('post_author', get_userid($GLOBALS['author_name'])));
}

if (test_param('order')) {
	$_order = get_param('order');
 	if ((strtoupper($_order) != 'ASC') && (strtoupper($_order) != 'DESC')) {
		$_criteria_order = 'DESC';
	} else {
		$_criteria_order = $_order;
	}
}

// order by stuff
if (!test_param('orderby')) {
	$_criteria_sort = 'post_date';
} else {
	// used to filter values
	$_allowed_keys = array('author','date','category','title');
	$_orderby_list = explode(' ', addslashes_gpc(urldecode(get_param('orderby'))));
	if (!in_array($_orderby_list[0], $_allowed_keys)) {
		$_orderby_array[] = 'post_date';
	}
	for ($_i = 0; $_i < (count($_orderby_list)); $_i++) {
		// Only allow certain values for safety
		if (in_array($_orderby_list[$_i], $_allowed_keys)) {
			$_orderby_array[] = 'post_'.$_orderby_list[$_i];
		}
	}
	$_criteria_sort = $_orderby_array;
}

if (!test_param('cat') && !test_param('category_name') && !test_param('m') && !test_param('p') && !test_param('w') && !test_param('s') && !test_param('poststart') && !test_param('postend')) {
	if ($GLOBALS['what_to_show'] == 'posts') {
		$_criteria_limit = $GLOBALS['posts_per_page'];
	} elseif ($GLOBALS['what_to_show'] == 'days' && !test_param('monthnum') && !test_param('year') && !test_param('day')) {
		$_lastpostdate = mysql2date('Y-m-d 00:00:00', get_lastpostdate());
		$_lastpostdate = mysql2date('U',$_lastpostdate);
		$_otherdate = date('Y-m-d H:i:s', ($_lastpostdate - (($GLOBALS['posts_per_page']-1) * 86400)));
		$_criteria->add(new Criteria('post_date', $_otherdate, '>'));
	}
}

if (test_param('postend') && (get_param('postend') > get_param('poststart')) && !test_param('m') && !test_param('monthnum') && !test_param('year') && !test_param('day') && !test_param('w') && !test_param('cat') && !test_param('category_name') && !test_param('s') && !test_param('p')) {
	if ($GLOBALS['what_to_show'] == 'posts' || ($GLOBALS['what_to_show'] == 'paged' && !test_param('paged'))) {
		$_poststart = intval(get_param('poststart'));
		$_postend = intval(get_param('postend'));
		$_criteria_limit = $_postend - $_poststart;
		$_criteria_start = $_poststart;
	} elseif ($GLOBALS['what_to_show'] == 'days') {
		$_poststart = intval(get_param('poststart'));
		$_postend = intval(get_param('postend'));
		$_limposts = $_postend - $_poststart;
		$_lastpostdate = mysql2date('Y-m-d 00:00:00', get_lastpostdate());
		$_lastpostdate = mysql2date('U',$_lastpostdate);
		$_startdate = date('Y-m-d H:i:s', ($_lastpostdate - (($_poststart -1) * 86400)));
		$_otherdate = date('Y-m-d H:i:s', ($_lastpostdate - (($_postend -1) * 86400)));
		$_criteria->add(new Criteria('post_date', $_startdate, '<'));
		$_criteria->add(new Criteria('post_date', $_otherdate, '>'));
	}
} else {
	if (($GLOBALS['what_to_show'] == 'paged') && !test_param('p') && !test_param('more')) {
		if ($GLOBALS['pagenow'] != 'post.php') {
			if (test_param('paged')) {
				$_criteria_start = (intval(get_param('paged')) -1) * $GLOBALS['posts_per_page'];
			}
			$_criteria_limit = $GLOBALS['posts_per_page'];
		} else {
			if (test_param('m') || test_param('p') || test_param('w') || test_param('s') || test_param('cat') || test_param('category_name')) {
			} else {
				if (test_param('paged')) {
					$_criteria_start = (intval(get_param('paged')) -1) * $GLOBALS['posts_per_page'];
				}
				$_criteria_limit = $GLOBALS['posts_per_page'];
			}
		}
	}
}
if (isset($GLOBALS['p']) && ($GLOBALS['p']=='all')) {
	unset($_criteria);
	$_criteria =& new CriteriaCompo();
}

if ($GLOBALS['pagenow'] != 'post.php' && $GLOBALS['pagenow'] != 'edit.php') {
	if (!test_param('poststart') || !test_param('postend') || !(get_param('postend') > get_param('poststart'))) {
		$_criteria->add(new Criteria('post_date', current_time('mysql'), '<='));
	}
	$_distinct = 'DISTINCT';
}
$_wCriteria = new CriteriaCompo(new Criteria('post_status', 'publish'));
// Get private posts
if (!empty($GLOBALS['user_ID'])) {
	$_wCriteria->add(new Criteria('post_author', intval($GLOBALS['user_ID'])), 'OR');
	$_wCriteria->add(new Criteria('post_status', 'draft', '!='), 'AND');
}
$_criteria->add($_wCriteria);
unset($_wCriteria);

$_criteria->setGroupBy(wp_table('posts').'.ID');

if ($_criteria_sort) $_criteria->setSort($_criteria_sort);
if ($_criteria_order) $_criteria->setOrder($_criteria_order);

$GLOBALS['current_posts_criteria'] = $_criteria;
$GLOBALS['current_posts_join'] =& $_joinCriteria;
$GLOBALS['current_posts_distinct'] = $_distinct;

if ($_criteria_limit) $_criteria->setLimit($_criteria_limit);
if ($_criteria_start) $_criteria->setStart($_criteria_start);

$postHandler =& wp_handler('Post');
$postObjects =& $postHandler->getObjects($_criteria, false, '', $_distinct, $_joinCriteria);

$GLOBALS['request'] = $postHandler->getLastSQL();
//echo $GLOBALS['request'].'<br>';

if (!empty($preview)) {
	$GLOBALS['request'] = 'SELECT 1-1'; // dummy mysql query for the preview
	// little funky fix for IEwin, rawk on that code
	$is_winIE = ((preg_match('/MSIE/',$HTTP_USER_AGENT)) && (preg_match('/Win/',$HTTP_USER_AGENT)));
	if (($is_winIE) && (!isset($IEWin_bookmarklet_fix))) {
		$preview_content =  preg_replace('/\%u([0-9A-F]{4,4})/e',  "'&#'.base_convert('\\1',16,10).';'", $preview_content);
	}
}
$GLOBALS['posts'] = array();
foreach ($postObjects as $postObject) {
	$GLOBALS['posts'][] =& $postObject->exportWpObject();
}
// No point in doing all this work if we didn't match any posts.
if ($GLOBALS['posts']) {
	if (count($GLOBALS['posts']) == 1) {
		if (!empty($GLOBALS['p']) || !empty($GLOBALS['name'])) {
			$GLOBALS['more'] = 1;
			$GLOBALS['c'] = 1;
			$GLOBALS['single'] = 1;
		}
//		if (!empty($s) && empty($paged) && !strstr($_SERVER['PHP_SELF'], 'wp-admin/')) { // If they were doing a search and got one result
		if (empty($GLOBALS['p']) && empty($paged) && preg_match('#/modules/'.wp_mod().'(/|/index.php)?$#',$_SERVER['PHP_SELF'])) { // If they were doing a search and got one result
			header('Location: ' . get_permalink($GLOBALS['posts'][0]->ID));
		}
	}
    // Get the categories for all the posts
	$_post_id_list = array();
    foreach ($GLOBALS['posts'] as $post) {
    	$_post_id_list[] = $post->ID;
		$GLOBALS['category_cache'][wp_id()][$post->ID] = array();
    }
    $_post_id_list = implode(',', $_post_id_list);
	$_post_id_criteria =& new Criteria('post_id', '('.$_post_id_list.')', 'IN');
	$_joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'ID', 'post_id');
	$_joinCriteria->cascade(new XoopsJoinCriteria(wp_table('categories'), 'category_id', 'cat_ID'));
	$postObjects =& $postHandler->getObjects($_post_id_criteria, false,
							'ID, category_id, cat_name, category_nicename, category_description, category_parent',
							true, $_joinCriteria);
    foreach ($postObjects as $postObject) {
    	$_cat->ID = $postObject->getVar('ID');
    	$_cat->category_id = $postObject->getExtraVar('category_id');
    	$_cat->cat_name = $postObject->getExtraVar('cat_name');
    	$_cat->category_nicename = $postObject->getExtraVar('category_nicename');
    	$_cat->category_description = $postObject->getExtraVar('category_description');
    	$_cat->category_parent = $postObject->getExtraVar('category_parent');
    	$GLOBALS['category_cache'][wp_id()][$postObject->getVar('ID')][] =& $_cat;
    	unset($_cat);
    }
    // Do the same for comment numbers
    $_criteria =&new CriteriaCompo(new Criteria('post_status', 'publish'));
    $_criteria->add(new Criteria('comment_approved', '1 '));
    $_criteria->add($_post_id_criteria);
    $_criteria->setGroupBy('ID');
	$_joinCriteria =& new XoopsJoinCriteria(wp_table('comments'), 'ID', 'comment_post_ID');
    $postObjects =&$postHandler->getObjects($_criteria, false, 'ID, COUNT( comment_ID ) AS ccount', false, $_joinCriteria);
	foreach ($postObjects as $postObject) {
		$GLOBALS['comment_count_cache'][wp_id()][''.$postObject->getVar('ID')] = $postObject->getExtraVar('ccount');
	}

	// Get post-meta info
	if ( $meta_list = $GLOBALS['wpdb']->get_results('SELECT post_id, meta_key, meta_value FROM '.wp_table('postmeta').' WHERE post_id IN('.$_post_id_list.') ORDER BY post_id, meta_key', ARRAY_A) ) {
		
		// Change from flat structure to hierarchical:
		$GLOBALS['post_meta_cache'][wp_id()] = array();
		foreach ($meta_list as $metarow) {
			$mpid = $metarow['post_id'];
			$mkey = $metarow['meta_key'];
			$mval = $metarow['meta_value'];
			
			// Force subkeys to be array type:
			if (!isset($GLOBALS['post_meta_cache'][wp_id()][$mpid]) || !is_array($GLOBALS['post_meta_cache'][wp_id()][$mpid])) {
				$GLOBALS['post_meta_cache'][wp_id()][$mpid] = array();
			}
			if (!isset($GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"]) || !is_array($GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"])) {
				$GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"] = array();
			}
			// Add a value to the current pid/key:
			$GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"][] = $mval;
		}
	}

}
if (preg_match('#/modules/'.wp_mod().'(/|/index.php)?$#',$_SERVER['PHP_SELF'])) {
	//redirect feed and trackback
	if (test_param('feed')) {
		require_once('wp-feed.php');
		exit();
	} else if (test_param('tb')) {
	    $trackback_filename = get_settings('trackback_filename') ? get_settings('trackback_filename') : 'wp-trackback.php';
		require_once($trackback_filename);
		exit();
	}
}

?>