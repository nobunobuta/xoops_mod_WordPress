<?php
$title = 'Moderate comments';
$parent_file = 'edit.php';
/* <Moderation> */

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

if (!get_magic_quotes_gpc()) {
	$_GET    = add_magic_quotes($_GET);
	$_POST   = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

$wpvarstoreset = array('action','item_ignored','item_deleted','item_approved');
for ($i=0; $i<count($wpvarstoreset); $i += 1) {
	$wpvar = $wpvarstoreset[$i];
	if (!isset($$wpvar)) {
		if (empty($_POST["$wpvar"])) {
			if (empty($_GET["$wpvar"])) {
				$$wpvar = '';
			} else {
				$$wpvar = $_GET["$wpvar"];
			}
		} else {
			$$wpvar = $_POST["$wpvar"];
		}
	}
}

$comment = array();
if (isset($_POST["comment"])) {
	foreach ($_POST["comment"] as $k => $v) {
		$comment[intval($k)] = $v;
	}
}

switch($action) {

case 'update':

	$standalone = 1;
	require_once('admin-header.php');

	if ($user_level < 3) {
		die('<p>Your level is not high enough to moderate comments. Ask for a promotion from your <a href="mailto:'.get_settings('admin_email').'">blog admin</a>. :)</p>');
	}

	$item_ignored = 0;
	$item_deleted = 0;
	$item_approved = 0;
	
	foreach($comment as $key => $value) {
	    switch($value) {
			case 'later':
				// do nothing with that comment
				// wp_set_comment_status($key, "hold");
				++$item_ignored;
				break;
			
			case 'delete':
				wp_set_comment_status($key, 'delete');
				++$item_deleted;
				break;
			
			case 'approve':
				wp_set_comment_status($key, 'approve');
				if (get_settings('comments_notify') == true) {
					wp_notify_postauthor($key);
				}
				++$item_approved;
				break;
	    }
	}

	$file = basename(__FILE__);
	header("Location: $file?ignored=$item_ignored&deleted=$item_deleted&approved=$item_approved");
	exit();

break;

default:

	require_once('admin-header.php');

	if ($user_level <= 3) {
		die('<p>Your level is not high enough to moderate comments. Ask for a promotion from your <a href="mailto:'.get_settings('admin_email').'">blog admin</a>. :)</p>');
	}
?>
<ul id="adminmenu2">
	<li><a href="edit.php"><?php echo _LANG_WPM_LATE_POSTS; ?></a></li>
	<li><a href="edit-comments.php"><?php echo _LANG_WPM_LATE_COMS; ?></a></li>
	<li class="last"><a href="moderation.php" class="current"><?php echo _LANG_WPM_AWIT_MODERATION; ?></a></li>
</ul>
<?php

	// if we come here after deleting/approving comments we give
	// a short overview what has been done
	if (($deleted) || ($approved) || ($ignored)) {
	    echo "<div class=\"wrap\">\n";
	    if ($approved) {
		if ($approved == "1") {
		    echo "1"._LANG_WPM_COM_APPROV."<br />\n";
		} else {
		    echo "$approved"._LANG_WPM_COMS_APPROVS."<br />\n";
		}
	    }
	    if ($deleted) {
		if ($deleted == "1") {
		    echo "1"._LANG_WPM_COM_DEL."<br />\n";
		} else {
		    echo "$approved"._LANG_WPM_COMS_DELS."<br />\n";
		}
	    }
	    if ($ignored) {
		if ($deleted == "1") {
		    echo "1"._LANG_WPM_COM_UNCHANGE."<br />\n";
		} else {
		    echo "$approved"._LANG_WPM_COMS_UNCHANGES."<br />\n";
		}
	    
	    }
	    echo "</div>\n";
	}

	?>
	
<div class="wrap">
<?php
$comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_approved = '0'");

if ($comments) {
    // list all comments that are waiting for approval
    $file = basename(__FILE__);
?>
    <p><?php echo _LANG_WPM_WAIT_APPROVAL; ?></p>
    <form name="approval" action="moderation.php" method="post">
    <input type="hidden" name="action" value="update" />
    <ol id="comments">
<?php
    foreach($comments as $comment) {
	$comment_date = mysql2date(get_settings("date_format") . " @ " . get_settings("time_format"), $comment->comment_date);
	$post_title = $wpdb->get_var("SELECT post_title FROM {$wpdb->posts[$wp_id]} WHERE ID='$comment->comment_post_ID'");
	
	echo "\n\t<li id='comment-$comment->comment_ID'>"; 
	?>
			<p><strong><?php echo _LANG_WPM_COMPOST_NAME; ?></strong> <?php comment_author() ?> <?php if ($comment->comment_author_email) { ?>| <strong><?php echo _LANG_WPM_COMPOST_MAIL; ?></strong> <?php comment_author_email_link() ?> <?php } if ($comment->comment_author_email) { ?> | <strong><?php echo _LANG_WPM_COMPOST_URL; ?></strong> <?php comment_author_url_link() ?> <?php } ?>| <strong>IP:</strong> <a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<?php comment_author_IP() ?>"><?php comment_author_IP() ?></a></p>
<?php comment_text() ?>
<p><?php
echo "<a href=\"post.php?action=editcomment&amp;comment=".$comment->comment_ID."\">"._LANG_WPM_JUST_EDIT."</a>";
				echo " | <a href=\"post.php?action=deletecomment&amp;p=".$comment->comment_post_ID."&amp;comment=".$comment->comment_ID."\" onclick=\"return confirm('You are about to delete this comment by \'".$comment->comment_author."\'\\n  \'Cancel\' to stop, \'OK\' to delete.')\">"._LANG_WPM_JUST_THIS."</a> | "; ?><?php echo _LANG_WPM_DO_ACTION; ?>
	<input type="radio" name="comment[<?php echo $comment->comment_ID; ?>]" id="comment[<?php echo $comment->comment_ID; ?>]-approve" value="approve" /> <label for="comment[<?php echo $comment->comment_ID; ?>]-approve"><?php echo _LANG_WPM_DO_APPROVE; ?></label>
	<input type="radio" name="comment[<?php echo $comment->comment_ID; ?>]" id="comment[<?php echo $comment->comment_ID; ?>]-delete" value="delete" /> <label for="comment[<?php echo $comment->comment_ID; ?>]-delete"><?php echo _LANG_WPM_DO_DELETE; ?></label>
	<input type="radio" name="comment[<?php echo $comment->comment_ID; ?>]" id="comment[<?php echo $comment->comment_ID; ?>]-nothing" value="later" checked="checked" /> <label for="comment[<?php echo $comment->comment_ID; ?>]-nothing"><?php echo _LANG_WPM_DO_NOTHING; ?></label>

	</li>
<?php
    }
?>
    </ol>
    <input type="submit" name="submit" value="<?php echo _LANG_WPM_MODERATE_BUTTON; ?>" />
    </form>
<?php
} else {
    // nothing to approve
    echo _LANG_WPM_CURR_COMAPP."\n";
}
?>

</div>

<?php
if ($comments) { 
    // show this help text only if there are comments waiting
?>

<div class="wrap"> 
	<?php echo _LANG_WPM_DEL_LATER; ?>
	<?php echo _LANG_WPM_PUBL_VISIBLE; ?>
	<?php 
	    if ('1' == get_settings('comments_notify')) {
		echo ": "._LANG_WPM_AUTHOR_NOTIFIED."</p>\n";
	    } else {
		echo ".</p>\n";
	    }
	?>	    
	<?php echo _LANG_WPM_ASKED_AGAIN; ?>
</div>

<?php
} // if comments

break;
}

/* </Template> */
include("admin-footer.php") ?>