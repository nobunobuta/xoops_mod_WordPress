<div class="wrap">
<?php

$allowed_users = explode(" ", trim(get_settings('fileupload_allowedusers')));

$submitbutton_text = 'Blog this!';
$toprow_title = 'New Post';
$form_action = 'post';
$form_extra = '';
if (get_settings('use_pingback')) {
	$form_pingback = '<input type="checkbox" class="checkbox" name="post_pingback" value="1" ';
	if ($post_pingback) $form_pingback .= 'checked="checked" ';
	$form_pingback .= 'tabindex="7" id="pingback" />' ._LANG_EF_PING_FORM;
} else {
	$form_pingback = '';
}
if (get_settings('use_trackback')) {
	$form_trackback = _LANG_EF_TRACK_FORM.'	<input type="text" name="trackback_url" style="width: 360px" id="trackback" tabindex="7" value="'.$trackback_url.'"/>';
	if ('bookmarklet' != $mode) {
		$form_trackback .= '&nbsp;&nbsp;&nbsp;Use UTF-8:<input value="1" type="checkbox" name="useutf8" id="useutf8" />';
	}
	$form_trackback .= '</p>';
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
$colspan = 3;
$saveasdraft = '';


?>

<form name="post" action="post.php" method="post" id="post">

<?php
if ('bookmarklet' == $mode) {
    echo '<input type="hidden" name="mode" value="bookmarklet" />';
    if ($target_charset) {
    	echo '<input type="hidden" name="target_charset" value="'.$target_charset.'" />';
    }
}
?>
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
<style media="screen" type="text/css">
#titlediv, #postpassworddiv {
	height: 3.5em;
}
</style>
<div id="poststuff">
    <fieldset id="titlediv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#title" title="Help on titles"><?php echo _LANG_EF_AD_POSTTITLE; ?></a></legend> 
	  <div><input type="text" name="post_title" size="30" tabindex="1" value="<?php echo $edited_post_title; ?>" id="title" /></div>
    </fieldset>
    <fieldset id="categorydiv">
      <legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#category" title="Help on categories"><?php echo _LANG_EF_AD_CATETITLE; ?></a></legend> 
	  <div><?php dropdown_categories($default_post_cat); ?></div>
    </fieldset>

<br />
<fieldset id="postdiv">
<legend><a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#post" title="Help with post field"><?php echo _LANG_EF_AD_POSTAREA; ?></a></legend>
		<div id="quicktags">
<?php
if ($wp_use_spaw==false||!$is_winIE) {
if (get_settings('use_quicktags') && 'bookmarklet' != $mode) {
	echo '<a href="http://wordpress.xwd.jp/wiki/index.php?Reference%20Post%2FEdit#quicktags" title="Help with quicktags">'._LANG_EF_AD_POSTQUICK.'</a>: ';
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
<div><textarea rows="<?php echo $rows; ?>" cols="40" name="wp_content" tabindex="4" id="wp_content"><?php echo $content ?></textarea></div>
<?php
} else {
// For Spaw Editor
    include_once "spaw/spaw_control.class.php";
//	$content = html_entity_decode($content);
	$trans_tbl = get_html_translation_table (HTML_SPECIALCHARS);
	$trans_tbl = array_flip ($trans_tbl);
	$content = strtr ($content, $trans_tbl);
	$sw = new SPAW_Wysiwyg( 'wp_content', $content, _LANGCODE, 'full', 'default', '70%', '400px' );
	$sw -> show();
    foreach($wpsmiliestrans[$wp_id] as $smiley => $img) 
    { 
        print '<a href="javascript:bbinsert(document.post,\'\',\''.str_replace("'","\'",$smiley).'\')"><img src="' . $smilies_directory . '/'. $img . '" alt="' . $smiley . '" /></a> '; 
    } 
echo "<br />"; 
echo "<script src=\"quicktags_spaw.js\" language=\"JavaScript\" type=\"text/javascript\"></script>";
//
}
?>
</fieldset>

<?php
if ($wp_use_spaw==false||!$is_winIE) {
if (get_settings('use_quicktags')&&(!(($is_macIE) || ($is_lynx)))) {
?>
<script type="text/javascript" language="JavaScript">
<!--
edCanvas = document.getElementById('wp_content');
//-->
</script>
<?php }} ?>

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
<input name="saveasdraft" type="submit" id="saveasdraft" tabindex="9" value="<?php echo _LANG_EF_AD_DRAFT; ?>" /> 
  <input name="saveasprivate" type="submit" id="saveasprivate" tabindex="10" value="<?php echo _LANG_EF_AD_PRIVATE; ?>" /> 
  <input name="publish" type="submit" id="publish" tabindex="6" value="<?php echo _LANG_EF_AD_PUBLISH; ?>" /> 
  <?php if ('bookmarklet' != $mode) {
      echo '<input name="advanced" type="submit" id="advancededit" tabindex="7" value="'._LANG_EF_AD_EDITING.'" />';
  } ?>
  <input name="referredby" type="hidden" id="referredby" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
</p>


<?php

echo $form_trackback;
?>

</div>
</form>

</div>
