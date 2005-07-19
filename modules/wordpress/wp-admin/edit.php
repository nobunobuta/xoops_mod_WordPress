<?php
require_once('admin.php');

$GLOBALS['title'] = 'Edit Posts';
$GLOBALS['parent_file'] = 'edit.php';
$GLOBALS['standalone'] = 0;
require_once('admin-header.php');

init_param('GET', 'showposts',      'integer', 10);
init_param('GET', 'posts_per_page', 'integer', get_param('showposts'));
init_param('GET', 'mode',           'string',  '');

$ticket=$GLOBALS['xoopsWPTicket']->getTicketParamString('plugins');
include(dirname(__FILE__)."/../wp-blog-header.php");

if (test_param('poststart') && test_param('postend')) {
	$poststart = get_param('poststart');
	$postend = get_param('postend');
	$showposts = get_param('postend') - get_param('poststart') + 1;
} else {
	$showposts = get_param('showposts');
	if (!test_param('poststart')) {
		$poststart = 0;
	} else {
		$poststart = get_param('poststart');
	}
	if (!test_param('postend')) {
		$postend = $poststart + $showposts -1;
	} else {
		$postend = get_param('postend');
	}
}

$nextXstart = $poststart + 1;
$nextXend = $nextXstart + $showposts -1;

$previousXstart = $poststart - $showposts;
$previousXend = $postend - $showposts;
if ($previousXstart < 1) {
	$previousXstart = 0;
	$previousXend = 0;
}
?>
<?php draft_list($GLOBALS['user_ID']) ?>
<?php include('include/edit-navibar.php') ?>
<div class="wrap">
<table width="100%">
  <tr>
	<td valign="top" width="33%">
		<form name="searchform" action="" method="get">
			<input type="hidden" name="a" value="s" />
			<input onfocus="if (this.value=='search...') {this.value='';}" onblur="if (this.value=='') {this.value='search...';}" type="text" name="s" value="<?php echo (test_param('s'))?get_param('s'):"search..."?>" size="7" style="width: 100px;" />
			<input type="submit" name="submit" value="search" />
		</form>
	</td>
    <td valign="top" width="33%" align="center">
	  <form name="viewcat" action="" method="get">
		<select name="cat" style="width:140px;">
		<option value="all">All Categories</option>
		<?php wp_dropdown_cats(0,get_param('cat')) ?>
		</select>
		<input type="submit" name="submit" value="View" />
	  </form>
    </td>
    <td valign="top" width="33%" align="right">
    <form name="viewarc" action="" method="get">
<?php if ($GLOBALS['archive_mode'] == "monthly") { ?>
		<select name="m" style="width:120px;">
			<option value="">All Months</option>
			<?php wp_dropdown_month(test_param('m')?get_param('m'):'') ?>
<?php } elseif ($GLOBALS['archive_mode'] == "daily") { ?>
		<select name="m" style="width:120px;">
			<option value="">All Days</option>
			<?php wp_dropdown_daily(test_param('m')?get_param('m'):'') ?>
<?php } elseif ($GLOBALS['archive_mode'] == "weekly") { ?>
		<select name="w" style="width:120px;">
			<option value="">All Weeks</option>
			<?php wp_dropdown_weekly(test_param('w')?get_param('w'):'') ?>
<?php } elseif ($GLOBALS['archive_mode'] == "postbypost") { ?>
		<input type="hidden" name="more" value="1" />
		<select name="p" style="width:120px;">
			<option value="">All Posts</option>
			<?php wp_dropdown_postbypost(test_param('p')?get_param('p'):'') ?>
<?php } ?>
		</select>
	    <input type="submit" name="submit" value="View" />
      </form>
    </td>
  </tr>
</table>

<?php

if ($GLOBALS['posts']) {
	foreach ($GLOBALS['posts'] as $GLOBALS['post']) { start_wp();
?>
<p>
	<strong><?php the_time('Y/m/d H:i:s'); ?></strong> [ <a href="edit.php?p=<?php echo $GLOBALS['wp_post_id'] ?>&c=1"><?php comments_number(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS) ?></a>
<?php if (($user_level > $authordata->user_level) or ($user_level == 10) or ($user_login == $authordata->user_login)) { ?>
	- <a href='post.php?action=edit&amp;post=<?php echo $wp_post_id?><?php echo (isset($m) && $m)? "&amp;m=$m":""?>'><?php echo _LANG_C_NAME_EDIT ?></a>
	- <a href='post.php?action=confirmdelete&amp;post=<?php echo $wp_post_id?>'><?php echo _LANG_C_NAME_DELETE ?></a>
<?php } ?>
<?php if ('private' == $post->post_status) { ?>
	- <strong>Private</strong>
<?php } ?>
	]
	<br />
	<strong><a href="<?php permalink_link(); ?>" rel="permalink"><?php the_title() ?></a></strong> &#8212; <cite><?php the_author() ?> (<a href="javascript:profile(<?php the_author_ID() ?>)"><?php the_author_nickname() ?></a>)</cite>, in <strong><?php the_category() ?></strong><br />
	<?php the_content() ?>
</p>
<?php
// comments
	if ((test_param('withcomments')) or (test_param('c'))) {
		$comments = $wpdb->get_results("SELECT * FROM ".wp_table('comments')." WHERE comment_post_ID = $wp_post_id ORDER BY comment_date");
		if ($comments) {
?> 
<h3><?php echo _LANG_E_TITLE_COMMENTS; ?></h3>
	<ol id="comments">
<?php foreach ($comments as $comment) { ?> 
	<!-- comment -->
		<li>
<?php 
			$comment_status = wp_get_comment_status($comment->comment_ID);
?>
<?php if ("unapproved" == $comment_status) { ?>
 		<span class="unapproved">
<?php } ?>
		<?php comment_date('Y/m/d') ?> @ <?php comment_time() ?> 
<?php if (($user_level > $authordata->user_level) or ($user_login == $authordata->user_login)) { ?>
	[ <a href="post.php?action=editcomment&amp;comment=<?php echo $comment->comment_ID ?>"><?php echo _LANG_C_NAME_EDIT ?></a>
	 - <a href="post.php?action=confirmdeletecomment&amp;p=<?php echo $post->ID ?>&amp;comment=<?php echo $comment->comment_ID ?>&amp;referredby=edit"><?php echo _LANG_C_NAME_DELETE ?></a>
<?php if ( ('none' != $comment_status) && ($user_level >= 3) ) { ?>
<?php if ('approved' == wp_get_comment_status($comment->comment_ID)) { ?>
	- <a href="post.php?action=unapprovecomment&amp;p=<?php echo $post->ID ?>&amp;comment=<?php echo $comment->comment_ID ?><?php echo $ticket?>"><?php echo _LANG_WPM_DO_NOTHING?></a>
<?php } else { ?>
    - <a href="post.php?action=approvecomment&amp;p=<?php echo $post->ID ?>&amp;comment=<?php echo $comment->comment_ID ?><?php echo $ticket?>"><?php echo _LANG_WPM_DO_APPROVE?></a>
<?php } ?>
<?php } ?>
	]
<?php } ?> 
	<br />
	<strong><?php comment_author() ?> ( <?php comment_author_email_link() ?> / <?php comment_author_url_link() ?> )</strong> (IP: <?php comment_author_IP() ?>) 
	<?php comment_text() ?>
<?php if ("unapproved" == $comment_status) { ?>
 		</span>
<?php } ?>
		</li>
	<!-- /comment -->
<?php } ?>
	</ol>
<?php } ?>
<?php if (get_xoops_option(wp_mod(), 'wp_use_xoops_comments') == 0) { ?>
<h3><?php echo _LANG_E_TITLE_LEAVECOM; ?></h3>
	<!-- form to add a comment -->
	<form action="<?php echo $siteurl.'/wp-comments-post.php'?>" method="post">
		<input type="hidden" name="comment_post_ID" value="<?php echo $wp_post_id; ?>" />
		<input type="hidden" name="redirect_to" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
		<input type="text" name="author" class="textarea" value="<?php echo $user_nickname ?>" size="20" tabindex="1" /><br />
		<input type="text" name="email" class="textarea" value="<?php echo $user_email ?>" size="20" tabindex="2" /><br />
		<input type="text" name="url" class="textarea" value="<?php echo $user_url ?>" size="20" tabindex="3" /><br />
		<textarea cols="40" rows="4" name="comment" tabindex="4" class="textarea"></textarea><br />
		<input type="submit" name="submit" class="buttonarea" value="ok" tabindex="5" />
	</form>
	<!-- /form -->
<?php } ?> 
<?php } ?> 
	<br />
<?php } ?>
<?php } else { ?> 
<p>
	<strong><?php echo _LANG_E_RESULTS_FOUND; ?></strong>
</p>
<?php } ?>
</div>
<?php 
	include('include/edit-navibar.php');
	include('admin-footer.php');
?>
