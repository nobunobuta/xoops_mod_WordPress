
<div class="wrap">
<?php

$allowed_users = explode(" ", trim(get_settings('fileupload_allowedusers')));

$submitbutton_text = 'Save';
$toprow_title = 'Editing Post #' . $postdata['ID'];
$form_action = 'editpost';
$form_extra = "' />\n<input type='hidden' name='post_ID' value='$post->ID";
$colspan = 2;
$form_pingback = '<input type="hidden" name="post_pingback" value="0" />';
$form_prevstatus = '<input type="hidden" name="prev_status" value="'.$post_status.'" />';
if (get_settings('use_trackback')) {
	$form_trackback = _LANG_EF_TRACK_FORM.'	<input type="text" name="trackback_url" style="width: 415px" id="trackback" tabindex="7" value="'. str_replace("\n", ' ', $to_ping) .'" />&nbsp;&nbsp;&nbsp;Use UTF-8:<input value="1" type="checkbox" name="useutf8" id="useutf8" /></p>';
	if ('' != $pinged) {
		$form_trackback .= '<p>Already pinged:</p><ul>';
		$already_pinged = explode("\n", trim($pinged));
		foreach ($already_pinged as $pinged_url) {
			$form_trackback .= "\n\t<li>$pinged_url</li>";
		}
		$form_trackback .= '</ul>';
	}
} else {
	$form_trackback = '';
}
$saveasdraft = '<input name="save" type="submit" id="save" tabindex="6" value="'._LANG_EFA_SAVE_CONTINUE.'" />';


?>

<form name="post" action="post.php" method="post" id="post">
<input type="hidden" name="user_ID" value="<?php echo $user_ID ?>" />
<input type="hidden" name="action" value='<?php echo $form_action . $form_extra ?>' />

<script type="text/javascript">
<!--
function focusit() {
	// focus on first input field
	document.post.title.focus();
}
window.onload = focusit;
//-->
</script>

<div id="poststuff">
    <fieldset id="titlediv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#title" title="Help on titles"><?php echo _LANG_EF_AD_POSTTITLE; ?></a></legend> 
	  <div><input type="text" name="post_title" size="30" tabindex="1" value="<?php echo $edited_post_title; ?>" id="title" /></div>
    </fieldset>

    <fieldset id="categorydiv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#category" title="Help on categories"><?php echo _LANG_EF_AD_CATETITLE; ?></a></legend> 
	  <div><?php dropdown_categories($default_post_cat); ?></div>
    </fieldset>

    <fieldset id="poststatusdiv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#post_status" title="Help on post status"><?php echo _LANG_EFA_POST_STATUS; ?></a></legend>
	  <div><label for="post_status_publish" class="selectit"><input id="post_status_publish" name="post_status" type="radio" value="publish" <?php checked($post_status, 'publish'); ?> /> <?php echo _LANG_EF_AD_PUBLISH; ?></label> 
	  <label for="post_status_draft" class="selectit"><input id="post_status_draft" name="post_status" type="radio" value="draft" <?php checked($post_status, 'draft'); ?> /> <?php echo _LANG_EF_AD_DRAFT; ?></label> 
	  <label for="post_status_private" class="selectit"><input id="post_status_private" name="post_status" type="radio" value="private" <?php checked($post_status, 'private'); ?> /> <?php echo _LANG_EF_AD_PRIVATE; ?></label></div>
    </fieldset>
    <fieldset id="commentstatusdiv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#comments" title="Help on comment status"><?php echo _LANG_EFA_AD_COMMENTS; ?></a></legend> 
	  <div><label for="comment_status_open" class="selectit"><input id="comment_status_open" name="comment_status" type="radio" value="open" <?php checked($comment_status, 'open'); ?> />  <?php echo _LANG_EFA_STATUS_OPEN; ?></label> 
	  <label for="comment_status_closed" class="selectit"><input id="comment_status_closed" name="comment_status" type="radio" value="closed" <?php checked($comment_status, 'closed'); ?> /> <?php echo _LANG_EFA_STATUS_CLOSE; ?></label></div>
    </fieldset>
    <fieldset id="pingstatusdiv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#pings" title="Help on ping status"><?php echo _LANG_EFA_AD_PINGS; ?></a></legend> 
	  <div><label for="ping_status_open" class="selectit"><input id="ping_status_open" name="ping_status" type="radio" value="open" <?php checked($ping_status, 'open'); ?> /> <?php echo _LANG_EFA_STATUS_OPEN; ?></label> 
	  <label for="ping_status_closed" class="selectit"><input id="ping_status_closed" name="ping_status" type="radio" value="closed" <?php checked($ping_status, 'closed'); ?> /> <?php echo _LANG_EFA_STATUS_CLOSE; ?></label></div>
    </fieldset>
    <fieldset id="postpassworddiv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#post_password" title="Help on post password"><?php echo _LANG_EFA_POST_PASSWORD; ?></a></legend> 
	  <div><input name="post_password" type="text" size="18" id="post_password" value="<?php echo $post_password ?>" /></div>
    </fieldset>

<br />
<fieldset style="clear:both">
<legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#excerpt" title="Help with excerpts"><?php echo _LANG_EFA_POST_EXCERPT; ?></a></legend>
<div><textarea rows="2" cols="40" name="excerpt" tabindex="4" id="excerpt"><?php echo $excerpt ?></textarea></div>
</fieldset>

<fieldset id="postdiv">
<legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#post" title="Help with post field"><?php echo _LANG_EF_AD_POSTAREA; ?></a></legend>
		<div id="quicktags">
<?php
if ($wp_use_spaw==false) {

if (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx)))) {
	echo '<a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#quicktags" title="Help with quicktags"><?php echo _LANG_EF_AD_POSTQUICK; ?></a>: ';
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
<div><textarea rows="<?php echo $rows; ?>" cols="40" name="wp_content" tabindex="5" id="wp_content"><?php echo $content ?></textarea></div>
<?php
} else {
// For Spaw Editor
    include_once "spaw/spaw_control.class.php";
//	$content = html_entity_decode($content);
	$trans_tbl = get_html_translation_table (HTML_SPECIALCHARS);
	$trans_tbl = array_flip ($trans_tbl);
	$content = strtr ($content, $trans_tbl);

	$sw = new SPAW_Wysiwyg( 'wp_content', $content, _LANGCODE , 'full', 'default', '70%', '400px'  );
	$sw -> show();
    foreach($wpsmiliestrans[$wp_id] as $smiley => $img) 
    { 
        print '<a href="javascript:bbinsert(document.post,\'\',\''.str_replace("'","\'",$smiley).'\')"><img src="' . $smilies_directory . '/'. $img . '" alt="' . $smiley . '" /></a> '; 
    } 
	echo "<script src=\"quicktags_spaw.js\" language=\"JavaScript\" type=\"text/javascript\"></script>";
//
}
?>
</fieldset>

<?php
if ($wp_use_spaw==false) {
if (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx)))) {
?>
<script type="text/javascript" language="JavaScript">
<!--
edCanvas = document.getElementById('wp_content');
//-->
</script>
<?php
}
}
if ($action != 'editcomment') {
    if (get_settings('use_geo_positions')) {
        if (empty($edited_lat)) {
            if (get_settings('use_default_geourl')) {
                $edited_lat = get_settings('default_geourl_lat');
                $edited_lon = get_settings('default_geourl_lon');
            }
        }
?>
<label for="post_latf"><?php echo _LANG_EFA_POST_LATITUDE; ?></label><input size="8" type="text" value="<?php echo $edited_lat; ?>" name="post_latf">&nbsp;
<label for="post_lonf"><?php echo _LANG_EFA_POST_LONGITUDE; ?></label><input size="8" type="text" value="<?php echo $edited_lon; ?>" name="post_lonf">&nbsp; <a href="http://www.geourl.org/resources.html" rel="external" ><?php echo _LANG_EFA_POST_GEOINFO; ?></a>
<br />
<?php
    }
}
?>

<?php echo $form_pingback ?>
<?php echo $form_prevstatus ?>

<p>
<?php
if ($action != 'editcomment') {
    if ( (get_settings('use_fileupload')) && ($user_level >= get_settings('fileupload_minlevel'))
         && (in_array($user_login, $allowed_users) || (trim(get_settings('fileupload_allowedusers'))=="")) ) { ?>
<input type="button" value="<?php echo _LANG_EFA_STATUS_UPLOAD; ?>" onclick="launchupload();" tabindex="10" />
<?php }
}
?>
<?php echo $saveasdraft; ?> <input type="submit" name="submit" value="<?php echo _LANG_EF_AD_DRAFT; ?>" tabindex="6" /> 
  <input name="publish" type="submit" id="publish" tabindex="10" value="<?php echo _LANG_EF_AD_PUBLISH; ?>" /> 
  <input name="referredby" type="hidden" id="referredby" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
</p>


<?php
echo $form_trackback;

// if the level is 5+, allow user to edit the timestamp - not on 'new post' screen though
// if (($user_level > 4) && ($action != "post"))
if ($user_level > 4) {
	touch_time(($action == 'edit'));
}
if ('edit' == $action) echo "
<p><a href='post.php?action=delete&amp;post=$post->ID' onclick=\"return confirm('You are about to delete this post \'".addslashes($edited_post_title)."\'\\n  \'Cancel\' to stop, \'OK\' to delete.')\">"._LANG_EFA_DEL_THISPOST."</a></p>";
?>

</div>
</form>

</div>
