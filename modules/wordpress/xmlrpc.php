<?php
# fix for mozBlog and other cases where '<?xml' isn't on the very first line
$HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];
$HTTP_RAW_POST_DATA = trim($HTTP_RAW_POST_DATA);

if (file_exists(dirname(__FILE__).'/xoops_version.php')) {
	require_once(dirname(__FILE__) . '/wp-config.php');
} else {
	if (file_exists(dirname(dirname(__FILE__)). '/xoops_version.php')) {
		require_once(dirname(dirname(__FILE__)) . '/wp-config.php');
	}
}
$xmlrpc_filename = get_settings('xmlrpc_filename') ? get_settings('xmlrpc_filename') : 'xmlrpc.php';
if (wp_base().'/'.$xmlrpc_filename != __FILE__ ) {
	@header('HTTP/1.x 404 Not Found');
	echo ("404 Not Found");
	exit();
}

include('wp-config.php');

require_once(wp_base().'/wp-includes/class-xmlrpc.php');
require_once(wp_base().'/wp-includes/class-xmlrpcs.php');
require_once(wp_base().'/wp-includes/template-functions.php');
require_once(wp_base().'/wp-includes/functions.php');
require_once(wp_base().'/wp-includes/vars.php');
error_reporting(E_ERROR);

#Temporally fix for kousagi
init_param('GET', 'kousagi', 'integer', '');

$use_cache = 1;
$post_autobr = 0;
$post_default_title = ''; // posts submitted via the xmlrpc interface get that title
$GLOBALS['post_default_category'] = 1; // posts submitted via the xmlrpc interface go into that category

function logIO($io,$msg) {
	if ($GLOBALS['wp_debug']) {
		$fp = fopen('./log/xmlrpc.log','a+');
		$date = date('Y-m-d H:i:s ');
		$iot = ($io == 'I') ? ' Input: ' : ' Output: ';
		fwrite($fp, "\n\n".$date.$iot.$msg);
		fclose($fp);
	}
	return true;
}

function starify($string) {
	$i = strlen($string);
	return str_repeat('*', $i);
}

logIO('I',$HTTP_RAW_POST_DATA);

function miniHTMLtoWiki($str) {
	logIO('O','miniHTMLtoWiki(IN) : ' .$str);
	$wsp = mb_conv('¡¡', $GLOBALS['blog_charset'], 'EUC-JP');
	$str = str_replace(array('&lt;','&gt;','&quot;','&amp;'),array('<','>','"','&'),$str);
	$str = preg_replace('/<a href=\\"(.*?)\\".*?>(.*?)<\/a>/', '[[$2:$1]]', $str);
	$str = preg_replace('/[\n\r]+/',"~\n".$wsp, $str);
	$str = preg_replace('/<br \/>/',"~\n".$wsp, $str);
	$str = preg_replace('/'.$wsp.'?<blockquote>~*\n*/i',">\n", $str);
	$str = preg_replace('/\n*'.$wsp.'?<\/blockquote>~*/i', "\n<\n", $str);
	$str = preg_replace('/^([^'.$wsp.'><])/', $wsp.'$1', $str);
	logIO('O','miniHTMLtoWiki(OUT) : ' .$str);
	return $str;
}

/**** DB Functions ****/
/*
 * These really should be moved into wp-includes/functions.php,
 * and re-used throughout the code, where possible. -- emc3
 */

/*
 * generic function for inserting data into the posts table.
 */
function wp_insert_post($postarr = array()) {
	$postHandler =& wp_handler('Post');
	$postObject =& $postHandler->create();
	if (!empty($postarr['post_content'])) {
		// Charset Encoding
		$post_content = mb_conv($postarr['post_content'], $GLOBALS['blog_charset'], 'auto');
		//Simple HTML to PukiWiki Format(for kousagi only)
		if (get_param('kousagi') == 2) {
			$post_content = miniHTMLtoWiki($post_content);
		}
		$postObject->setVar('post_content', $post_content, true);
	}
	if (!empty($postarr['post_excerpt'])) {
		$post_excerpt = mb_conv($postarr['post_excerpt'], $GLOBALS['blog_charset'], 'auto');
		//Simple HTML to PukiWiki Format(for kousagi only)
		if (get_param('kousagi') == 2) {
			$post_excerpt = miniHTMLtoWiki($post_excerpt);
		}
		$postObject->setVar('post_excerpt', $post_excerpt, true);
	}
	if (!empty($postarr['post_title'])) {
		$post_title = mb_conv($postarr['post_title'], $GLOBALS['blog_charset'], 'auto');
		$postObject->setVar('post_title', $post_title, true);

		$post_name = sanitize_title($post_title);
		$postObject->setVar('post_name', $post_name, true);
	}
	if (!empty($postarr['post_category'])) {
		// Make sure we set a valid category
		$post_category = $postarr['post_category'];
		if (count($post_category) == 0	|| !is_array($post_category)) {
			$post_category = array($GLOBALS['post_default_category']);
		}
		$postObject->setVar('post_category', $post_category[0], true);
	} else {
		$post_category = array($GLOBALS['post_default_category']);
	}
	if (!empty($postarr['post_date'])) {
		$postObject->setVar('post_date', $postarr['post_date'], true);
	} else {
		$postObject->setVar('post_date', current_time('mysql'), true);
	}
	if (!empty($postarr['post_author'])) {
		$postObject->setVar('post_author', $postarr['post_author'], true);
	}
	if (!empty($postarr['post_status'])) {
		$postObject->setVar('post_status', $postarr['post_status'], true);
	} else {
		$postObject->setVar('post_status', get_settings('default_post_status'), true);
	}
	if (!empty($postarr['ping_status'])) {
		$postObject->setVar('ping_status', $postarr['ping_status'], true);
	} else {
		$postObject->setVar('ping_status', get_settings('default_ping_status'), true);
	}
	if (!empty($postarr['comment_status'])) {
		$postObject->setVar('comment_status', $postarr['comment_status'], true);
	} else {
		$postObject->setVar('comment_status', get_settings('default_comment_status'), true);
	}
	if ($postHandler->insert($postObject, true)) {
		$post_ID = $postObject->getVar('ID');
		$postObject->assignCategories($post_category, true);
		do_action('publish_post', $post_ID);
		return $post_ID;
	} else {
		return 0;
	}
}

function wp_get_single_post($post_ID = 0, $mode = OBJECT) {
	$postHandler =& wp_handler('Post');
	if ($postObject =& $postHandler->get($post_ID)) {
	    if ($mode == OBJECT) {
		    $result =& $postObject->exportWpObject();
	    } else {
		    $result =& $postObject->getVarArray();
	    }
	    // Set categories
	    $result['post_category'] = wp_get_post_cats('',$post_ID);
	    return $result;
	} else {
		return false;
	}
}

function wp_get_recent_posts($num = 10) {
	$postHandler =& wp_handler('Post');
	$criteria =& new Criteria(1,1);
	$criteria->setSort('post_date');
	$criteria->setOrder('DESC');
	if ($num) {
		$criteria->setLimit($num);
	}
	$postObjects =& $postHandler->getObjects($criteria);
	$result = array();
	foreach($postObjects as $postObject) {
		$result[] = $postObject->getVarArray();
	}
	return $result?$result:array();
}

function wp_update_post($postarr = array()) {
	$postHandler =& wp_handler('Post');
	if ($postObject =& $postHandler->get($postarr['ID'])) {
	if (!empty($postarr['post_content'])) {
		// Charset Encoding
		$post_content = mb_conv($postarr['post_content'], $GLOBALS['blog_charset'], 'auto');
		//Simple HTML to PukiWiki Format(for kousagi only)
		if (get_param('kousagi') == 2) {
			$post_content = miniHTMLtoWiki($post_content);
		}
			$postObject->setVar('post_content', $post_content, true);
	}
	if (!empty($postarr['post_excerpt'])) {
		$post_excerpt = mb_conv($postarr['post_excerpt'], $GLOBALS['blog_charset'], 'auto');
		//Simple HTML to PukiWiki Format(for kousagi only)
		if (get_param('kousagi') == 2) {
			$post_excerpt = miniHTMLtoWiki($post_excerpt);
		}
			$postObject->setVar('post_excerpt', $post_excerpt, true);
	}
	if (!empty($postarr['post_title'])) {
		$post_title = mb_conv($postarr['post_title'], $GLOBALS['blog_charset'], 'auto');
			$postObject->setVar('post_title', $post_title, true);

		$post_name = sanitize_title($post_title);
		if ($post_name == '') {
			$post_name = 'post-'.$ID;
		}
			$postObject->setVar('post_name', $post_name, true);
	}
	if (!empty($postarr['post_category'])) {
		// Make sure we set a valid category
		$post_category = $postarr['post_category'];
		if (count($post_category) == 0	|| !is_array($post_category)) {
			$post_category = array($GLOBALS['post_default_category']);
		}
			$postObject->setVar('post_category', $post_category[0], true);
	} else {
		$post_category = array($GLOBALS['post_default_category']);
	}
	if (!empty($postarr['post_status'])) {
			$postObject->setVar('post_status', $postarr['post_status'], true);
	} else {
			$postObject->setVar('post_status', get_settings('default_post_status'), true);
	}
	if (!empty($postarr['ping_status'])) {
			$postObject->setVar('ping_status', $postarr['ping_status'], true);
	} else {
			$postObject->setVar('ping_status', get_settings('default_ping_status'), true);
	} 
	if (!empty($postarr['comment_status'])) {
			$postObject->setVar('comment_status', $postarr['comment_status'], true);
	} else {
			$postObject->setVar('comment_status', get_settings('default_comment_status'), true);
	}
	if (!empty($postarr['comment_status'])) {
			$postObject->setVar('comment_status', $postarr['comment_status'], true);
	}
	if ($postHandler->insert($postObject, true, true)) {
		$post_ID = $postObject->getVar('ID');
		$postObject->assignCategories($post_category, true);
		do_action('publish_post', $post_ID);
		return $post_ID;
	} else {
		return 0;
	}
	} else {
		return 0;
	}
}

function wp_get_post_cats($blogid = '1', $post_ID = 0) {
	$postHandler =& wp_handler('Post');
	if ($postObject =& $postHandler->get($post_ID)) {
	    $categoryObjects =& $postObject->getCategories();
	    $result = array();
	    foreach($categoryObjects as $categoryObject) {
		    $result[] = $categoryObject->getVar('category_id');
	    }
	    return array_unique($result);
	} else {
		return array();
	}
}

function wp_set_post_cats($blogid = '1', $post_ID = 0, $post_categories = array()) {
	// If $post_categories isn't already an array, make it one:
	if (!is_array($post_categories)) {
		if (!$post_categories) {
			$post_categories = 1;
		}
		$post_categories = array($post_categories);
	}
	$post_categories = array_unique($post_categories);
	$postHandler =& wp_handler('Post');
	if ($postObject =& $postHandler->get($post_ID)) {
		$postObject->assignCategories($post_categories, true);
	}
}

function wp_delete_post($post_ID = 0) {
	$postHandler =& wp_handler('Post');
	if ($postObject =& $postHandler->get($post_ID)) {
		$result = $postHandler->delete($postObject, true);
		return $result;
	} else {
		return false;
	}
}

/**** /DB Functions ****/

/**** Misc ****/

// get permalink from post ID
function post_permalink($post_ID=0, $mode = 'id') {
	return get_permalink($post_ID);
}

// Get the name of a category from its ID
function get_cat_name($cat_id) {
	return get_the_category_by_ID($cat_id);
}

// Get the ID of a category from its name
function get_cat_ID($cat_name='General') {
	global $wpdb;
	
	$cid = $wpdb->get_var("SELECT cat_ID FROM ".wp_table('categories')." WHERE cat_name='$cat_name'");

	return $cid?$cid:1;	// default to cat 1
}

if (!function_exists('get_author_name')) {
// Get author's preferred display name
	function get_author_name($auth_id, $idmode='') {
		$authordata = get_userdata($auth_id);
		if (empty($idmode)) {
			$idmode = $authordata->user_idmode;
		}
		switch($idmode) {
			case 'nickname':
				$authorname = $authordata->user_nickname;
				break;

			case 'login':
				$authorname = $authordata->user_login;
				break;
	
			case 'firstname':
				$authorname = $authordata->user_firstname;
				break;

			case 'lastname':
				$authorname = $authordata->user_lastname;
				break;

			case 'namefl':
				$authorname = $authordata->user_firstname.' '.$authordata->user_lastname;
				break;

			case 'namelf':
				$authorname = $authordata->user_lastname.' '.$authordata->user_firstname;
				break;

		default:
				$authorname = $authordata->user_nickname;
				break;
		}
		return $authorname;
	}
}

// get extended entry info (<!--more-->)
function get_extended($post) {
	list($main,$extended) = explode('<!--more-->',$post);

	// Strip leading and trailing whitespace
	$main = preg_replace('/^[\s]*(.*)[\s]*$/','\\1',$main);
	$extended = preg_replace('/^[\s]*(.*)[\s]*$/','\\1',$extended);

	return array('main' => $main, 'extended' => $extended);
}

// do trackbacks for a list of urls
// borrowed from edit.php
// accepts a comma-separated list of trackback urls and a post id
function trackback_url_list($tb_list, $post_id) {
	if (!empty($tb_list)) {
		// get post data
		$postdata = wp_get_single_post($post_id, ARRAY_A);
		
		// form an excerpt
		$excerpt = strip_tags($postdata['post_excerpt'] ? $postdata['post_excerpt'] :$postdata['post_content']);
		
		if (strlen($excerpt) > 255) {
			$excerpt = substr($excerpt,0,252) . '...';
		}
				
		$trackback_urls = explode(',', $tb_list);
		foreach($trackback_urls as $tb_url) {
			$tb_url = trim($tb_url);
			trackback($tb_url, stripslashes($postdata['post_title']), $excerpt, $post_id);
		}
	}
}

/**** /Misc ****/

/**** B2 API ****/
# note: the b2 API currently consists of the Blogger API,
#		plus the following methods:
#
# b2.newPost , b2.getCategories

# Note: the b2 API will be replaced by the standard Weblogs.API once the specs are defined.

### b2.newPost ###
$wpnewpost_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcBoolean, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$wpnewpost_doc='Adds a post, blogger-api like, +title +category +postdate';

function b2newpost($m) {
	$username=$m->getParam(2);
	$password=$m->getParam(3);
	$content=$m->getParam(4);
	$title=$m->getParam(6);
	$category=$m->getParam(7);
	$postdate=$m->getParam(8);

	$username = $username->scalarval();
	$password = $password->scalarval();
	$content = $content->scalarval();
	$title = $title->scalarval();
	$category = $category->scalarval();
	$postdate = $postdate->scalarval();

	if (user_pass_ok($username,$password)) {
		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
		   'Sorry, level 0 users can not post');
		}
		$postarr['post_author'] = $userdata->ID;
		$postarr['post_content'] = format_to_post($content);
		$postarr['post_title'] = $title;
		if ($postdate != '') {
			$postarr['post_date'] = $postdate;
		} else {
			$postarr['post_date'] = current_time('mysql');
		}
		if ($category) {
			$postarr['post_category'] = array($category);
		}

		$post_ID = wp_insert_post($postarr);
		if (!$post_ID) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
					'For some strange yet very annoying reason, your entry could not be posted.');
		}

		if (!isset($GLOBALS['blog_ID'])) {
			$GLOBALS['blog_ID'] = 1;
		}
		pingWeblogs($GLOBALS['blog_ID']);
		pingback($postarr['post_content'], $post_ID);

		return new xmlrpcresp(new xmlrpcval("$post_ID"));
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
			'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### b2.getCategories ###
$wpgetcategories_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$wpgetcategories_doc='given a blogID, gives a struct that list categories in that blog, using categoryID and categoryName. categoryName is there so the user would choose a category name from the client, rather than just a number. however, when using b2.newPost, only the category ID number should be sent.';

function b2getcategories($m) {
	$blog_ID=$m->getParam(0);
	$username=$m->getParam(1);
	$password=$m->getParam(2);

	$blog_ID = $blogid->scalarval();
	$username = $username->scalarval();
	$password = $password->scalarval();

	if (user_pass_ok($username,$password)) {
		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
		   'Sorry, level 0 users can not post');
		}
		$categoryHandler =& wp_handler('Category');
		$criteria =& new Criteria(1,1);
		$criteria->setSort('cat_ID');
		$criteria->setOrder('ACS');
		$categoryObjects =& $categoryHandler->getObjects($criteria);
		if (!$categoryObjects) die('Error getting data');
		$i = 0;
		foreach ($categoryObjects as $categoryObject) {
			$struct[$i++] = 
				new xmlrpcval(
					array(
						'categoryID' => new xmlrpcval($categoryObject->getVar('cat_ID')),
						'categoryName' => new xmlrpcval(mb_conv($categoryObject->getVar('cat_name'),'UTF-8',$GLOBALS['blog_charset']))
					),
					'struct');
		}

		$data = array($struct[0]);
		for ($j=1; $j<$i; $j++) {
			array_push($data, $struct[$j]);
		}
		$resp = new xmlrpcval($data, 'array');
		return new xmlrpcresp($resp);
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### b2.getPostURL ###
$wp_getPostURL_sig = array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$wp_getPostURL_doc = 'Given a blog ID, username, password, and a post ID, returns the URL to that post.';

function b2_getPostURL($m) {
	global $wpdb;

	$blog_ID  = $m->getParam(0);
	$username = $m->getParam(2);
	$password = $m->getParam(3);
	$post_ID  = $m->getParam(4);

	$blog_ID  = $blogid->scalarval();
	$username = $username->scalarval();
	$password = $password->scalarval();
	$post_ID  = intval($post_ID->scalarval());

	if (user_pass_ok($username,$password)) {
		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
		   'Sorry, users whose level is zero, can not use this method.');
		}

		$blog_URL = wp_siteurl().'/index.php';
		$postdata = get_postdata($post_ID);
		if (!($postdata===false)) {
			$title = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $postdata['Title']);
			// this code is blatantly derived from permalink_link()
			$archive_mode = get_settings('archive_mode');
			switch($archive_mode) {
				case 'daily':
					$post_URL = $blog_URL.'&m='.substr($postdata['Date'],0,4).substr($postdata['Date'],5,2).substr($postdata['Date'],8,2).'#'.$title;
					break;
				case 'monthly':
					$post_URL = $blog_URL.'&m='.substr($postdata['Date'],0,4).substr($postdata['Date'],5,2).'#'.$title;
					break;
				case 'weekly':
					if((!isset($cacheweekly)) || (empty($cacheweekly[$postdata['Date']]))) {
						$sql = "SELECT WEEK('".$postdata['Date']."') as wk";
			$row = $wpdb->get_row($sql);
						$cacheweekly[$postdata['Date']] = $row->wk;
					}
					$post_URL = $blog_URL.'&m='.substr($postdata['Date'],0,4).'&amp;w='.$cacheweekly[$postdata['Date']].'#'.$title;
					break;
				case 'postbypost':
					$post_URL = $blog_URL.'?p='.$post_ID;
					break;
			}
		} else {
			$err = 'This post ID ('.$post_ID.') does not correspond to any post here.';
		}

		if ($err) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser'], $err);
		} else {
			return new xmlrpcresp(new xmlrpcval($post_URL));;
		}
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}
/**** /B2 API ****/

/**** Blogger API ****/

# as described on http://plant.blogger.com/api and in various messages in http://groups.yahoo.com/group/bloggerDev/
#
# another list of these methods is there http://www.tswoam.co.uk/blogger_method_listing.html
# so you won't have to browse the eGroup to find all the methods
#
# special note: Evan please keep _your_ API page up to date :p

### blogger.newPost ###
$bloggernewpost_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcBoolean));
$bloggernewpost_doc='Adds a post, blogger-api like';

function bloggernewpost($m) {
	$blog_ID  = $m->getParam(1);
	$username = $m->getParam(2);
	$password = $m->getParam(3);
	$content  = $m->getParam(4);
	$publish  = $m->getParam(5);

	$blog_ID  = $blogid->scalarval();
	$username = $username->scalarval();
	$password = $password->scalarval();
	$content  = $content->scalarval();

	// publish flag sets post status appropriately
	$postarr['post_status'] = $publish->scalarval() ? 'publish' : 'draft';
	
	if (user_pass_ok($username,$password)) {

		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
			'Sorry, level 0 users can not post');
		}
		$postarr['post_author'] = $userdata->ID;
		$postarr['post_title'] = xmlrpc_getposttitle($content);
		$postarr['post_category'] = array(xmlrpc_getpostcategory($content));
		$postarr['post_content'] = format_to_post(xmlrpc_removepostdata($content));
		$postarr['post_date'] = current_time('mysql');

		$post_ID = wp_insert_post($postarr);
		if (!$post_ID) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			'For some strange yet very annoying reason, your entry could not be posted.');
		}

		if (!isset($GLOBALS['blog_ID'])) {
			$GLOBALS['blog_ID'] = 1;
		}
		pingWeblogs($GLOBALS['blog_ID']);
		pingback($postarr['post_content'], $post_ID);

		logIO('O',"Posted ! ID: $post_ID");
		return new xmlrpcresp(new xmlrpcval("$post_ID"));

	} else {
		logIO('O',"Wrong username/password combination <b>$username / $password</b>");
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.editPost ###
$bloggereditpost_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcBoolean));$bloggereditpost_doc='Edits a post, blogger-api like';

function bloggereditpost($m) {
	$ID=$m->getParam(1);
	$username=$m->getParam(2);
	$password=$m->getParam(3);
	$newcontent=$m->getParam(4);
	$publish=$m->getParam(5);

	$ID = intval($ID->scalarval());
	$username = $username->scalarval();
	$password = $password->scalarval();
	$newcontent = $newcontent->scalarval();
	$postarr['post_status'] = $publish->scalarval() ? 'publish' : 'draft';

	if (user_pass_ok($username,$password)) {
		$postdata = wp_get_single_post($ID,ARRAY_A);
		if (!$postdata)
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			"No such post '$ID'.");

		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
			'Sorry, level 0 users can not edit posts');
		}
		if (($userdata->ID != $postdata['post_author']) && ($userdata->user_level !=10)) {
			$authordata = get_userdata($postdata['post_author']);
			if ($userdata->user_level <= $authordata->user_level) {
				return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
				'Sorry, you do not have the right to edit this post');
			}
		}

		$postarr['ID'] = $ID;
		$postarr['post_title'] = xmlrpc_getposttitle($newcontent);
		$postarr['post_category'] = array(xmlrpc_getpostcategory($newcontent));
		$postarr['post_content'] = format_to_post(xmlrpc_removepostdata($newcontent));

		$post_ID = wp_update_post($postarr);
		if (!$post_ID) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			'For some strange yet very annoying reason, the entry could not be edited.');
		}

		if (!isset($GLOBALS['blog_ID'])) {
			$GLOBALS['blog_ID'] = 1;
		}
		pingWeblogs($GLOBALS['blog_ID']);

		return new xmlrpcresp(new xmlrpcval('1', 'boolean'));
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.deletePost ###
$bloggerdeletepost_sig=array(array($xmlrpcBoolean, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcBoolean));
$bloggerdeletepost_doc='Deletes a post, blogger-api like';

function bloggerdeletepost($m) {
	$ID=$m->getParam(1);
	$username=$m->getParam(2);
	$password=$m->getParam(3);
	$newcontent=$m->getParam(4);

	$ID = intval($ID->scalarval());
	$username = $username->scalarval();
	$password = $password->scalarval();
	$newcontent = $newcontent->scalarval();

	if (user_pass_ok($username,$password)) {
		$postdata = wp_get_single_post($ID,ARRAY_A);
		if (!$postdata)
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			"No such post '$ID'.");

		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
			'Sorry, level 0 users can not delete posts');
		}
		if (($userdata->ID != $postdata['post_author']) && ($userdata->user_level !=10)) {
			$authordata = get_userdata($postdata['post_author']);
			if ($userdata->user_level <= $authordata->user_level) {
				return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
				'Sorry, you do not have the right to delete this post');
			}
		}

		$result = wp_delete_post($ID);
		if (!$result) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			'For some strange yet very annoying reason, the entry could not be deleted.');
		}
		return new xmlrpcresp(new xmlrpcval(1,'boolean'));
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.getUsersBlogs ###
$bloggergetusersblogs_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$bloggergetusersblogs_doc='returns the user\'s blogs - this is a dummy function, just so that BlogBuddy and other blogs-retrieving apps work';

function bloggergetusersblogs($m) {
	$username = $m->getParam(1);
	$password=$m->getParam(2);

	$username = $username->scalarval();
	$password = $password->scalarval();

	if (user_pass_ok($username,$password)) {
		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
			'Sorry, level 0 users do not have any editable blog');
		}
		$is_admin = ($userdata->user_level > 3) ? true : false;

		$struct = new xmlrpcval(
					array(
						'isAdmin' => new xmlrpcval($is_admin,'boolean'),
						'url' => new xmlrpcval(wp_siteurl().'/index.php'),
						'blogid' => new xmlrpcval('1'),
						'blogName' => new xmlrpcval(mb_conv(get_settings('blogname'),'UTF-8',$GLOBALS['blog_charset']))
					),
					'struct'
				);
		$resp = new xmlrpcval(array($struct), 'array');
		return new xmlrpcresp($resp);
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.getUserInfo ###
$bloggergetuserinfo_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$bloggergetuserinfo_doc='gives the info about a user';

function bloggergetuserinfo($m) {
	$username=$m->getParam(1);
	$password=$m->getParam(2);

	$username = $username->scalarval();
	$password = $password->scalarval();

	if (user_pass_ok($username,$password)) {
		$userdata = get_userdatabylogin($username);
		$struct = new xmlrpcval(
					array(
						'nickname' => mb_conv(new xmlrpcval($userdata->user_nickname),'UTF-8',$GLOBALS['blog_charset']),
						'userid' => new xmlrpcval($userdata->ID),
						'url' => new xmlrpcval($userdata->user_url),
						'email' => new xmlrpcval($userdata->user_email),
						'lastname' => mb_conv(new xmlrpcval($userdata->user_lastname),'UTF-8',$GLOBALS['blog_charset']),
						'firstname' => mb_conv(new xmlrpcval($userdata->user_firstname),'UTF-8',$GLOBALS['blog_charset'])
					),
					'struct'
				);
		$resp = $struct;
		return new xmlrpcresp($resp);

	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.getPost ###
$bloggergetpost_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$bloggergetpost_doc='fetches a post, blogger-api like';

function bloggergetpost($m) {
	$post_ID=$m->getParam(1);
	$username=$m->getParam(2);
	$password=$m->getParam(3);

	$post_ID = $post_ID->scalarval();
	$username = $username->scalarval();
	$password = $password->scalarval();

	if (user_pass_ok($username,$password)) {
		$postdata = get_postdata($post_ID);
		if ($postdata['Date'] != '') {
			// Don't convert to GMT
			//$post_date = mysql2date('U', $postdata['Date']);
			$post_date = strtotime($postdata['Date']);
			$post_date = date('Ymd', $post_date).'T'.date('H:i:s', $post_date);

			$content  = '<title>'.mb_conv(stripslashes($postdata['Title']),'UTF-8',$GLOBALS['blog_charset']).'</title>';
			$content .= '<category>'.$postdata['Category'].'</category>';
			$content .= mb_conv(stripslashes($postdata['Content']),'UTF-8',$GLOBALS['blog_charset']);

			$struct = new xmlrpcval(array('userid' => new xmlrpcval($postdata['Author_ID']),
										  'dateCreated' => new xmlrpcval($post_date,'dateTime.iso8601'),
										  'content' => new xmlrpcval($content),
										  'postid' => new xmlrpcval($postdata['ID'])
										  ),'struct');

			$resp = $struct;
			return new xmlrpcresp($resp);
		} else {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 4
			"No such post #$post_ID");
		}
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
		'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.getRecentPosts ###
$bloggergetrecentposts_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcInt));
$bloggergetrecentposts_doc='fetches X most recent posts, blogger-api like';

function bloggergetrecentposts($m) {
	global $wpdb;
	error_reporting(0);

	$blog_ID  = $m->getParam(1);
	$username = $m->getParam(2);
	$password = $m->getParam(3);
	$numposts = $m->getParam(4);

	$blog_ID  = $blog_ID->scalarval();
	$username = $username->scalarval();
	$password = $password->scalarval();
	$numposts = $numposts->scalarval();

	if ($numposts > 0) {
		$limit = " LIMIT $numposts";
	} else {
		$limit = '';
	}

	if (user_pass_ok($username,$password)) {

		$sql = "SELECT * FROM ".wp_table('posts')." ORDER BY post_date DESC".$limit;
		$result = $wpdb->get_results($sql);
		if (!$result) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			'For some strange yet very annoying reason, the entries could not be fetched.');
		}
		$data = new xmlrpcval('','array');

		$i = 0;
		foreach ($result as $row) {
			$postdata = array(
				'ID' => $row->ID,
				'Author_ID' => $row->post_author,
				'Date' => $row->post_date,
				'Content' => $row->post_content,
				'Title' => ($row->post_title ? $row->post_title : ' '),
				'Category' => $row->post_category
			);

			// Don't convert to GMT
			//$post_date = mysql2date('U', $postdata['Date']);
			$post_date = strtotime($postdata['Date']);
			$post_date = date('Ymd', $post_date).'T'.date('H:i:s', $post_date);

			$content  = '<title>'.mb_conv(stripslashes($postdata['Title']),'UTF-8',$GLOBALS['blog_charset']).'</title>';
			$content .= '<category>'.mb_conv(get_cat_name($postdata['Category']),'UTF-8',$GLOBALS['blog_charset']).'</category>';
			$content .= mb_conv(stripslashes($postdata['Content']),'UTF-8',$GLOBALS['blog_charset']);

			$category = new xmlrpcval($postdata['Category']);

			$authorname = get_author_name($postdata['Author_ID']);

			$struct[$i] = new xmlrpcval(array('authorName' => new xmlrpcval(mb_conv($authorname,'UTF-8',$GLOBALS['blog_charset'])),
										'userid' => new xmlrpcval($postdata['Author_ID']),
										'dateCreated' => new xmlrpcval($post_date,'dateTime.iso8601'),
										'content' => new xmlrpcval($content),
										'postid' => new xmlrpcval($postdata['ID']),
										'category' => $category
										),'struct');
			$i = $i + 1;
		}

		$data = array($struct[0]);
		for ($j=1; $j<$i; $j++) {
			array_push($data, $struct[$j]);
		}

		$resp = new xmlrpcval($data, 'array');

		return new xmlrpcresp($resp);

	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}


### blogger.getTemplate ###
$bloggergettemplate_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$bloggergettemplate_doc='returns the default template file\'s code';

function bloggergettemplate($m) {
	error_reporting(0);
	$username=$m->getParam(2);
	$password=$m->getParam(3);
	$templateType=$m->getParam(4);

	$username = $username->scalarval();
	$password = $password->scalarval();
	$templateType = $templateType->scalarval();

	$blogid = 1;	// we do not need this yet

	$userdata = get_userdatabylogin($username);

	if ($userdata->user_level < 3) {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
	   'Sorry, users whose level is less than 3, can not edit the template.');
	}

	if (user_pass_ok($username,$password)) {

	if ($templateType == 'main') {
		$file = 'index.php';
	} elseif ($templateType == 'archiveIndex') {
		$file = 'index.php';
	}

	$f = fopen($file,'r');
	$content = fread($f,filesize($file));
	fclose($file);

	$content = str_replace("\n","\r\n",$content);

	return new xmlrpcresp(new xmlrpcval("$content"));

	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

### blogger.setTemplate ###
$bloggersettemplate_sig=array(array($xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$bloggersettemplate_doc='saves the default template file\'s code';

function bloggersettemplate($m) {
	error_reporting(0);

	$blogid = 1;	// we do not need this yet

	$username=$m->getParam(2);
	$password=$m->getParam(3);
	$template=$m->getParam(4);
	$templateType=$m->getParam(5);

	$username = $username->scalarval();
	$password = $password->scalarval();
	$template = $template->scalarval();
	$templateType = $templateType->scalarval();

	$userdata = get_userdatabylogin($username);

	if ($userdata->user_level < 3) {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
	   'Sorry, users whose level is less than 3, can not edit the template.');
	}

	if (user_pass_ok($username,$password)) {

	if ($templateType == 'main') {
		$file = 'index.php';
	} elseif ($templateType == 'archiveIndex') {
		$file = 'index.php';
	}

	$f = fopen($file,'w+');
	fwrite($f, $template);
	fclose($file);

	return new xmlrpcresp(new xmlrpcval('1', 'boolean'));

	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

/**** /Blogger API ****/

/**** metaWeblog API ****/
/**********************
 *
 * metaWeblog API extensions
 * added by 
 *	Dougal Campbell <dougal@gunters.org> 
 *	http://dougal.gunters.org/
 *
 **********************/
#Temporally fix for kousagi
if (test_param(kousagi)) {
	$mwnewpost_sig =  array(array($xmlrpcString,$xmlrpcInt,$xmlrpcString,$xmlrpcString,$xmlrpcStruct,$xmlrpcBoolean));
} else {
	$mwnewpost_sig =  array(array($xmlrpcString,$xmlrpcString,$xmlrpcString,$xmlrpcString,$xmlrpcStruct,$xmlrpcBoolean));
}

$mwnewpost_doc = 'Add a post, MetaWeblog API-style';

function mwnewpost($params) {
	global $blog_ID;

	$xblogid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	$xcontent = $params->getParam(3);
	$xpublish = $params->getParam(4);
	
	$blogid = $xblogid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();
	$contentstruct = php_xmlrpc_decode($xcontent);
	$postarr['post_status'] = $xpublish->scalarval() ? 'publish' : 'draft';

	// Check login
	if (user_pass_ok($username,$password)) {
		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1,
			  'Sorry, level 0 users cannot post');
		}

		$postarr['post_author'] = $userdata->ID;
		if (array_key_exists('title',$contentstruct)) {
			$postarr['post_title'] = $contentstruct['title'];
			logIO('O',$contentstruct['title']);
		}
		if (array_key_exists('description',$contentstruct)) {
			$postarr['post_content'] = format_to_post($contentstruct['description']);
			logIO('O',$contentstruct['description']);
		}
		if (array_key_exists('mt_excerpt',$contentstruct)) {
			$postarr['post_excerpt'] = $contentstruct['mt_excerpt'];
		}
		if (array_key_exists('mt_text_more',$contentstruct)) {
			if (trim(format_to_post($contentstruct['mt_text_more']))) {
			$postarr['post_content'] .= "\n<!--more-->\n" . format_to_post($contentstruct['mt_text_more']);
			}
		}
		
		if (array_key_exists('mt_allow_comments',$contentstruct)) {
			$postarr['comment_status'] = $contentstruct['mt_allow_comments']? 'open' : 'closed';
		}
		if (array_key_exists('mt_allow_pings',$contentstruct)) {
			$postarr['ping_status'] = $contentstruct['mt_allow_pings'] ? 'open' : 'closed';
		}
		if (!empty($contentstruct['dateCreated'])) {
			$dateCreated = preg_split('/([+\-Z])/',$contentstruct['dateCreated'],-1,PREG_SPLIT_DELIM_CAPTURE);
			if(count($dateCreated) == 3) {
				$dateCreated[2] = str_replace(':','',$dateCreated[2]);
			}
			if ($dateCreated[1] == '+') {
				$dateoffset = intval($dateCreated[2])*36;
			} else if ($dateCreated[1] == '-') {
				$dateoffset = -intval($dateCreated[2])*36;
			} else {
				$dateoffset = 0;
			}
			$dateCreated = iso8601_decode($dateCreated[0],1)- $dateoffset + (get_settings('time_difference') * 3600);
		} else {
			$dateCreated = current_time('timestamp');
		}
		$postarr['post_date'] = date('Y-m-d H:i:s', $dateCreated);
		$postarr['post_category'] = array();
		if (array_key_exists('categories',$contentstruct)&&is_array($contentstruct['categories'])) {
			foreach ($contentstruct['categories'] as $cat) {
				$postarr['post_category'][] = get_cat_ID(mb_conv($cat),'EUC-JP','auto');
			}
		} else {
			$postarr['post_category'][] = $GLOBALS['post_default_category'];
		}
		
		$post_ID = wp_insert_post($postarr);
		if (!$post_ID) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2,
			'For some strange yet very annoying reason, your entry could not be posted.');
		}

		if (empty($GLOBALS['blog_ID'])) {
			$GLOBALS['blog_ID'] = 1;
		}
		pingWeblogs($GLOBALS['blog_ID']);
		pingback($postarr['post_content'], $post_ID);
		if (array_key_exists('mt_tb_ping_urls',$contentstruct)) {
			trackback_url_list($content_struct['mt_tb_ping_urls'],$post_ID);
		}

		logIO('O',"(MW) Posted ! ID: $post_ID");
		$myResp = new xmlrpcval($post_ID,'string');
		return new xmlrpcresp($myResp);

	} else {
		logIO('O',"(MW) Wrong username/password combination <b>$username / $password</b>");
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mweditpost_sig =  array(array($xmlrpcBoolean,$xmlrpcString,$xmlrpcString,$xmlrpcString,$xmlrpcStruct,$xmlrpcBoolean));
$mweditpost_doc = 'Edit a post, MetaWeblog API-style';

function mweditpost ($params) {	// ($postid, $user, $pass, $content, $publish) 
	$xpostid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	$xcontent = $params->getParam(3);
	$xpublish = $params->getParam(4);
	
	$ID = intval($xpostid->scalarval());
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();
	$contentstruct = php_xmlrpc_decode($xcontent);
	$postarr['post_status'] = $xpublish->scalarval() ? 'publish' : 'draft';

	// Check login
	if (user_pass_ok($username,$password)) {
		$postdata = wp_get_single_post($ID,ARRAY_A);
		if (!$postdata) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, // user error 2
			"No such post '$ID'.");
		}
		$userdata = get_userdatabylogin($username);
		if ($userdata->user_level < 1) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
			'Sorry, level 0 users can not edit posts');
		}
		if (($userdata->ID != $postdata['post_author']) && ($userdata->user_level !=10)) {
			$authordata = get_userdata($postdata['post_author']);
			if ($userdata->user_level <= $authordata->user_level) {
				return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+1, // user error 1
				'Sorry, you do not have the right to edit this post');
			}
		}

		$postarr['ID'] = $ID;
		if (array_key_exists('title',$contentstruct)) {
			$postarr['post_title'] = $contentstruct['title'];
			logIO('O',$contentstruct['title']);
		}
		if (array_key_exists('description',$contentstruct)) {
			$postarr['post_content'] = format_to_post($contentstruct['description']);
			logIO('O',$contentstruct['description']);
		}
		if (array_key_exists('mt_excerpt',$contentstruct)) {
			$postarr['post_excerpt'] = $contentstruct['mt_excerpt'];
		}
		if (array_key_exists('mt_text_more',$contentstruct)) {
			if (trim(format_to_post($contentstruct['mt_text_more']))) {
			$postarr['post_content'] .= "\n<!--more-->\n" . format_to_post($contentstruct['mt_text_more']);
			}
		}
		if (array_key_exists('mt_allow_comments',$contentstruct)) {
			$postarr['comment_status'] = $contentstruct['mt_allow_comments']? 'open' : 'closed';
		}
		if (array_key_exists('mt_allow_pings',$contentstruct)) {
			$postarr['ping_status'] = $contentstruct['mt_allow_pings'] ? 'open' : 'closed';
		}
		if (!empty($contentstruct['dateCreated'])) {
			$dateCreated = preg_split('/([+\-Z])/',$contentstruct['dateCreated'],-1,PREG_SPLIT_DELIM_CAPTURE);
			if(count($dateCreated) == 3) {
				$dateCreated[2] = str_replace(':','',$dateCreated[2]);
			}
			if ($dateCreated[1] == '+') {
				$dateoffset = intval($dateCreated[2])*36;
			} else if ($dateCreated[1] == '-') {
				$dateoffset = -intval($dateCreated[2])*36;
			} else {
				$dateoffset = 0;
			}
			$dateCreated = iso8601_decode($dateCreated[0],1)- $dateoffset + (get_settings('time_difference') * 3600);
		} else {
			$dateCreated = current_time('timestamp');
		}
		$postarr['post_date'] = date('Y-m-d H:i:s', $dateCreated);
		$postarr['post_category'] = array();
		if (array_key_exists('categories',$contentstruct)&&is_array($contentstruct['categories'])) {
			foreach ($contentstruct['categories'] as $cat) {
				$postarr['post_category'][] = get_cat_ID(mb_conv($cat),'EUC-JP','auto');
			}
		} else {
			$postarr['post_category'][] = $GLOBALS['post_default_category'];
		}

		$post_ID = wp_update_post($postarr);
		if (!$post_ID) {
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2,
			'For some strange yet very annoying reason, your entry could not be posted.');
		}

		if (empty($GLOBALS['blog_ID'])) {
			$GLOBALS['blog_ID'] = 1;
		}
		pingWeblogs($GLOBALS['blog_ID']);
		pingback($postarr['post_content'], $post_ID);
		if (array_key_exists('mt_tb_ping_urls',$contentstruct)) {
			trackback_url_list($content_struct['mt_tb_ping_urls'],$post_ID);
		}

		logIO('O',"(MW) Edited ! ID: $post_ID");
		$myResp = new xmlrpcval(true,'boolean');

		return new xmlrpcresp($myResp);

	} else {
		logIO('O',"(MW) Wrong username/password combination <b>$username / $password</b>");
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mwgetpost_sig =  array(array($xmlrpcStruct,$xmlrpcString,$xmlrpcString,$xmlrpcString));
$mwgetpost_doc = 'Get a post, MetaWeblog API-style';

function mwgetpost ($params) {	// ($postid, $user, $pass) 
	$xpostid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	
	$post_ID = $xpostid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();

	// Check login
	if (user_pass_ok($username,$password)) {
		$postdata = get_postdata($post_ID);

		if ($postdata['Date'] != '') {

			// why were we converting to GMT here? spec doesn't call for that.
			//$post_date = mysql2date('U', $postdata['Date']);
			//$post_date = gmdate('Ymd', $post_date).'T'.gmdate('H:i:s', $post_date);
			$post_date = strtotime($postdata['Date']);
			$post_date = date('Ymd', $post_date).'T'.date('H:i:s', $post_date);
			
			$catids = wp_get_post_cats('1',$post_ID);
			logIO('O','CateGory No:'.count($catids));	
			foreach($catids as $catid) {
				$catname = get_cat_name($catid);
				logIO('O','CateGory:'.$catname);
				$catnameenc = new xmlrpcval(mb_conv($catname,'UTF-8',$GLOBALS['blog_charset']));
				$catlist[] = $catnameenc;
			}			
			$post = get_extended($postdata['Content']);
			$allow_comments = ('open' == $postdata['comment_status'])?1:0;
			$allow_pings = ('open' == $postdata['ping_status'])?1:0;

			$resp = array(
				'link' => new xmlrpcval(post_permalink($post_ID)),
				'title' => new xmlrpcval(mb_conv($postdata['Title'],'UTF-8',$GLOBALS['blog_charset'])),
				'description' => new xmlrpcval(mb_conv($post['main'],'UTF-8',$GLOBALS['blog_charset'])),
				'dateCreated' => new xmlrpcval($post_date,'dateTime.iso8601'),
				'userid' => new xmlrpcval($postdata['Author_ID']),
				'postid' => new xmlrpcval($postdata['ID']),
				'content' => new xmlrpcval(mb_conv($postdata['Content'],'UTF-8',$GLOBALS['blog_charset'])),
				'permalink' => new xmlrpcval(post_permalink($post_ID)),
				'categories' => new xmlrpcval($catlist,'array'),
				'mt_excerpt' => new xmlrpcval(mb_conv($postdata['Excerpt'],'UTF-8',$GLOBALS['blog_charset'])),
				'mt_allow_comments' => new xmlrpcval($allow_comments,'int'),
				'mt_allow_pings' => new xmlrpcval($allow_pings,'int'),
				'mt_text_more' => new xmlrpcval(mb_conv($post['extended'],'UTF-8',$GLOBALS['blog_charset'])),
			);
			
			$resp = new xmlrpcval($resp,'struct');
			
			return new xmlrpcresp($resp);
		} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 4
			"No such post #$post_ID");
		}
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}

}

$mwrecentposts_sig =  array(array($xmlrpcArray,$xmlrpcString,$xmlrpcString,$xmlrpcString,$xmlrpcInt));
$mwrecentposts_doc = 'Get recent posts, MetaWeblog API-style';

function mwrecentposts ($params) {	// ($blogid, $user, $pass, $num) 
	$xblogid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	$xnum = $params->getParam(3);
	
	$blogid = $xblogid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();
	$num = $xnum->scalarval();

	// Check login
	if (user_pass_ok($username,$password)) {

		$postlist = wp_get_recent_posts($num);
		
		// Build response packet. We can't just use xmlrpc_encode,
		// because of the dateCreated field, which must be a date type.
		
		// Encode each entry of the array.
		foreach($postlist as $entry) {
			$mdate = strtotime($entry['post_date']);
			$isoString = date('Ymd',$mdate).'T'.date('H:i:s',$mdate);
			$date = new xmlrpcval($isoString,'dateTime.iso8601');
			$userid = new xmlrpcval($entry['post_author']);
			$content = new xmlrpcval(stripslashes($entry['post_content']));
			$excerpt = new xmlrpcval(mb_conv(stripslashes($entry['post_excerpt']),'UTF-8',$GLOBALS['blog_charset']));
			
			$pcat = stripslashes(get_cat_name($entry['post_category']));
			
			// For multiple cats, we might do something like
			// this in the future:
			//$catstruct['description'] = $pcat;
			//$catstruct['categoryId'] = $entry['post_category'];
			//$catstruct['categoryName'] = $pcat;
			//$catstruct['isPrimary'] = TRUE;
			
			//$catstruct2 = xmlrpc_encode($catstruct);
			
			$categories = new xmlrpcval(array(new xmlrpcval($pcat)),'array');

			$post = get_extended(mb_conv(stripslashes($entry['post_content']),'UTF-8',$GLOBALS['blog_charset']));

			$postid = new xmlrpcval($entry['ID']);
			$entry['post_title'] = $entry['post_title'] ? $entry['post_title'] : ' ';
			$title = new xmlrpcval(mb_conv($entry['post_title'],'UTF-8',$GLOBALS['blog_charset']));
			$description = new xmlrpcval($post['main']);
			$link = new xmlrpcval(post_permalink($entry['ID']));
			$permalink = $link;
			$extended = new xmlrpcval($post['extended']);

			$allow_comments = new xmlrpcval((('open' == $entry['comment_status'])?1:0),'int');
			$allow_pings = new xmlrpcval((('open' == $entry['ping_status'])?1:0),'int');

			$encode_arr = array(
				'dateCreated' => $date,
				'userid' => $userid,
				'postid' => $postid,
				'categories' => $categories,
				'title' => $title,
				'description' => $description,
				'link' => $link,
				'permalink' => $permalink,
				'mt_excerpt' => $excerpt,
				'mt_allow_comments' => $allow_comments,
				'mt_allow_pings' => $allow_pings,
				'mt_text_more' => $extended
			);
			
			$xmlrpcpostarr[] = new xmlrpcval($encode_arr,'struct');
		}	

		// Now convert that to an xmlrpc array type
		$myResp = new xmlrpcval($xmlrpcpostarr,'array');

		return new xmlrpcresp($myResp);
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mwgetcats_sig =  array(array($xmlrpcArray,$xmlrpcString,$xmlrpcString,$xmlrpcString));
$mwgetcats_doc = 'Get a post, MetaWeblog API-style';

function mwgetcats ($params) {	// ($blogid, $user, $pass) 
	global $wpdb;
	
	$blog_URL = wp_siteurl() . '/index.php';
//	logIO('O',$blog_URL);
	if ($cats = $wpdb->get_results("SELECT cat_ID,cat_name FROM ".wp_table('categories'), ARRAY_A)) {
		foreach ($cats as $cat) {
			$struct['categoryId'] = $cat['cat_ID'];
			$struct['description'] = mb_conv($cat['cat_name'],'UTF-8',$GLOBALS['blog_charset']);
			$struct['categoryName'] = mb_conv($cat['cat_name'],'UTF-8',$GLOBALS['blog_charset']);
			$struct['htmlUrl'] = htmlspecialchars($blog_URL . '?cat='. $cat['cat_ID']);
			$struct['rssUrl'] = ''; // will probably hack alexking's stuff in here
			
			$arr[] = php_xmlrpc_encode($struct);
		}
	}
	
	$resp = new xmlrpcval($arr,'array');

	return new xmlrpcresp($resp);
}


$mwnewmedia_sig =  array(array($xmlrpcStruct,$xmlrpcString,$xmlrpcString,$xmlrpcString,$xmlrpcStruct));
$mwnewmedia_doc = 'Upload image or other binary data, MetaWeblog API-style (unimplemented)';

/* metaweblog.newMediaObject uploads a file, following your settings */
function mwnewmedia($params) {

	$xblogid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	$xdata = $params->getParam(3);
	
	$blogid = $xblogid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();
	$data = php_xmlrpc_decode($xdata);

	$name = $data['name'];
	$type = $data['type'];
	$bits = $data['bits'];

	$file_realpath = get_settings('fileupload_realpath'); 
	$file_url = get_settings('fileupload_url');

	logIO('O', '(MW) Received '.strlen($bits).' bytes');

// Check login
	if (user_pass_ok($username,$password)) {
		$user_data = get_userdatabylogin($username);
		if(!get_settings('use_fileupload')) {
			// Uploads not allowed
			logIO('O', '(MW) Uploads not allowed');
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, 'No uploads allowed for this site.');
		} 
		if(get_settings('fileupload_minlevel') > $user_data->user_level) {
			// User has not enough privileges
			logIO('O', '(MW) Not enough privilege: user level too low');
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, 'You are not allowed to upload files to this site.');
		}
		if(trim($file_realpath) == '' || trim($file_url) == '' ) {
			// WordPress is not correctly configured
			logIO('O', '(MW) Bad configuration. Real/URL path not defined');
			return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, 'Please configure WordPress with valid paths for file upload.');
		}
		$prefix = '/';
		if ($name[0] = '/') {
			$prefix = '';
		}
		if(!empty($name)) {
			// Create the path
			$localpath = $file_realpath.$prefix.$name;
			$url = $file_url.$prefix.$name;
			if (mkdir_p(dirname($localpath))) {
				/* encode & write data (binary) */
				$ifp = fopen($localpath, 'wb');
				$success = fwrite($ifp, $bits);
				fclose($ifp);
				@chmod($localpath, 0666);
				logIO('O', 'URL='.$url);
				if($success) {
					$resp = array('url'=>new xmlrpcval($url));
					$resp = new xmlrpcval($resp, 'struct');
					return new xmlrpcresp($resp);
				} else {
					logIO('O', '(MW) Could not write file '.$name.' to '.$localpath);
					return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, 'Could not write file '.$name);
				}
			} else {
				return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+2, 'Could not create directories for '.$name);
			}
		}
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}

}

/**** /MetaWeblog API ****/


/**** MovableType API ****/

/**********************
 *
 * MovableType API extensions
 * added by 
 *	Dougal Campbell <dougal@gunters.org> 
 *	http://dougal.gunters.org/
 *
 * DONE:
 *	mt.getCategoryList
 *	mt.setPostCategories
 *	mt.supportedMethods
 *	mt.getPostCategories
 *	mt.publishPost
 *	mt.getRecentPostTitles
 *	extend metaWeblog.newPost
 *	extend metaWeblog.editPost
 *	extend metaWeblog.getPost
 *	extend metaWeblog.getRecentPosts
 *
 * PARTIALLY DONE:
 *	mt.supportedTextFilters		// empty stub, because WP doesn't support per-post text filters at this time
 *	mt.getTrackbackPings		// another stub.
 *	metaWeblog.newMediaObject	// ditto. For now.
 *
 **********************/

$mt_supportedMethods_sig = array(array($xmlrpcArray));
$mt_supportedMethods_doc = 'Retrieve information about the XML-RPC methods supported by the server.';

// ripped out of system.listMethods
function mt_supportedMethods($params) {
	global $dispatch_map, $xmlrpcerr, $xmlrpcstr, $_xmlrpcs_dmap;
	$v=new xmlrpcval();
	$dmap=$dispatch_map;
	$outAr=array();
	for(reset($dmap); list($key, $val)=each($dmap); ) {
	$outAr[]=new xmlrpcval($key, 'string');
	}
	$dmap=$_xmlrpcs_dmap;
	for(reset($dmap); list($key, $val)=each($dmap); ) {
	$outAr[]=new xmlrpcval($key, 'string');
	}
	$v->addArray($outAr);
	return new xmlrpcresp($v);
}

$mt_getPostCategories_sig = array(array($xmlrpcArray, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$mt_getPostCategories_doc = 'Returns a list of all categories to which the post is assigned.';

function mt_getPostCategories($params) {
	global $xmlrpcusererr;

	$xpostid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	
	$post_ID = $xpostid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();

	if (user_pass_ok($username,$password)) {
		$catids = wp_get_post_cats('1', $post_ID);

		// The first category listed will be set as primary
		$struct['isPrimary'] = true;
		foreach($catids as $catid) {	
			$struct['categoryId'] = $catid;
			$struct['categoryName'] = mb_conv(get_cat_name($catid),'UTF-8',$GLOBALS['blog_charset']);

			$resp_struct[] = php_xmlrpc_encode($struct);
			$struct['isPrimary'] = false;
		}
		
		// Return an array of structs	
		$resp_array = new xmlrpcval($resp_struct,'array');
		
		return new xmlrpcresp($resp_array);

	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mt_setPostCategories_sig = array(array($xmlrpcBoolean, $xmlrpcString, $xmlrpcString, $xmlrpcString, $xmlrpcArray));
$mt_setPostCategories_doc = 'Sets the categories for a post';

function mt_setPostCategories($params) {
	global $xmlrpcusererr;
	
	$xpostid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	$xcats = $params->getParam(3);
	
	$post_ID = $xpostid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();
	$cats = php_xmlrpc_decode($xcats);
	
	foreach($cats as $cat) {
		$catids[] = $cat['categoryId'];
	}
	
	if (user_pass_ok($username,$password)) {
		wp_set_post_cats('', $post_ID, $catids);
		
		return new xmlrpcresp(new xmlrpcval($result,'boolean'));
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mt_publishPost_sig = array(array($xmlrpcBoolean, $xmlrpcString, $xmlrpcString, $xmlrpcString));
$mt_publishPost_doc = 'Publish (rebuild) all of the static files related to an entry. Equivalent to saving an entry in the system (but without the ping).';

function mt_publishPost($params) {
	$xpostid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	
	$post_ID = $xpostid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();

	if (user_pass_ok($username,$password)) {
		$postdata = wp_get_single_post($post_ID,ARRAY_A);
		
		$postdata['post_status'] = 'publish';
		
		// retain old cats
		$cats = wp_get_post_cats('',$post_ID);
		$postdata['post_category'] = $cats;
	
		$result = wp_update_post($postdata);

		return new xmlrpcresp(new xmlrpcval($result,'boolean'));
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mt_getRecentPostTitles_sig = array(array($xmlrpcArray,$xmlrpcString,$xmlrpcString,$xmlrpcString,$xmlrpcInt));
$mt_getRecentPostTitles_doc = 'Returns a bandwidth-friendly list of the most recent posts in the system.';

function mt_getRecentPostTitles($params) {
	global $xmlrpcusererr, $wpdb;

	$xblogid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	$xnumposts = $params->getParam(3);

	$blogid = $xblogid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();
	$numposts = intval($xnumposts->scalarval());

	if (user_pass_ok($username,$password)) {
		$sql = "SELECT post_date, post_author, ID, post_title FROM ".wp_table('posts')." ORDER BY post_date DESC LIMIT $numposts";
		$posts = $wpdb->get_results($sql,ARRAY_A);
		$result = array();
		foreach($posts as $post) {

			$post_date = strtotime($post['post_date']);
			$post_date = date('Ymd', $post_date).'T'.date('H:i:s', $post_date);
			$struct['dateCreated'] = new xmlrpcval($post_date, 'dateTime.iso8601');
			$struct['userid'] = new xmlrpcval(mb_conv($post['post_author'],'UTF-8',$GLOBALS['blog_charset']), 'string');
			$struct['postid'] = new xmlrpcval($post['ID'], 'string');
			$struct['title'] = new xmlrpcval(mb_conv($post['post_title'],'UTF-8',$GLOBALS['blog_charset']), 'string');
			$result[] = new xmlrpcval($struct,'struct');
		}
		return new xmlrpcresp(new xmlrpcval($result,'array'));

	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}
}

$mt_supportedTextFilters_sig = array(array($xmlrpcArray));
$mt_supportedTextFilters_doc = 'Retrieve information about the text formatting plugins supported by the server. (not implemented)';

function mt_supportedTextFilters($params) {
	// This should probably check the status of the 'use_bbcode' 
	// and 'use_gmcode' config options.
	
	return new xmlrpcresp(new xmlrpcval(array(),'array'));
}

$mt_getTrackbackPings_sig = array(array($xmlrpcArray,$xmlrpcString));
$mt_getTrackbackPings_doc = 'Retrieve the list of Trackback pings posted to a particular entry. (not implemented)';

function mt_getTrackbackPings($params) {
	$struct['pingTitle'] = '';
	$struct['pingURL'] = '';
	$struct['pingIP'] = '';
	
	$xmlstruct = php_xmlrpc_encode($struct);
	
	return new xmlrpcresp(new xmlrpcval(array($xmlstruct),'array'));
}

$mt_getpost_sig =  array(array($xmlrpcStruct,$xmlrpcString,$xmlrpcString,$xmlrpcString));
$mt_getpost_doc = 'Get a post, MetaWeblog API-style';

function mt_getpost ($params) {	// ($postid, $user, $pass) 
	$xpostid = $params->getParam(0);
	$xuser = $params->getParam(1);
	$xpass = $params->getParam(2);
	
	$post_ID = $xpostid->scalarval();
	$username = $xuser->scalarval();
	$password = $xpass->scalarval();

	// Check login
	if (user_pass_ok($username,$password)) {
		$postdata = get_postdata($post_ID);

		if ($postdata['Date'] != '') {

			// why were we converting to GMT here? spec doesn't call for that.
			//$post_date = mysql2date('U', $postdata['Date']);
			//$post_date = gmdate('Ymd', $post_date).'T'.gmdate('H:i:s', $post_date);
			$post_date = strtotime($postdata['Date']);
			$post_date = date('Ymd', $post_date).'T'.date('H:i:s', $post_date);
			
			$catids = wp_get_post_cats('1',$post_ID);
			logIO('O','Category No:'.count($catids));	
			foreach($catids as $catid) {
				$catname = get_cat_name($catid);
				logIO('O','Category:'.$catname);
				$catnameenc = new xmlrpcval(mb_conv($catname,'UTF-8',$GLOBALS['blog_charset']));
				$catlist[] = $catnameenc;
			}			
			$post = get_extended($postdata['Content']);
			$allow_comments = ('open' == $postdata['comment_status'])?1:0;
			$allow_pings = ('open' == $postdata['ping_status'])?1:0;

			$resp = array(
				'link' => new xmlrpcval(post_permalink($post_ID)),
				'title' => new xmlrpcval(mb_conv($postdata['Title'],'UTF-8',$GLOBALS['blog_charset'])),
				'description' => new xmlrpcval(mb_conv($post['main'],'UTF-8',$GLOBALS['blog_charset'])),
				'dateCreated' => new xmlrpcval($post_date,'dateTime.iso8601'),
				'userid' => new xmlrpcval($postdata['Author_ID']),
				'postid' => new xmlrpcval($postdata['ID']),
				'content' => new xmlrpcval(mb_conv($postdata['Content'],'UTF-8',$GLOBALS['blog_charset'])),
				'permalink' => new xmlrpcval(post_permalink($post_ID)),
				'categories' => new xmlrpcval($catlist,'array'),
				'mt_keywords' => new xmlrpcval("{$catids[0]}"),
				'mt_excerpt' => new xmlrpcval(mb_conv($postdata['Excerpt'],'UTF-8',$GLOBALS['blog_charset'])),
				'mt_allow_comments' => new xmlrpcval($allow_comments,'int'),
				'mt_allow_pings' => new xmlrpcval($allow_pings,'int'),
				'mt_convert_breaks' => new xmlrpcval('true'),
				'mt_text_more' => new xmlrpcval(mb_conv($post['extended'],'UTF-8',$GLOBALS['blog_charset'])),
			);
			
			$resp = new xmlrpcval($resp,'struct');
			
			return new xmlrpcresp($resp);
		} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 4
			"No such post #$post_ID");
		}
	} else {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser']+3, // user error 3
	   'Wrong username/password combination '.$username.' / '.starify($password));
	}

}

/**** /MovableType API ****/


/**** PingBack functions ****/

$pingback_ping_sig = array(array($xmlrpcString, $xmlrpcString, $xmlrpcString));

$pingback_ping_doc = 'Gets a pingback and registers it as a comment prefixed by &lt;pingback /&gt;';

function pingback_ping($m) { // original code by Mort
	// (http://mort.mine.nu:8080)
	global	 $wpdb; 
	global $wp_version; 

	if (!get_settings('use_pingback')) {
		return new xmlrpcresp(new xmlrpcval('Sorry, this weblog does not allow you to pingback its posts.'));
	}
	$title='';

	$pagelinkedfrom = $m->getParam(0);
	$pagelinkedfrom = $pagelinkedfrom->scalarval();

	$pagelinkedto = $m->getParam(1);
	$pagelinkedto = $pagelinkedto->scalarval();

	$pagelinkedfrom = addslashes(str_replace('&amp;', '&', $pagelinkedfrom));
	$pagelinkedto = preg_replace('#&([^amp\;])#is', '&amp;$1', $pagelinkedto);

	$messages = array(
		htmlentities('Pingback from '.$pagelinkedfrom.' to '
			. $pagelinkedto . ' registered. Keep the web talking! :-)'),
		htmlentities("We can't find the URL to the post you are trying to "
			. "link to in your entry. Please check how you wrote the post's permalink in your entry."),
		htmlentities("We can't find the post you are trying to link to."
			. " Please check the post's permalink.")
	);

	$message = $messages[0];

	// Check if the page linked to is in our site
	$pos1 = strpos($pagelinkedto, str_replace('http://', '', str_replace('www.', '', wp_siteurl())));
	if($pos1) {
		// let's find which post is linked to
		$urltest = parse_url($pagelinkedto);
		if ($post_ID = url_to_postid($pagelinkedto)) {
			$way = 'url_to_postid()';
		} elseif (preg_match('#p/[0-9]{1,}#', $urltest['path'], $match)) {
			// the path defines the post_ID (archives/p/XXXX)
			$blah = explode('/', $match[0]);
			$post_ID = $blah[1];
			$way = 'from the path';
		} elseif (preg_match('#p=[0-9]{1,}#', $urltest['query'], $match)) {
			// the querystring defines the post_ID (?p=XXXX)
			$blah = explode('=', $match[0]);
			$post_ID = $blah[1];
			$way = 'from the querystring';
		} elseif (isset($urltest['fragment'])) {
			// an #anchor is there, it's either...
			if (intval($urltest['fragment'])) {
				// ...an integer #XXXX (simpliest case)
				$post_ID = $urltest['fragment'];
				$way = 'from the fragment (numeric)';
			} elseif (preg_match('/post-[0-9]+/',$urltest['fragment'])) {
				// ...a post id in the form 'post-###'
				$post_ID = preg_replace('/[^0-9]+/', '', $urltest['fragment']);
				$way = 'from the fragment (post-###)';
			} elseif (is_string($urltest['fragment'])) {
				// ...or a string #title, a little more complicated
				$title = preg_replace('/[^a-zA-Z0-9]/', '.', $urltest['fragment']);
				$sql = "SELECT ID FROM ".wp_table('posts')." WHERE post_title RLIKE '$title'";
				$post_ID = $wpdb->get_var($sql) or die("Query: $sql\n\nError: ");
				$way = 'from the fragment (title)';
			}
		} else {
			// TODO: Attempt to extract a post ID from the given URL
			$post_ID = -1;
			$way = 'no match';
		}

		logIO('O',"(PB) URI='$pagelinkedto' ID='$post_ID' Found='$way'");

		$sql = "SELECT post_author FROM ".wp_table('posts')." WHERE ID = $post_ID";
		$result = $wpdb->get_results($sql);

		if ($wpdb->num_rows) {
			// Let's check that the remote site didn't already pingback this entry
			$sql = 'SELECT * FROM '.wp_table('comments').' 
				WHERE comment_post_ID = '.$post_ID.' 
					AND comment_author_url = \''.$pagelinkedfrom.'\' 
					AND comment_content LIKE \'%<pingback />%\'';
			$result = $wpdb->get_results($sql);
		
			if ($wpdb->num_rows || (1==1)) {
				// very stupid, but gives time to the 'from' server to publish !
				sleep(1);
				// Let's check the remote site
				require_once(XOOPS_ROOT_PATH.'/class/snoopy.php');
				$snoopy = New Snoopy;
				if ($snoopy->fetch($pagelinkedfrom)) {
					$linea = $snoopy->results;
				} else {
					$linea = '';
				}
				logIO('O',"(PB) CHARSET='".$GLOBALS['blog_charset']);
				$linea = mb_conv($linea, $GLOBALS['blog_charset'], 'auto');
				
				// Work around bug in strip_tags():
				$linea = str_replace('<!DOCTYPE','<DOCTYPE',$linea);
				$linea = strip_tags($linea, '<title><a>');
				$linea = strip_all_but_one_link($linea, $pagelinkedto);
				// I don't think we need this? -- emc3
				if (empty($matchtitle)) {
					preg_match('|<title>([^<]*?)</title>|is', $linea, $matchtitle);
				}
				$pos2 = strpos($linea, $pagelinkedto);
				$pos3 = strpos($linea, str_replace('http://www.', 'http://', $pagelinkedto));
				logIO('O',"(PB) POS='$pos2, $pos3'");
				if (is_integer($pos2) || is_integer($pos3)) {
					//debug_fwrite($log, 'The page really links to us :)'."\n");
					$pos4 = (is_integer($pos2)) ? $pos2 : $pos3;
					$start = $pos4-50;
					if (function_exists('mb_convert_encoding')) {
						$tmp1 = mb_strcut($linea,0,$start,$GLOBALS['blog_charset']);
					} else {
						$tmp1 = substr($linea,0,$start);
					}
					if (preg_match('/<[^>]*?$/',$tmp1,$match)) {
						logIO('O',"(PB) MATCH='{$match[0]}");
						$offset = strlen($match[0]);
					} else {
						$offset = 0;
					}
					if (function_exists('mb_convert_encoding')) {
						$context = mb_strcut($linea, $start-$offset, 150+$offset, $GLOBALS['blog_charset']);
					} else {
						$context = substr($linea, $star-$offsett, 150+$offset);
					}
					$context = str_replace("\n", ' ', $context);
					$context = str_replace('&amp;', '&', $context);
					logIO('O',"(PB) CONTENT='$context");
				} else {
					logIO('O',"(PB) CONTEXT=The page doesn't link to us, here's an excerpt");
					exit();
				}
//				fclose($fp);
				if (!empty($context)) {
					// Check if pings are on, inelegant exit
					$pingstatus = $wpdb->get_var("SELECT ping_status FROM ".wp_table('posts')." WHERE ID = $post_ID");
					if ('closed' == $pingstatus) {
						logIO('O','(PB) Sorry, pings are turned off for this post.');
						exit();
					}
					$pagelinkedfrom = preg_replace('#&([^amp\;])#is', '&amp;$1', $pagelinkedfrom);
					$title = (!strlen($matchtitle[1])) ? $pagelinkedfrom : $matchtitle[1];
					$context = strip_tags($context);
					$context = '<pingback />[...] '.htmlspecialchars(trim($context)) .' [...]';
					$context = format_to_post($context);
					$original_pagelinkedfrom = $pagelinkedfrom;
					$pagelinkedfrom = addslashes($pagelinkedfrom);
					$original_title = $title;
					$title = addslashes(strip_tags(trim($title)));
					$now = current_time('mysql');
					if (get_settings('comment_moderation') == 'manual') {
						$approved = 0;
					} else if (get_settings('comment_moderation') == 'auto') {
						$approved = 0;
					} else { // none
						$approved = 1;
					}
					$consulta = $wpdb->query("INSERT INTO ".wp_table('comments')." 
						(comment_post_ID, comment_author, comment_author_url, comment_date, comment_content,comment_approved) 
						VALUES 
						($post_ID, '$title', '$pagelinkedfrom', '$now', '$context', '$approved')
						");
					$comment_ID = $wpdb->get_var('SELECT last_insert_id()');
					do_action('pingback_post', $comment_ID);
					if ((get_settings('moderation_notify')) && (!$approved)) {
					    wp_notify_moderator($comment_ID, 'pingback');
					}
					if ((get_settings('comments_notify')) && ($approved)) {
						wp_notify_postauthor($comment_ID, 'pingback');
					}
				} else {
					// URL pattern not found
					$message = "Page linked to: $pagelinkedto\nPage linked from:"
						. " $pagelinkedfrom\nTitle: $title\nContext: $context\n\n".$messages[1];
				}
			} else {
				// We already have a Pingback from this URL
				$message = "Sorry, you already did a pingback to $pagelinkedto from $pagelinkedfrom.";
			}
		} else {
			// Post_ID not found
			$message = $messages[2];
			//debug_fwrite($log, 'Post doesn\'t exist'."\n");
		}
	}
	return new xmlrpcresp(new xmlrpcval($message));
}

/**** /PingBack functions ****/



/**** Legacy functions ****/

// a PHP version
// of the state-number server
// send me an integer and i'll sell you a state

$stateNames=array(
'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
'Colorado', 'Columbia', 'Connecticut', 'Delaware', 'Florida',
'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas',
'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan',
'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada',
'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina',
'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming');

$findstate_sig=array(array($xmlrpcString, $xmlrpcInt));

$findstate_doc='When passed an integer between 1 and 51 returns the
name of a US state, where the integer is the index of that state name
in an alphabetic order.';

function findstate($m) {
  global $stateNames;
  $err='';
  // get the first param
  $sno=$m->getParam(0);
  // if it's there and the correct type

  if (isset($sno) && ($sno->scalartyp()=='int')) {
	// extract the value of the state number
	$snv=$sno->scalarval();
	// look it up in our array (zero-based)
	if (isset($stateNames[$snv-1])) {
	  $sname=$stateNames[$snv-1];
	} else {
	  // not, there so complain
	  $err="I don't have a state for the index '" . $snv . "'";
	}
  } else {
	// parameter mismatch, complain
	$err='One integer parameter required';
  }

  // if we generated an error, create an error return response
  if ($err) {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser'], $err);
  } else {
		// otherwise, we create the right response
		// with the state name
		return new xmlrpcresp(new xmlrpcval($sname));
  }
}

$addtwo_sig=array(array($xmlrpcInt, $xmlrpcInt, $xmlrpcInt));

$addtwo_doc='Add two integers together and return the result';

function addtwo($m) {
  $s=$m->getParam(0);
	$t=$m->getParam(1);
  return new xmlrpcresp(new xmlrpcval($s->scalarval()+$t->scalarval(),'int'));
}

$addtwodouble_sig=array(array($xmlrpcDouble, $xmlrpcDouble, $xmlrpcDouble));

$addtwodouble_doc='Add two doubles together and return the result';

function addtwodouble($m) {
  $s=$m->getParam(0);
	$t=$m->getParam(1);
  return new xmlrpcresp(new xmlrpcval($s->scalarval()+$t->scalarval(),'double'));
}

$stringecho_sig=array(array($xmlrpcString, $xmlrpcString));

$stringecho_doc='Accepts a string parameter, returns the string.';

function stringecho($m) {
  // just sends back a string
  $s=$m->getParam(0);
  return new xmlrpcresp(new xmlrpcval($s->scalarval()));
}

$echoback_sig=array(array($xmlrpcString, $xmlrpcString));

$echoback_doc='Accepts a string parameter, returns the entire incoming payload';

function echoback($m) {
  // just sends back a string with what i got
  // send to me, just escaped, that's all
  //
  // $m is an incoming message
  $s="I got the following message:\n" . $m->serialize();
  return new xmlrpcresp(new xmlrpcval($s));
}

$echosixtyfour_sig=array(array($xmlrpcString, $xmlrpcBase64));

$echosixtyfour_doc='Accepts a base64 parameter and returns it decoded as a string';

function echosixtyfour($m) {
	// accepts an encoded value, but sends it back
	// as a normal string. this is to test base64 encoding
	// is working as expected
	$incoming=$m->getParam(0);
	return new xmlrpcresp(new xmlrpcval($incoming->scalarval(), 'string'));
}

$bitflipper_sig=array(array($xmlrpcArray, $xmlrpcArray));

$bitflipper_doc='Accepts an array of booleans, and returns them inverted';

function bitflipper($m) {
	global $xmlrpcArray;

	$v=$m->getParam(0);
	$sz=$v->arraysize();
	$rv=new xmlrpcval(array(), $xmlrpcArray);

	for($j=0; $j<$sz; $j++) {
		$b=$v->arraymem($j);
		if ($b->scalarval()) {

			$rv->addScalar(false, 'boolean');
		} else {

			$rv->addScalar(true, 'boolean');
		}
	}

	return new xmlrpcresp($rv);
}

// Sorting demo
//
// send me an array of structs thus:
//
// Dave 35
// Edd	45
// Fred 23
// Barney 37
//
// and I'll return it to you in sorted order

function agesorter_compare($a, $b) {
  global $agesorter_arr;


  // don't even ask me _why_ these come padded with
  // hyphens, I couldn't tell you :p
  $a=ereg_replace('-', '', $a);
  $b=ereg_replace('-', '', $b);

  if ($agesorter_arr[$a]==$agesorter[$b]) return 0;
  return ($agesorter_arr[$a] > $agesorter_arr[$b]) ? -1 : 1;
}

$agesorter_sig=array(array($xmlrpcArray, $xmlrpcArray));

$agesorter_doc='Send this method an array of [string, int] structs, eg:
<PRE>
 Dave	35
 Edd	45
 Fred	23
 Barney 37
</PRE>
And the array will be returned with the entries sorted by their numbers.
';

function agesorter($m) {
  global $agesorter_arr, $s;

	xmlrpc_debugmsg("Entering 'agesorter'");
  // get the parameter
  $sno=$m->getParam(0);
  // error string for [if|when] things go wrong
  $err='';
  // create the output value
  $v=new xmlrpcval();
  $agar=array();

  if (isset($sno) && $sno->kindOf()=='array') {
	$max=$sno->arraysize();
	// TODO: create debug method to print can work once more
	// print "<!-- found $max array elements -->\n";
	for($i = 0; $i < $max; $i = $i + 1) {
	  $rec=$sno->arraymem($i);
	  if ($rec->kindOf()!='struct') {
		$err="Found non-struct in array at element $i";
		break;
	  }
	  // extract name and age from struct
	  $n=$rec->structmem('name');
	  $a=$rec->structmem('age');
	  // $n and $a are xmlrpcvals,
	  // so get the scalarval from them
	  $agar[$n->scalarval()]=$a->scalarval();
	}

	$agesorter_arr=$agar;
	// hack, must make global as uksort() won't
	// allow us to pass any other auxilliary information
	uksort($agesorter_arr, agesorter_compare);
	$outAr=array();
	while (list( $key, $val ) = each( $agesorter_arr ) ) {
	  // recreate each struct element
	  $outAr[]=new xmlrpcval(array('name' =>
								   new xmlrpcval($key),
								   'age' =>
								   new xmlrpcval($val, 'int')), 'struct');
	}
	// add this array to the output value
	$v->addArray($outAr);
  } else {
	  $err="Must be one parameter, an array of structs";
  }

  if ($err) {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser'], $err);
  } else {
		return new xmlrpcresp($v);
  }
}


// signature and instructions, place these in the dispatch
// map

$mail_send_sig=array(array($xmlrpcBoolean, $xmlrpcString, $xmlrpcString,
													 $xmlrpcString, $xmlrpcString, $xmlrpcString,
													 $xmlrpcString, $xmlrpcString));

$mail_send_doc='mail.send(recipient, subject, text, sender, cc, bcc, mimetype)
<BR>recipient, cc, and bcc are strings, comma-separated lists of email addresses, as described above.
<BR>subject is a string, the subject of the message.
<BR>sender is a string, it\'s the email address of the person sending the message. This string can not be
a comma-separated list, it must contain a single email address only.
text is a string, it contains the body of the message.
<BR>mimetype, a string, is a standard MIME type, for example, text/plain.
';

// WARNING; this functionality depends on the sendmail -t option
// it may not work with Windows machines properly; particularly
// the Bcc option.	Sneak on your friends at your own risk!
function mail_send($m) {
  global $xmlrpcBoolean;
	$err='';

  $mTo=$m->getParam(0);
	$mSub=$m->getParam(1);
	$mBody=$m->getParam(2);
	$mFrom=$m->getParam(3);
	$mCc=$m->getParam(4);
	$mBcc=$m->getParam(5);
	$mMime=$m->getParam(6);

	if ($mTo->scalarval()=='')
		$err="Error, no 'To' field specified";

	if ($mFrom->scalarval()=='')
		$err="Error, no 'From' field specified";

	$msghdr='From: ' . $mFrom->scalarval() . "\n";
	$msghdr.='To: '. $mTo->scalarval() . "\n";

	if ($mCc->scalarval()!='')
		$msghdr.='Cc: ' . $mCc->scalarval(). "\n";
	if ($mBcc->scalarval()!='')
		$msghdr.='Bcc: ' . $mBcc->scalarval(). "\n";
	if ($mMime->scalarval()!='')
		$msghdr.='Content-type: ' . $mMime->scalarval() . "\n";

	$msghdr.='X-Mailer: XML-RPC for PHP mailer 1.0';

	if ($err=='') {
		/*
		if (!mail('',
							$mSub->scalarval(),
							$mBody->scalarval(),
							$msghdr)) {
			$err='Error, could not send the mail.';
		}
		*/
		$err = 'Just in case someone wants to use this for spam, this method is disabled';
	}

  if ($err) {
		return new xmlrpcresp(0, $GLOBALS['xmlrpcerruser'], $err);
  } else {
		return new xmlrpcresp(new xmlrpcval('true', $xmlrpcBoolean));
  }
}

$v1_arrayOfStructs_sig=array(array($xmlrpcInt, $xmlrpcArray));

$v1_arrayOfStructs_doc='This handler takes a single parameter, an array of structs, each of which contains at least three elements named moe, larry and curly, all <i4>s. Your handler must add all the struct elements named curly and return the result.';

function v1_arrayOfStructs($m) {
  $sno=$m->getParam(0);
	$numcurly=0;
	for($i = 0; $i < $sno->arraysize(); $i = $i + 1) {
		$str=$sno->arraymem($i);
		$str->structreset();
		while(list($key,$val)=$str->structeach())
			if ($key=='curly')
				$numcurly+=$val->scalarval();
	}
	return new xmlrpcresp(new xmlrpcval($numcurly, 'int'));
}

$v1_easyStruct_sig=array(array($xmlrpcInt, $xmlrpcStruct));

$v1_easyStruct_doc='This handler takes a single parameter, a struct, containing at least three elements named moe, larry and curly, all &lt;i4&gt;s. Your handler must add the three numbers and return the result.';

function v1_easyStruct($m) {
  $sno=$m->getParam(0);
	$moe=$sno->structmem('moe');
	$larry=$sno->structmem('larry');
	$curly=$sno->structmem('curly');
	$num=$moe->scalarval()+
		$larry->scalarval()+
		$curly->scalarval();
	return new xmlrpcresp(new xmlrpcval($num, 'int'));
}

$v1_echoStruct_sig=array(array($xmlrpcStruct, $xmlrpcStruct));

$v1_echoStruct_doc='This handler takes a single parameter, a struct. Your handler must return the struct.';

function v1_echoStruct($m) {
  $sno=$m->getParam(0);
	return new xmlrpcresp($sno);
}

$v1_manyTypes_sig=array(array($xmlrpcArray, $xmlrpcInt, $xmlrpcBoolean,
															$xmlrpcString, $xmlrpcDouble, $xmlrpcDateTime,
															$xmlrpcBase64));

$v1_manyTypes_doc='This handler takes six parameters, and returns an array containing all the parameters.';

function v1_manyTypes($m) {
	return new xmlrpcresp(new xmlrpcval(
							array(
								$m->getParam(0),
								$m->getParam(1),
								$m->getParam(2),
								$m->getParam(3),
								$m->getParam(4),
								$m->getParam(5)
							),
							'array'));
}

$v1_moderateSizeArrayCheck_sig=array(array($xmlrpcString, $xmlrpcArray));

$v1_moderateSizeArrayCheck_doc='This handler takes a single parameter, which is an array containing between 100 and 200 elements. Each of the items is a string, your handler must return a string containing the concatenated text of the first and last elements.';

function v1_moderateSizeArrayCheck($m) {
	$ar=$m->getParam(0);
	$sz=$ar->arraysize();
	$first=$ar->arraymem(0);
	$last=$ar->arraymem($sz-1);
	return new xmlrpcresp(new xmlrpcval($first->scalarval().$last->scalarval(), 'string'));
}

$v1_simpleStructReturn_sig=array(array($xmlrpcStruct, $xmlrpcInt));

$v1_simpleStructReturn_doc='This handler takes one parameter, and returns a struct containing three elements, times10, times100 and times1000, the result of multiplying the number by 10, 100 and 1000.';

function v1_simpleStructReturn($m) {
  $sno=$m->getParam(0);
	$v=$sno->scalarval();
	return new xmlrpcresp(new xmlrpcval(
									array(
										'times10' =>
										new xmlrpcval($v*10, 'int'),
										'times100' =>
										new xmlrpcval($v*100, 'int'),
										'times1000' =>
										new xmlrpcval($v*1000, 'int')
									),
									'struct'));
}

$v1_nestedStruct_sig=array(array($xmlrpcInt, $xmlrpcStruct));

$v1_nestedStruct_doc='This handler takes a single parameter, a struct, that models a daily calendar. At the top level, there is one struct for each year. Each year is broken down into months, and months into days. Most of the days are empty in the struct you receive, but the entry for April 1, 2000 contains a least three elements named moe, larry and curly, all &lt;i4&gt;s. Your handler must add the three numbers and return the result.';

function v1_nestedStruct($m) {
  $sno=$m->getParam(0);

	$twoK=$sno->structmem('2000');
	$april=$twoK->structmem('04');
	$fools=$april->structmem('01');
	$curly=$fools->structmem('curly');
	$larry=$fools->structmem('larry');
	$moe=$fools->structmem('moe');
	return new xmlrpcresp(new xmlrpcval($curly->scalarval()+$larry->scalarval()+$moe->scalarval(), 'int'));
}

$v1_countTheEntities_sig=array(array($xmlrpcStruct, $xmlrpcString));

$v1_countTheEntities_doc='This handler takes a single parameter, a string, that contains any number of predefined entities, namely &lt;, &gt;, &amp; \' and ".<BR>Your handler must return a struct that contains five fields, all numbers:	 ctLeftAngleBrackets, ctRightAngleBrackets, ctAmpersands, ctApostrophes, ctQuotes.';

function v1_countTheEntities($m) {
  $sno=$m->getParam(0);
	$str=$sno->scalarval();
	$gt=0; $lt=0; $ap=0; $qu=0; $amp=0;
	for($i = 0; $i < strlen($str); $i = $i + 1) {
		$c=substr($str, $i, 1);
		switch($c) {
		case '>':
			$gt++;
			break;
		case '<':
			$lt++;
			break;
		case '"':
			$qu++;
			break;
		case '\'':
			$ap++;
			break;
		case '&':
			$amp++;
			break;
		default:
			break;
		}
	}
	return new xmlrpcresp(new xmlrpcval(
							array(
								'ctLeftAngleBrackets' => new xmlrpcval($lt, 'int'),
								'ctRightAngleBrackets' => new xmlrpcval($gt, 'int'),
								'ctAmpersands' => new xmlrpcval($amp, 'int'),
								'ctApostrophes' => new xmlrpcval($ap, 'int'),
								'ctQuotes' => new xmlrpcval($qu, 'int')
							),
							'struct'));
}

// trivial interop tests
// http://www.xmlrpc.com/stories/storyReader$1636

$i_echoString_sig=array(array($xmlrpcString, $xmlrpcString));
$i_echoString_doc='Echoes string.';

$i_echoStringArray_sig=array(array($xmlrpcArray, $xmlrpcArray));
$i_echoStringArray_doc='Echoes string array.';

$i_echoInteger_sig=array(array($xmlrpcInt, $xmlrpcInt));
$i_echoInteger_doc='Echoes integer.';

$i_echoIntegerArray_sig=array(array($xmlrpcArray, $xmlrpcArray));
$i_echoIntegerArray_doc='Echoes integer array.';

$i_echoFloat_sig=array(array($xmlrpcDouble, $xmlrpcDouble));
$i_echoFloat_doc='Echoes float.';

$i_echoFloatArray_sig=array(array($xmlrpcArray, $xmlrpcArray));
$i_echoFloatArray_doc='Echoes float array.';

$i_echoStruct_sig=array(array($xmlrpcStruct, $xmlrpcStruct));
$i_echoStruct_doc='Echoes struct.';

$i_echoStructArray_sig=array(array($xmlrpcArray, $xmlrpcArray));
$i_echoStructArray_doc='Echoes struct array.';

$i_echoValue_doc='Echoes any value back.';

$i_echoBase64_sig=array(array($xmlrpcBase64, $xmlrpcBase64));
$i_echoBase64_doc='Echoes base64.';

$i_echoDate_sig=array(array($xmlrpcDateTime, $xmlrpcDateTime));
$i_echoDate_doc='Echoes dateTime.';

function i_echoParam($m) {
	$s=$m->getParam(0);
	return new xmlrpcresp($s);
}

function i_echoString($m) { return i_echoParam($m); }
function i_echoInteger($m) { return i_echoParam($m); }
function i_echoFloat($m) { return i_echoParam($m); }
function i_echoStruct($m) { return i_echoParam($m); }
function i_echoStringArray($m) { return i_echoParam($m); }
function i_echoIntegerArray($m) { return i_echoParam($m); }
function i_echoFloatArray($m) { return i_echoParam($m); }
function i_echoStructArray($m) { return i_echoParam($m); }
function i_echoValue($m) { return i_echoParam($m); }
function i_echoBase64($m) { return i_echoParam($m); }
function i_echoDate($m) { return i_echoParam($m); }

$i_whichToolkit_doc='Returns a struct containing the following strings:	 toolkitDocsUrl, toolkitName, toolkitVersion, toolkitOperatingSystem.';

function i_whichToolkit($m) {
	global $xmlrpcName, $xmlrpcVersion,$SERVER_SOFTWARE,
		$xmlrpcStruct;
	$ret=array(
		 'toolkitDocsUrl' => 'http://xmlrpc.usefulinc.com/php.html',
		 'toolkitName' => $xmlrpcName,
		 'toolkitVersion' => $xmlrpcVersion,
		 'toolkitOperatingSystem' => $SERVER_SOFTWARE);
	return new xmlrpcresp ( php_xmlrpc_encode($ret));
}

/**** SERVER FUNCTIONS ARRAY ****/

$dispatch_map =	 array(
					'blogger.newPost' =>
							 array('function' => 'bloggernewpost',
										 'signature' => $bloggernewpost_sig,
										 'docstring' => $bloggernewpost_doc),
					'blogger.editPost' =>
							 array('function' => 'bloggereditpost',
										 'signature' => $bloggereditpost_sig,
										 'docstring' => $bloggereditpost_doc),
					'blogger.deletePost' =>
							 array('function' => 'bloggerdeletepost',
										 'signature' => $bloggerdeletepost_sig,
										 'docstring' => $bloggerdeletepost_doc),
					'blogger.getUsersBlogs' =>
							 array('function' => 'bloggergetusersblogs',
										 'signature' => $bloggergetusersblogs_sig,
										 'docstring' => $bloggergetusersblogs_doc),
					 'blogger.getUserInfo' =>
							 array('function' => 'bloggergetuserinfo',
										 'signature' => $bloggergetuserinfo_sig,
										 'docstring' => $bloggergetuserinfo_doc),
					 'blogger.getPost' =>
							 array('function' => 'bloggergetpost',
										 'signature' => $bloggergetpost_sig,
										 'docstring' => $bloggergetpost_doc),
					 'blogger.getRecentPosts' =>
							 array('function' => 'bloggergetrecentposts',
										 'signature' => $bloggergetrecentposts_sig,
										 'docstring' => $bloggergetrecentposts_doc),
					 'blogger.getTemplate' =>
							 array('function' => 'bloggergettemplate',
										 'signature' => $bloggergettemplate_sig,
										 'docstring' => $bloggergettemplate_doc),
					 'blogger.setTemplate' =>
							 array('function' => 'bloggersettemplate',
										 'signature' => $bloggersettemplate_sig,
										 'docstring' => $bloggersettemplate_doc),
					 'metaWeblog.newPost' =>
							 array('function' => 'mwnewpost',
										 'signature' => $mwnewpost_sig,
										 'docstring' => $mwnewpost_doc),
					 'metaWeblog.editPost' =>
							 array('function' => 'mweditpost',
										 'signature' => $mweditpost_sig,
										 'docstring' => $mweditpost_doc),
					 'metaWeblog.getPost' =>
							 array('function' => 'mwgetpost',
										 'signature' => $mwgetpost_sig,
										 'docstring' => $mwgetpost_doc),
					 'metaWeblog.getRecentPosts' =>
							 array('function' => 'mwrecentposts',
										 'signature' => $mwrecentposts_sig,
										 'docstring' => $mwrecentposts_doc),
					 'metaWeblog.getCategories' =>
							 array('function' => 'mwgetcats',
										 'signature' => $mwgetcats_sig,
										 'docstring' => $mwgetcats_doc),
					 'metaWeblog.newMediaObject' =>
							 array('function' => 'mwnewmedia',
										 'signature' => $mwnewmedia_sig,
										 'docstring' => $mwnewmedia_doc),
					 'mt.getPost' =>
							 array('function' => 'mt_getpost',
										 'signature' => $mt_getpost_sig,
										 'docstring' => $mt_getpost_doc),
					 'mt.getCategoryList' =>
							 array('function' => 'mwgetcats',
										 'signature' => $mwgetcats_sig,
										 'docstring' => $mwgetcats_doc),
					 'mt.getPostCategories' =>
							 array('function' => 'mt_getPostCategories',
										 'signature' => $mt_getPostCategories_sig,
										 'docstring' => $mt_getPostCategories_doc),
					 'mt.setPostCategories' =>
							 array('function' => 'mt_setPostCategories',
										 'signature' => $mt_setPostCategories_sig,
										 'docstring' => $mt_setPostCategories_doc),
					 'mt.publishPost' =>
							 array('function' => 'mt_publishPost',
										 'signature' => $mt_publishPost_sig,
										 'docstring' => $mt_publishPost_doc),
					 'mt.supportedMethods' =>
							 array('function' => 'mt_supportedMethods',
										 'signature' => $mt_supportedMethods_sig,
										 'docstring' => $mt_supportedMethods_doc),
					 'mt.supportedTextFilters' =>
							 array('function' => 'mt_supportedTextFilters',
										 'signature' => $mt_supportedTextFilters_sig,
										 'docstring' => $mt_supportedTextFilters_doc),
					 'mt.getRecentPostTitles' =>
							 array('function' => 'mt_getRecentPostTitles',
										 'signature' => $mt_getRecentPostTitles_sig,
										 'docstring' => $mt_getRecentPostTitles_doc),
					 'mt.getTrackbackPings' =>
							 array('function' => 'mt_getTrackbackPings',
										 'signature' => $mt_getTrackbackPings_sig,
										 'docstring' => $mt_getTrackbackPings_doc),
					 'b2.newPost' =>
							 array('function' => 'b2newpost',
										 'signature' => $wpnewpost_sig,
										 'docstring' => $wpnewpost_doc),
					 'b2.getCategories' =>
							 array('function' => 'b2getcategories',
										 'signature' => $wpgetcategories_sig,
										 'docstring' => $wpgetcategories_doc),
//					 'b2.ping' =>
//							 array('function' => 'b2ping',
//										 'signature' => $wpping_sig,
//										 'docstring' => $wpping_doc),
					 'pingback.ping' =>
							 array('function' => 'pingback_ping',
										 'signature' => $pingback_ping_sig,
										 'docstring' => $pingback_ping_doc),
					 'b2.getPostURL' =>
							 array('function' => 'pingback_getPostURL',
										 'signature' => $wp_getPostURL_sig,
										 'docstring' => $wp_getPostURL_doc),
					 'examples.getStateName' =>
							 array('function' => 'findstate',
										 'signature' => $findstate_sig,
										 'docstring' => $findstate_doc),
					 'examples.sortByAge' =>
							 array('function' => 'agesorter',
										 'signature' => $agesorter_sig,
										 'docstring' => $agesorter_doc),
					 'examples.addtwo' =>
							 array('function' => 'addtwo',
										 'signature' => $addtwo_sig,
										 'docstring' => $addtwo_doc),
					 'examples.addtwodouble' =>
							 array('function' => 'addtwodouble',
										 'signature' => $addtwodouble_sig,
										 'docstring' => $addtwodouble_doc),
					 'examples.stringecho' =>
							 array('function' => 'stringecho',
										 'signature' => $stringecho_sig,
										 'docstring' => $stringecho_doc),
					 'examples.echo' =>
							 array('function' => 'echoback',
										 'signature' => $echoback_sig,
										 'docstring' => $echoback_doc),
					 'examples.decode64' =>
							 array('function' => 'echosixtyfour',
										 'signature' => $echosixtyfour_sig,
										 'docstring' => $echosixtyfour_doc),
					 'examples.invertBooleans' =>
							 array('function' => 'bitflipper',
										 'signature' => $bitflipper_sig,
										 'docstring' => $bitflipper_doc),
					 'mail.send' =>
							 array('function' => 'mail_send',
										 'signature' => $mail_send_sig,
										 'docstring' => $mail_send_doc),
					 'validator1.arrayOfStructsTest' =>
							 array('function' => 'v1_arrayOfStructs',
										 'signature' => $v1_arrayOfStructs_sig,
										 'docstring' => $v1_arrayOfStructs_doc),
					 'validator1.easyStructTest' =>
							 array('function' => 'v1_easyStruct',
										 'signature' => $v1_easyStruct_sig,
										 'docstring' => $v1_easyStruct_doc),
					 'validator1.echoStructTest' =>
							 array('function' => 'v1_echoStruct',
										 'signature' => $v1_echoStruct_sig,
										 'docstring' => $v1_echoStruct_doc),
					 'validator1.manyTypesTest' =>
							 array('function' => 'v1_manyTypes',
										 'signature' => $v1_manyTypes_sig,
										 'docstring' => $v1_manyTypes_doc),
					 'validator1.moderateSizeArrayCheck' =>
							 array('function' => 'v1_moderateSizeArrayCheck',
										 'signature' => $v1_moderateSizeArrayCheck_sig,
										 'docstring' => $v1_moderateSizeArrayCheck_doc),
					 'validator1.simpleStructReturnTest' =>
							 array('function' => 'v1_simpleStructReturn',
										 'signature' => $v1_simpleStructReturn_sig,
										 'docstring' => $v1_simpleStructReturn_doc),
					 'validator1.nestedStructTest' =>
							 array('function' => 'v1_nestedStruct',
										 'signature' => $v1_nestedStruct_sig,
										 'docstring' => $v1_nestedStruct_doc),
					 'validator1.countTheEntities' =>
							 array('function' => 'v1_countTheEntities',
										 'signature' => $v1_countTheEntities_sig,
										 'docstring' => $v1_countTheEntities_doc),
					 'interopEchoTests.echoString' =>
							 array('function' => 'i_echoString',
										 'signature' => $i_echoString_sig,
										 'docstring' => $i_echoString_doc),
					 'interopEchoTests.echoStringArray' =>
							 array('function' => 'i_echoStringArray',
										 'signature' => $i_echoStringArray_sig,
										 'docstring' => $i_echoStringArray_doc),
					 'interopEchoTests.echoInteger' =>
							 array('function' => 'i_echoInteger',
										 'signature' => $i_echoInteger_sig,
										 'docstring' => $i_echoInteger_doc),
					 'interopEchoTests.echoIntegerArray' =>
							 array('function' => 'i_echoIntegerArray',
										 'signature' => $i_echoIntegerArray_sig,
										 'docstring' => $i_echoIntegerArray_doc),
					 'interopEchoTests.echoFloat' =>
							 array('function' => 'i_echoFloat',
										 'signature' => $i_echoFloat_sig,
										 'docstring' => $i_echoFloat_doc),
					 'interopEchoTests.echoFloatArray' =>
							 array('function' => 'i_echoFloatArray',
										 'signature' => $i_echoFloatArray_sig,
										 'docstring' => $i_echoFloatArray_doc),
					 'interopEchoTests.echoStruct' =>
							 array('function' => 'i_echoStruct',
										 'signature' => $i_echoStruct_sig,
										 'docstring' => $i_echoStruct_doc),
					 'interopEchoTests.echoStructArray' =>
							 array('function' => 'i_echoStructArray',
										 'signature' => $i_echoStructArray_sig,
										 'docstring' => $i_echoStructArray_doc),
					  'interopEchoTests.echoValue' =>
							 array('function' => 'i_echoValue',
										 // no sig as takes anytype
										 'docstring' => $i_echoValue_doc),
					  'interopEchoTests.echoBase64' =>
							 array('function' => 'i_echoBase64',
										 'signature' => $i_echoBase64_sig,
										 'docstring' => $i_echoBase64_doc),
					  'interopEchoTests.echoDate' =>
							 array('function' => 'i_echoDate',
										 'signature' => $i_echoDate_sig,
										 'docstring' => $i_echoDate_doc),
					  'interopEchoTests.whichToolkit' =>
							 array('function' => 'i_whichToolkit',
										 // no sig as no parameters
										 'docstring' => $i_whichToolkit_doc),
					);



$s=new xmlrpc_server($dispatch_map);
						
function mkdir_p($target) {
	// from php.net/mkdir user contributed notes 
	if (file_exists($target)) {
	  if (!is_dir($target)) {
		return false;
	  } else {
		return true;
	  }
	}

	// Attempting to create the directory may clutter up our display.
	if (@mkdir($target)) {
	  return true;
	}

	// If the above failed, attempt to create the parent node, then try again.
	if (mkdir_p(dirname($target))) {
	  return mkdir_p($target);
	}

	return false;
}
?>
