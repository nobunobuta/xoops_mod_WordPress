<?
function b_wp_recent_posts_show($options)
{
	$id=1;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;
	$no_posts = 10;
	$skip_posts = 0;
    $request = "SELECT ID, post_title FROM $tableposts WHERE post_status = 'publish' ";
//  if(!$show_pass_post) { $request .= "AND post_password ='' "; }
    $request .= "ORDER BY post_date DESC LIMIT $skip_posts, $no_posts";
    $posts = $wpdb->get_results($request);
    $output = '';
    foreach ($posts as $post) {
        $post_title = stripslashes($post->post_title);
        $permalink = get_permalink($post->ID);
        $output .= '<li style="font-size:90%"><a href="' . $permalink . '" rel="bookmark" title="Permanent Link: ' . $post_title . '">' . $post_title . '</a></li>';
    }
    $block['content'] = $output;
	return $block;
}
?>
