<?php
$blog = 1; // enter your blog's ID
$doing_rss = 1;
header("Content-type: application/xml");
include_once (dirname(__FILE__)."/../../mainfile.php");
error_reporting(E_ERROR);
if ($HTTP_GET_VARS['num']) $showposts = $HTTP_GET_VARS['num'];
require('wp-blog-header.php');
if (isset($showposts) && $showposts) {
    $showposts = (int)$showposts;
	$posts_per_page = $showposts;
} else {
	$posts_per_page = get_settings('posts_per_rss');
}

if (function_exists('mb_convert_encoding')) {
	$rss_charset = 'utf-8';
}else{
	$rss_charset = $blog_charset;
}
?>
<?php echo '<?xml version="1.0" encoding="'.$rss_charset.'"?'.'>'; ?>
<!-- generator="wordpress/<?php echo $wp_version ?>" -->
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

<?php $items_count = 0; if ($posts) { foreach ($posts as $post) { start_wp(); ?>
        <item>
            <title><?php the_title_rss() ?></title>
<?php
// we might use this in the future, but not now, that's why it's commented in PHP
// so that it doesn't appear at all in the RSS
//          echo "<category>"; the_category_unicode(); echo "</category>";
$more = 1; 
if (get_settings('rss_use_excerpt')) {
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
<?php $items_count++; if (($items_count ==$posts_per_page) && empty($m)) { break; } } } ?>
    </channel>
</rss>