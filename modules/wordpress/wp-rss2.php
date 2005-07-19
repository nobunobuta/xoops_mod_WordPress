<?php 
$GLOBALS['blog'] = 1;
$GLOBALS['doing_rss'] = 1;
require_once(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
init_param('GET', 'num','integer');
if (test_param('num')) $GLOBALS['showposts'] = get_param('num');
$lastpostdate = mysql2date('Y-m-d H:i:s', get_lastpostmodified());
$lastpostdate = mysql2date('U',$lastpostdate);
static_content_header($lastpostdate);
require_once('wp-blog-header.php');
header('Content-type: application/xml');
?>
<?php echo '<?xml version="1.0" encoding="'.wp_get_rss_charset().'"?'.'>'; ?>
<!-- generator="wordpress/<?php echo $GLOBALS['wp_version'] ?>" -->
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/">

<channel>
	<title><?php bloginfo_rss('name') ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<language><?php echo (get_settings('rss_language')?get_settings('rss_language'):'en') ?></language>
	<copyright>Copyright <?php echo mysql2date('Y', get_lastpostdate()); ?></copyright>
	<pubDate><?php echo gmdate('r',$lastpostdate); ?></pubDate>
	<generator>http://www.kowa.org/?v=<?php echo $GLOBALS['wp_version_str'] ?></generator>

	<?php if ($GLOBALS['posts']) { foreach ($GLOBALS['posts'] as $GLOBALS['post']) { start_wp(); ?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php permalink_single_rss() ?></link>
		<comments><?php comments_link(); ?></comments>
		<pubDate><?php the_time('r'); ?></pubDate>
		<author><?php the_author_rss() ?> &lt;<?php the_author_email() ?>&gt;</author>
		<?php the_category_rss() ?>
		<guid isPermaLink="true"><?php permalink_single_rss() ?></guid>
<?php $GLOBALS['more'] = 1; if (get_settings('rss_use_excerpt')) {
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
	<?php } } ?>
</channel>
</rss>