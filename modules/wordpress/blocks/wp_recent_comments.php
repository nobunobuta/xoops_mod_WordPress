<?php
if( ! defined( 'WP_RECENT_COMMENTS_INCLUDED' ) ) {

	define( 'WP_RECENT_COMMENTS_INCLUDED' , 1 ) ;

	function b_wp_recent_comments_edit($options)
	{
		$form = "";
		$form .= "Comment List Style (=0 or 1): ";
		$form .= "<input type='text' name='options[]' value='".$options[0]."' /><br />";
		$form .= "Comment List Count: ";
		$form .= "<input type='text' name='options[]' value='".$options[1]."' /><br />";
		$form .= "<br />Display RSS Icon:&nbsp;";
		if ( $options[2] == 1 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[2]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		if ( $options[2] == 0 ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[2]' value='0'".$chk." />"._NO."<br />";
		return $form;

	}
	function b_wp_recent_comments_show($options, $wp_num="")
	{
		$block_style =  ($options[0])?$options[0]:0;
		$num_of_list = (empty($options[1]))? 10 : $options[1];
		$show_rss_icon = (empty($options[2]))? 0 : $options[2];

		global $wpdb, $siteurl, $wp_id, $wp_inblock, $use_cache;

		$id=1;
		$use_cache = 1;

		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}

		if ($block_style==0) {
			$no_comments = $num_of_list;
			$comment_lenth = 30;
			$skip_posts = 0;
			$request = "SELECT ID, comment_ID, comment_content, comment_author FROM {$wpdb->posts[$wp_id]}, {$wpdb->comments[$wp_id]} WHERE {$wpdb->posts[$wp_id]}.ID={$wpdb->comments[$wp_id]}.comment_post_ID AND post_status = 'publish' ";
			$request .= "AND comment_approved = '1' ORDER BY {$wpdb->comments[$wp_id]}.comment_date DESC LIMIT $no_comments";
			$lcomments = $wpdb->get_results($request);
			$output = '<ul>';
			$output = '';
			if ($lcomments) {
				foreach ($lcomments as $lcomment) {
					if (preg_match('|<trackback />|', $lcomment->comment_content)) $type='[TrackBack]';
					elseif (preg_match('|<pingback />|', $lcomment->comment_content)) $type='[PingBack]';
					else  $type='[Comment]';

					$comment_author = stripslashes($lcomment->comment_author);
					$comment_content = strip_tags($lcomment->comment_content);
					$comment_content = stripslashes($comment_content);
					if (function_exists('mb_substr')) {
						$comment_excerpt = mb_substr($comment_content,0,$comment_lenth);
					} else {
						$comment_excerpt = substr($comment_content,0,$comment_lenth);
					}
					$permalink = get_permalink($lcomment->ID)."#comment-".$lcomment->comment_ID;
					$output .= '<li style="list-style-type:none; list-style-position: outside; text-indext:0px; font-size:90%"><strong>' . $comment_author . ':</strong> <a href="' . $permalink;
					$output .= '" title="View the entire comment by ' . $comment_author.'">' . $comment_excerpt . '...</a> <span style=\"font-size:70%\">- '.$type.'</span></li>';
				}
			}
			$output .= '</ul>';	
		} else {
			$output = tkzy_get_recent_comments($num_of_list);
		}
		if ($show_rss_icon) {
			$output .= '<hr width="100%" />';
			$output .= '<div style="text-align:right">&nbsp;<a href="'.get_bloginfo('comments_rss2_url').'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss_comment.gif" /></a></div>';
		}

		$block['content'] = $output;
		return $block;
	}
	function tkzy_get_recent_comments($limit = 10) { 
	     global $wpdb,  $wp_id; 
	     global $siteurl; 
	     $lcomments = $wpdb->get_results("SELECT ID, post_title, post_date, 
	     comment_ID, comment_author, comment_author_url, comment_author_email, comment_date, comment_content 
	     FROM {$wpdb->posts[$wp_id]}, {$wpdb->comments[$wp_id]} WHERE {$wpdb->posts[$wp_id]}.ID={$wpdb->comments[$wp_id]}.comment_post_ID 
	     ORDER BY {$wpdb->comments[$wp_id]}.comment_date DESC LIMIT $limit"); 
	     $output = ''; 
	     if($lcomments){ 
	          usort($lcomments, "sort_comment_by_date"); 
	     } 
	     $new_post_ID = -1;
	     if ($lcomments) {
		     foreach ($lcomments as $lcomment) { 
		          if ($lcomment->ID != $new_post_ID) { // next post 
		               if ($new_post_ID != -1) { $output .= "\t</ul>\n</li>\n"; } 
		               $post_title = stripslashes($lcomment->post_title); 
		               $permalink = "$siteurl/index.php?p=$lcomment->ID&amp;c=1"; 
		               $output .= "<li>"; 
		               $output .= "<a href=\"$permalink\">$post_title</a>\n"; 
		               $output .= "\t<ul>\n"; 
		               $new_post_ID = $lcomment->ID; 
		          } 
		          $comment_date = $lcomment->comment_date; 
		          if ( time() - mysql2date('U', $comment_date) < 60*60*24 ) { # within 24 hours 
		               $comment_date = mysql2date('H:i', $comment_date); 
		          } else { 
		               $comment_date = mysql2date('m/d', $comment_date); 
		          } 
		          $output .= "\t\t<li style=\"list-style: none;\"><span style=\"font-size:90%;\" class=\"comment_date\">$comment_date </span>". 
		               "<span class=\"comment_author\">".tkzy_get_comment_author_link($lcomment,25)."</span></li>\n"; 
				if (preg_match('|<trackback />|', $lcomment->comment_content)) $type='[TrackBack]';
				elseif (preg_match('|<pingback />|', $lcomment->comment_content)) $type='[Ping]';
				else  $type='[Comment]';
				
				$output .= "<span style=\"font-size:70%\"> - $type</span>";
		     } 
	     }
	     $output .= "\t</ul>\n</li>\n"; 
	     return $output; 
	} 
     function sort_comment_by_date($a, $b){ 
          if( $b->ID == $a->ID ){ 
               return mysql2date('U',$a->comment_date) - mysql2date('U',$b->comment_date); 
          } 
          return mysql2date('U',$b->post_date) - mysql2date('U',$a->post_date); 
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
		if (function_exists('mb_strlen')) {
			if ($abbr && mb_strlen($author) > $abbr) { 
				$author = mb_substr($author, 0, $abbr); 
				$author .= ".."; 
			}
		} else {
			if ($abbr && strlen($author) > $abbr) { 
				$author = substr($author, 0, $abbr); 
				$author .= ".."; 
			}
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
	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_recent_comments_edit($options) {
			return (b_wp_recent_comments_edit($options));
		}

		function b_wp'.$i.'_recent_comments_show($options) {
			global $wpdb, $siteurl, $wp_id, $wp_inblock, $use_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_recent_comments_show($options,"'.$i.'"));
		}
	');
	}
}
?>
