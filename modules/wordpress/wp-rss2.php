<?php 
$blog = 1;
$doing_rss = 1;
header("Content-type: application/xml");
include_once (dirname(__FILE__)."/../../mainfile.php");
error_reporting(E_ERROR);
if ($_GET['num']) $showposts = $_GET['num'];
require('wp-blog-header.php');
if (isset($showposts) && $showposts) {
    $showposts = (int)$showposts;
	$posts_per_page = $showposts;
} else {
	$posts_per_page = get_settings('posts_per_rss');
}
$rss_charset = wp_get_rss_charset();
?>
<?php echo '<?xml version="1.0" encoding="'.$rss_charset.'"?'.'>'; ?>
<!-- generator="wordpress/<?php echo $wp_version ?>" -->
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/">

<channel>
	<title><?php bloginfo_rss('name') ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<language><?php echo (get_settings('rss_language')?get_settings('rss_language'):'en') ?></language>
	<copyright>Copyright <?php echo mysql2date('Y', get_lastpostdate()); ?></copyright>
	<pubDate><?php echo gmdate('r'); ?></pubDate>
	<generator>http://wordpress.xwd.jp/?v=<?php echo $wp_version ?></generator>

	<?php $items_count = 0; if ($posts) { foreach ($posts as $post) { start_wp(); ?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php permalink_single_rss() ?></link>
		<comments><?php comments_link(); ?></comments>
		<pubDate><?php the_time('r'); ?></pubDate>
		<author><?php the_author_rss() ?> &lt;<?php the_author_email() ?>&gt;</author>
		<?php the_category_rss() ?>
		<guid isPermaLink="true"><?php permalink_single_rss() ?></guid>
<?php $more = 1; if (get_settings('rss_use_excerpt')) {
?>
		<description><?php the_excerpt_rss(get_settings('rss_excerpt_length'), 2) ?></description>
<?php
} else { // use content
?>
		<description><?php the_content_rss('', 0, '', get_settings('rss_excerpt_length'), 2) ?></description>
<?php
} // end else use content
?>
		<content:encoded><![CDATA[<?php the_content_rss('', 0, '',0, 3) ?>]]></content:encoded>
	</item>
	<?php $items_count++; if (($items_count ==$posts_per_page) && empty($m)) { break; } } } ?>
</channel>
</rss>