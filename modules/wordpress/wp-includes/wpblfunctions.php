<?php
if( ! defined( 'WP_WPBLFUNCTIONS_INCLUDED' ) ) {
	define( 'WP_WPBLFUNCTIONS_INCLUDED' , 1 ) ;

/*
 clean a given string so that it will work with regex
 */
function sanctify($url, $sqlsafe = True) {
	// modify Jay Allen stuff to work with PHP
	if (strpos($url, '[\w\-_.]')) {
		$url = str_replace('[\w\-_.]','[-\w\_.]',$url);
	}
	// get rid of all unescaped forwardslashes
	$ps = strpos($url, '/');
	while ($ps !== False) {
		if ($ps == 1) {
			// slash at beginning, escape
			$url = '\\' + $url;
		} else if (substr($url, $ps-1, 1) != '\\') {
			$url = substr_replace($url, '\/', $ps, 1);
		}
		$ps = strpos($url, '/', $ps+2);
	}
	if ($sqlsafe) {
		return mysql_escape_string(trim($url));
	} else {
		return $url;
	}
}

/*
 Get information from a given comment to add to the blacklist
 */
function harvest($commentID) {
    global $wpdb;
	$tableblacklist = $GLOBALS['xoopsDB']->prefix("wp_blacklist");

	$info = '';
	$details = $wpdb->get_row("SELECT * FROM ".wp_table('comments')." WHERE comment_ID = $commentID");
	if ($details) {
		// Add author e-mail to blacklist - if it isn't blank
		if (!empty($details->comment_author_email)) {
			$buf = sanctify($details->comment_author_email);
			$request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
			if (!$request) {
				$wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','url')");
				$info .= "Author e-mail: $details->comment_author_email\r\n";
			}
		}
		// Add author IP to blacklist
		$buf = sanctify($details->comment_author_IP);
		$request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
		if (!$request) {
			$wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','ip')");
			$info .= "Author IP: $details->comment_author_IP\r\n";
		}
		// get the author's url without the prefix stuff - if it isn't blank
		if (!empty($details->comment_author_url)) {
			$regex   = "/([a-z]*)(:\/\/)([a-z]*\.)?(.*)/i";
			preg_match($regex, $details->comment_author_url, $matches);
			if (strcasecmp('www.', $matches[3]) == 0) {
				$buf = $matches[4];
			} else {
				$buf = $matches[3] . $matches[4];
			}
			$buf = remove_trailingslash($buf);
			$buf = sanctify($buf);
			$request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
			if (!$request) {
				$wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','url')");
				$info .= "Author URL: $buf\r\n";
			}
		}
		// harvest links found in comment
		$regex = "/([a-z]*)(:\/\/)([a-z]*\.)?([^\"><\s]*)/im";
		preg_match_all($regex, $details->comment_content, $matches);
		for ($i=0; $i < count($matches[4]); $i++ ) {
			if (strcasecmp('www.', $matches[3][$i]) == 0) {
				$buf = $matches[4][$i];
			} else {
				$buf = $matches[3][$i] . $matches[4][$i];
			}
			$ps = strrpos($buf, '/');
			if ($ps) {
				$buf = substr($buf, 0, $ps);
			}
			$buf = remove_trailingslash($buf);
			$buf = sanctify($buf);
			$request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
			if (!$request) {
				$wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','url')");
				$info .= "Comment URL: $buf\r\n";
			}
		} // for
	}
	return $info;
}
}
?>
