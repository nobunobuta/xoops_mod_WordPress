<?php
$xoopsOption['show_rblock'] =1;
include_once (dirname(__FILE__)."/../../mainfile.php");
include(XOOPS_ROOT_PATH.'/header.php');
require('wp-blog-header.php');
ob_start();
?>
	<meta name="generator" content="WordPress <?php echo $wp_version; ?>" />
	<!-- leave this for stats -->
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
ob_start();
echo  bloginfo('name');
$blog_name =  ob_get_contents();
ob_end_clean();
$module_title =single_post_title(' :: ',false).single_cat_title(' :: ',false).single_month_title(' :: ',false);
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