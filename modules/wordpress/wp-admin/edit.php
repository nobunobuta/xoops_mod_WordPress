<?php
require_once('admin.php');

$title = 'Edit Posts';
$parent_file = 'edit.php';
$standalone = 0;
require_once('admin-header.php');

param('showposts',      'integer', '');
param('posts_per_page', 'integer', '');
param('poststart',      'integer', '');
param('postend',        'integer', '');
param('order',          'string',  'DESC');
param('mode',           'string',  '');
param('c',              'integer');

param('m','integer',NO_DEFAULT_PARAM, true);  //Month Param   (YYYY[MM[DD[hh[mm[ss]]]]])
param('w','integer',NO_DEFAULT_PARAM, true);  //WeekNum Param
param('p','string',NO_DEFAULT_PARAM, true);  //PostID Param ("All" for All);
param('cat','string',NO_DEFAULT_PARAM,true);  // Category ID (Start with "-" means Exclude this.).
param('s','html',NO_DEFAULT_PARAM,true);    //Search String
$exact = 0;
$sentence = 0;

if (!$showposts) {
	if ($posts_per_page) {
		$showposts=$posts_per_page;
	} else {
		$showposts=10;
		$posts_per_page=$showposts;
	}
} else {
	$posts_per_page = $showposts;
}

if ((!empty($poststart)) && (!empty($postend)) && ($poststart == $postend)) {
	$p=$poststart;
	$poststart=0;
	$postend=0;
}

if (!$poststart) {
	$poststart=0;
	$postend=$showposts;
}

$nextXstart=$postend;
$nextXend=$postend+$showposts;

$previousXstart=($poststart-$showposts);
$previousXend=$poststart;
if ($previousXstart < 0) {
	$previousXstart=0;
	$previousXend=$showposts;
}

?>
<?php draft_list($user_ID) ?>
<?php include('include/edit-navibar.php') ?>
<div class="wrap">
<table width="100%">
  <tr>
	<td valign="top" width="33%">
		<form name="searchform" action="" method="get">
			<input type="hidden" name="a" value="s" />
			<input onfocus="if (this.value=='search...') {this.value='';}" onblur="if (this.value=='') {this.value='search...';}" type="text" name="s" value="<?php echo (isset($s)&&$s)?$s:"search..."?>" size="7" style="width: 100px;" />
			<input type="submit" name="submit" value="search" />
		</form>
	</td>
    <td valign="top" width="33%" align="center">
	  <form name="viewcat" action="" method="get">
		<select name="cat" style="width:140px;">
		<option value="all">All Categories</option>
		<?php wp_dropdown_cats(0,$cat) ?>
		</select>
		<input type="submit" name="submit" value="View" />
	  </form>
    </td>
    <td valign="top" width="33%" align="right">
    <form name="viewarc" action="" method="get">
<?php if ($archive_mode == "monthly") { ?>
		<select name="m" style="width:120px;">
			<option value="">All Months</option>
			<?php wp_dropdown_month(isset($m)?$m:"") ?>
<?php } elseif ($archive_mode == "daily") { ?>
		<select name="m" style="width:120px;">
			<option value="">All Days</option>
			<?php wp_dropdown_daily(isset($m)?$m:"") ?>
<?php } elseif ($archive_mode == "weekly") { ?>
		<select name="w" style="width:120px;">
			<option value="">All Weeks</option>
			<?php wp_dropdown_weekly(isset($w)?$w:"") ?>
<?php } elseif ($archive_mode == "postbypost") { ?>
		<input type="hidden" name="more" value="1" />
		<select name="p" style="width:120px;">
			<option value="">All Posts</option>
			<?php wp_dropdown_postbypost(isset($p)?$p:"") ?>
<?php } ?>
		</select>
	    <input type="submit" name="submit" value="View" />
      </form>
    </td>
  </tr>
</table>

<?php
include(dirname(__FILE__)."/../wp-blog-header.php");

if ($posts) {
	foreach ($posts as $post) { start_wp();
?>
<p>
	<strong><?php the_time('Y/m/d H:i:s'); ?></strong> [ <a href="edit.php?p=<?php echo $wp_post_id ?>&c=1"><?php comments_number(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS) ?></a>
<?php if (($user_level > $authordata->user_level) or ($user_level == 10) or ($user_login == $authordata->user_login)) { ?>
	- <a href='post.php?action=edit&amp;post=<?php echo $wp_post_id?><?php echo (isset($m) && $m)? "&m=$m":""?>'><?php echo _LANG_C_NAME_EDIT ?></a>
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
	if (($withcomments) or ($c)) {
		$comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID = $wp_post_id ORDER BY comment_date");
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
	- <a href="post.php?action=unapprovecomment&amp;p=<?php echo $post->ID ?>&amp;comment=<?php echo $comment->comment_ID ?>"><?php echo _LANG_WPM_DO_NOTHING?></a>
<?php } else { ?>
    - <a href="post.php?action=approvecomment&amp;p=<?php echo $post->ID ?>&amp;comment=<? echo $comment->comment_ID ?>"><?php echo _LANG_WPM_DO_APPROVE?></a>
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
<?php if (get_xoops_option($wp_mod[$wp_id],'wp_use_xoops_comments') == 0) { ?>
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
