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
		$categoryHandler =& wp_handler('Category');
		$optFormCatOptions = Array("0"=>_WP_LIST_CAT_ALL) + $categoryHandler->getParentOptionArray();

		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$optForm = new XoopsSimpleForm('Block Option Dummy Form', 'optionform', '');
		$optForm->addElement(new XoopsFormText('Number of posts to show:', 'options[0]', 5, 5, $options[0]));
		$optForm->addElement(new XoopsFormText('Custom Block Template File<br />(Default: wp_contents.html):', 'options[1]', 25, 50, $options[1]));
		$optFormCat = new XoopsFormSelect('Listing only in a following categoty:',  'options[2]', $options[2]);
		$optFormCat->addOptionArray($optFormCatOptions);
		$optForm->addElement($optFormCat);

		$_wpTpl =& new WordPresTpl('theme');
		$optForm->assign($_wpTpl);
		return $_wpTpl->fetch('wp_block_edit.html');
	}
	function _b_wp_contents_show($options,$wp_num="") {
		$no_posts = (empty($options[0]))? 10 : $options[0];
		$tpl_file = (empty($options[1]))? 'wp_contents.html' : $options[1];
		$category = (empty($options[2]))? "all" : intval($options[2]);

		$GLOBALS['dateformat'] = get_settings('date_format');
		$GLOBALS['timeformat'] = get_settings('time_format');
		
		$_criteria = new CriteriaCompo(new Criteria('post_status', 'publish'));
		$_criteria->add(new Criteria('post_date', current_time('mysql'), '<='));

		if ((empty($category)) || ($category == 'all') || ($category == '0')) {
			$_joinCriteria = null;
		} else {
        	$_joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'ID', 'post_id');
        	$_wCriteria =& new CriteriaCompo();
    		$_wCriteria->add(new Criteria('category_id', intCriteriaVal($category)), 'OR');
    		$_catc = trim(get_category_children($category, '', ' '));
    		if ($_catc!=="") {
    			$_catc_array = explode(' ',$_catc);
    		    for ($_j = 0; $_j < (count($_catc_array)); $_j++) {
    				$_wCriteria->add(new Criteria('category_id', intCriteriaVal($_catc_array[$_j])), 'OR');
    		    }
    		}
    		$_criteria->add($_wCriteria);
		}
		$_criteria->setGroupBy(wp_table('posts').'.ID');
		$_criteria->setSort('post_date');
		$_criteria->setOrder('DESC');
		$_criteria->setLimit($no_posts);
		$_criteria->setStart(0);
		$postHandler =& wp_handler('Post');
		$postObjects =& $postHandler->getObjects($_criteria, false, '', 'DISTINCT', $_joinCriteria);
//		echo $postHandler->getLastSQL();
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
			$_post_id_criteria =& new Criteria('comment_post_ID', '('.$_post_id_list.')', 'IN');
		    $_criteria =&new CriteriaCompo(new Criteria('post_status', 'publish'));
		    $_criteria->add(new Criteria('comment_approved', '1 '));
		    $_criteria->add($_post_id_criteria);
		    $_criteria->setGroupBy('ID');
			$_joinCriteria =& new XoopsJoinCriteria(wp_table('comments'), 'ID', 'comment_post_ID');
		    $postObjects =&$postHandler->getObjects($_criteria, false, 'ID, COUNT( comment_ID ) AS ccount', false, $_joinCriteria);
			foreach ($postObjects as $postObject) {
				$GLOBALS['comment_count_cache'][wp_id()][''.$postObject->getVar('ID')] = $postObject->getExtraVar('ccount');
			}

        	// Get post-meta info
        	if ( $meta_list = $GLOBALS['wpdb']->get_results('SELECT post_id, meta_key, meta_value FROM '.wp_table('postmeta').' WHERE post_id IN('.$_post_id_list.') ORDER BY post_id, meta_key', ARRAY_A) ) {
        		
        		// Change from flat structure to hierarchical:
        		$GLOBALS['post_meta_cache'][wp_id()] = array();
        		foreach ($meta_list as $metarow) {
        			$mpid = $metarow['post_id'];
        			$mkey = $metarow['meta_key'];
        			$mval = $metarow['meta_value'];
        			
        			// Force subkeys to be array type:
        			if (!isset($GLOBALS['post_meta_cache'][wp_id()][$mpid]) || !is_array($GLOBALS['post_meta_cache'][wp_id()][$mpid])) {
        				$GLOBALS['post_meta_cache'][wp_id()][$mpid] = array();
        			}
        			if (!isset($GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"]) || !is_array($GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"])) {
        				$GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"] = array();
        			}
        			// Add a value to the current pid/key:
        			$GLOBALS['post_meta_cache'][wp_id()][$mpid]["$mkey"][] = $mval;
        		}
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
                    $content['comments'] .= comments_popup_link(_WP_TPL_TRACKBACK0, _WP_TPL_TRACKBACK1, _WP_TPL_TRACKBACKS,'', 'Trackback Off', false);
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
		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		if (!$_wpTpl->tpl_exists($tpl_file)) $tpl_file = 'wp_contents.html';
		$block['content'] = $_wpTpl->fetch($tpl_file);
		$GLOBALS['previousday'] = 0;
		$GLOBALS['day'] = 0;
		$GLOBALS['comment_count_cache'][wp_id()]=array();
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'contents_edit($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_contents_edit($options,"'.$_wp_my_dirnumber.'"));
	}
	function b_'.$_wp_my_prefix.'contents_show($options) {
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		return (_b_wp_contents_show($options,"'.$_wp_my_dirnumber.'"));
	}
');
?>
