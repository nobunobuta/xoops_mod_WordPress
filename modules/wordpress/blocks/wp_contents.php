<?php
function b_wp_contents_edit($options)
{
	$form = "";
	$form .= "Number of posts to show: ";
	$form .= "<input type='text' name='options[]' value='".$options[0]."' /><br />";
	return $form;

}
function b_wp_contents_show($options) {
	$id=1;
	global $posts, $post, $day, $previousday, $newday;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
	global $tablelinks,$tablelinkcategories;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $smilies_directory, $use_smilies, $wp_smiliessearch, $wp_smiliesreplace;
	global $wp_bbcode, $use_bbcode, $wp_gmcode, $use_gmcode, $use_htmltrans, $wp_htmltrans, $wp_htmltranswinuni;
	global $posts_per_page;

	if (!empty($options[0])) {
	   $num_posts = $options[0];
	}
	require_once (dirname(__FILE__).'/../wp-blog-header.php');
	$blog = 1;
	$block = array();
	$block['siteurl'] = $siteurl;
	$i = 0;
	$previousday = 0;
	foreach ($posts as $post) {
		$i++;
		if ($i > $num_posts) continue;
		
		$content = array();
		start_wp();
		$content['date'] = the_date('','<h2>','</h2>', false);
		$content['time'] = the_time('', false);
		$content['title'] = the_title('','', false);
		$content['permlink'] = get_permalink();
//
		ob_start();
		the_author();
		$content['author'] = ob_get_contents();
		ob_end_clean();
//
		ob_start();
		the_category();
		$content['category'] = ob_get_contents();
		ob_end_clean();
//	
		ob_start();
		the_content();
		$content['body'] = ob_get_contents();
		ob_end_clean();
//
		ob_start();
		link_pages('<br />Pages: ', '<br />', 'number');
		$content['linkpage'] = ob_get_contents();
		ob_end_clean();
//
		ob_start();
		comments_popup_link(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS);
		$content['comments'] = ob_get_contents();
		ob_end_clean();
//
		ob_start();
		trackback_rdf();
		$content['trackback'] = ob_get_contents();
		ob_end_clean();
//
		$block['contents'][] = $content;
	}
	$previousday = 0;
	return $block;
}
?>
