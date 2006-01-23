<?php
$GLOBALS['blog'] = 1;
$GLOBALS['doing_rss'] = 1;
require_once(dirname(__FILE__).'/wp-config.php');
error_reporting(E_ERROR);
init_param('GET', 'num','integer');
if (test_param('num')) $showposts = get_param('num');
require_once('wp-blog-header.php');
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="'.wp_get_rss_charset().'"?'.'>';
?>
<!-- generator="wordpress/<?php echo $wp_version ?>" -->
<rss version="2.0" 
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
<?php
$_i = 0;
foreach ($GLOBALS['posts'] as $GLOBALS['post']) { start_wp();
	if ($_i < 1) {
		$_i++;
?>
	<title><?php if (test_param('p')) { echo 'Comments on: '; the_title_rss(); } else { bloginfo_rss('name'); echo ' Comments'; } ?></title>
	<link><?php test_param('p') ? permalink_single_rss() : bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<dc:language><?php echo (get_settings('rss_language')?get_settings('rss_language'):'en') ?></dc:language>
	<dc:creator><?php echo antispambot(get_settings('admin_email')) ?></dc:creator>
	<dc:rights>Copyright <?php echo mysql2date('Y', get_lastpostdate()); ?></dc:rights>
	<pubDate><?php echo gmdate('r'); ?></pubDate>
	<admin:generatorAgent rdf:resource="http://www.kowa.org/?v=<?php echo $GLOBALS['wp_version_str'] ?>"/>
	<admin:errorReportsTo rdf:resource="mailto:<?php echo antispambot(get_settings('admin_email')) ?>"/>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<sy:updateBase>2000-01-01T12:00+00:00</sy:updateBase>

<?php 
		$_criteria =& new CriteriaCompo(new Criteria('comment_approved','1 '));
		$_criteria->add(new Criteria('post_status','publish'));
		$_criteria->add(new Criteria('post_date',date('Y-m-d H:i:s'), '<'));
		if (test_param('p')) {
			$_criteria->add(new Criteria('comment_post_ID',$GLOBALS['wp_post_id']));
		}
		$_criteria->setOrder('DESC');
		$_criteria->setSort('comment_date');
		$_criteria->setLimit(get_settings('posts_per_rss'));
		$_joinCriteria =& new XoopsJoinCriteria(wp_table('posts'), 'comment_post_id', 'ID');
		$commentHandler =& wp_handler('Comment');
		$commentObjects = $commentHandler->getObjects($_criteria, false,
											 'comment_ID, comment_author, comment_author_email, comment_author_url,
											  comment_date, comment_content, comment_post_ID,'.wp_table('posts').'.ID,
											 '.wp_table('posts').'.post_title,'.wp_table('posts').'.post_password', false, $_joinCriteria);
		// this line is WordPress' motor, do not delete it.
		if ($commentObjects) {
			foreach ($commentObjects as $commentObject) {
				$GLOBALS['comment'] = $commentObject->exportWpObject();
?>
	<item rdf:about="<?php permalink_comments_rss() ?>">
		<title><?php comment_type() ?> on: <?php the_title_rss(true, $GLOBALS['comment']->post_title) ?> by: <?php comment_author_rss() ?></title>
		<link><?php comment_link_rss() ?></link>
		<pubDate><?php comment_time('r'); ?></pubDate>
		<author><?php comment_author_rss(); ?></author>
		<guid isPermaLink="false"><?php comment_ID(); echo ':'.$GLOBALS['comment']->comment_post_ID; ?>@<?php bloginfo_rss('url') ?></guid>
		<?php if (!empty($GLOBALS['comment']->post_password) && $_COOKIE['wp-postpass'] != $GLOBALS['comment']->post_password) { ?>
		<description>Protected Comments: Please enter your password to view comments.</description>
		<content:encoded><![CDATA[<?php echo get_the_password_form() ?>]]></content:encoded>
		<?php } else { ?>
		<description><?php comment_text_rss() ?></description>
		<content:encoded><![CDATA[<?php comment_text_rss(true, false) ?>]]></content:encoded>
		<?php } ?>
	</item>
<?php 
			}
		}
	}
}
?>
</channel>
</rss>