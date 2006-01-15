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
		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$optForm = new XoopsSimpleForm('Block Option Dummy Form', 'optionform', '');

		$optFormType = new XoopsFormRadio('Comment List Style:',  'options[0]', $options[0]);
		$optFormType->addOption(0, 'Standard');
		$optFormType->addOption(1, 'Grouped by Article');
		$optForm->addElement($optFormType);
		$optForm->addElement(new XoopsFormText('Comment List Count:', 'options[1]', 5, 5, $options[1]));
		$optForm->addElement(new XoopsFormRadioYN('Display RSS Icon:', 'options[2]', $options[2]));
		$optForm->addElement(new XoopsFormRadioYN('Display Posted Date:', 'options[3]', $options[3]));
		$optForm->addElement(new XoopsFormRadioYN('Show Comment Type:', 'options[4]', $options[4]));
		$optForm->addElement(new XoopsFormText('Custom Block Template File<br />(Default: wp_recent_comments.html):', 'options[5]', 25, 50, $options[5]));

		$_wpTpl =& new WordPresTpl('theme');
		$optForm->assign($_wpTpl);
		return $_wpTpl->fetch('wp_block_edit.html');

	}

	function _b_wp_recent_comments_show($options, $wp_num="")
	{
		$block_style =  ($options[0])?$options[0]:0;
		$num_of_list = (!isset($options[1]))? 10 : $options[1];
		$show_rss_icon = (!isset($options[2]))? 0 : $options[2];
		$cat_date = (!isset($options[3]))? ($block_style ? 1 : 0) : $options[3];
		$show_type = (!isset($options[4]))? 1 : $options[4];
		$tpl_file = (empty($options[5]))? 'wp_recent_comments.html' : $options[5];

		$block['style'] =block_style_get(false);
		$block['divid'] = 'wpRecentComment'.$wp_num;
		$block['block_style'] = $block_style;
		$block['cat_date'] = $cat_date;
		$block['show_type'] = $show_type;
		$comment_lenth = 30;

		if ($block_style==0) {
			$skip_posts = 0;
			$request = "SELECT ID, comment_ID, comment_content, comment_author, comment_author_url, comment_date, comment_type
						FROM ".wp_table('posts').", ".wp_table('comments')."
						WHERE ".wp_table('posts').".ID=".wp_table('comments').".comment_post_ID
						AND post_status = 'publish' AND comment_approved = '1' ";
			if (get_xoops_option(wp_mod(), 'wp_use_xoops_comments') == 1) {
				$request .= "AND (comment_content like '<trackback />%' 
				                  OR comment_content like '<pingkback />%'
				                  OR comment_type = 'trackback'
				                  OR comment_type = 'pingback'
				                  ) ";
			}
			$request .= "ORDER BY ".wp_table('comments').".comment_date DESC LIMIT $num_of_list";
			$lcomments = $GLOBALS['wpdb']->get_results($request);
			$output = '';
			$pdate = "";
			$block['records'] = array();
			if ($lcomments) {
				foreach ($lcomments as $lcomment) {
					if ($cat_date) {
						$date=mysql2date("Y-n-j", $lcomment->comment_date);
						if ($date <> $pdate) {
							$_record['date'] = $date;
							$_record['pdate'] = $pdate;
							$pdate = $date;
						} else {
							$_record['date'] = '';
						}
					}
					if (empty($lcomment->comment_type)) {
						if (preg_match('|<trackback />|', $lcomment->comment_content)) $type='[TrackBack]';
						elseif (preg_match('|<pingback />|', $lcomment->comment_content)) $type='[PingBack]';
						else  $type='[Comment]';
					} else {
						if ($lcomment->comment_type == 'trackback') $type='[TrackBack]';
						elseif ($lcomment->comment_type == 'pingback') $type='[PingBack]';
						else $type='[Comment]';
					}
					$_record['comment_author'] = apply_filters('comment_author', $lcomment->comment_author);
					$_record['comment_author_link'] = _get_comment_author_link($lcomment,25);
					$_record['comment_content'] = strip_tags($lcomment->comment_content);
					if (function_exists('mb_substr')) {
						$_record['comment_excerpt'] = mb_substr($_record['comment_content'],0,$comment_lenth);
					} else {
						$_record['comment_excerpt'] = substr($_record['comment_content'],0,$comment_lenth);
					}
					$_record['comment_excerpt'] = preg_replace('/([a-zA-Z0-9\.\/\:\%\?\-\+\&\;]{15})/ms','\\1&#8203;',$_record['comment_excerpt']);
					$_record['permalink'] = get_permalink($lcomment->ID).'#comment-'.$lcomment->comment_ID;
					if ($show_type) {
						$_record['type'] = $type;
					}
					$block['records'][] = $_record;
				}
			}
		} else {
			$request = 'SELECT ID, post_title, post_date, comment_ID, comment_author, comment_author_url,
						comment_date, comment_content, comment_type
						FROM '.wp_table('posts').', '.wp_table('comments').'
						WHERE '.wp_table('posts').'.ID='.wp_table('comments').'.comment_post_ID
						AND '.wp_table('comments').'.comment_approved=\'1\'';
			if (get_xoops_option(wp_mod(), 'wp_use_xoops_comments') == 1) {
				$request .= "AND (comment_content like '<trackback />%' 
				                  OR comment_content like '<pingkback />%'
				                  OR comment_type = 'trackback'
				                  OR comment_type = 'pingback'
				                  ) ";
			}
			$request .= ' ORDER BY '.wp_table('comments').'.comment_date DESC LIMIT '.$num_of_list;
			$lcomments = $GLOBALS['wpdb']->get_results($request);
			$output = ''; 
			if($lcomments){ 
				usort($lcomments, 'sort_comment_by_date'); 
			} 
			$new_post_ID = -1;
			$block['records'] = array();
			if ($lcomments) {
				foreach ($lcomments as $lcomment) { 
					$_record['new_post_ID'] = $new_post_ID;
					$_record['ID'] = $lcomment->ID;
					if ($lcomment->ID != $new_post_ID) { // next post 
						$_record['post_title'] = $lcomment->post_title;
						if (trim($_record['post_title'])=="")
							$_record['post_title'] = _WP_POST_NOTITLE;
						$_record['comment_content'] = strip_tags($lcomment->comment_content);
						if (function_exists('mb_substr')) {
							$_record['comment_excerpt'] = mb_substr($_record['comment_content'],0,$comment_lenth);
						} else {
							$_record['comment_excerpt'] = substr($_record['comment_content'],0,$comment_lenth);
						}
						$_record['comment_excerpt'] = preg_replace('/([a-zA-Z0-9\.\/\:\?\-\+%&;]{15})/ms','\\1&#8203;',$_record['comment_excerpt']);
						$_record['permalink'] = wp_siteurl().'/index.php?p='.$lcomment->ID.'&amp;c=1'; 
						$new_post_ID = $lcomment->ID; 
					} 
					if ($cat_date) {
						$comment_date = $lcomment->comment_date; 
						if ( time() - mysql2date('U', $comment_date) < 60*60*24 ) { # within 24 hours 
						   $_record['comment_date'] = mysql2date('H:i', $comment_date); 
						} else { 
						   $_record['comment_date'] = mysql2date('m/d', $comment_date); 
						}
					}
					$_record['comment_author'] = apply_filters('comment_author', $lcomment->comment_author);
					$_record['comment_author_link'] = _get_comment_author_link($lcomment,25);
					if (empty($lcomment->comment_type)) {
						if (preg_match('|<trackback />|', $lcomment->comment_content)) $type='[TrackBack]';
						elseif (preg_match('|<pingback />|', $lcomment->comment_content)) $type='[PingBack]';
						else  $type='[Comment]';
					} else {
						if ($lcomment->comment_type == 'trackback') $type='[TrackBack]';
						elseif ($lcomment->comment_type == 'pingback') $type='[PingBack]';
						else $type='[Comment]';
					}
					if ($show_type) {
						$_record['type'] = $type;
					}
					$block['records'][] = $_record;
				} 
			}
		}
		if ($show_rss_icon) {
			$block['feed_icon'] = array(
				'url' => get_bloginfo('comments_rss2_url'),
				'icon' => wp_siteurl().'/wp-images/rss_comment.gif', 'alt' => 'Comment RSS',
			);
		} else {
			$block['feed_icon'] = array();
		}

		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		if (!$_wpTpl->tpl_exists($tpl_file)) $tpl_file = 'wp_recent_comments.html';
		$block['content'] = $_wpTpl->fetch($tpl_file);
		return $block;
	}

    function sort_comment_by_date($a, $b){ 
		if( $b->ID == $a->ID ){ 
		   return mysql2date('U',$a->comment_date) - mysql2date('U',$b->comment_date); 
		} 
		return mysql2date('U',$b->post_date) - mysql2date('U',$a->post_date); 
    } 

	function _get_comment_author_link($my_comment,$abbr=0) { 
		$ret = ""; 
		$url = apply_filters('comment_url', $my_comment->comment_author_url);
		$author = apply_filters('comment_author', $my_comment->comment_author);
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
		if ($url == 'http://') $url = '';
		if (empty($url)) {
			$ret = $author;
		} else {
			$ret = '<a href="'.$url.'" title="Go to '.$author.'\'s site" rel="nofollow">'.$author.'</a>';
		}
		 return $ret; 
	}
}

eval ('
	function b_'.$_wp_my_prefix.'recent_comments_edit($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_recent_comments_edit($options));
	}
	function b_'.$_wp_my_prefix.'recent_comments_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_recent_comments_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
