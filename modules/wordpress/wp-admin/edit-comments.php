<?php
require_once('admin.php');

$title = 'Edit Comments';
$parent_file = 'edit.php';
$standalone = 0;
require_once('admin-header.php');

param('showcomments',      'integer', '');
param('comments_per_page',      'integer', '');
param('commentstart',      'integer', '');
param('commentend',      'integer', '');
param('commentorder',      'string', 'DESC');

if (!$showcomments) {
	if ($comments_per_page) {
		$showcomments=$comments_per_page;
	} else {
		$showcomments=10;
		$comments_per_page=$showcomments;
	}
} else {
	$comments_per_page = $showcomments;
}

if ((!empty($commentstart)) && (!empty($commentend)) && ($commentstart == $commentend)) {
	$p=$commentstart;
	$commentstart=0;
	$commentend=0;
}

if (!$commentstart) {
	$commentstart=0;
	$commentend=$showcomments;
}

$nextXstart=$commentend;
$nextXend=$commentend+$showcomments;

$previousXstart=($commentstart-$showcomments);
$previousXend=$commentstart;
if ($previousXstart < 0) {
	$previousXstart=0;
	$previousXend=$showcomments;
}
?>
<?php include('include/edit-comments-navibar.php'); ?>
<div class="wrap">
	<?php
	$comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]}
									ORDER BY comment_date $commentorder 
									LIMIT $commentstart, $commentend"
	                              );
?>
<?php if ($comments) { ?>
	<ol>
<?php
	foreach ($comments as $comment) {
		$comment_status = wp_get_comment_status($comment->comment_ID);
		$authordata = get_userdata($wpdb->get_var("SELECT post_author FROM {$wpdb->posts[$wp_id]} WHERE ID = $comment->comment_post_ID"));
		// Get post title
		$post_title = $wpdb->get_var("SELECT post_title FROM {$wpdb->posts[$wp_id]} WHERE ID = $comment->comment_post_ID");
		$post_title = ('' == $post_title) ? "# $comment->comment_post_ID" : $post_title;
		if ('unapproved' == $comment_status) {
			$class = 'class="unapproved" ';
		}
?>		
		<li <?php echo $class?> style="border-bottom: 1px solid #ccc;">
			<p><strong>Name:</strong> <?php comment_author() ?> 
<?php if ($comment->comment_author_email) { ?>
			| <strong>Email:</strong> <?php comment_author_email_link() ?> 
<?php } ?>
<?php if ($comment->comment_author_url) { ?>
			| <strong>URI:</strong> <?php comment_author_url_link() ?>
<?php } ?>
			| <strong>IP:</strong> <a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=<?php comment_author_IP() ?>"><?php comment_author_IP() ?></a></p>
		<?php comment_text() ?>
			<p>Posted <?php comment_date('Y/m/d H:i:s') ?> | 
<?php if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) { ?>
			<a href="post.php?action=editcomment&amp;comment=<?php echo $comment->comment_ID ?>"><?php echo _LANG_EC_EDIT_COM; ?></a>
			- <a href="post.php?action=confirmdeletecomment&amp;p=<?php echo $comment->comment_post_ID?>&amp;comment=<?php echo $comment->comment_ID ?>&amp;referredby=edit-comment"><?php echo _LANG_EC_DELETE_COM; ?></a>
			- <a href="post.php?action=edit&amp;post=<?php echo $comment->comment_post_ID; ?>"><?php echo _LANG_EC_EDIT_POST; ?><?php echo stripslashes($post_title); ?>&#8221;</a>
			- <a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php echo _LANG_EC_VIEW_POST; ?></a></p>
<?php } ?>
		</li>
<?php } // end foreach ?>
</ol>
<?php } else { ?>
	<p><strong><?php echo _LANG_E_RESULTS_FOUND; ?></strong></p>
<?php } // end if ($comments) ?>
</div>
<?php 
include('include/edit-comments-navibar.php');
include('admin-footer.php');
?>
