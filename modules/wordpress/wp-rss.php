<?php
$GLOBALS['blog'] = 1;
$GLOBALS['doing_rss'] = 1;
require_once(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
init_param('GET', 'num','integer');
if (test_param('num')) $GLOBALS['showposts'] = get_param('num');
require_once('wp-blog-header.php');
header('Content-type: application/xml');
?>
<?php echo '<?xml version="1.0" encoding="'.wp_get_rss_charset().'"?'.'>'; ?>
<!-- generator="wordpress/<?php echo $GLOBALS['wp_version_str'] ?>" -->
<rss version="0.92">
    <channel>
        <title><?php bloginfo_rss("name") ?></title>
        <link><?php bloginfo_rss("url") ?></link>
        <description><?php bloginfo_rss("description") ?></description>
        <lastBuildDate><?php echo gmdate("D, d M Y H:i:s"); ?> GMT</lastBuildDate>
        <docs>http://backend.userland.com/rss092</docs>
        <managingEditor><?php echo antispambot(get_settings('admin_email')) ?></managingEditor>
        <webMaster><?php echo antispambot(get_settings('admin_email')) ?></webMaster>
        <language><?php echo (get_settings('rss_language')?get_settings('rss_language'):'en') ?></language>

<?php if ($GLOBALS['posts']) { foreach ($GLOBALS['posts'] as $GLOBALS['post']) { start_wp(); ?>
        <item>
            <title><?php the_title_rss() ?></title>
<?php 	if (get_settings('rss_use_excerpt')) {
?>
            <description><?php the_excerpt_rss(get_settings('rss_excerpt_length'), get_settings('rss_encoded_html')) ?></description>
<?php
} else { // use content
?>
            <description><?php the_content_rss('', 0, '', get_settings('rss_excerpt_length'), get_settings('rss_encoded_html')) ?></description>
<?php
} // end else use content
?>
            <link><?php permalink_single_rss() ?></link>
        </item>
<?php } } ?>
    </channel>
</rss>