<?php /* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }?>
<?php //This is WordPress main content Template ?>
<div id="wpMainContent">
<?php if ($posts) { foreach ($posts as $post) { start_wp(); ?>

<?php the_date('','<h2>','</h2>'); ?>
	
<div class="post">
	 <h3 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<div class="meta"><?php echo _WP_TPL_FILED_UNDER ?><?php the_category() ?> - <?php the_author_posts_link() ?> @ <?php the_time() ?> <?php edit_post_link(); ?></div>
	
	<div class="storycontent">
		<?php the_content(); ?>
		<br clear=left>
	</div>
	
	<div class="feedback">
		<?php link_pages('<br />Pages: ', '<br />', 'number'); ?> 
		<?php comments_popup_link(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS); ?> 
	</div>
	
	<!--
	<?php trackback_rdf(); ?>
	-->

<?php include(dirname(dirname(dirname(__FILE__))) . '/wp-comments.php'); ?>
</div>

<?php } } else { // end foreach, end if any posts ?>
<p>Sorry, no posts matched your criteria.</p>
<?php } ?>
<p class="credit"><?php echo $wpdb->querycount; ?> queries. <?php timer_stop(1); ?> sec.<br /><cite>Powered by <a href="http://www.kowa.org/" title="NobuNobu XOOPS"><strong>WordPress Module</strong></a> based on <a href="http://wordpress.xwd.jp/" title="Powered by WordPress Japan"><strong>WordPress ME</strong></a> & <a href="http://www.wordpress.org/" title="Powered by WordPress"><strong>WordPress</strong></a></cite></p>
</div>
