<?
global $tableoptions;
function b_wp_recent_comments_edit($options)
{
	$form = "";
	$form .= "Comment List Style (=0 or 1): ";
	$form .= "<input type='text' name='options[]' value='".$options[0]."' /><br />";
	$form .= "Comment List Count: ";
	$form .= "<input type='text' name='options[]' value='".$options[1]."' /><br />";
	return $form;

}
function b_wp_recent_comments_show($options)
{
	$block_style =  ($options[0])?$options[0]:0;
	$num_of_list = (empty($options[1]))? 10 : $options[1];
	$id=1;
	global $tableposts,$tablepost2cat,$tablecomments,$tablecategories;
	global $tablelinks,$tablelinkcategories;
	global $dateformat, $time_difference, $siteurl, $blogfilename;
    global $querystring_start, $querystring_equal, $querystring_separator, $month, $wpdb, $start_of_week;
	global $smilies_directory, $use_smilies, $wp_smiliessearch, $wp_smiliesreplace;
	global $wp_bbcode, $use_bbcode, $wp_gmcode, $use_gmcode, $use_htmltrans, $wp_htmltrans, $wp_htmltranswinuni;
	require_once(dirname(__FILE__).'/../wp-blog-header.php');
	global $wpdb, $tablecomments, $tableposts;

	if ($block_style==0) {
		$no_comments = $num_of_list;
		$comment_lenth = 30;
		$skip_posts = 0;
		$request = "SELECT ID, comment_ID, comment_content, comment_author FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_status = 'publish' ";
		$request .= "AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT $no_comments";
		$lcomments = $wpdb->get_results($request);
		$output = '<ul>';
		$output = '';
		foreach ($lcomments as $lcomment) {
			if (preg_match('|<trackback />|', $lcomment->comment_content)) $type='[TrackBack]';
			elseif (preg_match('|<pingback />|', $lcomment->comment_content)) $type='[PingBack]';
			else  $type='[Comment]';

			$comment_author = stripslashes($lcomment->comment_author);
			$comment_content = strip_tags($lcomment->comment_content);
			$comment_content = stripslashes($comment_content);
			$comment_excerpt = mb_substr($comment_content,0,$comment_lenth);
	//      $words=split(" ",$comment_content);
	//      $comment_excerpt = join(" ",array_slice($words,0,$comment_lenth));
			$permalink = get_permalink($lcomment->ID)."#comment-".$lcomment->comment_ID;
			$output .= '<li style="font-size:90%"><strong>' . $comment_author . ':</strong> <a href="' . $permalink;
			$output .= '" title="View the entire comment by ' . $comment_author.'">' . $comment_excerpt . '...</a> <span style=\"font-size:70%\">- '.$type.'</span></li>';
		}
		$output .= '</ul>';	
	} else {
		$output = tkzy_get_recent_comments($num_of_list);
	}
	$block['content'] = $output;
	return $block;
}
function tkzy_get_recent_comments($limit = 10) { 
     global $wpdb, $tablecomments, $tableposts; 
     global $siteurl, $blogfilename; 
     $comments = $wpdb->get_results("SELECT ID, post_title, post_date, 
     comment_ID, comment_author, comment_author_url, comment_author_email, comment_date, comment_content 
     FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID 
     ORDER BY $tablecomments.comment_date DESC LIMIT $limit"); 
     $output = ''; 
     function sort_comment_by_date($a, $b){ 
          if( $b->ID == $a->ID ){ 
               return mysql2date('U',$a->comment_date) - mysql2date('U',$b->comment_date); 
          } 
          return mysql2date('U',$b->post_date) - mysql2date('U',$a->post_date); 
     } 
     if($comments){ 
          usort($comments, "sort_comment_by_date"); 
     } 
     $new_post_ID = -1; 
     foreach ($comments as $comment) { 
          if ($comment->ID != $new_post_ID) { // next post 
               if ($new_post_ID != -1) { $output .= "\t</ul>\n</li>\n"; } 
               $post_title = stripslashes($comment->post_title); 
               $permalink = "$siteurl/$blogfilename?p=$comment->ID&amp;c=1"; 
               $output .= "<li>"; 
               $output .= "<a href=\"$permalink\">$post_title</a>\n"; 
               $output .= "\t<ul>\n"; 
               $new_post_ID = $comment->ID; 
          } 
          $comment_date = $comment->comment_date; 
          if ( time() - mysql2date('U', $comment_date) < 60*60*24 ) { # within 24 hours 
               $comment_date = mysql2date('H:i', $comment_date); 
          } else { 
               $comment_date = mysql2date('m/d', $comment_date); 
          } 
          $output .= "\t\t<li style=\"list-style: none;\"><span style=\"font-size:90%;\" class=\"comment_date\">$comment_date </span>". 
               "<span class=\"comment_author\">".tkzy_get_comment_author_link($comment,25)."</span></li>\n"; 
		if (preg_match('|<trackback />|', $comment->comment_content)) $type='[TrackBack]';
		elseif (preg_match('|<pingback />|', $comment->comment_content)) $type='[Ping]';
		else  $type='[Comment]';
		
		$output .= "<span style=\"font-size:70%\"> - $type</span>";
     } 
     $output .= "\t</ul>\n</li>\n"; 
     return $output; 
} 
function tkzy_get_comment_author_link($my_comment,$abbr=0) { 
     // modified comment_author_link() 
     $ret = ""; 
    $url = trim(stripslashes($my_comment->comment_author_url)); 
    $email = stripslashes($my_comment->comment_author_email); 
    $author = stripslashes($my_comment->comment_author); 
    if (empty($author)) { 
        $author = "Anonymous"; 
    } 
     if ($abbr && mb_strlen($author) > $abbr) { 
          $author = mb_substr($author, 0, $abbr); 
          $author .= ".."; 
     } 

    $url = str_replace('http://url', '', $url); 
    $url = preg_replace('|[^a-z0-9-_.?#=&;,/:~]|i', '', $url); 
    if (empty($url) && empty($email)) { 
          $ret .= $author; 
     }else{ 
          $ret .= '<a href="'; 
          if ($url) { 
               $url = str_replace(';//', '://', $url); 
               $url = (!strstr($url, '://')) ? 'http://'.$url : $url; 
               $url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url); 
               $ret .= $url; 
          } else { 
               $ret .= 'mailto:'.antispambot($email); 
          } 
          $ret .= '" rel="external">' . $author . '</a>'; 
     } 
     return $ret; 
} 

?>
