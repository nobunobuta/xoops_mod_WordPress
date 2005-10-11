<?php

if (!function_exists('_')) {
	function _($string) {
		return $string;
	}
}

if (!function_exists('floatval')) {
	function floatval($string) {
		return ((float) $string);
	}
}

/* functions... */




function get_lastpostdate() {
	global  $cache_lastpostdate, $use_cache, $time_difference, $pagenow, $wpdb ,$wp_id;
	if ((!isset($cache_lastpostdate[$wp_id])) OR (!$use_cache)) {
		$now = date("Y-m-d H:i:s",(time() + ($time_difference * 3600)));

		$lastpostdate = $wpdb->get_var("SELECT post_date FROM {$wpdb->posts[$wp_id]} WHERE post_date <= '$now' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1");
		$cache_lastpostdate[$wp_id] = $lastpostdate;
	} else {
		$lastpostdate = $cache_lastpostdate[$wp_id];
	}
	return $lastpostdate;
}

function user_pass_ok($user_login,$user_pass) {
	global $cache_userdata,$use_cache,$wp_id;
	if ((empty($cache_userdata[$wp_id][$user_login])) OR (!$use_cache)) {
		$userdata = get_userdatabylogin($user_login);
	} else {
		$userdata = $cache_userdata[$wp_id][$user_login];
	}
	return (md5(trim($user_pass)) == $userdata->user_pass);
}

function get_currentuserinfo() { // a bit like get_userdata(), on steroids
	global $user_login, $userdata, $user_level, $user_ID, $user_nickname, $user_email, $user_url, $user_pass_md5, $cookiehash, $xoopsUser;
	// *** retrieving user's data from cookies and db - no spoofing
/*
	$user_login = $_COOKIE['wordpressuser_'.$cookiehash];
	$userdata = get_userdatabylogin($user_login);
	$user_level = $userdata->user_level;
	$user_ID = $userdata->ID;
	$user_nickname = $userdata->user_nickname;
	$user_email = $userdata->user_email;
	$user_url = $userdata->user_url;
	$user_pass_md5 = md5($userdata->user_pass);
*/
	if ($xoopsUser) {
		$user_login = $xoopsUser->uname();
		$userdata = get_userdatabylogin($user_login);
		$user_level = $userdata->user_level;
		$user_ID = $userdata->ID;
		$user_nickname = $userdata->user_nickname;
		$user_email = $userdata->user_email;
		$user_url = $userdata->user_url;
//		$user_pass_md5 = md5($userdata->user_pass);
		$user_pass_md5 = $xoopsUser->pass();
	}
}


function get_userdata($userid) {
	global $wpdb, $cache_userdata, $use_cache, $xoopsDB ,$wp_id;
	$userid = intval($userid);
	if ((empty($cache_userdata[$wp_id][$userid])) || (!$use_cache)) {
		$user = $wpdb->get_row("SELECT * FROM {$wpdb->users[$wp_id]} WHERE ID = $userid");
		$xuser = $wpdb->get_row("SELECT * FROM ".$xoopsDB->prefix('users')." WHERE uid=$userid");
        $user->user_nickname = stripslashes($user->user_nickname);
        $user->user_firstname = stripslashes($user->user_firstname);
        $user->user_lastname = stripslashes($user->user_lastname);
        $user->user_firstname =  stripslashes($user->user_firstname);
        $user->user_lastname = stripslashes($user->user_lastname);
		$user->user_description = stripslashes($user->user_description);
		$user->user_pass = $xuser->pass;
		$cache_userdata[$wp_id][$userid] = $user;
	} else {
		$user = $cache_userdata[$wp_id][$userid];
	}
	return $user;
}

function get_userdata2($userid) { // for team-listing
//	global  $post;
//	$user_data['ID'] = $userid;
	global  $post, $xoopsUser;
	$user_data['ID'] = $xoopsUser->uid();
	$user_data['user_login'] = $post->user_login;
	$user_data['user_firstname'] = $post->user_firstname;
	$user_data['user_lastname'] = $post->user_lastname;
	$user_data['user_nickname'] = $post->user_nickname;
	$user_data['user_level'] = $post->user_level;
	$user_data['user_email'] = $post->user_email;
	$user_data['user_url'] = $post->user_url;
	return $user_data;
}

function get_userdatabylogin($user_login) {
	global  $cache_userdata, $use_cache, $wpdb, $xoopsDB ,$wp_id;
	if ((empty($cache_userdata[$wp_id]["$user_login"])) OR (!$use_cache)) {
		$user = $wpdb->get_row("SELECT * FROM {$wpdb->users[$wp_id]} WHERE user_login = '$user_login'");
		$xuser = $wpdb->get_row("SELECT * FROM ".$xoopsDB->prefix('users')." WHERE uname='".trim($user_login)."'");
		$user->user_pass = $xuser->pass;
		$cache_userdata[$wp_id]["$user_login"] = $user;
	} else {
		$user = $cache_userdata[$wp_id]["$user_login"];
	}
	return $user;
}

function get_userid($user_login) {
	global  $cache_userdata, $use_cache, $wpdb ,$wp_id;
	if ((empty($cache_userdata[$wp_id]["$user_login"])) OR (!$use_cache)) {
		$user_id = $wpdb->get_var("SELECT ID FROM {$wpdb->users[$wp_id]} WHERE user_login = '$user_login'");

		$cache_userdata[$wp_id]["$user_login"] = $user_id;
	} else {
		$user_id = $cache_userdata[$wp_id]["$user_login"];
	}
	return $user_id;
}

function get_usernumposts($userid) {
	global   $wpdb ,$wp_id;
	$userid = intval($userid);
	return $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts[$wp_id]} WHERE post_author = $userid");
}

function user_can_edit($post_author) {
	if ($GLOBALS['xoopsUser']) {
		$post_author=intval($post_author);
		$uid = intval($GLOBALS['xoopsUser']->uid());
		$userdata = get_userdata($uid);
		$author_data = get_userdata($post_author);
		return ( ($uid == $post_author) || ($userdata->user_level == 10) || ($userdata->user_level > $author_data->user_level) );
	} else {
		return false;
	}
}

// examine a url (supposedly from this blog) and try to
// determine the post ID it represents.
function url_to_postid($url = '') {
	global $wpdb,  $siteurl ,$wp_id;

	// Take a link like 'http://example.com/blog/something'
	// and extract just the '/something':
	$uri = preg_replace("#$siteurl#i", '', $url);

	// on failure, preg_replace just returns the subject string
	// so if $uri and $siteurl are the same, they didn't match:
	if ($uri == $siteurl)
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
	if ($year) $where .= " AND YEAR(post_date) = " . intval($year);
	if ($monthnum) $where .= " AND MONTH(post_date) = " . intval($monthnum);
	if ($day) $where .= " AND DAYOFMONTH(post_date) = " . intval($day);
	if ($postname) $where .= " AND post_name = '" . $wpdb->escape($postname) . "' ";

	// Run the query to get the post ID:
	$id = intval($wpdb->get_var("SELECT ID FROM {$wpdb->posts[$wp_id]} WHERE 1 = 1 " . $where));

	return $id;
}


/* Options functions */

function get_settings($setting) {
	global $wpdb, $cache_settings, $use_cache, $REQUEST_URI, $wp_id;
	if (!isset($use_cache))	$use_cache=1;
	if (strstr($REQUEST_URI, 'install.php')) return false;
	if ((empty($cache_settings[$wp_id])) OR (!$use_cache)) {
		$settings = get_alloptions();
		$cache_settings[$wp_id] = $settings;
	} else {
		$settings = $cache_settings[$wp_id];
	}
    if (!isset($settings->$setting)) {
        return false;
    }
    else {
		return $settings->$setting;
	}
}

function get_alloptions() {
    global  $wpdb ,$wp_id;
    $options = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options[$wp_id]}");
    if ($options) {
        foreach ($options as $option) {
            $all_options->{$option->option_name} = $option->option_value;
        }
    }
    return $all_options;
}

function update_option($option_name, $newvalue) {
	global $wpdb, $wp_id, $cache_settings;
	// No validation at the moment
	$newvalue = stripslashes($newvalue);
	$newvalue = trim($newvalue); // I can't think of any situation we wouldn't want to trim
	$newvalue = $wpdb->escape($newvalue);
	$wpdb->query("UPDATE {$wpdb->options[$wp_id]} SET option_value = '$newvalue' WHERE option_name = '$option_name'");
	$cache_settings[$wp_id] = get_alloptions(); // Re cache settings
}

function add_option($name, $value='') {
	// Adds an option if it doesn't already exist
	global $wpdb, $wp_id;
	if(!get_settings($name)) {
		$name = $wpdb->escape($name);
		$options = $wpdb->get_results("SELECT option_id FROM {$wpdb->options[$wp_id]} WHERE option_name = '$name'");
		if (count($options) == 0) {
			$value = $wpdb->escape($value);
			$wpdb->query("INSERT INTO {$wpdb->options[$wp_id]} (option_name, option_value) VALUES ('$name', '$value')");

			if($wpdb->insert_id) {
				global $cache_settings;
				$cache_settings[$wp_id]->{$name} = $value;
			}
		}
	}
	return;
}

function get_postdata($postid) {
	global $post,     $wpdb ,$wp_id;

	$postid = intval($postid);
	$post = $wpdb->get_row("SELECT * FROM {$wpdb->posts[$wp_id]} WHERE ID = $postid");

	$postdata = array (
		'ID' => $post->ID,
		'Author_ID' => $post->post_author,
		'Date' => $post->post_date,
		'Content' => $post->post_content,
		'Excerpt' => $post->post_excerpt,
		'Title' => $post->post_title,
		'Category' => $post->post_category,
		'Lat' => $post->post_lat,
		'Lon' => $post->post_lon,
		'post_status' => $post->post_status,
		'comment_status' => $post->comment_status,
		'ping_status' => $post->ping_status,
		'post_password' => $post->post_password,
		'to_ping' => $post->to_ping,
		'pinged' => $post->pinged
	);
	return $postdata;
}

function get_postdata2($postid=0) { // less flexible, but saves DB queries
	global $post;
	$postdata = array (
		'ID' => $post->ID,
		'Author_ID' => $post->post_author,
		'Date' => $post->post_date,
		'Content' => $post->post_content,
		'Excerpt' => $post->post_excerpt,
		'Title' => $post->post_title,
		'Category' => $post->post_category,
		'Lat' => $post->post_lat,
		'Lon' => $post->post_lon,
		'post_status' => $post->post_status,
		'comment_status' => $post->comment_status,
		'ping_status' => $post->ping_status,
		'post_password' => $post->post_password
		);
	return $postdata;
}

function get_commentdata($comment_ID,$no_cache=0,$include_unapproved=false) { // less flexible, but saves DB queries
	global $postc,$id,$commentdata, $wpdb ,$wp_id;
	$comment_ID = intval($comment_ID);
	if ($no_cache) {
		$query = "SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_ID = $comment_ID";
		if (false == $include_unapproved) {
		    $query .= " AND comment_approved = '1'";
		}
    	$myrow = $wpdb->get_row($query, ARRAY_A);
		if (strstr($myrow['comment_content'], '<trackback />')) {
			$myrow['comment_type'] = 'trackback';
		} elseif (strstr($myrow['comment_content'], '<pingback />')) {
			$myrow['comment_type'] = 'pingback';
		} else {
			$myrow['comment_type'] = 'comment';
		}
	} else {
		$myrow['comment_ID']=$postc->comment_ID;
		$myrow['comment_post_ID']=$postc->comment_post_ID;
		$myrow['comment_author']=$postc->comment_author;
		$myrow['comment_author_email']=$postc->comment_author_email;
		$myrow['comment_author_url']=$postc->comment_author_url;
		$myrow['comment_author_IP']=$postc->comment_author_IP;
		$myrow['comment_date']=$postc->comment_date;
		$myrow['comment_content']=$postc->comment_content;
		$myrow['comment_karma']=$postc->comment_karma;
		if (strstr($myrow['comment_content'], '<trackback />')) {
			$myrow['comment_type'] = 'trackback';
		} elseif (strstr($myrow['comment_content'], '<pingback />')) {
			$myrow['comment_type'] = 'pingback';
		} else {
			$myrow['comment_type'] = 'comment';
		}
	}
	return $myrow;
}

function get_catname($cat_ID) {
	global $cache_catnames,$use_cache, $wpdb ,$wp_id;
	if ((!$cache_catnames[$wp_id]) || (!$use_cache)) {
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]}") or die('Oops, couldn\'t query the db for categories.');
		foreach ($results as $post) {
			$cache_catnames[$wp_id][$post->cat_ID] = $post->cat_name;
		}
	}
	$cat_name = $cache_catnames[$wp_id][$cat_ID];
	return $cat_name;
}

function profile($user_login) {
	global $user_data;
	echo "<a href='profile.php?user=".$user_data->user_login."' onclick=\"javascript:window.open('profile.php?user=".$user_data->user_login."','Profile','toolbar=0,status=1,location=0,directories=0,menuBar=1,scrollbars=1,resizable=0,width=480,height=320,left=100,top=100'); return false;\">$user_login</a>";
}
/*
function dropdown_categories($default = 0) {
	global $post,   $mode, $wpdb ,$wp_id;
	$categories = $wpdb->get_results("SELECT * FROM {$wpdb->categories[$wp_id]} ORDER BY cat_name");

	if ($post->ID) {
		$postcategories = $wpdb->get_col("
			SELECT category_id
			FROM  {$wpdb->categories[$wp_id]}, {$wpdb->post2cat[$wp_id]}
			WHERE {$wpdb->post2cat[$wp_id]}.category_id = cat_ID AND {$wpdb->post2cat[$wp_id]}.post_id = $post->ID
			");
	} else {
		$postcategories[] = $default;
	}
	$i =0;
	foreach($categories as $category) {
		++$i;
		$category->cat_name = stripslashes($category->cat_name);
		echo "\n<label for='category-$i' class='selectit'><input value='$category->cat_ID' type='checkbox' name='post_category[]' id='category-$i'";
		if ($postcategories && in_array($category->cat_ID, $postcategories))
			echo ' checked="checked"';
		echo " /> $category->cat_name</label> ";
	}

}
*/
function touch_time($edit = 1) {
	global $month, $postdata, $time_difference;
	// echo $postdata['Date'];
	if ('draft' == $postdata['post_status']) {
		$checked = 'checked="checked" ';
		$edit = false;
	} else {
		$checked = ' ';
	}

	echo '<p><input type="checkbox" class="checkbox" name="edit_date" value="1" id="timestamp" '.$checked.'/> <label for="timestamp">'._LANG_F_TIMESTAMP.'</label> : <a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#timestamp" title="Help on changing the timestamp">Help</a><br />';

	$time_adj = time() + ($time_difference * 3600);
	$jj = ($edit) ? mysql2date('d', $postdata['Date']) : date('d', $time_adj);
	$mm = ($edit) ? mysql2date('m', $postdata['Date']) : date('m', $time_adj);
	$aa = ($edit) ? mysql2date('Y', $postdata['Date']) : date('Y', $time_adj);
	$hh = ($edit) ? mysql2date('H', $postdata['Date']) : date('H', $time_adj);
	$mn = ($edit) ? mysql2date('i', $postdata['Date']) : date('i', $time_adj);
	$ss = ($edit) ? mysql2date('s', $postdata['Date']) : date('s', $time_adj);

	echo '<input type="text" name="jj" value="'.$jj.'" size="2" maxlength="2" />'."\n";
	echo "<select name=\"mm\">\n";
	for ($i=1; $i < 13; $i=$i+1) {
		echo "\t\t\t<option value=\"$i\"";
		if ($i == $mm)
		echo " selected='selected'";
		if ($i < 10) {
			$ii = "0".$i;
		} else {
			$ii = "$i";
		}
		echo ">".$month["$ii"]."</option>\n";
	} ?>
</select>
<input type="text" name="aa" value="<?php echo $aa ?>" size="4" maxlength="5" /> @
<input type="text" name="hh" value="<?php echo $hh ?>" size="2" maxlength="2" /> :
<input type="text" name="mn" value="<?php echo $mn ?>" size="2" maxlength="2" /> :
<input type="text" name="ss" value="<?php echo $ss ?>" size="2" maxlength="2" /> </p>
	<?php
}

function gzip_compression() {
	return;
	global $gzip_compressed;
		if (!$gzip_compressed) {
		$phpver = phpversion(); //start gzip compression
		if($phpver >= "4.0.4pl1") {
			if(extension_loaded("zlib")) {
				ob_start("ob_gzhandler");
			}
		} else if($phpver > "4.0") {
			if(strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
				if(extension_loaded("zlib")) {
					$do_gzip_compress = TRUE;
					ob_start();
					ob_implicit_flush(0);
					header("Content-Encoding: gzip");
				}
			}
		} //end gzip compression - that piece of script courtesy of the phpBB dev team
		$gzip_compressed=1;
	}
}

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

// functions to count the page generation time (from phpBB2)
// ( or just any time between timer_start() and timer_stop() )

function timer_start() {
    global $timestart;
    $mtime = microtime();
    $mtime = explode(" ",$mtime);
    $mtime = $mtime[1] + $mtime[0];
    $timestart = $mtime;
    return true;
}

function timer_stop($display=0,$precision=3) { //if called like timer_stop(1), will echo $timetotal
    global $timestart,$timeend;
    $mtime = microtime();
    $mtime = explode(" ",$mtime);
    $mtime = $mtime[1] + $mtime[0];
    $timeend = $mtime;
    $timetotal = $timeend-$timestart;
    if ($display)
        echo number_format($timetotal,$precision);
    return $timetotal;
}

// pings Weblogs.com
function pingWeblogs($blog_ID = 1) {
	// original function by Dries Buytaert for Drupal
	global  $siteurl,$my_pingserver;
	if ((!((get_settings('blogname')=="my weblog") && ($siteurl=="http://example.com"))) && (!preg_match("/localhost\//",$siteurl)) && (get_settings('use_weblogsping'))) {
		$message = new xmlrpcmsg("weblogUpdates.ping", array(new xmlrpcval(get_settings('blogname')), new xmlrpcval($siteurl."/index.php")));
		foreach($my_pingserver as $p) {
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

// pings Weblogs.com/rssUpdates
function pingWeblogsRss($blog_ID = 1, $rss_url) {
	global $use_weblogsrssping,  $rss_url;
	if (get_settings('blogname') != 'my weblog' && $rss_url != 'http://example.com/b2rdf.php' && $use_weblogsrssping) {
		$client = new xmlrpc_client('/RPC2', 'rssrpc.weblogs.com', 80);
		$message = new xmlrpcmsg('rssUpdate', array(new xmlrpcval(get_settings('blogname')), new xmlrpcval($rss_url)));
		$result = $client->send($message);
		if (!$result || $result->faultCode()) {
			return false;
		}
		return true;
	} else {
		return false;
	}
}

// pings Cafñ­og.com
function pingCafelog($cafelogID,$title='',$p='') {
	global $use_cafelogping,  $siteurl;
	if ((!((get_settings('blogname')=="my weblog") && ($siteurl=="http://example.com"))) && (!preg_match("/localhost\//",$siteurl)) && ($use_cafelogping) && ($cafelogID != '')) {
		$client = new xmlrpc_client("/xmlrpc.php", "cafelog.tidakada.com", 80);
		$message = new xmlrpcmsg("b2.ping", array(new xmlrpcval($cafelogID), new xmlrpcval($title), new xmlrpcval($p)));
		$result = $client->send($message);
		if (!$result || $result->faultCode()) {
			return false;
		}
		return true;
	} else {
		return false;
	}
}

// pings Blo.gs
function pingBlogs($blog_ID="1") {
	global   $use_rss,  $siteur;
	if ((!((get_settings('blogname')=='my weblog') && ($siteurl=='http://example.com'))) && (!preg_match('/localhost\//',$siteurl)) && (get_settings('use_blodotgsping'))) {
		$url = (get_settings('blodotgsping_url') == 'http://example.com') ? $siteurl.'/index.php' : get_settings('blodotgsping_url');
		$client = new xmlrpc_client('/', 'ping.blo.gs', 80);
		if ($use_rss) {
			$message = new xmlrpcmsg('weblogUpdates.extendedPing', array(new xmlrpcval(get_settings('blogname')), new xmlrpcval($url), new xmlrpcval($url), new xmlrpcval($siteurl.'/b2rss.xml')));
		} else {
			$message = new xmlrpcmsg('weblogUpdates.ping', array(new xmlrpcval(get_settings('blogname')), new xmlrpcval($url)));
		}
		$result = $client->send($message);
		if (!$result || $result->faultCode()) {
			return false;
		}
		return true;
	} else {
		return false;
	}
}


// Send a Trackback
function trackback($trackback_url, $title, $excerpt, $ID, $charset = "") {
	global  $wpdb,  $blog_charset ,$wp_id;
	$ID=intval($ID);
	$title = stripslashes($title);
	$excerpt = stripslashes($excerpt);
	$blog_name = stripslashes(get_settings('blogname'));
	if ($charset) {
		if (function_exists('mb_convert_encoding')) {
			$title = mb_convert_encoding($title,$charset,$blog_charset);
			$excerpt = mb_convert_encoding($excerpt,$charset,$blog_charset);
			$blog_name = mb_convert_encoding($blog_name,$charset,$blog_charset);
		}
	} else {
		$charset = $blog_charset;
	}
	$title1 = urlencode($title);
	$excerpt1 = urlencode($excerpt);
	$blog_name1 = urlencode($blog_name);
	$tb_url = $trackback_url;
	$url = urlencode(get_permalink($ID));
	$query_string = "title=$title1&url=$url&blog_name=$blog_name1&excerpt=$excerpt1&charset=$charset";
	$trackback_url = parse_url($trackback_url);
	if ($trackback_url['query']=="") {
		$http_request  = 'POST '.$trackback_url['path']." HTTP/1.0\r\n";
	} else {
		$http_request  = 'POST '.$trackback_url['path']."?".$trackback_url['query']." HTTP/1.0\r\n";
	}
	$http_request .= 'Host: '.$trackback_url['host']."\r\n";
	$http_request .= 'Content-Type: application/x-www-form-urlencoded; charset='.$charset."\r\n";
	$http_request .= 'Content-Length: '.strlen($query_string)."\r\n";
	$http_request .= "\r\n";
	$http_request .= $query_string;
	$fs = @fsockopen($trackback_url['host'], 80);
	@fputs($fs, $http_request);
	if(false) {
		$debug_file = '../log/trackback.log';
		$fp = fopen($debug_file, 'a');
		fwrite($fp, "\n*****\nRequest:\n\n$http_request\n\nResponse:\n\n");
		fwrite($fp, "CHARSET:$charset\n");
		fwrite($fp, "TITLE:$title\n");
		fwrite($fp, "TITLE1:".urldecode($title1)."\n");
		fwrite($fp, "EXCERPT:$excerpt\n");
		while(!@feof($fs)) {
			fwrite($fp, @fgets($fs, 4096));
		}
		fwrite($fp, "\n\n");
		fclose($fp);
	}
	@fclose($fs);
	$wpdb->query("UPDATE {$wpdb->posts[$wp_id]} SET pinged = CONCAT(pinged, '\n', '$tb_url') WHERE ID = $ID");
	$wpdb->query("UPDATE {$wpdb->posts[$wp_id]} SET to_ping = REPLACE(to_ping, '$tb_url', '') WHERE ID = $ID");
	return $result;
}

// trackback - reply
function trackback_response($error = 0, $error_message = '') {
	global $blog_charset;
	if ($error) {
		echo "<?xml version=\"1.0\" encoding=\"$blog_charset\"?".">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
	} else {
		echo "<?xml version=\"1.0\" encoding=\"$blog_charset\"?".">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
	die();
}

function make_url_footnote($content) {
	global $siteurl;
	preg_match_all('/<a(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/', $content, $matches);
	$j = 0;
	for ($i=0; $i<count($matches[0]); $i++) {
		$links_summary = (!$j) ? "\n" : $links_summary;
		$j++;
		$link_match = $matches[0][$i];
		$link_number = '['.($i+1).']';
		$link_url = $matches[2][$i];
		$link_text = $matches[4][$i];
		$content = str_replace($link_match, $link_text.' '.$link_number, $content);
		$link_url = (strtolower(substr($link_url,0,7)) != 'http://') ? $siteurl.$link_url : $link_url;
		$links_summary .= "\n".$link_number.' '.$link_url;
	}
	$content = strip_tags($content);
	$content .= $links_summary;
	return $content;
}


function xmlrpc_getposttitle($content) {
	global $post_default_title;
	if (preg_match('/<title>(.+?)<\/title>/is', $content, $matchtitle)) {
		$post_title = $matchtitle[0];
		$post_title = preg_replace('/<title>/si', '', $post_title);
		$post_title = preg_replace('/<\/title>/si', '', $post_title);
	} else {
		$post_title = $post_default_title;
	}
	return $post_title;
}

function xmlrpc_getpostcategory($content) {
	global $post_default_category;
	if (preg_match('/<category>(.+?)<\/category>/is', $content, $matchcat)) {
		$post_category = $matchcat[0];
		$post_category = preg_replace('/<category>/si', '', $post_category);
		$post_category = preg_replace('/<\/category>/si', '', $post_category);

	} else {
		$post_category = $post_default_category;
	}
	return $post_category;
}

function xmlrpc_removepostdata($content) {
	$content = preg_replace('/<title>(.+?)<\/title>/si', '', $content);
	$content = preg_replace('/<category>(.+?)<\/category>/si', '', $content);
	$content = trim($content);
	return $content;
}

function debug_fopen($filename, $mode) {
	global $debug;
	if ($debug == 1) {
		$fp = fopen($filename, $mode);
		return $fp;
	} else {
		return false;
	}
}

function debug_fwrite($fp, $string) {
	global $debug;
	if ($debug == 1) {
		fwrite($fp, $string);
	}
}

function debug_fclose($fp) {
	global $debug;
	if ($debug == 1) {
		fclose($fp);
	}
}

function pingback($content, $post_ID) {
	// original code by Mort (http://mort.mine.nu:8080)
	global $siteurl, $wp_version;
	$log = debug_fopen('./pingback.log', 'a');
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
		$request = "GET $path HTTP/1.1\r\nHost: $host\r\nUser-Agent: WordPress/$wp_version PHP/" . phpversion() . "\r\n\r\n";
		ob_end_flush();
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

function pingGeoURL($blog_ID) {
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
    global $wpdb, $wp_id;

    switch($comment_status) {
		case 'hold':
			$query = "UPDATE {$wpdb->comments[$wp_id]} SET comment_approved='0' WHERE comment_ID='$comment_id' LIMIT 1";
		break;
		case 'approve':
			$query = "UPDATE {$wpdb->comments[$wp_id]} SET comment_approved='1' WHERE comment_ID='$comment_id' LIMIT 1";
		break;
		case 'delete':
			$query = "DELETE FROM {$wpdb->comments[$wp_id]} WHERE comment_ID='$comment_id' LIMIT 1";
		break;
		default:
			return false;
    }

    if ($wpdb->query($query)) {
		return true;
    } else {
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
    global $wpdb, $wp_id;

    $result = $wpdb->get_var("SELECT comment_approved FROM {$wpdb->comments[$wp_id]} WHERE comment_ID='$comment_id' LIMIT 1");
    if ($result == NULL) {
        return "deleted";
    } else if ($result == "1") {
        return "approved";
    } else if ($result == "0") {
        return "unapproved";
    } else {
        return false;
    }
}

function wp_notify_postauthor($comment_id, $comment_type='comment') {
	global $blog_charset;
    global $wpdb;
    global  $siteurl ,$wp_id;

    $comment = $wpdb->get_row("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_ID='$comment_id' LIMIT 1");
    if (!$comment) return false;
    $post = $wpdb->get_row("SELECT * FROM {$wpdb->posts[$wp_id]} WHERE ID='$comment->comment_post_ID' LIMIT 1");
    $user = $wpdb->get_row("SELECT * FROM {$wpdb->users[$wp_id]} WHERE ID='$post->post_author' LIMIT 1");

    if ('' == $user->user_email) return false; // If there's no email to send the comment to

	$comment_author_domain = gethostbyaddr($comment->comment_author_IP);

	$blogname = stripslashes(get_settings('blogname'));

	if ('comment' == $comment_type) {
		$notify_message  = _LANG_F_NEW_COMMENT." #$comment->comment_post_ID ".stripslashes($post->post_title)."\r\n\r\n";
		$notify_message .= "Author : $comment->comment_author (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
		$notify_message .= "E-mail : $comment->comment_author_email\r\n";
		$notify_message .= "URI    : $comment->comment_author_url\r\n";
		$notify_message .= "Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=$comment->comment_author_IP\r\n";
		if (function_exists('mb_convert_encoding')) {
			$notify_message .= "Comment:\r\n".stripslashes(mb_convert_encoding($comment->comment_content,$blog_charset,"auto"))."\r\n\r\n";
		} else {
			$notify_message .= "Comment:\r\n".stripslashes($comment->comment_content)."\r\n\r\n";
		}
		$notify_message .= _LANG_F_ALL_COMMENTS." \r\n";
		$subject = '[' . $blogname . '] Comment: "' .stripslashes($post->post_title).'"';
	} elseif ('trackback' == $comment_type) {
		$notify_message  = _LANG_F_NEW_TRACKBACK." #$comment_post_ID ".stripslashes($post->post_title)."\r\n\r\n";
		if (function_exists('mb_convert_encoding')) {
			$notify_message .= "Website: ".mb_convert_encoding($comment->comment_author,$blog_charset,"auto")." (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
		} else {
			$notify_message .= "Website: ".$comment->comment_author." (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
		}
		$notify_message .= "URI    : $comment->comment_author_url\r\n";
		if (function_exists('mb_convert_encoding')) {
			$notify_message .= "Comment:\r\n".stripslashes(mb_convert_encoding($comment->comment_content,$blog_charset,"auto"))."\r\n\r\n";
		} else {
			$notify_message .= "Comment:\r\n".stripslashes($comment->comment_content)."\r\n\r\n";
		}
		$notify_message .= _LANG_F_ALL_TRACKBACKS." \r\n";
		$subject = '[' . $blogname . '] Trackback: "' .stripslashes($post->post_title).'"';
	} elseif ('pingback' == $comment_type) {
		$notify_message  = _LANG_F_NEW_PINGBACK." #$comment_post_ID ".stripslashes($post->post_title)."\r\n\r\n";
		$notify_message .= "Website: $comment->comment_author\r\n";
		$notify_message .= "URI    : $comment->comment_author_url\r\n";
		if (function_exists('mb_convert_encoding')) {
			$notify_message .= "Excerpt: \n[...] ".mb_convert_encoding($original_context,$blog_charset,"auto")." [...]\r\n\r\n";
		} else {
			$notify_message .= "Excerpt: \n[...] ".$original_context." [...]\r\n\r\n";
		}
		$notify_message .= _LANG_F_ALL_PINGBACKS." \r\n";
		$subject = '[' . $blogname . '] Pingback: "' .stripslashes($post->post_title).'"';
	}
	$notify_message .= get_permalink($comment->comment_post_ID) . '#comments';

	if ('' == $comment->comment_author_email || '' == $comment->comment_author) {
		if (function_exists('mb_convert_encoding')) {
			$from = "From: \"". mb_encode_mimeheader(mb_convert_encoding($blogname,"JIS","auto")) ."\" <wordpress@" . $_SERVER['SERVER_NAME'] . '>';
		} else {
			$from = "From: \"". $blogname ."\" <wordpress@" . $_SERVER['SERVER_NAME'] . '>';
		}
	} else {
		if (function_exists('mb_convert_encoding')) {
			$from = 'From: "' . stripslashes(mb_encode_mimeheader(mb_convert_encoding($comment->comment_author,"JIS","auto"))) . "\" <$comment->comment_author_email>";
		} else {
			$from = 'From: "' . stripslashes($comment->comment_author) . "\" <$comment->comment_author_email>";
		}
	}

	if (function_exists('mb_send_mail')) {
		mb_send_mail($user->user_email, $subject, $notify_message, $from);
	} else {
		@mail($user->user_email, $subject, $notify_message, $from);
	}

    return true;
}

/* wp_notify_moderator
   notifies the moderator of the blog (usually the admin)
   about a new comment that waits for approval
   always returns true
 */
function wp_notify_moderator($comment_id) {
    global $wpdb;
    global  $siteurl ,$wp_id;

    $comment = $wpdb->get_row("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_ID='$comment_id' LIMIT 1");
    $post = $wpdb->get_row("SELECT * FROM {$wpdb->posts[$wp_id]} WHERE ID='$comment->comment_post_ID' LIMIT 1");
    $user = $wpdb->get_row("SELECT * FROM {$wpdb->users[$wp_id]} WHERE ID='$post->post_author' LIMIT 1");

    $comment_author_domain = gethostbyaddr($comment->comment_author_IP);
    $comments_waiting = $wpdb->get_var("SELECT count(comment_ID) FROM {$wpdb->comments[$wp_id]} WHERE comment_approved = '0'");

    $notify_message  = _LANG_F_COMMENT_POST." #$comment->comment_post_ID ".stripslashes($post->post_title)._LANG_F_WAITING_APPROVAL."\r\n\r\n";
    $notify_message .= "Author : $comment->comment_author (IP: $comment->comment_author_IP , $comment_author_domain)\r\n";
    $notify_message .= "E-mail : $comment->comment_author_email\r\n";
    $notify_message .= "URL    : $comment->comment_author_url\r\n";
    $notify_message .= "Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=$comment->comment_author_IP\r\n";
    $notify_message .= "Comment:\r\n".stripslashes($comment->comment_content)."\r\n\r\n";
    $notify_message .= _LANG_F_APPROVAL_VISIT." $siteurl/wp-admin/post.php?action=mailapprovecomment&p=".$comment->comment_post_ID."&comment=$comment_id\r\n";
    $notify_message .= _LANG_F_DELETE_VISIT." $siteurl/wp-admin/post.php?action=confirmdeletecomment&p=".$comment->comment_post_ID."&comment=$comment_id\r\n";
    $notify_message .= "\"$comments_waiting\""._LANG_F_PLEASE_VISIT."\r\n";
    $notify_message .= "$siteurl/wp-admin/moderation.php\r\n";

    $subject = '[' . stripslashes(get_settings('blogname')) . '] Please approve: "' .stripslashes($post->post_title).'"';
    $from  = "From: ".get_settings('admin_email');

    if (function_exists('mb_send_mail')) {
	    mb_send_mail(get_settings('admin_email'), $subject, $notify_message, $from);
    } else {
	    @mail(get_settings('admin_email'), $subject, $notify_message, $from);
    }

    return true;
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

function start_wp() {
	global $post, $id, $postdata, $authordata, $day, $preview, $page, $pages, $multipage, $more, $numpages;
	global $preview_userid,$preview_date,$preview_content,$preview_title,$preview_category,$preview_notify,$preview_make_clickable,$preview_autobr;
	global $pagenow,$wp_id;
	if (!$preview) {
		$id = $post->ID;
	} else {
		$id = 0;
		$postdata = array (
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
	$authordata = get_userdata($post->post_author);
	$day = mysql2date('d.m.y', $post->post_date);
	$currentmonth = mysql2date('m', $post->post_date);
	$numpages = 1;
	if (!$page)
		$page = 1;
	if (isset($p))
		$more = 1;
	$content = $post->post_content;
	if (preg_match('/<!--nextpage-->/', $post->post_content)) {
		if ($page > 1)
			$more = 1;
		$multipage = 1;
		$content = stripslashes($post->post_content);
		$content = str_replace("\n<!--nextpage-->\n", '<!--nextpage-->', $content);
		$content = str_replace("\n<!--nextpage-->", '<!--nextpage-->', $content);
		$content = str_replace("<!--nextpage-->\n", '<!--nextpage-->', $content);
		$pages = explode('<!--nextpage-->', $content);
		$numpages = count($pages);
	} else {
		$pages[0] = stripslashes($post->post_content);
		$multipage = 0;
	}
	return true;
}

function is_new_day() {
	global $day, $previousday;
	if ($day != $previousday) {
		return(1);
	} else {
		return(0);
	}
}
// Filters: these are the core of WP's plugin architecture

function apply_filters($tag, $string) {
	global $wp_filter, $wp_id;;
	if (isset($wp_filter[$wp_id]['all'])) {
		foreach ($wp_filter[$wp_id]['all'] as $priority => $functions) {
			if (isset($wp_filter[$wp_id][$tag][$priority]))
				$wp_filter[$wp_id][$tag][$priority] = array_merge($wp_filter[$wp_id]['all'][$priority], $wp_filter[$wp_id][$tag][$priority]);
			else
				$wp_filter[$wp_id][$tag][$priority] = array_merge($wp_filter[$wp_id]['all'][$priority], array());
			$wp_filter[$wp_id][$tag][$priority] = array_unique($wp_filter[$wp_id][$tag][$priority]);
		}

	}
	
	if (isset($wp_filter[$wp_id][$tag])) {
		ksort($wp_filter[$wp_id][$tag]);
		foreach ($wp_filter[$wp_id][$tag] as $priority => $functions) {
			foreach($functions as $function) {
//					if ($tag == "the_content") echo $function."<br>\n";
					$string = $function($string);
			}
		}
	}
	return $string;
}

function add_filter($tag, $function_to_add, $priority = 10) {
	global $wp_filter, $wp_id;
	// So the format is wp_filter[$wp_id]['tag']['array of priorities']['array of functions']
	if (!@in_array($function_to_add, $wp_filter[$wp_id][$tag]["$priority"])) {
		$wp_filter[$wp_id][$tag]["$priority"][] = $function_to_add;
	}
	return true;
}

function remove_filter($tag, $function_to_remove, $priority = 10) {
	global $wp_filter, $wp_id;;
	if (@in_array($function_to_remove, $wp_filter[$wp_id][$tag]["$priority"])) {
		$new_function_list = array();
		foreach ($wp_filter[$wp_id][$tag]["$priority"] as $function) {
			if ($function_to_remove != $function) {
				$new_function_list[] = $function;
			}
		}
		if (!count($new_function_list)) {
			if (!empty($wp_filter[$wp_id][$tag]["$priority"])) {
				unset($wp_filter[$wp_id][$tag]["$priority"]);
			}
		} else {
			$wp_filter[$wp_id][$tag]["$priority"] = $new_function_list;
		}
	}
	//die(var_dump($wp_filter));
	return true;
}
// The *_action functions are just aliases for the *_filter functions, they take special strings instead of generic content

function do_action($tag, $string) {
	return apply_filters($tag, $string);
}

function add_action($tag, $function_to_add, $priority = 10) {
	add_filter($tag, $function_to_add, $priority);
}

function remove_action($tag, $function_to_remove, $priority = 10) {
	remove_filter($tag, $function_to_remove, $priority);
}

function wp_head() {
	do_action('wp_head', '');
}

function mb_conv($str,$to,$from)
{
	if (function_exists('mb_convert_encoding')) {
		$retstr = mb_convert_encoding($str,$to,$from);
	} else {
		$retstr = $str;
	}
	return $retstr;
}
/* rewrite_rules
 * Construct rewrite matches and queries from permalink structure.
 * matches - The name of the match array to use in the query strings.
 *           If empty, $1, $2, $3, etc. are used.
 * Returns an associate array of matches and queries.
 */
function rewrite_rules($matches = '', $permalink_structure = '') {

    function preg_index($number, $matches = '') {
        $match_prefix = '$';
        $match_suffix = '';
        
        if (! empty($matches)) {
            $match_prefix = '$' . $matches . '['; 
                                               $match_suffix = ']';
        }        
        
        return "$match_prefix$number$match_suffix";        
    }
    
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
    $trackbackquery = 'wp-trackback.php?';
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

    // Site feed
    $sitefeedmatch = 'feed/?([_0-9a-z-]+)?/?$';
    $sitefeedquery = 'wp-feed.php?feed=' . preg_index(1, $matches);

    // Site comment feed
    $sitecommentfeedmatch = 'comments/feed/?([_0-9a-z-]+)?/?$';
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
	global $wpdb, $tableposts;
	parse_str($args, $r);
	if (!isset($r['numberposts'])) $r['numberposts'] = 5;
	if (!isset($r['offset'])) $r['offset'] = 0;
	// The following not implemented yet
	if (!isset($r['category'])) $r['category'] = '';
	if (!isset($r['orderby'])) $r['orderby'] = '';
	if (!isset($r['order'])) $r['order'] = '';

	$now = current_time('mysql');

	$posts = $wpdb->get_results("SELECT DISTINCT * FROM $tableposts WHERE post_date <= '$now' AND (post_status = 'publish') GROUP BY $tableposts.ID ORDER BY post_date DESC LIMIT " . $r['offset'] . ',' . $r['numberposts']);
	
	return $posts;
}

function check_comment($author, $email, $url, $comment, $user_ip) {
	if (1 == get_settings('comment_moderation')) return false; // If moderation is set to manual

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

// Check for hacks file if the option is enabled
if (get_settings('hack_file')) {
	if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'.(($wp_id=='-') ?'':$wp_id) . '/my-hacks.php'))
		require(XOOPS_ROOT_PATH.'/modules/wordpress'.(($wp_id=='-') ?'':$wp_id) . '/my-hacks.php');
}

function get_xoops_option($dirname,$conf_name) {
	global $xoopsDB;

    $query = "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname='".$dirname."' ";
	$result = $xoopsDB->query($query);
	$record= $xoopsDB->fetcharray($result);
	$mid = $record['mid'];
    
	$query = "SELECT conf_value,conf_valuetype FROM ".$xoopsDB->prefix('config')." WHERE conf_modid=".$mid." AND conf_name='".$conf_name."' ";
	$result = $xoopsDB->query($query);
	$record= $xoopsDB->fetcharray($result);
	$value = $record['conf_value'];
	$valuetype = $record['conf_valuetype'];
	
    switch ($valuetype) {
    case 'int':
        return intval($value);
        break;
    case 'array':
        return unserialize($value);
    case 'float':
        return (float)$value;
        break;
    case 'textarea':
        return $value;
    default:
        return $value;
        break;
    }
	
	return($value);
}
function block_style_get($wp_num, $echo = 'true') {
global $xoopsConfig;

	if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. $wp_num .'/themes/'.$xoopsConfig['theme_set'].'/wp-blocks.css.php')) {
		$themes = $xoopsConfig['theme_set'];
	} else {
		$themes = "default";
	}
	$wp_block_style="";
	include_once(XOOPS_ROOT_PATH."/modules/wordpress". $wp_num ."/themes/".$themes."/wp-blocks.css.php");
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
    global $siteurl;
	$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_ENV['HTTP_REFERER'];
	if ($ref == '') {
		if ($redirect) {
			if (defined('XOOPS_URL')) { //XOOPS Module mode
				redirect_header($siteurl, 1, "You cannot update Database contents.(Could not detect HTTP_REFERER)");
			} else {
				header("Location: $siteurl");
			}
		}
		return false;
	}
	if (strpos($ref, $siteurl.$offset) !== 0 ) {
		if ($redirect) {
			if (defined('XOOPS_URL')) { //XOOPS Module mode
				redirect_header($siteurl, 1, "You cannot update Database contents.(HTTP_REFERER is not valid site.)");
			} else {
				header("Location: $siteurl");
			}
		}
		return false;
	}
	return true;
}

function wp_get_rss_charset() {
  global $blog_charset;
	if (function_exists('mb_convert_encoding')) {
		if ($blog_charset != 'iso-8859-1') {
			$rss_charset = 'utf-8';
		} else {
			$rss_charset = $blog_charset;
		}
	}else{
		$rss_charset = $blog_charset;
	}
	return $rss_charset;
}

function wp_convert_rss_charset($srcstr) {
  global $blog_charset;
	$rss_charset = wp_get_rss_charset();
	if ($blog_charset != $rss_charset) {
		return mb_convert_encoding($srcstr,  $rss_charset, $blog_charset);
	} else {
		return $srcstr;
	}
}
function trailingslashit($string) {
    if ( '/' != substr($string, -1)) {
        $string .= '/';
    }
    return $string;
}

function get_version() {
	$old_stat=error_reporting(0);
	include (dirname(dirname(__FILE__))."/xoops_version.php");
	error_reporting($old_stat);
	return $modversion['version'];
}
?>
