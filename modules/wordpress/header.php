<?php
$xoopsOption['show_rblock'] =1;
include_once (dirname(__FILE__)."/../../mainfile.php");
include(XOOPS_ROOT_PATH.'/header.php');
/* Sending HTTP headers */
// It is presumptious to think that WP is the only thing that might change on the page.
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 				// Date in the past
@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
@header("Cache-Control: no-store, no-cache, must-revalidate"); 	// HTTP/1.1
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma: no-cache"); 									// HTTP/1.0
@header ("X-Pingback: $siteurl/xmlrpc.php");
require('wp-blog-header.php');
ob_start();
?>
	<meta name="generator" content="WordPress <?php echo $wp_version; ?>" />
	<!-- leave this for stats -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_custom_url('wp-layout.css') ?>" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_custom_url('print.css') ?>" />
	<link rel="alternate" type="application/rdf+xml" title="RDF" href="<?php bloginfo('rdf_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo $siteurl; ?>/wp-rsd.php" />
<?php get_archives('monthly', '', 'link'); ?>
<?php // comments_popup_script(); // off by default ?>
<?php
$my_header = ob_get_contents();
ob_end_clean();
$blog_name = get_bloginfo('name');

if (!strstr($_SERVER['REQUEST_URI'], 'wp-comments-post.php')) {
	$module_title =single_post_title('',false).single_cat_title('',false).single_month_title('',false).single_author_title(' by ',false);
}
if (trim($module_title) == "") {
	$module_title = $blog_name;
}else{
	$module_title = $blog_name ." : ".$module_title;
}
global $xoopsTpl;
if ($xoopsTpl){
	$xoopsTpl->assign("xoops_pagetitle",$module_title);
	$xoopsTpl->assign('xoops_module_header', $my_header);
}

?>