<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_RECENT_COMMENTS_BLOCK_INCLUDED' ) ) {
	define( 'WP_RECENT_COMMENTS_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_recent_comments_edit($options)
	{
		$form = "<table width='100%'>";
		$form .= "<tr><td width='40%'>Comment List Style (=0 or 1):</td>";
		$form .= "<td><input type='text' name='options[0]' value='".$options[0]."' /></td></tr>";
		
		$form .= "<tr><td>Comment List Count:</td>";
		$form .= "<td><input type='text' name='options[1]' value='".$options[1]."' /></td></tr>";
		
		$form .= "<tr><td>Display RSS Icon:</td>";
		$chk = ( $options[2] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[2]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		$chk = ( $options[2] == 0 ) ? " checked='checked'" : "";
		$form .= "&nbsp;<input type='radio' name='options[2]' value='0'".$chk." />"._NO."</td></tr>";
		
		$form .= "<tr><td>Display Posted Date:</td>";
		$chk = ( $options[3] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[3]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[3] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[3]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "<tr><td>Show Comment Type:</td>";
		$chk = ( $options[4] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[4]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[4] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[4]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "</table>";
		return $form;

	}

	function _b_wp_recent_comments_show($options, $wp_num="")
	{
		$block_style =  ($options[0])?$options[0]:0;
		$num_of_list = (!isset($options[1]))? 10 : $options[1];
		$show_rss_icon = (!isset($options[2]))? 0 : $options[2];
		$cat_date = (!isset($options[3]))? ($block_style ? 1 : 0) : $options[3];
		$show_type = (!isset($options[4]))? 1 : $options[4];

		if ($block_style==0) {
			$no_comments = $num_of_list;
			$comment_lenth = 30;
			$skip_posts = 0;
			$request = "SELECT ID, comment_ID, comment_content, comment_author,comment_date FROM ".wp_table('posts').", ".wp_table('comments')." WHERE ".wp_table('posts').".ID=".wp_table('comments').".comment_post_ID AND post_status = 'publish' AND comment_approved = '1' ";
			if (get_xoops_option(wp_mod(), 'wp_use_xoops_comments') == 1) {
				$request .= "AND (comment_content like '<trackback />%' OR comment_content like '<pingkback />%') ";
			}
			$request .= "ORDER BY ".wp_table('comments').".comment_date DESC LIMIT $no_comments";
			$lcomments = $GLOBALS['wpdb']->get_results($request);
			$output = '';
			$pdate = "";
			if ($lcomments) {
				if (!$cat_date) {
					$output .= "<ul class='wpBlockList'>\n";
				} else {
					$output .= "<ul class='wpBlockDateList'>\n";
				}
				foreach ($lcomments as $lcomment) {
					if ($cat_date) {
						$date=mysql2date("Y-n-j", $lcomment->comment_date);
						if ($date <> $pdate) {
							if ($pdate <> "") {
								$output .= "</ul></li>\n";
							}
							$output .= "<li><span class=\"postDate\">".$date."</span>\n<ul class=\"children\">\n";
							$pdate = $date;
						}
					}

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
					$output .= '<li><span class="comment-author">' . $comment_author . ':</span> <a href="' . $permalink;
					$output .= '" title="View the entire comment by ' . $comment_author.'">' . $comment_excerpt . '...</a>';
					if ($show_type) {
						$output .= '<span style="font-size:70%">- '.$type.'</span>';
					}
					$output .= "</li>\n";
				}
			}
			$output .= "</ul>\n";
			if ($cat_date) {
				$output .= "</li></ul>\n";
			}
		} else {
			$output = tkzy_get_recent_comments($num_of_list, $cat_date, $show_type);
		}
		if ($show_rss_icon) {
			$output .= '<hr width="100%" />';
			$output .= '<div style="text-align:right">&nbsp;<a href="'.get_bloginfo('comments_rss2_url').'"><img src="'.wp_siteurl().'/wp-images/rss_comment.gif" /></a></div>';
		}
		ob_start();
		block_style_get($wp_num);
		echo $output;
		$block['content'] = ob_get_contents();
		ob_end_clean();
		return $block;
	}

	function tkzy_get_recent_comments($limit = 10, $cat_date=1, $show_type = 1) { 
		$comment_lenth = 30;
		$request = "SELECT ID, post_title, post_date, 
		comment_ID, comment_author, comment_author_url, comment_author_email, comment_date, comment_content 
		FROM ".wp_table('posts').", ".wp_table('comments')." WHERE ".wp_table('posts').".ID=".wp_table('comments').".comment_post_ID AND ".wp_table('comments').".comment_approved='1'";
		if (get_xoops_option(wp_mod(), 'wp_use_xoops_comments') == 1) {
			$request .= "AND (comment_content like '<trackback />%' OR comment_content like '<pingkback />%') ";
		}
		$request .= " ORDER BY ".wp_table('comments').".comment_date DESC LIMIT $limit";
		$lcomments = $GLOBALS['wpdb']->get_results($request);
		$output = ''; 
		if($lcomments){ 
			usort($lcomments, "sort_comment_by_date"); 
		} 
		$new_post_ID = -1;
		if ($lcomments) {
			$output .= "<ul class='wpBlockList'>";
			foreach ($lcomments as $lcomment) { 
				if ($lcomment->ID != $new_post_ID) { // next post 
					if ($new_post_ID != -1) { $output .= "\t</ul>\n</li>\n"; } 
					$post_title = stripslashes($lcomment->post_title); 
					if (trim($post_title)=="")
						$post_title = _WP_POST_NOTITLE;
					$comment_content = strip_tags($lcomment->comment_content);
					$comment_content = stripslashes($comment_content);
					if (function_exists('mb_substr')) {
						$comment_excerpt = mb_substr($comment_content,0,$comment_lenth);
					} else {
						$comment_excerpt = substr($comment_content,0,$comment_lenth);
					}
					$permalink = wp_siteurl()."/index.php?p=$lcomment->ID&amp;c=1"; 
					$output .= "<li>"; 
					$output .= "<span class='comment-title'><a href=\"$permalink\">$post_title</a></span>\n"; 
					$output .= "\t<ul class=\"children\" style=\"list-style-type: none;\">\n"; 
					$new_post_ID = $lcomment->ID; 
				} 
				$output .= "\t\t<li>";
				if ($cat_date) {
					$comment_date = $lcomment->comment_date; 
					if ( time() - mysql2date('U', $comment_date) < 60*60*24 ) { # within 24 hours 
					   $comment_date = mysql2date('H:i', $comment_date); 
					} else { 
					   $comment_date = mysql2date('m/d', $comment_date); 
					}
					$output .= "<span class=\"post-date\">$comment_date</span> : "; 
				}
				$output .= "<span class=\"comment_author\">".tkzy_get_comment_author_link($lcomment,25)."</span></li>\n"; 
				if (preg_match('|<trackback />|', $lcomment->comment_content)) $type='[TrackBack]';
				elseif (preg_match('|<pingback />|', $lcomment->comment_content)) $type='[Ping]';
				else  $type='[Comment]';
				if ($show_type) {
					$output .= "<span style=\"font-size:90%\"> - $type</span>";
				}
			} 
		}
		$output .= "\t</ul>\n</li>\n</ul>\n"; 
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
}

eval ('
	function b_'.$_wp_my_prefix.'recent_comments_edit($options) {
		return (_b_wp_recent_comments_edit($options));
	}
	function b_'.$_wp_my_prefix.'recent_comments_show($options) {
		$GLOBALS["use_cache"] = 1;
		$GLOBALS["wp_id"] = "'.(($_wp_my_dirnumber!=='') ? $_wp_my_dirnumber : '-').'";
		$GLOBALS["wp_inblock"] = 1;
		$GLOBALS["wp_mod"][$GLOBALS["wp_id"]] ="'.$_wp_my_dirname.'";
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_recent_comments_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
