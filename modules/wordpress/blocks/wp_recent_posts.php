<?
if( ! defined( 'WP_RECENT_POSTS_INCLUDED' ) ) {

	define( 'WP_RECENT_POSTS_INCLUDED' , 1 ) ;

	function b_wp_recent_posts_edit($options)
	{
		$form = "";
		$form .= "Number of Posts in this block: ";
		$form .= "<input type='text' name='options[]' value='".$options[0]."' /><br />";
		$form .= "<br />Display Posted Date:&nbsp;";
		if ( $options[1] == 1 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[1]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		if ( $options[1] == 0 ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[1]' value='0'".$chk." />"._NO."<br />";
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
		$form .= "<br />Display RDF Icon:&nbsp;";
		if ( $options[3] == 1 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[3]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		if ( $options[3] == 0 ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[3]' value='0'".$chk." />"._NO."<br />";
		$form .= "<br />Display RSS2 Icon:&nbsp;";
		if ( $options[4] == 1 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[4]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		if ( $options[4] == 0 ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[4]' value='0'".$chk." />"._NO."<br />";
		$form .= "<br />Display ATOM Icon:&nbsp;";
		if ( $options[5] == 1 ) {
			$chk = " checked='checked'";
		}
		$form .= "<input type='radio' name='options[5]' value='1'".$chk." />&nbsp;"._YES."";
		$chk = "";
		if ( $options[5] == 0 ) {
			$chk = " checked=\"checked\"";
		}
		$form .= "&nbsp;<input type='radio' name='options[5]' value='0'".$chk." />"._NO."<br />";
		$form .= "Number of Posts in Meta(RSS,RDF,ATOM): ";
		$form .= "<input type='text' name='options[]' value='".$options[6]."' /><br />";
		
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
		$now = date('Y-m-d H:i:s',(time() + (get_settings('time_difference') * 3600)));
		$request = "SELECT * FROM ".$xoopsDB->prefix("wp{$wp_num}_posts")." WHERE post_status = 'publish' ";
		$request .= " AND post_date <= '".$now."'";
		$request .= " ORDER BY post_date DESC LIMIT 0, $no_posts";
		$lposts = $wpdb->get_results($request);
		$date = "";
		$pdate = "";
		ob_start();
		block_style_get($wp_num);
		$output = ob_get_contents();
		ob_end_clean();

		$output .= '<div id="wpRecentPost">';
		if ($lposts) {
			foreach ($lposts as $lpost) {
				if ($cat_date) {
					$date=mysql2date("Y-n-j", $lpost->post_date);
					if ($date <> $pdate) {
//						if ($pdate) $output .= "</ul>";
						$output .= '<label id="postDate">'.$date.'</label><br />';
						$pdate = $date;
					}
					$output .= '&nbsp;';
				}
				$post_title = stripslashes($lpost->post_title);
				$permalink = get_permalink($lpost->ID);
				$output .= '&nbsp;<strong><big>&middot;</big></strong>&nbsp;<a href="' . $permalink . '" rel="bookmark" title="Permanent Link: ' . $post_title . '">' . $post_title . '</a><br>';
			}
		}
		if ($show_rss_icon || $show_rdf_icon || $show_rss2_icon || $show_atom_icon) {
			$output .= '<hr width="100%" />';
		}
		$output .= '</div>';

		$num_param = $rss_num ? "?num=".$rss_num : "";
		if ($show_rss_icon) {
			$output .= '<div style="text-align:right">&nbsp;<a href="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-rss.php'.$num_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss.gif" /></a></div>';
		}
		if ($show_rdf_icon) {
			$output .= '<div style="text-align:right">&nbsp;<a href="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-rdf.php'.$num_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rdf.gif" /></a></div>';
		}
		if ($show_rss2_icon) {
			$output .= '<div style="text-align:right">&nbsp;<a href="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-rss2.php'.$num_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/rss.gif" /></a></div>';
		}
		if ($show_atom_icon) {
			$output .= '<div style="text-align:right">&nbsp;<a href="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-atom.php'.$num_param.'"><img src="'.XOOPS_URL.'/modules/wordpress'.$wp_num.'/wp-images/atom.gif" /></a></div>';
		}
		$block['content'] = $output;
		return $block;
	}

	for ($i = 0; $i < 10; $i++) {
		eval ('
		function b_wp'.$i.'_recent_posts_edit($options) {
			return (b_wp_recent_posts_edit($options));
		}

		function b_wp'.$i.'_recent_posts_show($options) {
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
