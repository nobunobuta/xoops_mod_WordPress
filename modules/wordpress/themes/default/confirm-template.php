<?php /* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }?>
<?php //This is Comment listing and form Template ?>
<div id="wpMainContent">
<h2 id="comments"><?php echo _LANG_WPCM_CONF_TITLE; ?></h2>
<ol id="commentlist">
	<li id="comment-prev">
	<?php echo $comment_preview; ?> by <?php echo $author_preview; ?>
	</li>
</ol>
<form action="<?php echo wp_siteurl(); ?>/wp-comments-post.php" method="post" id="commentform">
	<input type="hidden" name="author" id="author" class="textarea" value="<?php echo $_author; ?>" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $_comment_post_ID; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo $_redirect_to; ?>" />
	<input type="hidden" name="email" id="email" value="<?php echo $_email; ?>" />
	<input type="hidden" name="url" id="url" value="<?php echo $_url; ?>" />
	<input type="hidden" name="comment" id="comment" value="<?php echo htmlspecialchars($_comment); ?>" />
	<?php echo $xoopsWPTicket->getTicketHtml(__LINE__) ?>
	<input type="hidden" name="action" id="action"  value="confirm" />
	<?php echo _LANG_WPCM_CONF_MSG ?>
	<p>
	  <input name="submit" type="submit" tabindex="5" value="<?php echo _LANG_WPCM_CONF_BTN ?>" />
	</p>
</form>
<h2><?php echo _LANG_WPCM_EDIT_TITLE; ?></h2>
<p><?php echo _LANG_WPCM_HTML_ALLOWED; ?><code><?php echo allowed_tags(); ?></code></p>
<form action="<?php echo wp_siteurl(); ?>/wp-comments-post.php" method="post" id="commentform">
	<p>
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo $_author; ?>" size="28" tabindex="1" />
	  <label for="author"><?php echo _LANG_WPCM_COM_NAME ?></label>
	  <input type="hidden" name="comment_post_ID" value="<?php echo $_comment_post_ID; ?>" />
	  <input type="hidden" name="redirect_to" value="<?php echo $_redirect_to; ?>" />
	</p>
	<p>
	  <input type="text" name="email" id="email" value="<?php echo $_email; ?>" size="28" tabindex="2" />
	  <label for="email"><?php echo _LANG_WUS_AU_MAIL; ?></label>
	</p>
	<p>
	  <input type="text" name="url" id="url" value="<?php echo $_url; ?>" size="28" tabindex="3" />
	  <label for="url"><?php echo _LANG_WUS_AU_URI; ?></label>
	</p>
	<p>
	  <label for="comment"><?php echo _LANG_WPCM_COM_YOUR; ?></label>
	<br />
	  <textarea name="comment" id="comment" cols="70" rows="5" tabindex="4" ><?php echo $_comment; ?></textarea>
	</p>
	<p>
	  <input name="submit" type="submit" tabindex="5" value="<?php echo _LANG_WPCM_EDIT_BTN; ?>" />
	</p>
</form>
</div>
