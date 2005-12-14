<?php
require_once('../wp-config.php');
require_once('auth.php');

require_once('../wp-includes/wpblfunctions.php');
$title = _('WPBlacklist - Moderate');
$parent_file = 'wpblacklist.php';

init_param('POST', 'btndeladd', 'string', '');
init_param('POST', 'btndel', 'string', '');
init_param('POST', 'btnapprove', 'string', '');
init_param('POST', 'delete_comments', 'array', '');

$GLOBALS['standalone'] = 0;
require_once('admin-header.php');

$tableblacklist = $xoopsDB->prefix("wp_blacklist");
$tablecomments = wp_table('comments');
$tableposts =  wp_table('posts');

//Check User_Level
user_level_check();
?>
<script type="text/javascript">
<!--
function checkAll(form)
{
	for (i = 0, n = form.elements.length; i < n; i++) {
		if(form.elements[i].type == "checkbox") {
			if(form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}
//-->
</script>
<div class="wrap">
<p>
<?php
// figure out what the action is
if ($btndeladd <> '') {
	$action = 'deladd';
} else if ($btndel <> '') {
	$action = 'delete';
} else if ($btnapprove <> '') {
	$action = 'approve';
} else {
	$action = '';
}

$cnt = 0;
$add = '';
switch($action) {
	case 'deladd':
	case 'delete':
		foreach ($delete_comments as $comment) {
			// first get the details and add it to blacklist - if necessary
			if ($action == 'deladd') {
				if (!empty($add)) {
					$add .= '<br />';
				}
				$add .= harvest($comment);
			} // $action == 'deladd'
			wp_set_comment_status($comment, 'delete');
			++$cnt;
		}
		break;

	case 'approve':
		foreach ($delete_comments as $comment) {
			wp_set_comment_status($comment, 'approve');
			++$cnt;
		}
		break;
}
if ($cnt <> 0) {
	echo "<div class='updated'>\n<p>";
	if ('1' == $cnt) {
		$resp = '1 comment ';
	} else {
		$resp = sprintf("%s comments ", $cnt);
	}
	switch ($action) {
		case 'deladd':
			$resp = $resp . 'deleted <br />' . "\n";
			if (!empty($add)) {
				$resp = $resp . 'The following comment details were added to blacklist: <br />' . $add . "\n";
			}
			break;

		case 'delete':
			$resp = $resp . 'deleted <br />' . "\n";
			break;

		case 'approve':
			$resp = $resp . 'approved <br />' . "\n";
			break;
	}
	echo "$resp</p></div>\n";
}
$comments = $wpdb->get_results("SELECT * FROM $tablecomments WHERE comment_approved = '0'");
if ($comments) {
    // list all comments that are waiting for approval
?>
    <?php _e('<p>This screen allows you to work with comments in the moderation queue. You can approve, delete or delete while adding the author IP, e-mail, URL and any URLs found in the comment body to the blacklist. These are the comments in the moderation queue:</p>') ?>
    <form name="approval" action="wpblmoderate.php" method="post">
		<ol id="comments">
<?php
    foreach($comments as $comment) {
		$comment_date = mysql2date(get_settings("date_format") . " @ " . get_settings("time_format"), $comment->comment_date);
		$post_title = $wpdb->get_var("SELECT post_title FROM $tableposts WHERE ID='$comment->comment_post_ID'");
		echo "\n\t<li id='comment-$comment->comment_ID'>";
?>
			<p>
 		    <?php if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) { ?>
			<input type="checkbox" name="delete_comments[]" value="<?php echo $comment->comment_ID; ?>" /><?php } ?>
			<strong><?php _e('Name:') ?></strong> <?php comment_author() ?>
<?php
		if ($comment->comment_author_email) {
?>
			| <strong><?php _e('Email:') ?></strong> <?php comment_author_email_link() ?>
<?php
		}
		if ($comment->comment_author_url) {
?>
			| <strong><?php _e('URI:') ?></strong> <?php comment_author_url_link() ?>
<?php
		}
?>
			| <strong><?php _e('IP:') ?></strong>
			<a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<?php comment_author_IP() ?>">
				<?php comment_author_IP() ?>
			</a></p>
			<?php comment_text() ?>
		</li>
<?php
    } // foreach
?>
    </ol>
    <p class="submit">
		<input type="submit" name="btndeladd" value="<?php _e('Delete & Add') ?>" />
		<input type="submit" name="btndel" value="<?php _e('Delete') ?>" />
		<input type="submit" name="btnapprove" value="<?php _e('Approve') ?>" />
	</p>
    </form>
<?php
} else {
    // nothing to approve
    echo _("<p>Currently there are no comments to be approved.</p>") . "\n";
}
?>

</div>

<?php
/* </Template> */
include("admin-footer.php")
?>
