<?php /* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }?>
<?php //This is Comment listing and form Template ?>
<h2 id="comments"><?php echo "TrackBacks"; ?></h2>

<p><?php comments_rss_link(_LANG_WPCM_COM_RSS); ?></p>

<?php if ('open' == $post->ping_status) { ?>
<p><?php echo _LANG_WPCM_COM_TRACK; ?><em><?php trackback_url() ?></em></p>
<?php } ?>

<?php if ($comments) { ?>
<ol id="commentlist">
<?php foreach ($comments as $comment) { ?>
	<li id="comment-<?php comment_ID() ?>">
	<?php comment_text() ?>
	<p><cite><?php comment_type(); ?> by <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite> <?php edit_comment_link('Edit This', ' |'); ?></p>
	</li>

<?php } // end for each comment ?>
</ol>
<?php } else { // this is displayed if there are no comments so far ?>
	<p><?php echo _LANG_WPCM_COM_YET; ?></p>
<?php } ?>
<h2 id="xcomments"><?php echo _LANG_WPCM_COM_TITLE; ?></h2>
<?php if ('open' == $post->comment_status) { ?>
<?php require XOOPS_ROOT_PATH.'/modules/'.$wp_mod[$wp_id].'/include/comment_view.php'; ?>
<div style="text-align: center; padding: 3px; margin: 3px;">
  <?php echo $navbar; ?>
  <?php echo _CM_NOTICE; ?>
</div>

<div style="margin: 3px; padding: 3px;">
<?php
	if ($com_mode == "flat") {
		echo $xoopsTpl->fetch("db:system_comments_flat.html");
	} else if ($com_mode == "thread") {
		echo $xoopsTpl->fetch("db:system_comments_thread.html");
	} else if ($com_mode == "nest") {
		echo $xoopsTpl->fetch("db:system_comments_nest.html");
	}
?>
</div>
<?php } else { // comments are closed ?>
<p><?php echo _LANG_WPCM_THIS_TIME; ?></p>
<?php } ?>
