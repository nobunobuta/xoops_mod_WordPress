<?php
$GLOBALS['xoopsOption']['show_rblock'] =1;
include_once (dirname(__FILE__)."/../../mainfile.php");
include(XOOPS_ROOT_PATH.'/header.php');
require('wp-blog-header.php');
/* Sending HTTP headers */
// It is presumptious to think that WP is the only thing that might change on the page.
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 				// Date in the past
@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
@header("Cache-Control: no-store, no-cache, must-revalidate"); 	// HTTP/1.1
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma: no-cache"); 									// HTTP/1.0
@header ("X-Pingback: ".wp_siteurl()."/xmlrpc.php");
ob_start();
?>
	<meta name="generator" content="WordPress <?php echo $GLOBALS['wp_version']; ?>" />
	<!-- leave this for stats -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_custom_url('wp-layout.css') ?>" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_custom_url('print.css') ?>" />
	<link rel="alternate" type="application/rdf+xml" title="RDF" href="<?php bloginfo('rdf_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<?php
	$userObject = false;
	if (!empty($GLOBALS['author_name'])) {
		$_user = get_userdatabylogin($GLOBALS['author_name']);
		$author = $_user->ID;
		$author_name = $GLOBALS['author_name'];
?>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0(by <?php echo $author_name; ?>)" href="<?php get_author_rss_link(true, $author, $author_name); ?>" />
<?php
	} else if (!empty($GLOBALS['author'])) {
		$_user = get_userdata($GLOBALS['author']);
		$author = $GLOBALS['author'];
		$author_name = $_user->user_login;
?>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0(by <?php echo $author_name; ?>)" href="<?php get_author_rss_link(true, $author, $author_name); ?>" />
<?php
    } else if (!empty($GLOBALS['p'])) {
        $_user = get_userdata($GLOBALS['post']->post_author);
        $author = $_user->ID;
        $author_name = $_user->user_login;
?>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0(by <?php echo $author_name; ?>)" href="<?php get_author_rss_link(true, $author, $author_name); ?>" />
<?php
	}
?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo wp_siteurl(); ?>/wp-rsd.php" />
<?php get_archives('monthly', '', 'link'); ?>
<?php // comments_popup_script(); // off by default ?>
<?php
$_my_header = ob_get_contents();
ob_end_clean();

$_module_title = get_bloginfo('name');
if (!strstr($_SERVER['REQUEST_URI'], 'wp-comments-post.php')) {
	$_sub_title = wp_title("",false);
	if (trim($_sub_title)) {
		$_module_title .= ' : '. $_sub_title;
	}
}
if ($GLOBALS['xoopsTpl']){
	$GLOBALS['xoopsTpl']->assign("xoops_pagetitle",$_module_title);
	$GLOBALS['xoopsTpl']->assign('xoops_module_header', $_my_header);
}

?>