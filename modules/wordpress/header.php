<?php
$xoopsOption['show_rblock'] =1;
include(XOOPS_ROOT_PATH.'/header.php');
ob_start();
?>
	<meta name="generator" content="WordPress <?php echo $wp_version; ?>" />
	<!-- leave this for stats -->

	<style type="text/css" media="screen">
		@import url( <?php echo $siteurl; ?>/wp-layout.css );
	</style>
	
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo $siteurl; ?>/print.css" />
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
//include(XOOPS_ROOT_PATH.'/header.php');
$xoopsTpl->assign('xoops_module_header', $my_header);
?>