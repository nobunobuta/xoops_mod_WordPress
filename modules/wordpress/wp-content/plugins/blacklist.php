<?php
/*
Plugin Name: Blacklist
Plugin URI: http://www.farook.org
Description: Checks each entered comment against a standard blacklist and either approves or holds the comment for later approval or automatically deletes it. Also allows you to work with comments in the moderation queue so that you can harvest information to add to the blacklist while mass-deleting held comments. If it's your first time you can use the <a href="../blacklist-install.php">Blacklist Installer</a> or you can simply go to the <a href="wpblacklist.php">Blacklist Configuration</a> screen.
Version: 2.9
Author: Fahim Farook
Author URI: http://www.farook.org
*/

require_once(wp_base() .'/wp-includes/wpblfunctions.php');
$tableblacklist = $GLOBALS['xoopsDB']->prefix("wp_blacklist");

/*
   notifies the moderator of the blog (usually the admin) about deleted comments
   always returns true
 */
function wpbl_notify($comment_id, $reason, $harvest) {
    global $wbbl_comment;
	
	$tableposts = wp_table('posts');
    $sql = "SELECT * FROM $tableposts WHERE ID='{$wbbl_comment['comment_post_ID']}' LIMIT 1";
    $post = $GLOBALS['wpdb']->get_row($sql);
    if (!empty($wpbl_comment['comment_author_IP'])) {
        $comment_author_domain = gethostbyaddr($wpbl_comment['comment_author_IP']);
    } else {
        $comment_author_domain = '';
    }
    // create the e-mail body
    $notify_message  = "A new ";
    if ($wpbl_comment['comment_type'] == '') {
        $notify_message .= "Comment";
    } else if ($wpbl_comment['comment_type'] == 'trackback') {
        $notify_message .= "TrackBack";
    } else if ($wpbl_comment['comment_type'] == 'pingback') {
        $notify_message .= "PingBack";
    }
    $notify_message .= " on post #{$wbbl_comment['comment_post_ID']} \"".stripslashes($post->post_title)."\" has been automatically deleted by the WPBlacklist plugin.\r\n\r\n";
    $notify_message .= "Author : {$wpbl_comment['comment_author']} (IP: {$wpbl_comment['comment_author_IP']} , $comment_author_domain)\r\n";
    $notify_message .= "E-mail : {$wpbl_comment['comment_author_email']}\r\n";
    $notify_message .= "URL    : {$wpbl_comment['comment_author_url']}\r\n";
    $notify_message .= "Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput={$wpbl_comment['comment_author_IP']}\r\n";
    $notify_message .= "Comment:\r\n".stripslashes($wpbl_comment['comment_content'])."\r\n\r\n";
    $notify_message .= "Triggered by : $reason\r\n\r\n";
    // add harvested info - if there is any
    if (!empty($harvest)) {
        $notify_message .= "Harvested the following information:\r\n". stripslashes($harvest);
    }
    // e-mail header
    $subject = '[' . stripslashes(get_settings('blogname')) . '] Automatically deleted: "' .stripslashes($post->post_title).'"';
    $admin_email = get_settings("admin_email");
    $from  = "From: $admin_email";
	if (strtolower(get_settings('blog_charset'))=="euc-jp") {
		$mail_charset = "iso-2022-jp";
	} else {
		$mail_charset = get_settings('blog_charset');
	}
    $message_headers = "MIME-Version: 1.0\r\n"
    	. "$from\r\n"
    	. "Content-Type: text/plain; charset=\"" . $mail_charset . "\"\r\n";
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
    global $wpbl_options;

    $info = '';
    // harvest information - if necessary
    if (in_array('harvestinfo', $wpbl_options)) {
        $info = harvest($commentID);
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
    global $wpbl_options, $wbbl_comment, $tableblacklist, $approved;

	$wpbl_comment=get_commentdata($commentID,1,false);
    // first check the comment status based on WP core moderation
    $stat = wp_get_comment_status($commentID);
    if ($stat == 'deleted') {
        // no need to proceed since there is no comment
        return;
    } else if ($stat == 'unapproved') {
        $held = True;
    } else {
        $held = False;
    }
    // are we supposed to delete comments held by the core?
    if ($held && in_array('deletecore', $wpbl_options)) {
        mail_and_del($commentID, "Mail held for moderation outside WPBlacklist");
        return;
    } else if ($held && !in_array('checkcore', $wpbl_options)) {
        // comment held for moderation but option to check against blacklist not specified
        return;
    }
    // IP check
    $sites = $GLOBALS['wpdb']->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='ip'");
    if ($sites) {
        foreach ($sites as $site)  {
            $regex = "/^$site->regex/";
            if (preg_match($regex, $wpbl_comment['comment_author_IP'])) {
                $held = True;
                if (in_array('deleteip', $wpbl_options)) {
                    $approved = 'deleted';
                    mail_and_del($commentID, "Author IP: {$wpbl_comment['comment_author_IP']} matched $regex");
                    return;
                }
                break;
            }
        }
    }
    // RBL check
    if (!$held || in_array('deleterbl', $wpbl_options)) {
        $sites = $GLOBALS['wpdb']->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='rbl'");
        if ($sites) {
            foreach ($sites as $site)  {
                $regex = $site->regex;
                if (preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)/", $wpbl_comment['comment_author_IP'], $matches)) {
                    $rblhost = $matches[4] . "." . $matches[3] . "." . $matches[2] . "." . $matches[1] . "." . $regex;
                    $resolved = gethostbyname($rblhost);
                    if ($resolved != $rblhost) {
                        $held = True;
                        if (in_array('deleterbl', $wpbl_options)) {
                            mail_and_del($commentID, "Author IP: {$wpbl_comment['comment_author_IP']} blacklisted by RBL $regex");
                            return;
                        }
                        break;
                    }
                }
            }
        }
    }
    // expression check
    if (!$held || in_array('deletemail', $wpbl_options) || in_array('deleteurl', $wpbl_options) || in_array('delcommurl', $wpbl_options)) {
        $sites = $GLOBALS['wpdb']->get_results("SELECT regex FROM $tableblacklist WHERE regex_type='url'");
        if ($sites) {
            foreach ($sites as $site)  {

                $regex = "/$site->regex/i";
//                echo "Regex: $regex <br />";
                if (preg_match($regex, $wpbl_comment['comment_author_url'])) {
                    $held = True;
                    if (in_array('deleteurl', $wpbl_options)) {
                        $approved = 'deleted';
                        mail_and_del($commentID, "Author URL: {$wpbl_comment['comment_author_url']} matched $regex");
                        return;
                    }
                    break;
                }
                if (preg_match($regex, $wpbl_comment['comment_author_email'])) {
                    $held = True;
                    if (in_array('deletemail', $wpbl_options)) {
                        mail_and_del($commentID, "Author e-mail: {$wpbl_comment['comment_author_email']} matched $regex");
                        return;
                    }
                    break;
                }
                if (preg_match($regex, $wpbl_comment['comment_content'])) {
                    $held = True;
                    if (in_array('delcommurl', $wpbl_options)) {
                        $approved = 'deleted';
                        mail_and_del($commentID, "Comment text contained $regex");
                        return;
                    }
                    break;
                }
            }
        }
    }
	if (($wpbl_comment['comment_type']=='trackback') && (!$held || in_array('deltbsp', $wpbl_options))) {
		// Let's check the remote site
		require_once(XOOPS_ROOT_PATH.'/class/snoopy.php');
		$snoopy = New Snoopy;
		if ($snoopy->fetch($wpbl_comment['comment_author_url'])) {
			$orig_contents = $snoopy->results;
		}

		if (!strpos($orig_contents, $siteurl)) {
			$approved = 'deleted';
			mail_and_del($commentID, "TrackBack URL does not contain my site URL");
		}
	}
    if ($held) {
        $approved = 0;
        wp_set_comment_status($commentID, 'hold');
    } else {
        $approved = 1;
        wp_set_comment_status($commentID, 'approve');

    }
    // the following is essential not to break other plugins
    return $commentID;
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
// set up the other global variables
$wpbl_comment=array();
// load options from DB
$sql = "SELECT * FROM $tableblacklist WHERE regex_type = 'option'";
$results = $GLOBALS['wpdb']->get_results($sql);
if ($results) {
    foreach ($results as $result) {
        $wpbl_options[] = $result->regex;
    }
}

// the hook
add_action('comment_post', 'blacklist');
add_action('trackback_post', 'blacklist');
add_action('pingback_post', 'blacklist');
add_action('admin_menu', 'wpblmenu');
?>
