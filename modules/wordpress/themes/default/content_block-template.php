<?php /* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }?>
<?php //This is WordPress main content XOOPS block Template ?>
<?php start_wp(); ?>
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
</div>
