<?php 
/* Don't remove these lines. */
$blog = 1;
include_once (dirname(__FILE__)."/../../mainfile.php");
require ('wp-blog-header.php');
add_filter('comment_text', 'popuplinks');
foreach ($posts as $post) { start_wp();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo get_settings('blogname') ?> - Comments on "<?php the_title() ?>"</title>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset ?>" />
<?php 
if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/wp-layout.css')) {
	$themes = $xoopsConfig['theme_set'];
} else {
	$themes = "default";
}
if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/print.css')) {
	$themes_p = $xoopsConfig['theme_set'];
} else {
	$themes_p = "default";
}
?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $siteurl; ?>/themes/<?php echo $themes; ?>/wp-layout.css" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo $siteurl; ?>/themes/<?php echo $themes_p; ?>/print.css" />
	<style type="text/css" media="screen">
		@import url( wp-layout.css );
		body { margin: 3px; }
	</style>

</head>
<body id="wpMainContent">

<h1 id="header"><a href="" title="<?php echo get_settings('blogname'); ?>"><?php echo get_settings('blogname'); ?></a></h1>

<h2 id="comments"><?php echo _LANG_WPCM_COM_TITLE; ?></h2>

<p><?php comments_rss_link('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.'); ?></p>

<?php if ('open' == $post->ping_status) { ?>
<p><?php echo _LANG_WPCM_COM_TRACK; ?><em><?php trackback_url(); ?></em></p>
<?php } ?>

<?php
// this line is WordPress' motor, do not delete it.
$comment_author = (isset($_COOKIE['comment_author_'.$cookiehash])) ? trim($_COOKIE['comment_author_'.$cookiehash]) : '';
$comment_author_email = (isset($_COOKIE['comment_author_email_'.$cookiehash])) ? trim($_COOKIE['comment_author_email_'.$cookiehash]) : '';
$comment_author_url = (isset($_COOKIE['comment_author_url_'.$cookiehash])) ? trim($_COOKIE['comment_author_url_'.$cookiehash]) : '';
$comments = $wpdb->get_results("SELECT * FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID = $id AND comment_approved = '1' ORDER BY comment_date");
$commentstatus = $wpdb->get_row("SELECT comment_status, post_password FROM {$wpdb->posts[$wp_id]} WHERE ID = $id");
if (!empty($commentstatus->post_password) && $_COOKIE['wp-postpass_'.$cookiehash] != $commentstatus->post_password) {  // and it doesn't match the cookie
	echo(get_the_password_form());
} else { 
?>

<?php if ($comments) { ?>
<ol id="commentlist">
<?php foreach ($comments as $comment) { ?>
	<li id="comment-<?php comment_ID() ?>">
	<?php comment_text(); ?>
	<p><cite><?php comment_type(); ?> by <?php comment_author_link(); ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite></p>
	</li>

<?php } // end for each comment ?>
</ol>
<?php } else { // this is displayed if there are no comments so far ?>
	<p><?php echo _LANG_WPCM_COM_YET; ?></p>
<?php } ?>
<h2><?php echo _LANG_WPCM_COM_LEAVE; ?></h2>
<?php if ('open' == $post->comment_status) { ?>
<p><?php echo _LANG_WPCM_HTML_ALLOWED; ?><code><?php echo allowed_tags(); ?></code></p>

<form action="<?php echo $siteurl; ?>/wp-comments-post.php" method="post" id="commentform">
	<p>
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
	   <label for="author"><?php echo _LANG_WPCM_COM_NAME; ?></label>
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" />
	</p>

	<p>
	  <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" />
	   <label for="email"><?php echo _LANG_WUS_AU_MAIL; ?></label>
	</p>

	<p>
	  <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" />
	   <label for="url"><acronym title="Uniform Resource Identifier"><?php echo _LANG_WUS_AU_URI; ?></acronym></label>
	</p>

	<p>
	  <label for="comment"><?php echo _LANG_WPCM_COM_YOUR; ?></label>
	<br />
	  <textarea name="comment" id="comment" cols="50" rows="4" tabindex="4"></textarea>
	</p>

<?php if ('none' != get_settings("comment_moderation")) { ?>
	<p>
	<?php echo _LANG_WPCM_PLEASE_NOTE; ?>
	</p>
<?php } // comment_moderation != 'none' ?>
	<p>
	  <input name="submit" type="submit" tabindex="5" value="<?php echo _LANG_WPCM_COM_SAYIT; ?>" />
	</p>
</form>
<?php } else { // comments are closed ?>
<p><?php echo _LANG_WPCM_THIS_TIME; ?></p>
<?php } ?>
<?php } // end password check ?>

<div><strong><a href="javascript:window.close()">Close this window</a>.</strong></div>

<?php } // if you delete this the sky will fall on your head ?>

<p class="credit"><?php timer_stop(1); ?> <cite>Powered by <a href="http://wordpress.org"><strong>Wordpress</strong></a></cite></p>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {	
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>
</body>
</html>
