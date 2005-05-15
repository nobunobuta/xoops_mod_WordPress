<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_CONTENTS_BLOCK_INCLUDED' ) ) {
	define( 'WP_CONTENTS_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_contents_edit($options)
	{
		$form = "";
		$form .= "Number of posts to show: ";
		$form .= "<input type='text' name='options[]' value='".$options[0]."' /><br />";
		return $form;

	}
	function _b_wp_contents_show($options,$wp_num="") {
		$no_posts = (empty($options[0]))? 10 : $options[0];

		$GLOBALS['dateformat'] = stripslashes(get_settings('date_format'));
		$GLOBALS['timeformat'] = stripslashes(get_settings('time_format'));
		
		$_criteria = new CriteriaCompo(new Criteria('post_status', 'publish'));
		$_criteria->add(new Criteria('post_date', current_time('mysql'), '<='));
		$_criteria->setGroupBy(wp_table('posts').'.ID');
		$_criteria->setSort('post_date');
		$_criteria->setOrder('DESC');
		$_criteria->setLimit($no_posts);
		$_criteria->setStart(0);

		$postHandler =& wp_handler('Post');
		$postObjects =& $postHandler->getObjects($_criteria, false, '', 'DISTINCT');
		$lposts = array();
		foreach ($postObjects as $postObject) {
				$lposts[] =& $postObject->exportWpObject();
		}
		
		if ($lposts) {
			// Get the categories for all the posts
			$_post_id_list = array();
			foreach ($lposts as $post) {
		    	$_post_id_list[] = $post->ID;
				$GLOBALS['category_cache'][wp_id()][$post->ID] = array();
			}
		    $_post_id_list = implode(',', $_post_id_list);
			$_post_id_criteria =& new Criteria('post_id', '('.$_post_id_list.')', 'IN');
			$_joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'ID', 'post_id');
			$_joinCriteria->cascade(new XoopsJoinCriteria(wp_table('categories'), 'category_id', 'cat_ID'));
			$postObjects =& $postHandler->getObjects($_post_id_criteria, false,
									'ID, category_id, cat_name, category_nicename, category_description, category_parent',
									true, $_joinCriteria);
		    foreach ($postObjects as $postObject) {
		    	$_cat->ID = $postObject->getVar('ID');
		    	$_cat->category_id = $postObject->getExtraVar('category_id');
		    	$_cat->cat_name = $postObject->getExtraVar('cat_name');
		    	$_cat->category_nicename = $postObject->getExtraVar('category_nicename');
		    	$_cat->category_description = $postObject->getExtraVar('category_description');
		    	$_cat->category_parent = $postObject->getExtraVar('category_parent');
		    	$GLOBALS['category_cache'][wp_id()][$postObject->getVar('ID')][] =& $_cat;
		    	unset($_cat);
		    }
		    // Do the same for comment numbers
		    $_criteria =&new CriteriaCompo(new Criteria('post_status', 'publish'));
		    $_criteria->add(new Criteria('comment_approved', '1 '));
		    $_criteria->add($_post_id_criteria);
		    $_criteria->setGroupBy('ID');
			$_joinCriteria =& new XoopsJoinCriteria(wp_table('comments'), 'ID', 'comment_post_ID');
		    $postObjects =&$postHandler->getObjects($_criteria, false, 'ID, COUNT( comment_ID ) AS ccount', false, $_joinCriteria);
			foreach ($postObjects as $postObject) {
				$GLOBALS['comment_count_cache'][wp_id()][''.$postObject->getVar('ID')] = $postObject->getExtraVar('ccount');
			}
		}
		$blog = 1;
		$block = array();
		$block['use_theme_template'] = get_xoops_option(wp_mod(),'use_theme_template');
		
		$block['style'] =block_style_get(false);
		$block['divid'] = 'wpBlockContent'.$wp_num;
		$block['template_content'] = "";
		$i = 0;
		$GLOBALS['previousday'] = 0;
		foreach ($lposts as $post) {
			$GLOBALS['post'] = $post;
			if ($block['use_theme_template'] == 0) {
				$content = array();
				start_wp();
				$content['date'] = the_date($GLOBALS['dateformat'],'','', false);
				$content['time'] = the_time('', false);
				$content['title'] = the_title('','', false);
				$content['permlink'] = get_permalink();
				$content['author'] = the_author_posts_link('', false);
				$content['category'] = the_category('', '', false);
				$content['body'] = the_content(_WP_TPL_MORE, 0, '', false);
				$content['linkpage'] = link_pages('<br />Pages: ', '<br />', 'number', 'next page', 'previous page', '%', '', false);
				if (get_xoops_option(wp_mod(),'wp_use_xoops_comments') == 0) {
					$content['comments'] = comments_popup_link(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS, '', 'Comments Off', false);
				} else {
					$content['comments'] = xcomments_popup_link(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS, '', 'Comments Off', false);
					$content['comments'] .= " | ";
					$content['comments'] .= comments_popup_link(_WP_TPL_COMMENT0, _WP_TPL_COMMENT1, _WP_TPL_COMMENTS, '', 'Comments Off', false);
				}
				$content['trackback'] = trackback_rdf(0, false);;

				$block['contents'][] = $content;
			} else {
				ob_start();
				include(get_custom_path('content_block-template.php'));
				$block['template_content'] .= ob_get_contents();
				ob_end_clean();
			}
		}
		$GLOBALS['previousday'] = 0;
		$GLOBALS['day'] = 0;
		$GLOBALS['comment_count_cache'][wp_id()]=array();
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'contents_edit($options) {
		return (_b_wp_contents_edit($options,"'.$_wp_my_dirnumber.'"));
	}
	function b_'.$_wp_my_prefix.'contents_show($options) {
		$GLOBALS["wp_mod"][$GLOBALS["wp_id"]] ="'.$_wp_my_dirname.'";
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		return (_b_wp_contents_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
