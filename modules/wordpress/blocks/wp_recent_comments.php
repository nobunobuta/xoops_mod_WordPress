<?
global $tableoptions;
function b_wp_recent_comments_show($options)
{
	$id=1;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;
	$no_comments = 10;
	$comment_lenth = 30;
	$skip_posts = 0;
	$request = "SELECT ID, comment_ID, comment_content, comment_author FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_status = 'publish' ";
	$request .= "AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT $no_comments";
	$comments = $wpdb->get_results($request);
	$output = '<ul>';
	$output = '';
	foreach ($comments as $comment) {
		if (preg_match('|<trackback />|', $comment->comment_content)) $type='[T]';
		elseif (preg_match('|<pingback />|', $comment->comment_content)) $type='[P]';
		else  $type='[C]';

		$comment_author = stripslashes($comment->comment_author);
		$comment_content = strip_tags($comment->comment_content);
		$comment_content = stripslashes($comment_content);
		$comment_excerpt = mb_substr($comment_content,0,$comment_lenth);
//      $words=split(" ",$comment_content);
//      $comment_excerpt = join(" ",array_slice($words,0,$comment_lenth));
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$output .= '<li style="font-size:90%">'.$type.'<strong>' . $comment_author . ':</strong> <a href="' . $permalink;
		$output .= '" title="View the entire comment by ' . $comment_author.'">' . $comment_excerpt . '...</a></li>';
	}
	$output .= '</ul>';	
	$block['content'] = $output;
	return $block;
}
?>
