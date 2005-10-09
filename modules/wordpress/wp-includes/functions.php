<?php
if( ! defined( 'WP_FUNCTIONS_INCLUDED' ) ) {
	define( 'WP_FUNCTIONS_INCLUDED' , 1 ) ;

if (!function_exists('_')) {
	function _($string) {
		return $string;
	}
}

if (!function_exists('_e')) {
	function _e($string) {
		echo $string;
	}
}

if (!function_exists('floatval')) {
	function floatval($string) {
		return ((float) $string);
	}
}
// implementation of in_array that also should work on PHP3
if (!function_exists('in_array')) {
	function in_array($needle, $haystack) {
	    $needle = strtolower($needle);
	    for ($i = 0; $i < count($haystack); $i++) {
			if (strtolower($haystack[$i]) == $needle) {
			    return true;
			}
    	}
	    return false;
	}
}

function _echo($string, $echo=true) {
	if ($echo) {
		echo $string;
		return;
	} else {
		return $string;
	}
}

function wp_id() {
	return $GLOBALS['wp_id'];
}

function wp_mod() {
	return $GLOBALS['wp_mod'][$GLOBALS['wp_id']];
}

function wp_prefix() {
	return $GLOBALS['wp_prefix'][$GLOBALS['wp_id']];
}

function wp_base() {
	return $GLOBALS['wp_base'][$GLOBALS['wp_id']];
}

function wp_siteurl() {
	return $GLOBALS['wp_siteurl'][$GLOBALS['wp_id']];
}

function wp_table($tblname) {
	return $GLOBALS['wpdb']->{$tblname}[$GLOBALS['wp_id']];
}

function &wp_handler($tblname) {
	return $GLOBALS['wp'.$tblname.'Handler'][$GLOBALS['wp_prefix'][$GLOBALS['wp_id']]];
}

/* functions... */
function add_magic_quotes($array) {
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	return $array;
}


function remove_magic_quotes( $mixed ) {
	if( get_magic_quotes_gpc()) {
		if( is_array( $mixed ) ) {
			foreach($mixed as $k => $v) {
				$mixed[$k] = remove_magic_quotes( $v );
			}
		} else {
			$mixed = stripslashes( $mixed );
		}
	}
	return $mixed;
}

/**
 * Sets a parameter with values from the request or to provided default,
 * except if param is already set!
 *
 * Also removes magic quotes if they are set automatically by PHP.
 * Also forces type.
 * Priority order: POST, GET, COOKIE, DEFAULT.
 *
 * {@internal init_param(-) }}
 *
 * @author fplanque
 * @param string Variable to set
 * @param string Force value type to one of:
 * - boolean
 * - integer
 * - float
 * - string
 * - string-yn
 * - check-01
 * - array
 * - array-int
 * - object
 * - null
 * - clean-html (clean html strin with kses)
 * - html (does nothing)
 * @param mixed Default value or TRUE if user input required
 * @param boolean Override if variable already set
 * @param boolean Force setting of variable to default?
 * @return mixed Final value of Variable, or false if we don't force setting and and did not set
 *
 * @todo add option to override what's already set. DONE.
 */
if (!defined('NO_DEFAULT_PARAM')) define('NO_DEFAULT_PARAM', '__nodefault__');

function _array_int_callback(& $value) {
	settype($value,'integer');
	return $value;
}

function init_param($para_types, $var, $type = '', $default = NO_DEFAULT_PARAM, $must_exist = false, $set_global = true, $global_override = true)
{
	if (!is_array($para_types)) {
		if ($para_types) {
			$para_tmp = $para_types;
			$para_types = array();
			$para_types[] = $para_tmp;
		} else {
			$para_types = array('POST','GET');
		}
	}
	$para_found = false;
	foreach($para_types as $para_type) {
		switch (strtoupper($para_type)) {
			case 'POST':
				if (isset($_POST[$var])) {
					$para_value = remove_magic_quotes($_POST[$var]);
					$para_found = true;
				}
				break;
			case 'GET':
				if (isset($_GET[$var])) {
					$para_value = remove_magic_quotes($_GET[$var]);
					$para_found = true;
				}
				break;
			case 'COOKIE':
				if (isset($_COOKIE[$var])) {
					$para_value = remove_magic_quotes($_COOKIE[$var]);
					$para_found = true;
				}
				break;
			case 'SESSION':
				if (isset($_SESSION[$var])) {
					$para_value = $_SESSION[$var];
					$para_found = true;
				}
				break;
			default:
		}
		if ($para_found) break;
	}
	if ($must_exist && !$para_found) {
		redirect_header('', 5, 'Required parameter['.$var.'] should not be empty.');
	}
	if (!$para_found) {
		if ($default !== NO_DEFAULT_PARAM) {
			$para_value = $default;
		} elseif ($type == 'string-yn') {
			$para_value = 'N';
		} elseif ($type == 'check-01') {
			$para_value = '0';
		}
	}
	if (isset($para_value)) {
		if (!empty($type)) {
			// Force the type
			switch( $type ) {
				case 'html':
					// do nothing
					break;
				case 'clean-html':
					$para_value = trim(clean_html($para_value));
					break;
				case 'string':
					$para_value = trim(strip_tags($para_value));
					break;
				case 'string-yn':
					$para_value = ($para_value == 'Y') ? 'Y' : 'N';
					break;
				case 'check-01':
					$para_value = ($para_value == '1') ? '1' : '0';
					break;
				case 'array-int':
					settype($para_value,'array');
					array_walk($para_value,'_array_int_callback');
					break;
				default:
					settype($para_value, $type );
			}
		}
		set_param($var, $para_value);
	}
	if ($set_global) {
		if ($global_override || empty($GLOBALS[$var])) {
			if (!empty($GLOBALS[$var])) {
				unset($GLOBALS[$var]);
			}
			if (isset($para_value)) {
				$GLOBALS[$var] = $para_value;
			}
		}
	}
	if (!empty($para_value)) {
		return $para_value;
	} else {
		return false;
	}
}
function test_param($var) {
	if (isset($GLOBALS['wpParams'])) {
		return (array_key_exists($var, $GLOBALS['wpParams']) && !empty($GLOBALS['wpParams'][$var]));
	} else {
		return false;
	}
}

function get_param($var) {
	if (isset($GLOBALS['wpParams'][$var])) {
		return $GLOBALS['wpParams'][$var];
	} else {
		return null;
	}
}

function set_param($var, $value) {
	$GLOBALS['wpParams'][$var] = $value;
}

function get_lastpostdate() {
	static $cache_lastpostdate;
	if ((!isset($cache_lastpostdate[wp_id()])) || (!$GLOBALS['use_cache'])) {
		$criteria =& new CriteriaCompo(new Criteria('post_date', current_time('mysql'), "<="));
		$criteria->add(new Criteria('post_status', 'publish'));
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		$criteria->setLimit(1);
		$postHandler =& wp_handler('Post');
		$postObjects =& $postHandler->getObjects($criteria, false, 'post_date');
		$cache_lastpostdate[wp_id()] = $lastpostdate = $postObjects[0]->getVar('post_date');
	} else {
		$lastpostdate = $cache_lastpostdate[wp_id()];
	}
	return $lastpostdate;
}

function user_pass_ok($user_login,$user_pass) {
	if ((empty($GLOBALS['cache_userdata'][wp_id()][$user_login])) OR (!$GLOBALS['use_cache'])) {
		$userdata = get_userdatabylogin($user_login);
	} else {
		$userdata = $GLOBALS['cache_userdata'][wp_id()][$user_login];
	}
	if (!$userdata) return false;
	return (md5(trim($user_pass)) == $userdata->user_pass);
}

function get_currentuserinfo() { // a bit like get_userdata(), on steroids
	if ($GLOBALS['xoopsUser']) {
		$GLOBALS['user_ID'] = $GLOBALS['xoopsUser']->uid();
		$GLOBALS['userdata'] = get_userdata($GLOBALS['user_ID']);
		$GLOBALS['user_login'] = $GLOBALS['xoopsUser']->uname('n');
		$GLOBALS['user_level'] = $GLOBALS['userdata']->user_level;
		$GLOBALS['user_ID'] = $GLOBALS['userdata']->ID;
		$GLOBALS['user_nickname'] = $GLOBALS['userdata']->user_nickname;
		$GLOBALS['user_email'] = $GLOBALS['userdata']->user_email;
		$GLOBALS['user_url'] = $GLOBALS['userdata']->user_url;
		$GLOBALS['user_pass_md5'] = $GLOBALS['xoopsUser']->pass();
	} else {
		$GLOBALS['user_login'] = '';
		$GLOBALS['userdata'] = null;
		$GLOBALS['user_level'] = '';
		$GLOBALS['user_ID'] = '';
		$GLOBALS['user_nickname'] = '';
		$GLOBALS['user_email'] = '';
		$GLOBALS['user_url'] = '';
		$GLOBALS['user_pass_md5'] = '';
	}
}


function get_userdata($userid) {
	if ((empty($GLOBALS['cache_userdata'][wp_id()][$userid])) || (!$GLOBALS['use_cache'])) {
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->get($userid);
		if ($userObject) {
			$user =& $userObject->exportWpObject();
			$GLOBALS['cache_userdata'][wp_id()][$userid] = $user;
		} else {
			return false;
		}
	} else {
		$user = $GLOBALS['cache_userdata'][wp_id()][$userid];
	}
	return $user;
}

function get_userdatabylogin($user_login) {
	$user_login = addslashes($user_login);
	if ((empty($GLOBALS['cache_userdata'][wp_id()]["$user_login"])) || (!$GLOBALS['use_cache'])) {
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->getByLogin($user_login);
		if ($userObject) {
			$user =& $userObject->exportWpObject();
			$GLOBALS['cache_userdata'][wp_id()]["$user_login"] = $user;
		} else {
			return false;
		}
	} else {
		$user = $GLOBALS['cache_userdata'][wp_id()]["$user_login"];
	}
	return $user;
}

function get_userid($user_login) {
	$user = get_userdatabylogin($user_login);
	return $user->ID;
}

function get_author_name($auth_id) {
	$authordata = get_userdata($auth_id);

	switch($authordata['user_idmode']) {
		case 'nickname':
			$authorname = $authordata['user_nickname'];

		case 'login':
			$authorname = $authordata['user_login'];
			break;
	
		case 'firstname':
			$authorname = $authordata['user_firstname'];
			break;

		case 'lastname':
			$authorname = $authordata['user_lastname'];
			break;

		case 'namefl':
			$authorname = $authordata['user_firstname'].' '.$authordata['user_lastname'];
			break;

		case 'namelf':
			$authorname = $authordata['user_lastname'].' '.$authordata['user_firstname'];
			break;

		default:
			$authorname = $authordata['user_nickname'];
			break;
	}

	return $authorname;
}

function get_usernumposts($userid) {
	$userHandler =& wp_handler('User');
	if ($userObject =& $userHandler->get($userid)) {
		return $userObject->getNumPosts();
	} else {
		return 0;
	}
}

function user_can_edit($post_author) {
	$userHandler = wp_handler('User');
	$userObject =& $userHandler->get($post_author);
	return ( ($GLOBALS['user_level'] == 10) || ($GLOBALS['user_ID'] == $userObject->getVar('ID'))|| ($GLOBALS['user_level'] > $userObject->getVar('user_level')));
}
// examine a url (supposedly from this blog) and try to
// determine the post ID it represents.
function url_to_postid($url = '') {
	// Take a link like 'http://example.com/blog/something'
	// and extract just the '/something':
	$uri = preg_replace('#'.wp_siteurl().'#i', '', $url);

	// on failure, preg_replace just returns the subject string
	// so if $uri and $siteurl are the same, they didn't match:
	if ($uri ==wp_siteurl())
		return 0;

	// First, check to see if there is a 'p=N' to match against:
	preg_match('#[?&]p=(\d+)#', $uri, $values);
	$p = intval($values[1]);
	if ($p) return $p;

	// Match $uri against our permalink structure
	$permalink_structure = get_settings('permalink_structure');

	// Matt's tokenizer code
	$rewritecode = array(
		'%year%',
		'%monthnum%',
		'%day%',
		'%postname%',
		'%post_id%'
	);
	$rewritereplace = array(
		'([0-9]{4})?',
		'([0-9]{1,2})?',
		'([0-9]{1,2})?',
		'([0-9a-z-]+)?',
		'([0-9]+)?'
	);

	// Turn the structure into a regular expression
	$matchre = str_replace('/', '/?', $permalink_structure);
	$matchre = str_replace($rewritecode, $rewritereplace, $matchre);

	// Extract the key values from the uri:
	preg_match("#$matchre#",$uri,$values);

	// Extract the token names from the structure:
	preg_match_all("#%(.+?)%#", $permalink_structure, $tokens);

	for($i = 0; $i < count($tokens[1]); $i++) {
		$name = $tokens[1][$i];
		$value = $values[$i+1];
		// Create a variable named $year, $monthnum, $day, $postname, or $post_id:
		$$name = $value;
	}

	// If using %post_id%, we're done:
	if (intval($post_id)) return intval($post_id);

	// Otherwise, build a WHERE clause, making the values safe along the way:
	$criteria &= new CriteriaCompo(new Criteria(1,1));
	if ($year) $criteria->add('YEAR(post_date)', intval($year));
	if ($monthnum) $criteria->add('MONTH(post_date)', intval($monthnum));
	if ($day) $criteria->add('DAYOFMONTH(post_date)', intval($day));
	if ($postname) $criteria->add('post_name', $postname);
	$postHandler =& wp_handler('Post');
	$postObjects =& $postHandler->getObjects($criteria, false, 'ID');
	$id = $postObjects[0]->getVar('ID');
	return $id;
}


/* Options functions */
function get_option($option) {
	return get_settings($option);
}

function get_settings($setting) {
	if (!isset($GLOBALS['use_cache'])) $use_cache=1;
	if (strstr($_SERVER['REQUEST_URI'], 'install.php')) return false;
	if ((empty($GLOBALS['cache_settings'][wp_id()])) OR (!$GLOBALS['use_cache'])) {
		$settings = get_alloptions();
		$GLOBALS['cache_settings'][wp_id()] = $settings;
	} else {
		$settings = $GLOBALS['cache_settings'][wp_id()];
	}
    if (!isset($settings->$setting)) {
        return false;
    }
    else {
		return $settings->$setting;
	}
}

function get_alloptions() {
	$optionHandler =& wp_handler('Option');
	$optionObjects =& $optionHandler->getObjects();
    if ($optionObjects) {
        foreach ($optionObjects as $optionObject) {
            $all_options->{$optionObject->getVar('option_name')} = $optionObject->getVar('option_value');
        }
    }
    return $all_options;
}

function update_option($option_name, $newvalue, $force=false) {
	if (get_settings($option_name) != $newvalue) {
		$optionHandler =& wp_handler('Option');
		$optionObject =& $optionHandler->getByName($option_name);
		$optionObject->setVar('option_value', $newvalue);
		if (!$optionHandler->insert($optionObject,$force, true)) {
			return false;
		}
		$GLOBALS['cache_settings'][wp_id()] = get_alloptions(); // Re cache settings
	}
	return true;
}

function add_option($name, $value='', $group=0, $desc='', $type=1, $level=8) {
	// Adds an option if it doesn't already exist
	if(!get_settings($name)) {
		$optionHandler =& wp_handler('Option');
		if (!$optionHandler->getByName($name)) {
			$optionObject =& $optionHandler->create();
			$optionObject->setVar('option_name', $name);
			$optionObject->setVar('option_value', $value);
			$optionObject->setVar('option_type', $type);
			$optionObject->setVar('option_description', $desc);
			$optionObject->setVar('option_admin_level', $level);
			if ($optionHandler->insert($optionObject, true)) {
				$option_id = $optionObject->getVar('option_id');
				$GLOBALS['cache_settings'][wp_id()]->{$name} = $value;
				if ($group) {
					$criteria =& new Criteria('group_id', $group);
					$optionGroup2OptionHandler =& wp_handler('OptionGroup2Option');
					$optionGroup2OptionObjects =& $optionGroup2OptionHandler->getObjects($criteria, false, 'MAX(seq) seq_max');
					if ($optionGroup2OptionObjects) {
						$seq = $optionGroup2OptionObjects[0]->getExtraVar('seq_max')+1;
						$optionGroup2OptionObject =& $optionGroup2OptionHandler->create();
						$optionGroup2OptionObject->setVar('group_id',$group);
						$optionGroup2OptionObject->setVar('option_id',$option_id);
						$optionGroup2OptionObject->setVar('seq',$seq);
						$optionGroup2OptionHandler->insert($optionGroup2OptionObject, true);
					}
				}
			}
		}
	}
	return;
}

/* PostMeta functions */

function add_post_meta($post_id, $key, $value, $unique = false) {
	$postmetaHandler =& wp_handler('PostMeta');
	if ($unique) {
		$postmetaObjects =& $postmetaHandler->getByKey($post_id. $key);
		if(count($postmetaObjects)) {
			return false;
		}
	}
	$postmetaObject =& $postmetaHandler->create();
	$postmetaObject->setVar('post_id', $post_id);
	$postmetaObject->setVar('meta_key', $key);
	$postmetaObject->setVar('meta_value', $value);
	$GLOBALS['post_meta_cache'][wp_id()][$post_id][$key][] = $value;
	return $postmetaHandler->insert($postmetaObject, true);
}

function delete_post_meta($post_id, $key, $value = '') {
	$criteria =&  new CriteriaCompo(new Criteria('post_id', $post_id));
	$criteria->add(new Criteria('meta_key', $key));
	if (!empty($value)) {
		$criteria->add(new Criteria('meta_value', $value));
	}
	$postmetaHandler =& wp_handler('PostMeta');
	unset($GLOBALS['post_meta_cache'][wp_id()][$post_id][$key]);
	return $postmetaHandler->deleteAll($criteria, true);
}

function get_post_meta($post_id, $key, $single = false) {
	if (isset($GLOBALS['post_meta_cache'][wp_id()][$post_id][$key])) {
		if ($single) {
			return $GLOBALS['post_meta_cache'][wp_id()][$post_id][$key][0];
		} else {
			return $GLOBALS['post_meta_cache'][wp_id()][$post_id][$key];
		}
	}
	$criteria =&  new CriteriaCompo(new Criteria('post_id', $post_id));
	$criteria->add(new Criteria('meta_key', $key));
	$postmetaHandler =& wp_handler('PostMeta');
	$postmetaObjects =& $postmetaHandler->getObjects($criteria);
	$values = array();
	if ($postmetaObjects) {
		foreach ($postmetaObjects as $postmetaObject) {
			$values[] = $postmetaObject->getVar('meta_value');
			$GLOBALS['post_meta_cache'][wp_id()][$post_id][$key][] = $postmetaObject->getVar('meta_value');
		}
	}
	if ($single) {
		if (count($values)) {
			return $values[0];
		} else {
			return '';
		}
	} else {
		return $values;
	}
}

function update_post_meta($post_id, $key, $value, $prev_value = '') {
	$criteria =&  new CriteriaCompo(new Criteria('post_id', $post_id));
	$criteria->add(new Criteria('meta_key', $key));
	if (!empty($prev_value)) {
		$criteria->add(new Criteria('meta_value', $prev_value));
	}
	$postmetaHandler =& wp_handler('PostMeta');
	unset($GLOBALS['post_meta_cache'][wp_id()][$post_id][$key]);
	$postmetaHandler->updateAll('meta_value', $value, $criteria, true);
	return true;
}

function get_postdata($postid) {
	$postHandler =& wp_handler('Post');
	$postObject =& $postHandler->get($postid);
	$GLOBALS['post'] = $postObject->exportWpObject();
	$postdata = array (
		'ID' => $GLOBALS['post']->ID,
		'Author_ID' => $GLOBALS['post']->post_author,
		'Date' => $GLOBALS['post']->post_date,
		'Content' => $GLOBALS['post']->post_content,
		'Excerpt' => $GLOBALS['post']->post_excerpt,
		'Title' => $GLOBALS['post']->post_title,
		'Category' => $GLOBALS['post']->post_category,
		'Lat' => $GLOBALS['post']->post_lat,
		'Lon' => $GLOBALS['post']->post_lon,
		'post_status' => $GLOBALS['post']->post_status,
		'comment_status' => $GLOBALS['post']->comment_status,
		'ping_status' => $GLOBALS['post']->ping_status,
		'post_password' => $GLOBALS['post']->post_password,
		'to_ping' => $GLOBALS['post']->to_ping,
		'pinged' => $GLOBALS['post']->pinged
	);
	return $postdata;
}

function get_postdata2($postid=0) { // less flexible, but saves DB queries
	$postdata = array (
		'ID' => $GLOBALS['post']->ID,
		'Author_ID' => $GLOBALS['post']->post_author,
		'Date' => $GLOBALS['post']->post_date,
		'Content' => $GLOBALS['post']->post_content,
		'Excerpt' => $GLOBALS['post']->post_excerpt,
		'Title' => $GLOBALS['post']->post_title,
		'Category' => $GLOBALS['post']->post_category,
		'Lat' => $GLOBALS['post']->post_lat,
		'Lon' => $GLOBALS['post']->post_lon,
		'post_status' => $GLOBALS['post']->post_status,
		'comment_status' => $GLOBALS['post']->comment_status,
		'ping_status' => $GLOBALS['post']->ping_status,
		'post_password' => $GLOBALS['post']->post_password
		);
	return $postdata;
}
//this is obsolute function
function get_commentdata($comment_ID, $no_cache=0, $include_unapproved=false) { // less flexible, but saves DB queries
	global $postc;
	$comment_ID = intval($comment_ID);
	if ($no_cache) {
		$criteria = null;
		$commentHandler =& wp_handler('Comment');
		$commentObject =& $commentHandler->get($comment_ID);
		if (!$include_unapproved) {
			if ($commentObject->getVar('comment_approved') != 1) {
				return false;
			}
		}
		$myrow = $commentObject->getVarArray();
	} else {
		$myrow['comment_ID']=$GLOBALS['postc']->comment_ID;
		$myrow['comment_post_ID']=$GLOBALS['postc']->comment_post_ID;
		$myrow['comment_author']=$GLOBALS['postc']->comment_author;
		$myrow['comment_author_email']=$GLOBALS['postc']->comment_author_email;
		$myrow['comment_author_url']=$GLOBALS['postc']->comment_author_url;
		$myrow['comment_author_IP']=$GLOBALS['postc']->comment_author_IP;
		$myrow['comment_date']=$GLOBALS['postc']->comment_date;
		$myrow['comment_content']=$GLOBALS['postc']->comment_content;
		$myrow['comment_karma']=$GLOBALS['postc']->comment_karma;
	}
	if (strstr($myrow['comment_content'], '<trackback />')) {
		$myrow['comment_type'] = 'trackback';
	} elseif (strstr($myrow['comment_content'], '<pingback />')) {
		$myrow['comment_type'] = 'pingback';
	} else {
		$myrow['comment_type'] = 'comment';
	}
	return $myrow;
}

function get_catname($cat_ID) {
	static $cache_catnames;
	if (empty($cache_catnames[wp_id()]) || (!$GLOBALS['use_cache'])) {
		$categoryHandler =& wp_handler('Category');
		$categoryObjects =& $categoryHandler->getObjects();
		foreach ($categoryObjects as $categoryObject) {
			$cache_catnames[wp_id()][$categoryObject->getVar('cat_ID')] = $categoryObject->getVar('cat_name');
		}
	}
	$cat_name = $cache_catnames[wp_id()][$cat_ID];
	return $cat_name;
}

function profile($user_login) {
	echo "<a href='profile.php?user=".$GLOBALS['user_data']->user_login."' onclick=\"javascript:window.open('profile.php?user=".$GLOBALS['user_data']->user_login."','Profile','toolbar=0,status=1,location=0,directories=0,menuBar=1,scrollbars=1,resizable=0,width=480,height=320,left=100,top=100'); return false;\">$user_login</a>";
}

function touch_time($edit = 1, $echo=true) {
	if ($GLOBALS['postdata']['post_status'] == 'draft') {
		$checked = 'checked="checked" ';
		$edit = false;
	} else {
		$checked = ' ';
	}
	
	$output = '<p><input type="checkbox" class="checkbox" name="edit_date" value="1" id="timestamp" '.$checked.'/> <label for="timestamp">'._LANG_F_TIMESTAMP.'</label> : <a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#timestamp" title="Help on changing the timestamp">Help</a><br />';

	$time_adj = current_time('timestamp');
	$jj = ($edit) ? mysql2date('d', $GLOBALS['postdata']['post_date']) : date('d', $time_adj);
	$mm = ($edit) ? mysql2date('m', $GLOBALS['postdata']['post_date']) : date('m', $time_adj);
	$aa = ($edit) ? mysql2date('Y', $GLOBALS['postdata']['post_date']) : date('Y', $time_adj);
	$hh = ($edit) ? mysql2date('H', $GLOBALS['postdata']['post_date']) : date('H', $time_adj);
	$mn = ($edit) ? mysql2date('i', $GLOBALS['postdata']['post_date']) : date('i', $time_adj);
	$ss = ($edit) ? mysql2date('s', $GLOBALS['postdata']['post_date']) : date('s', $time_adj);

	$output .= '<input type="text" name="jj" value="'.$jj.'" size="2" maxlength="2" />'."\n";
	$output .= "<select name=\"mm\">\n";
	for ($i=1; $i < 13; $i=$i+1) {
		$output .= "\t\t\t<option value=\"$i\"";
		if ($i == $mm)
		$output .= " selected='selected'";
		if ($i < 10) {
			$ii = "0".$i;
		} else {
			$ii = "$i";
		}
		$output .= ">".$GLOBALS['month']["$ii"]."</option>\n";
	}
	$output .= <<<EOD
</select>
<input type="text" name="aa" value="$aa" size="4" maxlength="5" /> @
<input type="text" name="hh" value="$hh" size="2" maxlength="2" /> :
<input type="text" name="mn" value="$mn" size="2" maxlength="2" /> :
<input type="text" name="ss" value="$ss" size="2" maxlength="2" /> </p>
EOD;
	if ($echo) {
		echo $output;
	} else {
		return $output;
	}
}

function gzip_compression() {
	//In XOOPS Environment This function would be ignored
	return;
}

// functions to count the page generation time (from phpBB2)
// ( or just any time between timer_start() and timer_stop() )

function timer_start() {
    $mtime = microtime();
    $mtime = explode(" ",$mtime);
    $mtime = $mtime[1] + $mtime[0];
    $GLOBALS['timestart'] = $mtime;
    return true;
}

function timer_stop($display=0,$precision=3) { //if called like timer_stop(1), will echo $timetotal
    $mtime = microtime();
    $mtime = explode(" ",$mtime);
    $mtime = $mtime[1] + $mtime[0];
    $GLOBALS['timeend'] = $mtime;
    $timetotal = $GLOBALS['timeend']-$GLOBALS['timestart'];
    if ($display)
        echo number_format($timetotal,$precision);
    return $timetotal;
}

// pings Weblogs.com
function pingWeblogs($blog_ID = 1) {
	// original function by Dries Buytaert for Drupal
	if ((!((get_settings('blogname')=="my weblog") && (wp_siteurl()=="http://example.com"))) && (!preg_match("/localhost\//",wp_siteurl())) && (get_settings('use_weblogsping'))) {
		$message = new xmlrpcmsg("weblogUpdates.ping", array(new xmlrpcval(get_settings('blogname')), new xmlrpcval(wp_siteurl()."/index.php")));
		foreach($GLOBALS['my_pingserver'] as $p) {
			$client = new xmlrpc_client($p['path'],$p['server'],$p['port']);
			$result = $client->send($message, 30);
			unset($client);
		}
		unset($message);
		if (!$result || $result->faultCode()) {
			return false;
		}
		return true;
	} else {
		return false;
	}
}

function trackback($trackback_url, $title, $excerpt, $ID, $charset = "", $force=true) {
	require_once(XOOPS_ROOT_PATH.'/class/snoopy.php');
	$ID=intval($ID);
	$blog_name = get_settings('blogname');
	if ($charset) {
		$title = mb_conv($title,$charset,$GLOBALS['blog_charset']);
		$excerpt = mb_conv($excerpt,$charset,$GLOBALS['blog_charset']);
		$blog_name = mb_conv($blog_name,$charset,$GLOBALS['blog_charset']);
	} else {
		$charset = $GLOBALS['blog_charset'];
	}
	$snoopy = New Snoopy;
	$formvars['title'] = $title;
	$formvars['excerpt'] = $excerpt;
	$formvars['blog_name'] = $blog_name;
	$formvars['charset'] = $charset;
	$formvars['url'] = get_permalink($ID);
	
	$result = $snoopy->submit($trackback_url, $formvars);
	$fp = debug_fopen(wp_base().'/log/trackback.log', 'a');
	debug_fwrite($fp, "\n*****\nRequest:\n\n");
	debug_fwrite($fp, "CHARSET:$charset\n");
	debug_fwrite($fp, "TITLE:$title\n");
	debug_fwrite($fp, "EXCERPT:$excerpt\n");
	debug_fwrite($fp, "\n\nResponse:\n\n");
	debug_fwrite($fp, $snoopy->results);
	debug_fwrite($fp, "\n\n");
	$postHandler =& wp_handler('Post');
	$postObject =& $postHandler->get($ID);
	$postObject->setVar('pinged', "__MySqlFunc__CONCAT(pinged, '\n', '$trackback_url')");
	$postObject->setVar('to_ping', "__MySqlFunc__REPLACE(to_ping, '$trackback_url', '')");
	if( !$postHandler->insert($postObject, $force, true)) {
		debug_fwrite($fp, $postHandler->getErrors());
	}
	debug_fwrite($fp, $postHandler->getLastSQL());
	debug_fclose($fp);
	return $result;
}

// trackback - reply
function trackback_response($error = 0, $error_message = '') {
	if ($error) {
		echo "<?xml version=\"1.0\" encoding=\"{$GLOBALS['blog_charset']}\"?".">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
	} else {
		echo "<?xml version=\"1.0\" encoding=\"{$GLOBALS['blog_charset']}\"?".">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
	exit();
}

function make_url_footnote($content) {
	preg_match_all('/<a(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/', $content, $matches);
	$j = 0;
	$links_summary = '';
	for ($i=0; $i<count($matches[0]); $i++) {
		$links_summary = (!$j) ? "\n" : $links_summary;
		$j++;
		$link_match = $matches[0][$i];
		$link_number = '['.($i+1).']';
		$link_url = $matches[2][$i];
		$link_text = $matches[4][$i];
		$content = str_replace($link_match, $link_text.' '.$link_number, $content);
		$link_url = (strtolower(substr($link_url,0,7)) != 'http://') ? wp_siteurl().$link_url : $link_url;
		$links_summary .= "\n".$link_number.' '.$link_url;
	}
	$content = strip_tags($content);
	$content .= $links_summary;
	return $content;
}


function xmlrpc_getposttitle($content) {
	if (preg_match('/<title>(.+?)<\/title>/is', $content, $matchtitle)) {
		$post_title = $matchtitle[0];
		$post_title = preg_replace('/<title>/si', '', $post_title);
		$post_title = preg_replace('/<\/title>/si', '', $post_title);
	} else {
		$post_title = $GLOBALS['post_default_title'];
	}
	return $post_title;
}

function xmlrpc_getpostcategory($content) {
	if (preg_match('/<category>(.+?)<\/category>/is', $content, $matchcat)) {
		$post_category = $matchcat[0];
		$post_category = preg_replace('/<category>/si', '', $post_category);
		$post_category = preg_replace('/<\/category>/si', '', $post_category);

	} else {
		$post_category = $GLOBALS['post_default_category'];
	}
	return $post_category;
}

function xmlrpc_removepostdata($content) {
	$content = preg_replace('/<title>(.+?)<\/title>/si', '', $content);
	$content = preg_replace('/<category>(.+?)<\/category>/si', '', $content);
	$content = trim($content);
	return $content;
}

function &debug_fopen($filename, $mode) {
	if ($GLOBALS['wp_debug'] == 1) {
		$fp = fopen($filename, $mode);
		return $fp;
	} else {
		return false;
	}
}

function debug_fwrite(&$fp, $string) {
	if ($GLOBALS['wp_debug'] == 1) {
		fwrite($fp, $string);
	}
}

function debug_fclose($fp) {
	if ($GLOBALS['wp_debug'] == 1) {
		fclose($fp);
	}
}

function pingback($content, $post_ID) {
	// original code by Mort (http://mort.mine.nu:8080)
	$buf_keep = array();
	while (ob_get_level()) {
		$buf_keep[] = ob_get_contents ();
		ob_end_clean();
	}

	$log = debug_fopen(wp_base().'/log/pingback.log', 'a');
	$post_links = array();
	debug_fwrite($log, 'BEGIN '.time()."\n");

	// Variables
	$ltrs = '\w';
	$gunk = '/#~:.?+=&%@!\-';
	$punc = '.:?\-';
	$any = $ltrs.$gunk.$punc;
	$pingback_str_dquote = 'rel="pingback"';
	$pingback_str_squote = 'rel=\'pingback\'';
	$x_pingback_str = 'x-pingback: ';
	$pingback_href_original_pos = 27;

	// Step 1
	// Parsing the post, external links (if any) are stored in the $post_links array
	// This regexp comes straight from phpfreaks.com
	// http://www.phpfreaks.com/quickcode/Extract_All_URLs_on_a_Page/15.php
	preg_match_all("{\b http : [$any] +? (?= [$punc] * [^$any] | $)}x", $content, $post_links_temp);

	// Debug
	debug_fwrite($log, 'Post contents:');
	debug_fwrite($log, $content."\n");

	// Step 2.
	// Walking thru the links array
	// first we get rid of links pointing to sites, not to specific files
	// Example:
	// http://dummy-weblog.org
	// http://dummy-weblog.org/
	// http://dummy-weblog.org/post.php
	// We don't wanna ping first and second types, even if they have a valid <link/>

	foreach($post_links_temp[0] as $link_test){
		$test = parse_url($link_test);
		if (isset($test['query'])) {
			$post_links[] = $link_test;
		} elseif(($test['path'] != '/') && ($test['path'] != '')) {
			$post_links[] = $link_test;
		}
	}

	foreach ($post_links as $pagelinkedto){
		debug_fwrite($log, 'Processing -- '.$pagelinkedto."\n\n");

		$bits = parse_url($pagelinkedto);
		if (!isset($bits['host'])) {
			debug_fwrite($log, 'Couldn\'t find a hostname for '.$pagelinkedto."\n\n");
			continue;
		}
		$host = $bits['host'];
		$path = isset($bits['path']) ? $bits['path'] : '';
		if (isset($bits['query'])) {
			$path .= '?'.$bits['query'];
		}
		if (!$path) {
			$path = '/';
		}
		$port = isset($bits['port']) ? $bits['port'] : 80;

		// Try to connect to the server at $host
		$fp = fsockopen($host, $port, $errno, $errstr, 30);
		if (!$fp) {
			debug_fwrite($log, 'Couldn\'t open a connection to '.$host."\n\n");
			continue;
		}

		// Send the GET request
		$request = "GET $path HTTP/1.1\r\nHost: $host\r\nUser-Agent: WordPress/{$GLOBALS['wp_version']} PHP/" . phpversion() . "\r\n\r\n";
		@ob_end_flush();
		fputs($fp, $request);

		// Start receiving headers and content
		$contents = '';
		$headers = '';
		$gettingHeaders = true;
		$found_pingback_server = 0;
		while (!feof($fp)) {
			$line = fgets($fp, 4096);
			if (trim($line) == '') {
				$gettingHeaders = false;
			}
			if (!$gettingHeaders) {
				$contents .= trim($line)."\n";
				$pingback_link_offset_dquote = strpos($contents, $pingback_str_dquote);
				$pingback_link_offset_squote = strpos($contents, $pingback_str_squote);
			} else {
				$headers .= trim($line)."\n";
				$x_pingback_header_offset = strpos(strtolower($headers), $x_pingback_str);
			}
			if ($x_pingback_header_offset) {
				preg_match('#x-pingback: (.+)#is', $headers, $matches);
				$pingback_server_url = trim($matches[1]);
				debug_fwrite($log, "Pingback server found from X-Pingback header @ $pingback_server_url\n");
				$found_pingback_server = 1;
				break;
			}
			if ($pingback_link_offset_dquote || $pingback_link_offset_squote) {
				$quote = ($pingback_link_offset_dquote) ? '"' : '\'';
				$pingback_link_offset = ($quote=='"') ? $pingback_link_offset_dquote : $pingback_link_offset_squote;
				$pingback_href_pos = @strpos($contents, 'href=', $pingback_link_offset);
				$pingback_href_start = $pingback_href_pos+6;
				$pingback_href_end = @strpos($contents, $quote, $pingback_href_start);
				$pingback_server_url_len = $pingback_href_end-$pingback_href_start;
				$pingback_server_url = substr($contents, $pingback_href_start, $pingback_server_url_len);
				debug_fwrite($log, "Pingback server found from Pingback <link /> tag @ $pingback_server_url\n");
				$found_pingback_server = 1;
				break;
			}
		}

		if (!$found_pingback_server) {
			debug_fwrite($log, "Pingback server not found\n\n*************************\n\n");
			@fclose($fp);
		} else {
			debug_fwrite($log,"\n\nPingback server data\n");

			// Assuming there's a "http://" bit, let's get rid of it
			$host_clear = substr($pingback_server_url, 7);

			//  the trailing slash marks the end of the server name
			$host_end = strpos($host_clear, '/');

			// Another clear cut
			$host_len = $host_end-$host_start;
			$host = substr($host_clear, 0, $host_len);
			debug_fwrite($log, 'host: '.$host."\n");

			// If we got the server name right, the rest of the string is the server path
			$path = substr($host_clear,$host_end);
			debug_fwrite($log, 'path: '.$path."\n\n");

			 // Now, the RPC call
			$method = 'pingback.ping';
			debug_fwrite($log, 'Page Linked To: '.$pagelinkedto."\n");
			debug_fwrite($log, 'Page Linked From: ');
			$pagelinkedfrom = get_permalink($post_ID);
			debug_fwrite($log, $pagelinkedfrom."\n");

			$client = new xmlrpc_client($path, $host, 80);
			$message = new xmlrpcmsg($method, array(new xmlrpcval($pagelinkedfrom), new xmlrpcval($pagelinkedto)));
			$result = $client->send($message);
			if ($result){
				if (!$result->value()){
					debug_fwrite($log, $result->faultCode().' -- '.$result->faultString());
				} else {
					$value = xmlrpc_decode1($result->value());
					if (is_array($value)) {
						$value_arr = '';
						foreach($value as $blah) {
							$value_arr .= $blah.' |||| ';
						}
						debug_fwrite($log, $value_arr);
					} else {
						debug_fwrite($log, $value);
					}
				}
			}
			@fclose($fp);
		}
	}
	debug_fwrite($log, "\nEND: ".time()."\n****************************\n\r");
	debug_fclose($log);

	for ($i=count($buf_keep)-1; $i>=0 ; $i--) {
		ob_start();
		echo $buf_keep[$i];
	}
}

/**
 ** sanitise HTML attributes, remove frame/applet/*script/mouseovers,etc. tags
 ** so that this kind of thing cannot be done:
 ** This is how we can do <b onmouseover="alert('badbadbad')">bad stuff</b>!
 **/
function sanitise_html_attributes($text) {
    $text = preg_replace('#(([\s"\'])on[a-z]{1,}|style|class|id)="(.*?)"#i', '$1', $text);
    $text = preg_replace('#(([\s"\'])on[a-z]{1,}|style|class|id)=\'(.*?)\'#i', '$1', $text);
    $text = preg_replace('#(([\s"\'])on[a-z]{1,}|style|class|id)[ \t]*=[ \t]*([^ \t\>]*?)#i', '$1', $text);
    $text = preg_replace('#([a-z]{1,})="(( |\t)*?)(javascript|vbscript|about):(.*?)"#i', '$1=""', $text);
    $text = preg_replace('#([a-z]{1,})=\'(( |\t)*?)(javascript|vbscript|about):(.*?)\'#i', '$1=""', $text);
    $text = preg_replace('#\<(\/{0,1})([a-z]{0,2})(frame|applet)(.*?)\>#i', '', $text);
    return $text;
}

function doGeoUrlHeader($posts) {
    if (count($posts) == 1) {
        // there's only one result  see if it has a geo code
        $row = $posts[0];
        $lat = $row->post_lat;
        $lon = $row->post_lon;
        $title = $row->post_title;
        if(($lon != null) && ($lat != null) ) {
            echo "<meta name=\"ICBM\" content=\"".$lat.", ".$lon."\" />\n";
            echo "<meta name=\"DC.title\" content=\"".convert_chars(strip_tags(get_bloginfo("name")),"unicode")." - ".$title."\" />\n";
            echo "<meta name=\"geo.position\" content=\"".$lat.";".$lon."\" />\n";
            return;
        }
    } else {
        if(get_settings('use_default_geourl')) {
            // send the default here
            echo "<meta name=\"ICBM\" content=\"".get_settings('default_geourl_lat').", ".get_settings('default_geourl_lon')."\" />\n";
            echo "<meta name=\"DC.title\" content=\"".convert_chars(strip_tags(get_bloginfo("name")),"unicode")."\" />\n";
            echo "<meta name=\"geo.position\" content=\"".get_settings('default_geourl_lat').";".get_settings('default_geourl_lon')."\" />\n";
        }
    }
}

function getRemoteFile($host,$path) {
    $fp = fsockopen($host, 80, $errno, $errstr);
    if ($fp) {
        fputs($fp,"GET $path HTTP/1.0\r\nHost: $host\r\n\r\n");
        while ($line = fgets($fp, 4096)) {
            $lines[] = $line;
        }
        fclose($fp);
        return $lines;
    } else {
        return false;
    }
}

function pingGeoURL($blog_ID=1) {
    $ourUrl = get_settings('blodotgsping_url')."/index.php?p=".$blog_ID;
    $host="geourl.org";
    $path="/ping/?p=".$ourUrl;
    getRemoteFile($host,$path);
}

/* wp_set_comment_status:
   part of otaku42's comment moderation hack
   changes the status of a comment according to $comment_status.
   allowed values:
   hold   : set comment_approve field to 0
   approve: set comment_approve field to 1
   delete : remove comment out of database

   returns true if change could be applied
   returns false on database error or invalid value for $comment_status
 */
function wp_set_comment_status($comment_id, $comment_status) {
	$commentHandler =& wp_handler('Comment');
	if (!($commentObject =& $commentHandler->get($comment_id))) {
		return false;
	}
    switch($comment_status) {
		case 'hold':
			return $commentObject->unapprove(true); // Force Update now.
			break;
		case 'approve':
			return $commentObject->approve(true); // Force Update now.
			break;
		case 'delete':
			return $commentHandler->delete($commentObject, true); // Force Delete now.
			break;
		default:
			return false;
    }

}


/* wp_get_comment_status
   part of otaku42's comment moderation hack
   gets the current status of a comment

   returned values:
   "approved"  : comment has been approved
   "unapproved": comment has not been approved
   "deleted   ": comment not found in database

   a (boolean) false signals an error
 */
function wp_get_comment_status($comment_id) {
	$commentHandler =& wp_handler('Comment');
	if (!($commentObject =& $commentHandler->get($comment_id))) {
		return "deleted";
	} else if ($commentObject->getVar('comment_approved') == '1') {
        return "approved";
	} else if ($commentObject->getVar('comment_approved') == '0') {
        return "unapproved";
    } else {
        return false;
    }
}

function wp_notify_postauthor($comment_id, $comment_type='comment') {
	$commentHandler =& wp_handler('Comment');
	if (!($commentObject =& $commentHandler->get($comment_id))) {
		return false;
	}
    $comment =& $commentObject->exportWpObject();

	$postHandler =& wp_handler('Post');
	if (!($postObject =& $postHandler->get($comment->comment_post_ID))) {
		return false;
	}
	$post =& $postObject->exportWpObject();
	
	$userHandler =& wp_handler('User');
	if (!($userObject =& $userHandler->get($post->post_author))) {
		return false;
	}
    $user = $userObject->exportWpObject();
    if ($user->user_email == '') return false; // If there's no email to send the comment to
	
	$comment_author_domain = gethostbyaddr($comment->comment_author_IP);

	$blogname = get_settings('blogname');

	if ($comment_type == 'comment') {
		$notify_message	 = _LANG_F_NEW_COMMENT." #$comment->comment_post_ID ".$post->post_title."\r\n\r\n";
		$notify_message .= "Author : $comment->comment_author (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
		$notify_message .= "E-mail : $comment->comment_author_email\r\n";
		$notify_message .= "URI	   : $comment->comment_author_url\r\n";
		$notify_message .= "Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=$comment->comment_author_IP\r\n";
		$notify_message .= "Comment:\r\n".mb_conv($comment->comment_content,$GLOBALS['blog_charset'] ,'auto')."\r\n\r\n";
		$notify_message .= _LANG_F_ALL_COMMENTS." \r\n";
		$subject = '[' . $blogname . '] Comment: "' .$post->post_title.'"';
	} elseif ($comment_type == 'trackback') {
		$notify_message	 = _LANG_F_NEW_TRACKBACK." #$comment->comment_post_ID ".$post->post_title."\r\n\r\n";
		$notify_message .= "Website: ".mb_conv($comment->comment_author,$GLOBALS['blog_charset'],"auto")." (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
		$notify_message .= "URI	   : $comment->comment_author_url\r\n";
		$notify_message .= "Comment:\r\n".mb_conv($comment->comment_content,$GLOBALS['blog_charset'],"auto")."\r\n\r\n";
		$notify_message .= _LANG_F_ALL_TRACKBACKS." \r\n";
		$subject = '[' . $blogname . '] Trackback: "' .$post->post_title.'"';
	} elseif ($comment_type == 'pingback') {
		$notify_message	 = _LANG_F_NEW_PINGBACK." #$comment->comment_post_ID ".$post->post_title."\r\n\r\n";
		$notify_message .= "Website: $comment->comment_author\r\n";
		$notify_message .= "URI	   : $comment->comment_author_url\r\n";
		$notify_message .= "Excerpt: \n[...] ".mb_conv($original_context,$GLOBALS['blog_charset'],"auto")." [...]\r\n\r\n";
		$notify_message .= _LANG_F_ALL_PINGBACKS." \r\n";
		$subject = '[' . $blogname . '] Pingback: "' .$post->post_title.'"';
	}
	$notify_message .= get_permalink($comment->comment_post_ID,false) . '#comments';

	if ('' == $comment->comment_author_email || '' == $comment->comment_author) {
		if (function_exists('mb_convert_encoding')) {
			$from = "From: \"". mb_encode_mimeheader(mb_conv($blogname,"JIS","auto")) ."\" <wordpress@" . $_SERVER['SERVER_NAME'] . '>';
		} else {
			$from = "From: \"". $blogname ."\" <wordpress@" . $_SERVER['SERVER_NAME'] . '>';
		}
	} else {
		if (function_exists('mb_convert_encoding')) {
			$from = 'From: "' . mb_encode_mimeheader(mb_conv($comment->comment_author,"JIS","auto")) . "\" <$comment->comment_author_email>";
		} else {
			$from = 'From: "' . $comment->comment_author . "\" <$comment->comment_author_email>";
		}
	}
	if (defined('XOOPS_URL')) {
		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setToEmails($user->user_email);
		$xoopsMailer->setFromEmail($comment->comment_author_email);
		$xoopsMailer->setFromName($comment->comment_author);
		$xoopsMailer->setSubject($subject);
		$xoopsMailer->setBody($notify_message);
		$xoopsMailer->send(true);
	} else {
		if (function_exists('mb_send_mail')) {
			mb_send_mail($user->user_email, $subject, $notify_message, $from);
		} else {
			@mail($user->user_email, $subject, $notify_message, $from);
		}
	}
    return true;
}

/* wp_notify_moderator
   notifies the moderator of the blog (usually the admin)
   about a new comment that waits for approval
   always returns true
 */
function wp_notify_moderator($comment_id) {
	$commentHandler =& wp_handler('Comment');
	if (!($commentObject =& $commentHandler->get($comment_id))) {
		return false;
	}
    $comment =& $commentObject->exportWpObject();

	$postHandler =& wp_handler('Post');
	if (!($postObject =& $postHandler->get($comment->comment_post_ID))) {
		return false;
	}
	$post =& $postObject->exportWpObject();
	
	$userHandler =& wp_handler('User');
	if (!($userObject =& $userHandler->get($post->post_author))) {
		return false;
	}
    $user = $userObject->exportWpObject();

    $comment_author_domain = gethostbyaddr($comment->comment_author_IP);
    
	$comments_waiting = $commentHandler->getCount(new Criteria('comment_approved', '0 '));
	$notify_message	 = _LANG_F_COMMENT_POST." #$comment->comment_post_ID ".$post->post_title._LANG_F_WAITING_APPROVAL."\r\n\r\n";
    $notify_message .= "Author : $comment->comment_author (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
    $notify_message .= "E-mail : $comment->comment_author_email\r\n";
	$notify_message .= "URL	   : $comment->comment_author_url\r\n";
    $notify_message .= "Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=$comment->comment_author_IP\r\n";
    $notify_message .= "Comment:\r\n".$comment->comment_content."\r\n\r\n";
    $notify_message .= _LANG_F_APPROVAL_VISIT." ".wp_siteurl()." /wp-admin/post.php?action=mailapprovecomment&p=".$comment->comment_post_ID."&comment=$comment_id\r\n";
    $notify_message .= _LANG_F_DELETE_VISIT." ".wp_siteurl()."/wp-admin/post.php?action=confirmdeletecomment&p=".$comment->comment_post_ID."&comment=$comment_id\r\n";
    $notify_message .= "\"$comments_waiting\""._LANG_F_PLEASE_VISIT."\r\n";
    $notify_message .= wp_siteurl()."/wp-admin/moderation.php\r\n";

    $subject = '[' . get_settings('blogname') . '] Please approve: "' .$post->post_title.'"';
    $from  = "From: ".get_settings('admin_email');

	if (defined('XOOPS_URL')) {
		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setToEmails(get_settings('admin_email'));
		$xoopsMailer->setFromEmail(get_settings('admin_email'));
		$xoopsMailer->setSubject($subject);
		$xoopsMailer->setBody($notify_message);
		$xoopsMailer->send();
	} else {
	    if (function_exists('mb_send_mail')) {
		    mb_send_mail(get_settings('admin_email'), $subject, $notify_message, $from);
	    } else {
		    @mail(get_settings('admin_email'), $subject, $notify_message, $from);
	    }
	}
    return true;
}


function start_wp() {
	if (empty($GLOBALS['preview'])) {
		$GLOBALS['wp_post_id'] = $GLOBALS['post']->ID;
	} else {
		$GLOBALS['wp_post_id'] = 0;
		$GLOBALS['postdata'] = array (
			'ID' => 0,
			'Author_ID' => $_GET['preview_userid'],
			'Date' => $_GET['preview_date'],
			'Content' => $_GET['preview_content'],
			'Excerpt' => $_GET['preview_excerpt'],
			'Title' => $_GET['preview_title'],
			'Category' => $_GET['preview_category'],
			'Notify' => 1
			);
	}
	$GLOBALS['authordata'] = get_userdata($GLOBALS['post']->post_author);
	$GLOBALS['day'] = mysql2date('d.m.y', $GLOBALS['post']->post_date);
	$GLOBALS['numpages'] = 1;
	if (empty($GLOBALS['page'])) {
		$GLOBALS['page'] = 1;
	}
	if (!empty($GLOBALS['p'])) {
		$GLOBALS['more'] = 1;
	}
	$content = $GLOBALS['post']->post_content;
	if (preg_match('/<!--nextpage-->/', $GLOBALS['post']->post_content)) {
		if ($GLOBALS['page'] > 1)
			$GLOBALS['more'] = 1;
		$GLOBALS['multipage'] = 1;
		$content = stripslashes($GLOBALS['post']->post_content);
		$content = str_replace("\n<!--nextpage-->\n", '<!--nextpage-->', $content);
		$content = str_replace("\n<!--nextpage-->", '<!--nextpage-->', $content);
		$content = str_replace("<!--nextpage-->\n", '<!--nextpage-->', $content);
		$GLOBALS['pages'] = explode('<!--nextpage-->', $content);
		$GLOBALS['numpages'] = count($GLOBALS['pages']);
	} else {
		$GLOBALS['pages'][0] = stripslashes($GLOBALS['post']->post_content);
		$GLOBALS['multipage'] = 0;
	}
	return true;
}

function is_new_day() {
	if ($GLOBALS['day'] != $GLOBALS['previousday']) {
		return(1);
	} else {
		return(0);
	}
}

function wp_head() {
	do_action('wp_head', '');
}

function permlink_to_param() {
	if ( !empty( $_SERVER['PATH_INFO'] ) ) {
		// Fetch the rewrite rules.
		$rewrite = rewrite_rules('matches');
		$pathinfo =explode('/',$_SERVER['PATH_INFO']);
		foreach($pathinfo as $key => $val) {
			$pathinfo[$key] = rawurlencode($pathinfo[$key]);
		}
		$pathinfo = implode('/',$pathinfo);
		// Trim leading '/'.
		$pathinfo = preg_replace('!^/!', '', $pathinfo);

		if (! empty($rewrite)) {
			// Get the name of the file requesting path info.
			$req_uri = $_SERVER['REQUEST_URI'];
			$req_uri = explode('?', $req_uri);
			$req_uri = $req_uri[0];
			$req_uri = str_replace($pathinfo, '', $req_uri);
			$req_uri = preg_replace("!/+$!", '', $req_uri);
			$req_uri = explode('/', $req_uri);
			$req_uri = $req_uri[count($req_uri)-1];
			// Look for matches.
			$pathinfomatch = $pathinfo;
			foreach ($rewrite as $match => $query) {
				// If the request URI is the anchor of the match, prepend it
				// to the path info.
				if ((! empty($req_uri)) && (strpos($match, $req_uri) === 0)) {
					$pathinfomatch = $req_uri . '/' . $pathinfo;
				}

				if (preg_match("!^$match!", $pathinfomatch, $matches)) {
					// Got a match.
					// Trim the query of everything up to the '?'.
					$query = preg_replace("!^.+\?!", '', $query);

					// Substitute the substring matches into the query.
					@eval("\$query = \"$query\";");

					// Parse the query.
					parse_str($query, $get);
					break;
				}
			}
			if ($get) {
				$_GET += $get;
			}
		}	 
	}
}

/* rewrite_rules
 * Construct rewrite matches and queries from permalink structure.
 * matches - The name of the match array to use in the query strings.
 *           If empty, $1, $2, $3, etc. are used.
 * Returns an associate array of matches and queries.
 */
function preg_index($number, $matches = '') {
    $match_prefix = '$';
    $match_suffix = '';

    if (! empty($matches)) {
        $match_prefix = '$' . $matches . '['; 
                         $match_suffix = ']';
    }        
    return "$match_prefix$number$match_suffix";        
}
function rewrite_rules($matches = '', $permalink_structure = '') {
    $rewrite = array();

    if (empty($permalink_structure)) {
        $permalink_structure = get_settings('permalink_structure');
        
        if (empty($permalink_structure)) {
            return $rewrite;
        }
    }

    $rewritecode = 
	array(
	'%year%',
	'%monthnum%',
	'%day%',
	'%hour%',
	'%minute%',
	'%second%',
	'%postname%',
	'%post_id%'
	);

    $rewritereplace = 
	array(
	'([0-9]{4})?',
	'([0-9]{1,2})?',
	'([0-9]{1,2})?',
	'([0-9]{1,2})?',
	'([0-9]{1,2})?',
	'([0-9]{1,2})?',
	'([_0-9a-z-]+)?',
	'([0-9]+)?'
	);

    $queryreplace = 
	array (
	'year=',
	'monthnum=',
	'day=',
	'hour=',
	'minute=',
	'second=',
	'name=',
	'p='
	);


    $match = str_replace('/', '/?', $permalink_structure);
    $match = preg_replace('|/[?]|', '', $match, 1);

    $match = str_replace($rewritecode, $rewritereplace, $match);
    $match = preg_replace('|[?]|', '', $match, 1);

    $feedmatch = trailingslashit(str_replace('?/?', '/', $match));
    $trackbackmatch = $feedmatch;

    preg_match_all('/%.+?%/', $permalink_structure, $tokens);

    $query = 'index.php?';
    $feedquery = 'wp-feed.php?';
    $trackbackquery = get_settings('trackback_filename') ? get_settings('trackback_filename') : 'wp-trackback.php';
    $trackbackquery = $trackbackquery.'?';
    for ($i = 0; $i < count($tokens[0]); ++$i) {
		if (0 < $i) {
			 $query .= '&';
			 $feedquery .= '&';
			 $trackbackquery .= '&';
		}
		$query_token = str_replace($rewritecode, $queryreplace, $tokens[0][$i]) . preg_index($i+1, $matches);
		$query .= $query_token;
		$feedquery .= $query_token;
		$trackbackquery .= $query_token;
    }
    ++$i;
	$trackbackquery .= '&tb=1';
    // Add post paged stuff
    $match .= '([0-9]+)?/?$';
    $query .= '&page=' . preg_index($i, $matches);

    // Add post feed stuff
    $feedregex = '(feed|rdf|rss|rss2|atom)/?$';
    $feedmatch .= $feedregex;
    $feedquery .= '&feed=' . preg_index($i, $matches);

    // Add post trackback stuff
    $trackbackregex = 'trackback/?$';
    $trackbackmatch .= $trackbackregex;

	$front = preg_match('#^/index.php/#' ,$permalink_structure) ? 'index.php/' : '';
    // Site feed
    $sitefeedmatch = $front.'feed/?([_0-9a-z-]+)?/?$';
    $sitefeedquery = 'wp-feed.php?feed=' . preg_index(1, $matches);

    // Site comment feed
    $sitecommentfeedmatch = $front.'comments/feed/?([_0-9a-z-]+)?/?$';
    $sitecommentfeedquery = 'wp-feed.php?feed=' . preg_index(1, $matches) . '&withcomments=1';

    // Code for nice categories and authors, currently not very flexible
    $front = substr($permalink_structure, 0, strpos($permalink_structure, '%'));
	if ( '' == get_settings('category_base') )
		$catmatch = $front . 'category/';
	else
	    $catmatch = get_settings('category_base') . '/';
    $catmatch = preg_replace('|^/+|', '', $catmatch);
    
    $catfeedmatch = $catmatch . '(.*)/' . $feedregex;
    $catfeedquery = 'wp-feed.php?category_name=' . preg_index(1, $matches) . '&feed=' . preg_index(2, $matches);

    $catmatch = $catmatch . '?(.*)';
    $catquery = 'index.php?category_name=' . preg_index(1, $matches);

    $authormatch = $front . 'author/';
    $authormatch = preg_replace('|^/+|', '', $authormatch);

    $authorfeedmatch = $authormatch . '(.*)/' . $feedregex;
    $authorfeedquery = 'wp-feed.php?author_name=' . preg_index(1, $matches) . '&feed=' . preg_index(2, $matches);

    $authormatch = $authormatch . '?(.*)';
    $authorquery = 'index.php?author_name=' . preg_index(1, $matches);

    $rewrite = array(
                     $catfeedmatch => $catfeedquery,
                     $catmatch => $catquery,
                     $authorfeedmatch => $authorfeedquery,
                     $authormatch => $authorquery,
                     $match => $query,
                     $feedmatch => $feedquery,
                     $trackbackmatch => $trackbackquery,
                     $sitefeedmatch => $sitefeedquery,
                     $sitecommentfeedmatch => $sitecommentfeedquery
                     );

    return $rewrite;
}

function get_posts($args) {
	parse_str($args, $r);
	if (!isset($r['numberposts'])) $r['numberposts'] = 5;
	if (!isset($r['offset'])) $r['offset'] = 0;
	// The following not implemented yet
	if (!isset($r['category'])) $r['category'] = '';
	if (!isset($r['orderby'])) $r['orderby'] = '';
	if (!isset($r['order'])) $r['order'] = '';

	$now = current_time('mysql');
	
	$criteria =& new CriteriaCompo(new Criteria('post_date', $now, '<='));
	$criteria->add(new Criteria('post_status', 'publish'));
	$criteria->setSort('post_date');
	$criteria->setOrder('DESC');
	$criteria->setStart(intval($r['offset']));
	$criteria->setLimit(intval($r['numberposts']));
	$criteria->setGroupBy('ID');

	$postHandler =& wp_handler('Post');
	$postObjects =& $postHandler->getObjects($criteria, false, '', true);
	$posts = array();
	foreach($postObjects as $postObject) {
		$posts[] =& $postObjects->exportWpObject();
	}
	return $posts;
}

function check_comment($author, $email, $url, $comment, $user_ip) {
	if (get_settings('comment_moderation') == 1) return false; // If moderation is set to manual

	if ( (count(explode('http:', $comment)) - 1) >= get_settings('comment_max_links') )
		return false; // Check # of external links

	if ('' == trim( get_settings('moderation_keys') ) ) return true; // If moderation keys are empty
	$words = explode("\n", get_settings('moderation_keys') );
	foreach ($words as $word) {
	$word = trim($word);
	$pattern = "#$word#i";
		if ( preg_match($pattern, $author) ) return false;
		if ( preg_match($pattern, $email) ) return false;
		if ( preg_match($pattern, $url) ) return false;
		if ( preg_match($pattern, $comment) ) return false;
		if ( preg_match($pattern, $user_ip) ) return false;
	}

	return true;
}

function get_xoops_option($dirname,$conf_name) {
	$module_handler =& xoops_gethandler('module');
	$module=$module_handler->getByDirname($dirname);
	$mid=$module->getVar('mid');
	if (empty($GLOBALS['wp_xoops_config'])) {
		$GLOBALS['wp_xoops_config'] =& xoops_gethandler('config');
	}
    
    $records =& $GLOBALS['wp_xoops_config']->getConfigList($mid);
    $value = $records[$conf_name];
    return ($value);
}
function block_style_get($echo = true, $with_tpl = true) {
	$wp_num= (wp_id()=='-' ? '' : wp_id());
	if ($with_tpl) {
		if (get_xoops_option(wp_mod(),'wp_use_blockcssheader')) {
			$tplVars =& $GLOBALS['xoopsTpl']->get_template_vars();
			$csslink = "\n".'<link rel="stylesheet" type="text/css" media="screen" href="'.wp_siteurl() .'/wp-blockstyle.php" />';
			if(array_key_exists('xoops_block_header', $tplVars)) {
				if (!strstr($tplVars['xoops_block_header'],$csslink)) {
					$GLOBALS['xoopsTpl']->assign('xoops_block_header',$tplVars['xoops_block_header'].$csslink);
				}
			} else {
				$GLOBALS['xoopsTpl']->assign('xoops_block_header',$csslink);
			}
			return;
		} else {
			if (!defined('WP_BLOCKSTYLE_READ'.$wp_num)) {
				define('WP_BLOCKSTYLE_READ'.$wp_num, 1);
				if ($echo) {
					echo '<style type="text/css" media="screen">@import url('.wp_siteurl() .'/wp-blockstyle.php);</style>'."\n";
				} else {
					return '@import url('.wp_siteurl() .'/wp-blockstyle.php);';
				}
			}
			return;
		}
	}
	if (file_exists(wp_base().'/themes/'.$GLOBALS['xoopsConfig']['theme_set'].'/wp-blocks.css.php')) {
		$themes = $GLOBALS['xoopsConfig']['theme_set'];
	} else {
		$themes = 'default';
	}
	$wp_block_style='';
	include_once(wp_base().'/themes/'.$themes.'/wp-blocks.css.php');
	if ($echo) {
		if (trim($wp_block_style) != "") {
		echo <<< EOD
<style type="text/css" media="screen">
    <!--
	$wp_block_style
    -->
</style>
EOD;
		}
	} else {
		return trim($wp_block_style);
	}
}

function wp_refcheck($offset = "", $redirect = true) {
	$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_ENV['HTTP_REFERER'];
	if ($ref == '') {
		if ($redirect) {
			if (defined('XOOPS_URL')) { //XOOPS Module mode
				redirect_header(wp_siteurl(), 1, 'You cannot update Database contents.(Could not detect HTTP_REFERER)');
			} else {
				header("Location: ".wp_siteurl());
			}
		}
		return false;
	}
	if (strpos($ref, wp_siteurl().$offset) !== 0 ) {
		if ($redirect) {
			if (defined('XOOPS_URL')) { //XOOPS Module mode
				redirect_header(wp_siteurl(), 1, 'You cannot update Database contents.(HTTP_REFERER is not valid site.)');
			} else {
				header("Location: ".wp_siteurl());
			}
		}
		return false;
	}
	return true;
}

function wp_get_rss_charset() {
	if (function_exists('mb_convert_encoding')) {
		if ($GLOBALS['blog_charset'] != 'iso-8859-1') {
			$rss_charset = 'utf-8';
		} else {
			$rss_charset = $GLOBALS['blog_charset'];
		}
	}else{
		$rss_charset = $GLOBALS['blog_charset'];
	}
	return $rss_charset;
}

function wp_convert_rss_charset($srcstr) {
	return mb_conv($srcstr, wp_get_rss_charset(), $GLOBALS['blog_charset']);
}

function mb_conv($str,$to,$from) {
	if (function_exists('mb_convert_encoding')) {
		if ($to != $from) {
			if (strtolower($from) == 'auto') $from = 'ASCII, JIS, UTF-8,eucJP-win, EUC-JP, SJIS-win, SJIS';
			if (strtolower($from) == 'euc-jp') $from = 'eucJP-win';
			if (strtolower($to) == 'euc-jp') $to = 'eucJP-win';
			if ((strtolower($from) == 'sjis')||(strtolower($from) == 'sjis')) $from = 'SJIS-win';
			if ((strtolower($to) == 'sjis')||(strtolower($to) == 'sjis')) $to = 'SJIS-win';
			$retstr = mb_convert_encoding($str,$to,$from);
		} else {
			$retstr = $str;
		}
	} else {
		if ((strtolower($from) == 'iso-8859-1')&&(strtolower($to) == 'utf-8')) {
			$retstr = utf8_encode($str);
		} else if ((strtolower($to) == 'iso-8859-1')&&(strtolower($from) == 'utf-8')) {
			$retstr = utf8_decode($str);
		} else {
			$retstr = $str;
		}
	}
	return $retstr;
}

function mb_substring($string, $start, $length, $charset="") {
	if (function_exists('mb_convert_encoding')) {
		if (!$charset) {
			if (!empty($GLOBALS['blog_charset'])) {
				$charset = $GLOBALS['blog_charset'];
			} else {
				$charset = mb_internal_encoding();
			}
		}
		return mb_substr($string, $start, $length, $charset);
	} else {
		return substr($string, $start, $length);
	}
}

function trailingslashit($string) {
    if ( '/' != substr($string, -1)) {
        $string .= '/';
    }
    return $string;
}

function get_version() {
	return $GLOBALS['wp_version_str'];
}

function get_custom_path($filename) {
	if (file_exists(wp_base().'/themes/'.$GLOBALS['xoopsConfig']['theme_set'].'/'. $filename)) {
		$themes = $GLOBALS['xoopsConfig']['theme_set'];
	} else {
		$themes = "default";
	}
	return wp_base().'/themes/'.$themes.'/'. $filename;
}

function get_custom_url($filename) {
	if (file_exists(wp_base().'/themes/'.$GLOBALS['xoopsConfig']['theme_set'].'/'. $filename)) {
		$themes = $GLOBALS['xoopsConfig']['theme_set'];
	} else {
		$themes = "default";
	}
	return wp_siteurl().'/themes/'.$themes.'/'. $filename;
}

function current_wp() {
	$cur_PATH = $_SERVER['SCRIPT_FILENAME'];
	if (preg_match('/^'.preg_quote(wp_base().'/','/').'/i',$cur_PATH)) {
		return true;
	} else {
		return false;
	}
}

//May not Used now, but keeping for compatiblity
function alert_error($msg) { // displays a warning box with an error message (original by KYank)
	?>
	<html>
	<head>
	<script language="JavaScript">
	<!--
	alert("<?php echo $msg ?>");
	history.back();
	//-->
	</script>
	</head>
	<body>
	<!-- this is for non-JS browsers (actually we should never reach that code, but hey, just in case...) -->
	<?php echo $msg; ?><br />
	<a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>">go back</a>
	</body>
	</html>
	<?php
	exit;
}

function alert_confirm($msg) { // asks a question - if the user clicks Cancel then it brings them back one page
	?>
	<script language="JavaScript">
	<!--
	if (!confirm("<?php echo $msg ?>")) {
	history.back();
	}
	//-->
	</script>
	<?php
}

function redirect_js($url,$title="...") {
	?>
	<script language="JavaScript">
	<!--
	function redirect() {
	window.location = "<?php echo $url; ?>";
	}
	setTimeout("redirect();", 100);
	//-->
	</script>
	<p>Redirecting you : <b><?php echo $title; ?></b><br />
	<br />
	If nothing happens, click <a href="<?php echo $url; ?>">here</a>.</p>
	<?php
	exit();
}

function wp_create_thumbnail($file, $max_side, $effect = '') { 
	// 1 = GIF, 2 = JPEG, 3 = PNG
	if (file_exists($file)) {
		$type = getimagesize($file); 
        
		// if the associated function doesn't exist - then it's not
		// handle. duh. i hope.
		if (!function_exists('imagegif') && $type[2] == 1) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} elseif (!function_exists('imagejpeg') && $type[2] == 2) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} elseif (!function_exists('imagepng') && $type[2] == 3) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} else {
			// create the initial copy from the original file
			if ($type[2] == 1) {
				$image = imagecreatefromgif($file);
			} elseif ($type[2] == 2) {
				$image = imagecreatefromjpeg($file);
			} elseif ($type[2] == 3) {
				$image = imagecreatefrompng($file);
			} 

			if (function_exists('imageantialias'))
	            imageantialias($image, TRUE);

			$image_attr = getimagesize($file); 
            
			// figure out the longest side
			if ($image_attr[0] > $image_attr[1]) {
				$image_width = $image_attr[0];
				$image_height = $image_attr[1];
				$image_new_width = $max_side;

				$image_ratio = $image_width / $image_new_width;
				$image_new_height = $image_height / $image_ratio; 
				// width is > height
			} else {
				$image_width = $image_attr[0];
				$image_height = $image_attr[1];
				$image_new_height = $max_side;

				$image_ratio = $image_height / $image_new_height;
				$image_new_width = $image_width / $image_ratio; 
				// height > width
			} 
            if (function_exists('gd_info')) {
	            $gdver=gd_info();
	            if(strstr($gdver['GD Version'],'1.')!=false){
	            	//For GD
	                $thumbnail = imagecreate($image_new_width, $image_new_height);
	            }else{
	            	//For GD2
	                $thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
	            }
			} else {
                if (function_exists('imagecreatetruecolor')) {
                    $thumbnail = @imagecreatetruecolor($image_new_width, $image_new_height);
                }
                if (!$thumbnail) {
                     $thumbnail =imagecreate($image_new_width, $image_new_width);
                }
			}
			@imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_attr[0], $image_attr[1]); 
            
			// move the thumbnail to it's final destination
            
			$path = explode('/', $file);
			$thumbpath = substr($file, 0, strrpos($file, '/')) . '/thumb-' . $path[count($path)-1];

			if ($type[2] == 1) {
				if (!imagegif($thumbnail, $thumbpath)) {
					$error = 'Thumbnail path invalid';
				} 
			} elseif ($type[2] == 2) {
				if (!imagejpeg($thumbnail, $thumbpath)) {
					$error = 'Thumbnail path invalid';
				} 
			} elseif ($type[2] == 3) {
				if (!imagepng($thumbnail, $thumbpath)) {
					$error = 'Thumbnail path invalid';
				} 
			} 
		} 
	} 

	if (!empty($error)) {
		return $error;
	} else {
		return 1;
	} 
}
}
?>
