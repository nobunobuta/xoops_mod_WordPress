<?php
/* <Bookmarklet> */
// accepts 'post_title' and 'content' as vars passed in. Add-on from Alex King
require_once('admin.php');
$mode = 'bookmarklet';
$GLOBALS['standalone'] = 1;
$GLOBALS['title'] = 'WordPress Bookmarklet';
require_once('admin-header.php');
require_once(XOOPS_ROOT_PATH.'/class/template.php');

if ($GLOBALS['user_level'] == 0) {
	redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
	exit();
}

init_param('', 'action', 'string', '');

if (get_param('action') == 'done') {

?><html>
<head>
<script language="javascript" type="text/javascript">
<!--
window.close()
-->
</script>
</head>
<body></body>
</html><?php

} else {
	init_param('GET', 'popuptitle','string','');
	init_param('GET', 'popupurl','string','');
	init_param('GET', 'text','html','');
	init_param('GET', 'post_pingback','integer',0);

	$action = 'post';
	$pinged = '';
    $default_post_cat = get_settings('default_post_category');

    /* big funky fixes for browsers' javascript bugs */
    $_popuptitle = fix_js_param(get_param('popuptitle'));
    $_text = fix_js_param(get_param('text'));

	$_popuptitle = sanitize_text($_popuptitle);
	$_text = sanitize_text($_text,true);
	$_popupurl = sanitize_text(get_param('popupurl'),true, true);
	
    $post_title = $_popuptitle;
    $edited_post_title = $post_title;
    $content = '<a href="'.$_popupurl.'">'.$_popuptitle.'</a>'."\n$_text";
    
// autodetect Trackback

	$tb_obj = new WP_TrackBack_XML_collection;
	$trackback_url = $tb_obj->get($_popupurl);
	$target_charset = $tb_obj->charset;
	
	$_css_file = get_custom_url('wp-admin.css');
	$_xoops_css = xoops_getcss($GLOBALS['xoopsConfig']['theme_set']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress > Bookmarklet</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['blog_charset'] ?>" />
<link rel="stylesheet" href="<?php echo $_xoops_css ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $_css_file ?>" type="text/css" />
<link rel="shortcut icon" href="../wp-images/wp-favicon.png" />
<script type="text/javascript" language="javascript">
<!--
function launchupload() {
	window.open ("upload.php", "wpupload", "width=380,height=360,location=0,menubar=0,resizable=1,scrollbars=yes,status=1,toolbar=0");
}

//-->
</script>
<style type="text/css">
<!--
#wpbookmarklet textarea,input,select {
	border-width: 1px;
	border-style: solid;
	padding: 2px;
	margin: 1px;
}

#wpbookmarklet .checkbox {
	border-width: 0px;
	padding: 0px;
	margin: 0px;
}

#wpbookmarklet textarea {
	height:180px;
}

#wpbookmarklet .wrap {
    border: 0px;
}	

#wpbookmarklet #postdiv {
    margin-bottom: 0.5em;
}

#wpbookmarklet #titlediv {
    margin-bottom: 1em;
}

-->
</style>
</head>
<body id="wpbookmarklet">
<h2>New Post to "<?php echo get_settings('blogname');?>"</h2>
<div id="wpAdminMain">
<?php require('edit-form.php'); ?>
</div>
</body>
</html>
<?php
}
?>
