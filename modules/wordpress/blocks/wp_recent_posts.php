<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_RECENT_POSTS_BLOCK_INCLUDED' ) ) {
	define( 'WP_RECENT_POSTS_BLOCK_INCLUDED' , 1 ) ;
	function _b_wp_recent_posts_edit($options, $wp_num = "")
	{
		$categoryHandler =& wp_handler('Category');
		$optFormCatOptions = Array("0"=>_WP_LIST_CAT_ALL) + $categoryHandler->getParentOptionArray();

		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$optForm = new XoopsSimpleForm('Block Option Dummy Form', 'optionform', '');
		$optForm->addElement(new XoopsFormText('Number of Posts in this block:', 'options[0]', 5, 5, $options[0]));
		$optForm->addElement(new XoopsFormRadioYN('Display Posted Date:', 'options[1]', $options[1]));
		$optForm->addElement(new XoopsFormRadioYN('Display RSS Icon:', 'options[2]', $options[2]));
		$optForm->addElement(new XoopsFormRadioYN('Display RDF Icon:', 'options[3]', $options[3]));
		$optForm->addElement(new XoopsFormRadioYN('Display RSS2 Icon:', 'options[4]', $options[4]));
		$optForm->addElement(new XoopsFormRadioYN('Display ATOM Icon:', 'options[5]', $options[5]));
		$optForm->addElement(new XoopsFormText('Number of Posts in Meta Feed(RSS,RDF,ATOM):', 'options[6]', 5, 5, $options[6]));
		$optFormCat = new XoopsFormSelect('Listing only in a following categoty:',  'options[7]', $options[7]);
		$optFormCat->addOptionArray($optFormCatOptions);
		$optForm->addElement($optFormCat);
		$optForm->addElement(new XoopsFormRadioYN('Display New Flag:', 'options[8]', $options[8]));
		$optForm->addElement(new XoopsFormText('Custom Block Template File<br />(Default: wp_recent_posts.html):', 'options[9]', 25, 50, $options[9]));

		$_wpTpl =& new WordPresTpl('theme');
		$optForm->assign($_wpTpl);
		return $_wpTpl->fetch('wp_block_edit.html');
	}

	function _b_wp_recent_posts_show($options, $wp_num = "")
	{
		$no_posts = (empty($options[0]))? 10 : $options[0];
		$cat_date = (empty($options[1]))? 0 : $options[1];
		$show_rss_icon = (empty($options[2]))? 0 : $options[2];
		$show_rdf_icon = (empty($options[3]))? 0 : $options[3];
		$show_rss2_icon = (empty($options[4]))? 0 : $options[4];
		$show_atom_icon = (empty($options[5]))? 0 : $options[5];
		$rss_num = (empty($options[6]))? "" : $options[6];
		$category = intval((empty($options[7]))? "all" : $options[7]);
		$new_flg = (empty($options[8]))? 0 : $options[8];
		$tpl_file = (empty($options[9]))? 'wp_recent_posts.html' : $options[9];
		
		$new1_span = 1*60*60*24;
		$new2_span = 7*60*60*24;

		if ((empty($category)) || ($category == 'all') || ($category == '0')) {
			$whichcat='';
			$join = '';
			$cat_param ='';
		} else {
			$join = ' LEFT JOIN '.wp_table('post2cat').' ON ('.wp_table('posts').'.ID = '.wp_table('post2cat').'.post_id) ';
		    $whichcat = ' AND (category_id = '.$category.')';
		    $cat_param = 'cat='.$category;
		}
		$now = current_time('mysql');
		$request = 'SELECT * FROM '. wp_table('posts'). $join. ' WHERE post_status = \'publish\'';
		$request .= ' AND post_date <= \''.$now.'\''. $whichcat;
		$request .= ' ORDER BY post_date DESC LIMIT 0, '. $no_posts;
		$lposts = $GLOBALS['wpdb']->get_results($request);
		$date = "";
		$pdate = "";

		$block['style'] =block_style_get(false);
		$block['divid'] = 'wpRecentPost'.$wp_num.'_'.$category;
		$block['cat_date'] = $cat_date;

		$block['records'] = array();
		if ($lposts) {
			foreach ($lposts as $lpost) {
				if ($cat_date) {
					$date=mysql2date('Y-n-j', $lpost->post_date);
					if ($date <> $pdate) {
						$_record['date'] = $date;
						$_record['pdate'] = $pdate;
						$pdate = $date;
					} else {
						$_record['date'] = '';
					}
				}
				$_record['new'] = 0;
				$_record['newstr'] = '';
				if ($new_flg) {
					$m =  $lpost->post_date;
					$elapse = current_time('timestamp') - mktime(substr($m,11,2),substr($m,14,2),substr($m,17,2),substr($m,5,2),substr($m,8,2),substr($m,0,4));
					if ($elapse < $new1_span ) {
						$_record['new'] = 1;
						$_record['newstr'] = ' <span class="new1">New!</span>';
					} else if ($elapse < $new2_span) {
						$_record['new'] = 2;
						$_record['newstr'] = ' <span class="new2">New</span>';
					} else {
						$_record['new'] = 0;
						$_record['newstr'] = '';
					}
				}
				$_record['post_title'] = htmlspecialchars($lpost->post_title);
				$_record['post_author'] = htmlspecialchars(get_author_name($lpost->post_author));
				if (trim($_record['post_title'])=='')
					$_record['post_title'] = _WP_POST_NOTITLE;
				$_record['permalink'] = get_permalink($lpost->ID);
				
				$block['records'][] = $_record;
			}
		}

		$feed_param = $rss_num ? "?num=".$rss_num : "";
		$block['feed_icons'] = array();
		if ((empty($category)) || ($category == 'all') || ($category == '0')) {
			if ($show_rss_icon) {
				$block['feed_icons'][] = array(
					'url' => get_bloginfo('rss_url').$feed_param,
					'icon' => wp_siteurl().'/wp-images/rss.gif', 'alt' => 'rss',
				);
			}
			if ($show_rdf_icon) {
				$block['feed_icons'][] = array(
					'url' => get_bloginfo('rdf_url').$feed_param,
					'icon' => wp_siteurl().'/wp-images/rdf.gif', 'alt' => 'rdf',
				);
			}
			if ($show_rss2_icon) {
				$block['feed_icons'][] = array(
					'url' => get_bloginfo('rss2_url').$feed_param,
					'icon' => wp_siteurl().'/wp-images/rss2.gif', 'alt' => 'rss2',
				);
			}
			if ($show_atom_icon) {
				$block['feed_icons'][] = array(
					'url' => get_bloginfo('atom_url').$feed_param,
					'icon' => wp_siteurl().'/wp-images/atom.gif', 'alt' => 'atom',
				);
			}
		} else {
			if ($show_rss_icon) {
				$block['feed_icons'][] = array(
					'url' => get_category_rss_link(false, $category,"",'rss').$feed_param,
					'icon' => wp_siteurl().'/wp-images/rss.gif', 'alt' => 'rss',
				);
			}
			if ($show_rdf_icon) {
				$block['feed_icons'][] = array(
					'url' => get_category_rss_link(false, $category,"",'rdf').$feed_param,
					'icon' => wp_siteurl().'/wp-images/rdf.gif', 'alt' => 'rdf',
				);
			}
			if ($show_rss2_icon) {
				$block['feed_icons'][] = array(
					'url' => get_category_rss_link(false, $category,"",'rss2').$feed_param,
					'icon' => wp_siteurl().'/wp-images/rss2.gif', 'alt' => 'rss2',
				);
			}
			if ($show_atom_icon) {
				$block['feed_icons'][] = array(
					'url' => get_category_rss_link(false, $category,"",'atom').$feed_param,
					'icon' => wp_siteurl().'/wp-images/atom.gif', 'alt' => 'atom',
				);
			}
		}

		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		if (!$_wpTpl->tpl_exists($tpl_file)) $tpl_file = 'wp_recent_posts.html';
		$block['content'] = $_wpTpl->fetch($tpl_file);
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'recent_posts_edit($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_recent_posts_edit($options,"'.$_wp_my_dirnumber.'"));
	}
	function b_'.$_wp_my_prefix.'recent_posts_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_recent_posts_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
