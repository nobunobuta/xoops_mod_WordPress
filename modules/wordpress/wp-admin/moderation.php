<?php
require_once('admin.php');

$title = 'Moderate comments';
$this_file = 'moderation.php';
$parent_file = 'edit.php';

param('action','string','');

switch($action) {
	case 'update':
		wp_refcheck("/wp-admin/moderation.php");
	    if ($user_level < 3) {
	    	redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
	    	exit();
		}
		param('comment','array',array());

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
	    $standalone = 0;
		require_once('admin-header.php');
	    if ($user_level < 3) {
	    	redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
	    	exit();
		}
		param('ignored','integer',0);
		param('deleted','integer',0);
		param('approved','integer',0);
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
	
	?>
	<li id='comment-$comment->comment_ID'>
		<p><strong><?php echo _LANG_WPM_COMPOST_NAME; ?></strong> <?php comment_author() ?> <?php if ($comment->comment_author_email) { ?>| <strong><?php echo _LANG_WPM_COMPOST_MAIL; ?></strong> <?php comment_author_email_link() ?> <?php } if ($comment->comment_author_email) { ?> | <strong><?php echo _LANG_WPM_COMPOST_URL; ?></strong> <?php comment_author_url_link() ?> <?php } ?>| <strong>IP:</strong> <a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<?php comment_author_IP() ?>"><?php comment_author_IP() ?></a></p>
<?php comment_text() ?>
<p>
		<a href="post.php?action=editcomment&amp;comment=<?php echo $comment->comment_ID ?>"><?php echo _LANG_WPM_JUST_EDIT ?></a>
		| <a href="post.php?action=confirmdeletecomment&amp;p=<?php echo $comment->comment_post_ID?>&amp;comment=<?php echo $comment->comment_ID ?>&amp;referredby=moderation"><?php echo _LANG_WPM_JUST_THIS ?></a>
		| <?php echo _LANG_WPM_DO_ACTION; ?>
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

<?php if ($comments) { ?>
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
<?php } ?>

<?php

		break;
}
include("admin-footer.php") ?>
