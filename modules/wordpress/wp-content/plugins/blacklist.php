<?php
/*
Plugin Name: Blacklist
Plugin URI: http://www.farook.org
Description: Checks each entered comment against a standard blacklist and either approves or holds the comment for later approval or automatically deletes it. Also allows you to work with comments in the moderation queue so that you can harvest information to add to the blacklist while mass-deleting held comments.<BR /><a href="wpblacklist.php?action=install">Blacklist Installer</a><BR /><a href="wpblacklist.php">Blacklist Configuration</a>
Version: 2.6.1
Author: Fahim Farook
Author URI: http://www.farook.org
*/

//require_once(ABSPATH.'/wp-config.php');
require_once(ABSPATH.'/wp-includes/wpblfunctions.php');
$tableblacklist = $xoopsDB->prefix("wp_blacklist");

/*
   notifies the moderator of the blog (usually the admin) about deleted comments
   always returns true
 */
function wpbl_notify($comment_id, $reason, $harvest) {
    global $wpdb, $wp_id, $url, $email, $comment, $user_ip, $comment_post_ID, $author, $tableposts;
	
	$tableposts = $wpdb->posts[$wp_id];
    $sql = "SELECT * FROM $tableposts WHERE ID='$comment_post_ID' LIMIT 1";
    $post = $wpdb->get_row($sql);
    if (!empty($user_ip)) {
        $comment_author_domain = gethostbyaddr($user_ip);
    } else {
        $comment_author_domain = '';
    }
    // create the e-mail body
    $notify_message  = "A new comment on post #$comment_post_ID \"".stripslashes($post->post_title)."\" has been automatically deleted by the WPBlacklist plugin.\r\n\r\n";
    $notify_message .= "Author : $author (IP: $user_ip , $comment_author_domain)\r\n";
    $notify_message .= "E-mail : $email\r\n";
    $notify_message .= "URL    : $url\r\n";
    $notify_message .= "Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=$user_ip\r\n";
    $notify_message .= "Comment:\r\n".stripslashes($comment)."\r\n\r\n";
    $notify_message .= "Triggered by : $reason\r\n\r\n";
    // add harvested info - if there is any
    if (!empty($harvest)) {
        $notify_message .= "Harvested the following information:\r\n". stripslashes($harvest);
    }
    // e-mail header
    $subject = '[' . stripslashes(get_settings('blogname')) . '] Automatically deleted: "' .stripslashes($post->post_title).'"';
    $admin_email = get_settings("admin_email");
    $from  = "From: $admin_email";
    // send e-mail
	if (function_exists('mb_send_mail')) {
		mb_send_mail($admin_email, $subject, $notify_message, $from);
	} else {
		@mail($admin_email, $subject, $notify_message, $from);
	}
    return true;
}

/*
  this function harvests blacklist info, e-mails moderator (if necessary) and deletes the comment
  return true on successful deletion, false otherwise
 */
function mail_and_del($commentID, $reason) {
    global $wpdb, $wpbl_options, $url, $email, $comment, $user_ip,$tableblacklist;

    $info = '';
    // harvest information - if necessary
    if (in_array('harvestinfo', $wpbl_options)) {
        // Add author e-mail to blacklist
        $buf = sanctify($email);
        $request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
        if (!$request) {
            $wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','url')");
            $info .= "Author e-mail: $email\r\n";
        }
        // Add author IP to blacklist
        $buf = sanctify($user_ip);
        $request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
        if (!$request) {
            $wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','ip')");
            $info .= "Author IP: $user_ip\r\n";
        }
        // get the author's url without the prefix stuff
        $regex   = "/([a-z]*)(:\/\/)([a-z]*\.)?(.*)/i";
        preg_match($regex, $url, $matches);
        if (strcasecmp('www.', $matches[3]) == 0) {
            $buf = $matches[4];
        } else {
            $buf = $matches[3] . $matches[4];
        }
        $buf = remove_trailer($buf);
        $buf = sanctify($buf);
        $request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
        if (!$request) {
            $wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','url')");
            $info .= "Author URL: $buf\r\n";
        }
        // harvest links found in comment
        $regex = "/([a-z]*)(:\/\/)([a-z]*\.)?([^\">\s]*)/im";
        preg_match_all($regex, $comment, $matches);
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
            $buf = remove_trailer($buf);
            $buf = sanctify($buf);
            $request = $wpdb->get_row("SELECT id FROM $tableblacklist WHERE regex='$buf'");
            if (!$request) {
                $wpdb->query("INSERT INTO $tableblacklist (regex, regex_type) VALUES ('$buf','url')");
                $info .= "Comment URL: $buf\r\n";
            }
        } // for
    }
    // send e-mail first since details won't be there after delete :p
    if (in_array('sendmail', $wpbl_options)) {
        wpbl_notify($commentID, $reason, $info);
    }
    if (wp_set_comment_status($commentID, 'delete')) {
        return true;
    } else {
        return false;
    }
}

/*
  the main function which approves/holds/deletes comments based on the internal blacklist
 */
function blacklist($commentID) {
    global $wpdb, $url, $email, $comment, $user_ip, $wpbl_options, $tablecomments, $tableblacklist;

//    $row = $wpdb->get_row("SELECT * FROM $tablecomments WHERE comment_ID='$commentID'");
//    echo "Author: $row->comment_author<br />";
    // first check the comment status based on WP core moderation
    $stat = wp_get_comment_status($commentID);
    if ($stat == 'deleted') {
        // no need to proceed since there is no comment
        return;
    } else if ($stat == 'unapproved') {
        $approved = False;
    } else {
        $approved = True;
    }
    // are we supposed to delete comments held by the core?
    if (!$approved && in_array('deletecore', $wpbl_options)) {
        mail_and_del($commentID, "Mail held for moderation outside WPBlacklist");
        return;
    }
    // IP check
    $sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='ip'");
    if ($sites) {
        foreach ($sites as $site)  {
            $regex = "/^$site->regex/";
            if (preg_match($regex, $user_ip)) {
                $approved = False;
                if (in_array('deleteip', $wpbl_options)) {
                    mail_and_del($commentID, "Author IP: $user_ip matched $regex");
                    return;
                }
                break;
            }
        }
    }
    // RBL check
    if ($approved || in_array('deleterbl', $wpbl_options)) {
        $sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='rbl'");
        if ($sites) {
            foreach ($sites as $site)  {
                $regex = $site->regex;
                if (preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)/", $user_ip, $matches)) {
                    $rblhost = $matches[4] . "." . $matches[3] . "." . $matches[2] . "." . $matches[1] . "." . $regex;
                    $resolved = gethostbyname($rblhost);
                    if ($resolved != $rblhost) {
                        $approved = False;
                        if (in_array('deleterbl', $wpbl_options)) {
                            mail_and_del($commentID, "Author IP: $user_ip blacklisted by RBL $regex");
                            return;
                        }
                        break;
                    }
                }
            }
        }
    }
    // expression check
    if ($approved || in_array('deletemail', $wpbl_options) || in_array('deleteurl', $wpbl_options) || in_array('delcommurl', $wpbl_options)) {
        $sites = $wpdb->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='url'");
        if ($sites) {
            foreach ($sites as $site)  {
                $regex = "/$site->regex/i";
//                echo "Regex: $regex <br />";
                if (preg_match($regex, $url)) {
                    $approved = False;
                    if (in_array('deleteurl', $wpbl_options)) {
                        mail_and_del($commentID, "Author URL: $url matched $regex");
                        return;
                    }
                    break;
                }
                if (preg_match($regex, $email)) {
                    $approved = False;
                    if (in_array('deletemail', $wpbl_options)) {
                        mail_and_del($commentID, "Author e-mail: $email matched $regex");
                        return;
                    }
                    break;
                }
                if (preg_match($regex, $comment)) {
                    $approved = False;
                    if (in_array('delcommurl', $wpbl_options)) {
                        mail_and_del($commentID, "Comment text contained $regex");
                        return;
                    }
                    break;
                }
            }
        }
    }
    if ($approved) {
        wp_set_comment_status($commentID, 'approve');
    } else {
        wp_set_comment_status($commentID, 'hold');
    }
}

function wpblmenu() {
	global $menu, $submenu;
	$menu[46] = array('BlackList', 4, 'wpblacklist.php');
	$submenu['wpblacklist.php'][5] =array('Manage', 4, 'wpblacklist.php');
	$submenu['wpblacklist.php'][10] =array('Search', 4, 'wpblsearch.php');
	$submenu['wpblacklist.php'][15] =array('Moderate', 4, 'wpblmoderate.php');
}

// set up the options array
$wpbl_options = array();
// load options from DB
$sql = "SELECT * FROM $tableblacklist WHERE regex_type = 'option'";
$results = $wpdb->get_results($sql);
if ($results) {
    foreach ($results as $result) {
        $wpbl_options[] = $result->regex;
    }
}

// the hook
add_action('comment_post', 'blacklist');
add_action('trackback_post', 'blacklist');
add_action('admin_menu', 'wpblmenu');
?>
