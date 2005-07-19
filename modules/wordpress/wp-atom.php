<?php
$GLOBALS['blog'] = 1;
$GLOBALS['doing_rss'] = 1;
require_once(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
init_param('GET', 'num','integer');
if (test_param('num')) $GLOBALS['showposts'] = get_param('num');
$lastpostdate_s = mysql2date('Y-m-d H:i:s', get_lastpostmodified());
$lastpostdate = mysql2date('U',$lastpostdate_s);
static_content_header($lastpostdate);
require_once('wp-blog-header.php');
header('Content-type: application/xml');
?>
<?php echo '<?xml version="1.0" encoding="'.wp_get_rss_charset().'"?'.'>'; ?>
<feed version="0.3"
  xmlns="http://purl.org/atom/ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xml:lang="<?php echo (get_settings('rss_language')?get_settings('rss_language'):'en') ?>">
	<title><?php bloginfo_rss('name') ?></title>
	<link rel="alternate" type="text/html" href="<?php bloginfo_rss('url') ?>" />
	<tagline><?php bloginfo_rss("description") ?></tagline>
	<modified><?php echo mysql2date('Y-m-d\TH:i:so',$lastpostdate_s); ?></modified>
	<copyright>Copyright <?php echo mysql2date('Y', $lastpostdate_s); ?></copyright>
	<generator url="http://www.kowa.org/" version="<?php echo $GLOBALS['wp_version_str'] ?>">WordPress</generator>
	
	<?php if ($GLOBALS['posts']) { foreach ($GLOBALS['posts'] as $GLOBALS['post']) { start_wp(); ?>
	<entry>
	  	<author>
			<name><?php the_author_rss() ?></name>
		</author>
		<title><?php the_title_rss() ?></title>
		<link rel="alternate" type="text/html" href="<?php permalink_single_rss() ?>" />
		<id><?php bloginfo_rss('url') ?>?p=<?php echo $GLOBALS['wp_post_id']; ?></id>
		<modified><?php the_modtime('Y-m-d\TH:i:so'); ?></modified>
		<issued><?php the_time('Y-m-d\TH:i:so'); ?></issued>
		<?php the_category_rss('rdf') ?>
<?php $GLOBALS['more'] = 1; if (get_settings('rss_use_excerpt')) {
?>
		<summary type="text/html"><?php the_excerpt_rss(get_settings('rss_excerpt_length'), 2) ?></summary>
<?php
} else { // use content
?>
		<summary type="text/html"><?php the_content_rss('', 0, '', get_settings('rss_excerpt_length'), 2) ?></summary>
<?php
} // end else use content
?>
		<content type="text/html" mode="escaped" xml:base="<?php permalink_single_rss() ?>"><![CDATA[<?php the_content_rss('', 0, '', 0, 1) ?>]]></content>
	</entry>
	<?php } } ?>
</feed>
