
<div class="wrap">
<?php

$allowed_users = explode(" ", trim(get_settings('fileupload_allowedusers')));


		$submitbutton_text = _LANG_EFC_BUTTON_TEXT;
		$toprow_title = 'Editing Comment # '.$commentdata['comment_ID'];
		$form_action = 'editedcomment';
		$form_extra = "' />\n<input type='hidden' name='comment_ID' value='$comment' />\n<input type='hidden' name='comment_post_ID' value='".$commentdata["comment_post_ID"];




?>

<form name="post" action="post.php" method="post" id="post">
<input type="hidden" name="user_ID" value="<?php echo $user_ID ?>" />
<input type="hidden" name="action" value='<?php echo $form_action . $form_extra ?>' />

<script type="text/javascript">
function focusit() {
	// focus on first input field
	document.post.name.focus();
}
window.onload = focusit;
</script>
<fieldset id="namediv">
<legend><?php echo _LANG_EFC_COM_NAME; ?></legend>
	<div>
	  <input type="text" name="newcomment_author" size="22" value="<?php echo format_to_edit($commentdata['comment_author']) ?>" tabindex="1" id="name" />
    </div>
</fieldset>
<fieldset id="emaildiv">
		<legend><?php echo _LANG_EFC_COM_MAIL; ?></legend>
		<div>
		  <input type="text" name="newcomment_author_email" size="30" value="<?php echo format_to_edit($commentdata['comment_author_email']) ?>" tabindex="2" id="email" />
    </div>
</fieldset>
<fieldset id="uridiv">
		<legend><?php echo _LANG_EFC_COM_URI; ?></legend>
		<div>
		  <input type="text" name="newcomment_author_url" size="35" value="<?php echo format_to_edit($commentdata['comment_author_url']) ?>" tabindex="3" id="URL" />
    </div>
</fieldset>

<fieldset style="clear: both;">
<legend><?php echo _LANG_EFC_COM_COMMENT; ?></legend>
		<div id="quicktags">
<?php
if (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx)))) {
	echo '<a href="http://wordpress.org/docs/reference/post/#quicktags" title="Help with quicktags">'._LANG_EF_AD_POSTQUICK.'</a>: ';
	include('quicktags.php');
}
?>
</div>
<?php
 $rows = get_settings('default_post_edit_rows');
 if (($rows < 3) || ($rows > 100)) {
     $rows = 10;
 }
?>
<div><textarea rows="<?php echo $rows; ?>" cols="40" name="wp_content" tabindex="4" id="wp_content" style="width: 99%"><?php echo $content ?></textarea></div>
</fieldset>

<?php
if (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx)))) {
?>
<script type="text/javascript" language="JavaScript">
<!--
edCanvas = document.getElementById('wp_content');
//-->
</script>
<?php
}
?>

<p><?php echo $saveasdraft; ?> <input type="submit" name="submit" value="<?php echo $submitbutton_text ?>" style="font-weight: bold;" tabindex="6" />
  <input name="referredby" type="hidden" id="referredby" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
</p>


<?php


// if the level is 5+, allow user to edit the timestamp - not on 'new post' screen though
// if (($user_level > 4) && ($action != "post"))
if ($user_level > 4) {
	touch_time(($action == 'edit'));
}
?>

</form>
<p><a href="post.php?action=deletecomment&amp;noredir=true&amp;comment=<?php echo $commentdata['comment_ID']; ?>&amp;p=<?php echo $commentdata['comment_post_ID']; ?>">Delete this comment</a>.</p>
</div>
