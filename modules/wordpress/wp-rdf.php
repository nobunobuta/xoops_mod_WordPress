<?php /* RDF 1.0 generator, original version by garym@teledyn.com */
$blog = 1; // enter your blog's ID
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

add_filter('the_content', 'trim');
$rss_charset = wp_get_rss_charset();
?>
<?php echo '<?xml version="1.0" encoding="'.$rss_charset.'"?'.'>'; ?>
<!-- generator="wordpress/<?php echo $wp_version ?>" -->
<rdf:RDF
	xmlns="http://purl.org/rss/1.0/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
>
<channel rdf:about="<?php bloginfo_rss("url") ?>">
	<title><?php bloginfo_rss('name') ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<dc:language><?php echo (get_settings('rss_language')?get_settings('rss_language'):'en') ?></dc:language>
	<dc:date><?php echo gmdate('Y-m-d\TH:i:s'); ?></dc:date>
<?php if (function_exists('mb_convert_encoding')) { ?>
	<dc:creator><?php echo antispambot(mb_convert_encoding(get_settings('admin_email'),$rss_charset,$blog_charset)) ?></dc:creator>
<?php } else { ?>
	<dc:creator><?php echo antispambot(get_settings('admin_email')) ?></dc:creator>
<?php } ?>
	<admin:generatorAgent rdf:resource="http://wordpress.xwd.jp/?v=<?php echo $wp_version ?>"/>
	<admin:errorReportsTo rdf:resource="mailto:<?php echo antispambot(get_settings('admin_email')) ?>"/>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<sy:updateBase>2000-01-01T12:00+00:00</sy:updateBase>
	<items>
		<rdf:Seq>
		<?php $items_count = 0; if ($posts) { foreach ($posts as $post) { start_wp(); ?>
			<rdf:li rdf:resource="<?php permalink_single_rss() ?>"/>
		<?php /*$wp_items[] = $row;*/ $items_count++; if (($items_count == get_settings('posts_per_rss')) && empty($m)) { break; } } } ?>
		</rdf:Seq>
	</items>
</channel>
<?php if ($posts) { foreach ($posts as $post) { start_wp(); ?>
<item rdf:about="<?php permalink_single_rss() ?>">
	<title><?php the_title_rss() ?></title>
	<link><?php permalink_single_rss() ?></link>
	<dc:date><?php the_time('Y-m-d\TH:i:s'); ?></dc:date>
	<dc:creator><?php the_author_rss() ?> &lt;<?php the_author_email() ?>&gt;</dc:creator>
	<?php the_category_rss('rdf') ?>
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
	<content:encoded><![CDATA[<?php the_content_rss('', 0, '', 0, 3) ?>]]></content:encoded>
</item>
<?php } }  ?>
</rdf:RDF>