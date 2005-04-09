<?php
if( ! defined( 'WP_RECENT_POSTS_INCLUDED' ) ) {

	define( 'WP_RECENT_POSTS_INCLUDED' , 1 ) ;

	function b_wp_recent_posts_edit($options, $wp_num = "")
	{
		global $wpdb, $siteurl, $wp_id, $wp_inblock, $use_cache;

		$form = "<table width='100%'>";
		
		$form .= "<tr><td width='40%'>Number of Posts in this block:</td>";
		$form .= "<td><input type='text' name='options[]' value='".$options[0]."' /></td></tr>";
		
		$form .= "<tr><td>Display Posted Date:</td>";
		$chk = ( $options[1] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[1]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[1] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[1]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "<tr><td>Display RSS Icon:</td>";
		$chk = ( $options[2] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[2]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[2] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[2]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "<tr><td>Display RDF Icon:</td>";
		$chk = ( $options[3] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[3]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[3] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[3]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "<tr><td>Display RSS2 Icon:</td>";
		$chk = ( $options[4] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[4]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[4] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[4]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";
		
		$form .= "<tr><td>Display ATOM Icon:</td>";
		$chk = ( $options[5] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[5]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[5] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[5]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";

		$form .= "<tr><td>Number of Posts in Meta Feed(RSS,RDF,ATOM):</td>";
		$form .= "<td><input type='text' name='options[6]' value='".$options[6]."' /></td></tr>";
		
		$form .= "<tr><td>Listing only in a following categoty:</td><td>";
		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		$cat = $options[7];
		ob_start();
		dropdown_cats(1,_WP_LIST_CAT_ALL,'ID','asc',0,0,0,FALSE,$options[7]);
		$list_str = ob_get_contents();
		ob_end_clean();
		$select_str = '<select name="options[7]">';
		$form .= ereg_replace('\<select name\=[^\>]*\>',$select_str,$list_str);
		$form .= "</td></tr>";

		$form .= "<tr><td>Display New Flag:</td>";
		$chk = ( $options[8] == 1 ) ? " checked='checked'" : "";
		$form .= "<td><input type='radio' name='options[8]' value='1'".$chk." />&nbsp;"._YES."&nbsp;";
		$chk = ( $options[8] == 0 ) ? " checked='checked'" : "";
		$form .= "<input type='radio' name='options[8]' value='0'".$chk." />&nbsp;"._NO."</td></tr>";

		$form .= "</table>";
		
		return $form;

	}

	function b_wp_recent_posts_show($options, $wp_num = "")
	{
		$no_posts = (empty($options[0]))? 10 : $options[0];
		$cat_date = (empty($options[1]))? 0 : $options[1];
		$show_rss_icon = (empty($options[2]))? 0 : $options[2];
		$show_rdf_icon = (empty($options[3]))? 0 : $options[3];
		$show_rss2_icon = (empty($options[4]))? 0 : $options[4];
		$show_atom_icon = (empty($options[5]))? 0 : $options[5];
		$rss_num = (empty($options[6]))? "" : $options[6];
		$category = (empty($options[7]))? "all" : $options[7];
		$new_flg = (empty($options[8]))? 0 : $options[8];
//	echo "$wp_num:$cat_date";
		global $xoopsDB;
		global $wpdb, $siteurl, $wp_id, $wp_inblock, $use_cache;

		$id=1;
		$use_cache = 1;

		if ($wp_num == "") {
			$wp_id = $wp_num;
			$wp_inblock = 1;
			require(dirname(__FILE__).'/../wp-config.php');
			$wp_inblock = 0;
		}
		if ((empty($category)) || ($category == 'all') || ($category == '0')) {
			$whichcat='';
			$join = '';
			$cat_param ='';
		} else {
			$join = " LEFT JOIN {$wpdb->post2cat[$wp_id]} ON ({$wpdb->posts[$wp_id]}.ID = {$wpdb->post2cat[$wp_id]}.post_id) ";
		    $whichcat = ' AND (category_id = '.$category.')';
		    $cat_param = 'cat='.$category;
		}
		$now = date('Y-m-d H:i:s',(time() + (get_settings('time_difference') * 3600)));
		$request = "SELECT * FROM ".$xoopsDB->prefix("wp{$wp_num}_posts").$join." WHERE post_status = 'publish' ";
		$request .= " AND post_date <= '".$now."'". $whichcat;
		$request .= " ORDER BY post_date DESC LIMIT 0, $no_posts";
		$lposts = $wpdb->get_results($request);
		$date = "";
		$pdate = "";
		ob_start();
		block_style_get($wp_num);
		$output = ob_get_contents();
		ob_end_clean();
		$output .= "<div id='wpRecentPost'>";
		if ($lposts) {
			if (!$cat_date) {
				$output .= "<ul class='wpBlockList'>\n";
			} else {
				$output .= "<ul class='wpBlockDateList'>\n";
			}
			foreach ($lposts as $lpost) {
				if ($cat_date) {
					$date=mysql2date("Y-n-j", $lpost->post_date);
					if ($date <> $pdate) {
						if ($pdate <> "") {
							$output .= "</ul>\n";
						}
						$output .= "<li><span id=\"postDate\">".$date."</span></li>\n<ul class=\"children\">\n";
						$pdate = $date;
					}
				}
				$newstr = "";
				if ($new_flg) {
					$m =  $lpost->post_date;
					$elapse = time() + get_settings('time_difference') * 3600 - mktime(substr($m,11,2),substr($m,14,2),substr($m,17,2),substr($m,5,2),substr($m,8,2),substr($m,0,4));
					if ($elapse < 1*60*60*24 ) {
						$newstr = ' <span class="new1">New!</span>';
					} else if ($elapse < 7*60*60*24) {
						$newstr = ' <span class="new2">New</span>';
					} else {
						$newstr = '';
					}
				}
				$post_title = stripslashes($lpost->post_title);
				if (trim($post_title)=="")
					$post_title = _WP_POST_NOTITLE;
				$permalink = get_permalink($lpost->ID);
				$output .= '<li><span class="post-title"><a href="' . $permalink . '" rel="bookmark" title="Permanent Link: ' . $post_title . '">' . $post_title . '</a></span>'.$newstr.'<br />';
				$output .= "</li>\n";
			}
			$output .= "</ul>\n";	
            if ($cat_date) {
                $output .= "</ul>\n";
            }
		}
		if ($show_rss_icon || $show_rdf_icon || $show_rss2_icon || $show_atom_icon) {
			$output .= '<hr width="100%" />';
		}
		$feed_param = $rss_num ? "?num=".$rss_num : "";
/*
		if ($feed_param != "") {
			$feed_param .= $cat_param ? "&".$cat_param : "";
		} else {
			$feed_param = $cat_param ? "?".$cat_param : "";
		}
*/
		if ((empty($category)) || ($category == 'all') || ($category == '0')) {
			if ($show_rss_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_bloginfo('rss_url').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss.gif" alt="rss" /></a></div>';
			}
			if ($show_rdf_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_bloginfo('rdf_url').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rdf.gif"  alt="rdf" /></a></div>';
			}
			if ($show_rss2_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_bloginfo('rss2_url').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss2.gif" alt="rss2" /></a></div>';
			}
			if ($show_atom_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_bloginfo('atom_url').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/atom.gif" alt="atom" /></a></div>';
			}
		} else {
			if ($show_rss_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_category_rss_link(false, $category,"",'rss').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss.gif" alt="rss"  /></a></div>';
			}
			if ($show_rdf_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_category_rss_link(false, $category,"",'rdf').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rdf.gif" alt="rdf"  /></a></div>';
			}
			if ($show_rss2_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_category_rss_link(false, $category,"",'rss2').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss2.gif" alt="rss2"  /></a></div>';
			}
			if ($show_atom_icon) {
				$output .= '<div style="text-align:right">&nbsp;<a href="'.get_category_rss_link(false, $category,"",'atom').$feed_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/atom.gif"  alt="atom" /></a></div>';
			}
		}
		$output .= "</div>";
		$block['content'] = $output;
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_recent_posts_edit($options) {
			global $wpdb, $siteurl, $wp_id, $wp_inblock, $use_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_recent_posts_edit($options,"'.$i.'"));
		}

		function b_wp'.$i.'_recent_posts_show($options) {
			global $xoopsDB;
			global $wpdb, $siteurl, $wp_id, $wp_inblock, $use_cache;
			$wp_id = "'.$i.'";
			$wp_inblock = 1;
			require(XOOPS_ROOT_PATH."/modules/wordpress'.$i.'/wp-config.php");
			$wp_inblock = 0;
			return (b_wp_recent_posts_show($options,"'.$i.'"));
		}
	');
	}
}
?>
