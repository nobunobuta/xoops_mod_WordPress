<?php
global $xoopsDB,$xoopsUser,$wpdb, $wp_id, $wp_inblock;
global $wp_once_called,$blog_charset;;
$use_cache = 1; // No reason not to
/* Including config and functions files */
$wp_inblock = 0;
require(dirname(__FILE__).'/wp-config.php');

if ( !empty( $_SERVER['PATH_INFO'] ) ) {
	permlink_to_param();
}

param('m','integer',NO_DEFAULT_PARAM, true);  //Month Param   (YYYY[MM[DD[hh[mm[ss]]]]])
param('year','integer',NO_DEFAULT_PARAM, true);
param('monthnum','integer',NO_DEFAULT_PARAM, true);
param('w','integer',NO_DEFAULT_PARAM, true);  //WeekNum Param
param('day','integer',NO_DEFAULT_PARAM, true);

param('p','string',NO_DEFAULT_PARAM, true);  //PostID Param ("All" for All);
param('name','string',NO_DEFAULT_PARAM, true);  //PostName Param

param('cat','string',NO_DEFAULT_PARAM,true);  // Category ID (Start with "-" means Exclude this.).
param('category_name','string',NO_DEFAULT_PARAM,true);  // Category Name

param('author','string',NO_DEFAULT_PARAM,true);// Author ID (Start with "-" means Exclude this.).
param('author_name','string',NO_DEFAULT_PARAM,true);// Author Name

param('s','html',NO_DEFAULT_PARAM,true);    //Search String
param('exact','integer',0, true);   //Search Exactly matching flag
param('sentence','integer',0,true);   //Search Sentence matching flag

param('poststart','integer',NO_DEFAULT_PARAM,true); // Query Limt Start number
param('postend','integer',NO_DEFAULT_PARAM,true); // Query Limt End number

param('order','string','DESC',true);
param('orderby','string','date',true);

param('page','integer',NO_DEFAULT_PARAM,true);   // Content Page number;
param('paged','integer',NO_DEFAULT_PARAM,true); // Index Page number;

param('c','integer',NO_DEFAULT_PARAM,true);   //With Comment (=1:yes)
param('withcomments','integer',NO_DEFAULT_PARAM,true); //With Comment (=1:yes)
param('preview','integer',NO_DEFAULT_PARAM,true); //Preview Flag
param('debug','integer',NO_DEFAULT_PARAM,true); //Debug Flag
param('more','integer',NO_DEFAULT_PARAM,true); // Display More Content;

/* Getting settings from db */
if (isset($doing_rss) && $doing_rss == 1) {
    $posts_per_page=get_settings('posts_per_rss');
}
if (empty($posts_per_page)) {
    $posts_per_page = get_settings('posts_per_page');
}
$what_to_show = get_settings('what_to_show');
$archive_mode = get_settings('archive_mode');
global $dateformat,$timeformat;
$dateformat = stripslashes(get_settings('date_format'));
$timeformat = stripslashes(get_settings('time_format'));
$time_difference = get_settings('time_difference');
$use_gzipcompression = get_settings('gzipcompression');

/* First let's clear some variables */
$whichcat = '';
$whichauthor = '';
$result = '';
$where = '';
$limits = '';
$distinct = '';
$join = '';
$search = '';

if ($pagenow != 'post.php') { timer_start(); }

if (isset($showposts) && $showposts) {
    $showposts = (int)$showposts;
	$posts_per_page = $showposts;
}

// if a month is specified in the querystring, load that month
if (!empty($m)) {
	$m = "$m";
	$where .= ' AND YEAR(post_date)='.substr($m,0,4);
	if (strlen($m)>5)
		$where .= ' AND MONTH(post_date)='.substr($m,4,2);
	if (strlen($m)>7)
		$where .= ' AND DAYOFMONTH(post_date)='.substr($m,6,2);
	if (strlen($m)>9)
		$where .= ' AND HOUR(post_date)='.substr($m,8,2);
	if (strlen($m)>11)
		$where .= ' AND MINUTE(post_date)='.substr($m,10,2);
	if (strlen($m)>13)
		$where .= ' AND SECOND(post_date)='.substr($m,12,2);

}
if (!empty($year)) {
	$year = "$year";
	$where .= ' AND YEAR(post_date)=' . $year;
}

if (!empty($monthnum)) {
	$monthnum = "$monthnum";
	$where .= ' AND MONTH(post_date)=' . $monthnum;
}

if (!empty($day)) {
	$day = "$day";
	$where .= ' AND DAYOFMONTH(post_date)=' . $day;
}

if (!empty($w)) {
	$w = "$w";
	$where .= ' AND WEEK(post_date)=' . $w;
}

if (!empty($name)) {
	$name = preg_replace('/[^a-z0-9-]/', '', $name);
	$where .= " AND post_name = '$name'";
}

// if a post number is specified, load that post
if (!empty($p) && ($p != 'all')) {
	$p = "".intval($p)."";
	$where = ' AND ID = '.$p;
}

// if a search pattern is specified, load the posts that match
if (!empty($s)) {
	$s = addslashes_gpc($s);
	$search = ' AND (';
	// puts spaces instead of commas
	$s = preg_replace('/, +/', '', $s);
	$s = str_replace(',', ' ', $s);
	$s = str_replace('"', ' ', $s);
	$s = trim($s);
	$s = htmlspecialchars($s);
	if ($exact) {
		$n = '';
	} else {
		$n = '%';
	}
	if (!$sentence) {
		$s_array = explode(' ',$s);
		$search .= '((post_title LIKE \''.$n.$s_array[0].$n.'\') OR (post_content LIKE \''.$n.$s_array[0].$n.'\'))';
		for ( $i = 1; $i < count($s_array); $i = $i + 1) {
			$search .= ' AND ((post_title LIKE \''.$n.$s_array[$i].$n.'\') OR (post_content LIKE \''.$n.$s_array[$i].$n.'\'))';
		}
		$search .= ' OR (post_title LIKE \''.$n.$s.$n.'\') OR (post_content LIKE \''.$n.$s.$n.'\')';
		$search .= ')';
	} else {
		$search = ' AND ((post_title LIKE \''.$n.$s.$n.'\') OR (post_content LIKE \''.$n.$s.$n.'\'))';
	}
}

// category stuff
if (!empty($cat) && ($cat != 'all')) {
	$cat = urldecode($cat);
	$cat = addslashes_gpc($cat);
	if (stristr($cat,'-')) {
		$eq = '!=';
		$andor = 'AND';
		$cat = explode('-',$cat);
		$cat = $cat[1];
	} else {
		$eq = '=';
		$andor = 'OR';
	}
	$join = " LEFT JOIN {$wpdb->post2cat[$wp_id]} ON ({$wpdb->posts[$wp_id]}.ID = {$wpdb->post2cat[$wp_id]}.post_id) ";
	$cat_array = explode(' ',$cat);
    $whichcat .= ' AND (category_id '.$eq.' '.intval($cat_array[0]);
    $whichcat .= get_category_children($cat_array[0], ' '.$andor.' category_id '.$eq.' ');
    for ($i = 1; $i < (count($cat_array)); $i = $i + 1) {
        $whichcat .= ' '.$andor.' category_id '.$eq.' '.intval($cat_array[$i]);
        $whichcat .= get_category_children($cat_array[$i], ' '.$andor.' category_id '.$eq.' ');
   }
	$whichcat .= ')';
    if ($eq == '!=') {
	    $cat = '-'.$cat; //put back the knowledge that we are excluding a category.
    }
}
// Category stuff for nice URIs

if (!empty($category_name)) {
    if (stristr($category_name,'/')) {
        $category_name = explode('/',$category_name);
        if ($category_name[count($category_name)-1]) {
        $category_name = $category_name[count($category_name)-1]; // no trailing slash
        } else {
        $category_name = $category_name[count($category_name)-2]; // there was a trailling slash
        }
    }
	$category_name = preg_replace('|[^a-z0-9-]|', '', $category_name);
	$tables = ", {$wpdb->post2cat[$wp_id]}, {$wpdb->categories[$wp_id]}";
	$join = " LEFT JOIN {$wpdb->post2cat[$wp_id]} ON ({$wpdb->posts[$wp_id]}.ID = {$wpdb->post2cat[$wp_id]}.post_id) LEFT JOIN {$wpdb->categories[$wp_id]} ON ({$wpdb->post2cat[$wp_id]}.category_id = {$wpdb->categories[$wp_id]}.cat_ID) ";
	$whichcat = " AND (category_nicename = '$category_name'";
	$cat = $wpdb->get_var("SELECT cat_ID FROM {$wpdb->categories[$wp_id]} WHERE category_nicename = '$category_name'");
    $whichcat .= get_category_children($cat, " OR category_id = ");
	$whichcat .= " )";
}

// author stuff
if (!empty($author) && ($author != 'all')) {
	$author = ''.urldecode($author).'';
	$author = addslashes_gpc($author);
	if (stristr($author, '-')) {
		$eq = '!=';
		$andor = 'AND';
		$author = explode('-', $author);
		$author = ''.$author[1];
	} else {
		$eq = '=';
		$andor = 'OR';
	}
	$author_array = explode(' ', $author);
	$whichauthor .= ' AND (post_author '.$eq.' '.intval($author_array[0]);
	for ($i = 1; $i < (count($author_array)); $i = $i + 1) {
		$whichauthor .= ' '.$andor.' post_author '.$eq.' '.intval($author_array[$i]);
	}
	$whichauthor .= ')';
}

// Author stuff for nice URIs
if (!empty($author_name)) {
    if (stristr($author_name,'/')) {
        $author_name = explode('/',$author_name);
        if ($author_name[count($author_name)-1]) {
        $author_name = $author_name[count($author_name)-1];#no trailing slash
        } else {
        $author_name = $author_name[count($author_name)-2];#there was a trailling slash
        }
    }
    $author_name = rawurldecode($author_name); // For Japanese Author Name;
    $author = $wpdb->get_var("SELECT ID FROM {$wpdb->users[$wp_id]} WHERE user_login='".$author_name."'");
    $whichauthor .= ' AND (post_author = '.intval($author).')';
}

$where .= $search.$whichcat.$whichauthor;

if ((empty($order)) || ((strtoupper($order) != 'ASC') && (strtoupper($order) != 'DESC'))) {
	$order='DESC';
}

// order by stuff
if (empty($orderby)) {
	$orderby='date '.$order;
} else {
	// used to filter values
	$allowed_keys = array('author','date','category','title');
	$orderby = urldecode($orderby);
	$orderby = addslashes_gpc($orderby);
	$orderby_array = explode(' ',$orderby);
	if (!in_array($orderby_array[0],$allowed_keys)) {
		$orderby_array[0] = 'date';
	}
	$orderby = $orderby_array[0].' '.$order;
	if (count($orderby_array)>1) {
		for ($i = 1; $i < (count($orderby_array)); $i = $i + 1) {
			// Only allow certain values for safety
			if (in_array($orderby_array[$i],$allowed_keys)) {
				$orderby .= ',post_'.$orderby_array[$i].' '.$order;
			}
		}
	}
}

if ((!$whichcat) && empty($m) && empty($p) && empty($w) && empty($s) && empty($poststart) && empty($postend)) {
	if ($what_to_show == 'posts') {
		$limits = ' LIMIT '.$posts_per_page;
	} elseif (($what_to_show == 'days') && empty($monthnum) && empty($year) && empty($day)) {
		$lastpostdate = get_lastpostdate();
		$lastpostdate = mysql2date('Y-m-d 00:00:00',$lastpostdate);
		$lastpostdate = mysql2date('U',$lastpostdate);
		$otherdate = date('Y-m-d H:i:s', ($lastpostdate - (($posts_per_page-1) * 86400)));
		$where .= ' AND post_date > \''.$otherdate.'\'';
	}
}

if ( !empty($postend) && ($postend > $poststart) && empty($m) && empty($monthnum) && empty($year) && empty($day) && empty($w) && (!$whichcat) && empty($s) && empty($p)) {
	if ($what_to_show == 'posts' || (($what_to_show == 'paged') && empty($paged))) {
		$poststart = intval($poststart);
		$postend = intval($postend);
		$limposts = $postend - $poststart;
		$limits = ' LIMIT '.$poststart.','.$limposts;
	} elseif ($what_to_show == 'days') {
		$poststart = intval($poststart);
		$postend = intval($postend);
		$limposts = $postend - $poststart;
		$lastpostdate = get_lastpostdate();
		$lastpostdate = mysql2date('Y-m-d 00:00:00',$lastpostdate);
		$lastpostdate = mysql2date('U',$lastpostdate);
		$startdate = date('Y-m-d H:i:s', ($lastpostdate - (($poststart -1) * 86400)));
		$otherdate = date('Y-m-d H:i:s', ($lastpostdate - (($postend -1) * 86400)));
		$where .= ' AND post_date > \''.$otherdate.'\' AND post_date < \''.$startdate.'\'';
	}
} else {
	if (($what_to_show == 'paged') && empty($p) && empty($more)) {
		if ($pagenow != 'post.php') {
			$pgstrt = '';
			if (isset($paged) && $paged ) {
				$pgstrt = (intval($paged) -1) * $posts_per_page . ', ';
			}
			$limits = 'LIMIT '.$pgstrt.$posts_per_page;
		} else {
			if ((!empty($m)) || (!empty($p)) || (!empty($w)) || (!empty($s)) || ($whichcat)) {
				$limits = '';
			} else {
				$pgstrt = '';
				if ($paged) {
					$pgstrt = (intval($paged) -1) * $posts_per_page . ', ';
				}
				$limits = 'LIMIT '.$pgstrt.$posts_per_page;
			}
		}
	}
	elseif ((!empty($m)) || (!empty($p)) || (!empty($w)) || (!empty($s)) || ($whichcat) || (!empty($author)) || (!empty($monthnum)) || (!empty($year)) || (!empty($day))) {
		$limits = '';
	}
}
if (isset($p) && ($p=='all')) {
	$where = '';
}

$now = date('Y-m-d H:i:s',(time() + ($time_difference * 3600)));

if ($pagenow != 'post.php' && $pagenow != 'edit.php') {
	if ((empty($poststart)) || (empty($postend)) || !($postend > $poststart)) {
		$where .= ' AND post_date <= \''.$now.'\'';
	}

	$distinct = 'DISTINCT';

	if ($use_gzipcompression) {
		// gzipping the output of the script
		gzip_compression();
	}
}
$where .= ' AND (post_status = "publish"';

// Get private posts
if (isset($user_ID) && ('' != intval($user_ID))) {
	$user_ID = intval($user_ID);
    $where .= " OR post_author = $user_ID AND post_status != 'draft')";
} else {
    $where .= ')';
}
$where .= " GROUP BY {$wpdb->posts[$wp_id]}.ID";
$request = " SELECT $distinct * FROM {$wpdb->posts[$wp_id]} $join WHERE 1=1".$where." ORDER BY post_$orderby $limits";


if (!empty($preview)) {
	$request = 'SELECT 1-1'; // dummy mysql query for the preview
	// little funky fix for IEwin, rawk on that code
	$is_winIE = ((preg_match('/MSIE/',$HTTP_USER_AGENT)) && (preg_match('/Win/',$HTTP_USER_AGENT)));
	if (($is_winIE) && (!isset($IEWin_bookmarklet_fix))) {
		$preview_content =  preg_replace('/\%u([0-9A-F]{4,4})/e',  "'&#'.base_convert('\\1',16,10).';'", $preview_content);
	}
}
//error_log("$request");
global $posts;
//echo $request."<br>";
$posts = $wpdb->get_results($request);
// No point in doing all this work if we didn't match any posts.
if ($posts) {
    // Get the categories for all the posts
	$post_id_list = array();
    foreach ($posts as $post) {
    	$post_id_list[] = $post->ID;
    }
    $post_id_list = implode(',', $post_id_list);

    $dogs = $wpdb->get_results("SELECT DISTINCT
        ID, category_id, cat_name, category_nicename, category_description, category_parent
    	FROM {$wpdb->categories[$wp_id]}, {$wpdb->post2cat[$wp_id]}, {$wpdb->posts[$wp_id]}
    	WHERE category_id = cat_ID AND post_id = ID AND post_id IN ($post_id_list)");

    foreach ($dogs as $catt) {
    	$category_cache[$wp_id][$catt->ID][] = $catt;
    }

    // Do the same for comment numbers
	$comment_counts = $wpdb->get_results("SELECT ID, COUNT( comment_ID ) AS ccount
		FROM {$wpdb->posts[$wp_id]}
		LEFT JOIN {$wpdb->comments[$wp_id]} ON ( comment_post_ID = ID  AND comment_approved =  '1')
		WHERE post_status =  'publish' AND ID IN ($post_id_list)
		GROUP BY ID");

	foreach ($comment_counts as $comment_count) {
		$comment_count_cache[$wp_id]["$comment_count->ID"] = $comment_count->ccount;
	}

	// Get post-meta info
	if ( $meta_list = $wpdb->get_results("SELECT post_id, meta_key, meta_value FROM {$wpdb->postmeta[$wp_id]}  WHERE post_id IN($post_id_list) ORDER BY post_id, meta_key", ARRAY_A) ) {
		
		// Change from flat structure to hierarchical:
		$post_meta_cache[$wp_id] = array();
		foreach ($meta_list as $metarow) {
			$mpid = $metarow['post_id'];
			$mkey = $metarow['meta_key'];
			$mval = $metarow['meta_value'];
			
			// Force subkeys to be array type:
			if (!isset($post_meta_cache[$wp_id][$mpid]) || !is_array($post_meta_cache[$wp_id][$mpid]))
				$post_meta_cache[$wp_id][$mpid] = array();
			if (!isset($post_meta_cache[$wp_id][$mpid]["$mkey"]) || !is_array($post_meta_cache[$wp_id][$mpid]["$mkey"]))
				$post_meta_cache[$wp_id][$mpid]["$mkey"] = array();
			
			// Add a value to the current pid/key:
			$post_meta_cache[$wp_id][$mpid][$mkey][] = $mval;
		}
	}

    if (count($posts) == 1) {
		if ((!empty($p)) || (!empty($name))) {
    		$more = 1;
    		$c = 1;
    		$single = 1;
    	}
		if ((!empty($s)) && empty($paged) && !strstr($_SERVER['PHP_SELF'], 'wp-admin/')) { // If they were doing a search and got one result
    		header('Location: ' . get_permalink($posts[0]->ID));
    	}
	}
}
?>