<?php
$_wp_base_prefix = 'wp';
$_wp_my_dirname = basename( dirname(dirname( __FILE__ ) ) );
if (!preg_match('/\D+(\d*)/', $_wp_my_dirname, $_wp_regs )) {
	echo ('Invalid dirname for WordPress Module: '. htmlspecialchars($_wp_my_dirname));
}
$_wp_my_dirnumber = $_wp_regs[1] ;
$_wp_my_prefix = $_wp_base_prefix.$_wp_my_dirnumber.'_';

if( ! defined( 'WP_CATEGORIES_BLOCK_INCLUDED' ) ) {
	define( 'WP_CATEGORIES_BLOCK_INCLUDED' , 1 ) ;

	function _b_wp_categories_edit($options)
	{
		require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$optForm = new XoopsSimpleForm('Block Option Dummy Form', 'optionform', '');

		$optFormType = new XoopsFormRadio('Category List Style:',  'options[0]', $options[0]);
		$optFormType->addOption(0, 'Simple List');
		$optFormType->addOption(1, 'Dropdown List');
		$optForm->addElement($optFormType);
		$optForm->addElement(new XoopsFormRadioYN('Listing with count:', 'options[1]', $options[1]));
		$optFormSort = new XoopsFormRadio('Sorting Key:',  'options[2]', $options[2]);
		$optFormSort->addOption('ID', 'ID');
		$optFormSort->addOption('name', 'Name');
		$optFormSort->addOption('description', 'Description');
		$optForm->addElement($optFormSort);
		$optFormOrder = new XoopsFormRadio('Sorting Order:',  'options[3]', $options[3]);
		$optFormOrder->addOption('asc', 'Ascending');
		$optFormOrder->addOption('desc', 'Descending');
		$optForm->addElement($optFormOrder);
		
		$_wpTpl =& new WordPresTpl('theme');
		$optForm->assign($_wpTpl);
		return $_wpTpl->fetch('wp_block_edit.html');
	}

	function _b_wp_categories_show($options, $wp_num="")
	{
		$block_style =  ($options[0])?$options[0]:0;
		$with_count =  ($options[1])?$options[1]:0;
		$sorting_key = ($options[2])?$options[2]:'name';
		$sorting_order = ($options[3])?$options[3]:'asc';
		
		if (current_wp()) {
			if ( !empty( $_SERVER['PATH_INFO'] ) ) {
				permlink_to_param();
			}
			init_param('GET', 'cat','string','');
			init_param('GET', 'category_name','string','');
			if (!empty($GLOBALS['category_name']) && empty($GLOBALS['cat'])) {
			    if (stristr($GLOBALS['category_name'],'/')) {
			        $GLOBALS['category_name'] = explode('/',$GLOBALS['category_name']);
			        if ($GLOBALS['category_name'][count($GLOBALS['category_name'])-1]) {
				        $GLOBALS['category_name'] = $GLOBALS['category_name'][count($GLOBALS['category_name'])-1]; // no trailing slash
			        } else {
				        $GLOBALS['category_name'] = $GLOBALS['category_name'][count($GLOBALS['category_name'])-2]; // there was a trailling slash
			        }
			    }
			    $categoryHandler =& wp_handler('Category');
			    $categoryObject =& $categoryHandler->getByNiceName($GLOBALS['category_name']);
			    if ($categoryObject) {
			    	$GLOBALS['cat'] = $categoryObject->getVar('cat_ID');
			    }
			}
		} else {
			$GLOBALS['cat'] = '';
		}

		$block['wp_num'] = $wp_num;
		$block['divid'] = 'wpCategory'.$wp_num;
		$block['siteurl'] = wp_siteurl();
		$block['style'] = block_style_get(false);
		$block['block_style'] = $block_style;
		$block['with_count'] = $with_count;

		if ($block_style == 0) {
			$cat_block = _b_wp_categories_list($sorting_key, $sorting_order, $with_count, 0, null, true);
		} else {
			$cat_block = _b_wp_categories_list($sorting_key, $sorting_order, $with_count, 0, null, false,
												'&#8211;', 0, $GLOBALS['cat']);
		}
		$block['records'] = $cat_block['records'];
		$_wpTpl =& new WordPresTpl('theme');
		$_wpTpl->assign('block', $block);
		$block['content'] = $_wpTpl->fetch('wp_categories.html');
		return $block;
	}

	function _b_wp_categories_list($sort_column = 'ID', $sort_order = 'asc', $optioncount = 0, $child_of=0,
									$categoryObjects=null, $arraytree = true, $padchar='&#8211;',
									$level=0, $current=0) {
		$categoryHandler =& wp_handler('Category');
		if (!$categoryObjects){
			$criteria =& new CriteriaCompo(new Criteria('cat_ID', 0, '>'));
			$criteria->setSort('cat_'.$sort_column);
			$criteria->setOrder($sort_order);
			$categoryObjects =& $categoryHandler->getObjects($criteria,false, 
				'cat_ID, cat_name, category_nicename, category_description cat_description, category_parent');
		}
		if (empty($GLOBALS['category_posts']) || !count($GLOBALS['category_posts'])) {
			$criteria =& new CriteriaCompo('post_status', 'publish');
			$criteria->setGroupBy('category_id');
			$joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'cat_ID', 'category_id', 'INNER');
			$joinCriteria->cascade(new XoopsJoinCriteria(wp_table('posts'), 'post_id', 'ID', 'INNER'));
			$categoryPostsObjects =& $categoryHandler->getObjects($criteria, false, 'cat_ID, COUNT('.wp_table('post2cat').'.post_id) AS cat_count', false, $joinCriteria);
			if ($categoryPostsObjects) {
				foreach ($categoryPostsObjects as $categoryObject) {
					if ($categoryObject->getExtraVar('cat_count') > 0) {
						$GLOBALS['category_posts'][$categoryObject->getVar('cat_ID')] = $categoryObject->getExtraVar('cat_count');
					}
				}
			}
		}
		$pad = str_repeat($padchar, $level)." ";
		$block['records'] = array();
		foreach ($categoryObjects as $categoryObject) {
			$category = $categoryObject->exportWpObject();
			if (($category->category_parent == $child_of)) {
				$chilid_block =& _b_wp_categories_list($sort_column, $sort_order, $optioncount, $category->cat_ID, $categoryObjects, $arraytree, $padchar, $level+1, $current);
				if ($arraytree) {
					$_record['children'] = $chilid_block['records'];
				}
				if (isset($GLOBALS['category_posts']["$category->cat_ID"]) || count($chilid_block['records'])) {
					$_record['name'] = apply_filters('list_cats', $category->cat_name);
					if (!$arraytree) {
						$_record['name'] = $pad .$_record['name'];
						if ($category->cat_ID == $current) {
							$_record['select'] = 'selected="selected"';
						} else {
							$_record['select'] = '';
						}
					}
					$_record['url'] = get_category_link(0, $category->cat_ID, $category->category_nicename);
					if (empty($category->cat_description)) {
						$_record['title'] = sprintf("View all posts filed under %s", htmlspecialchars($category->cat_name));
					} else {
						$_record['title'] = htmlspecialchars(strip_tags($category->cat_description));
					}
					if (intval($optioncount)) {
						$_record['count'] = ' ('. intval($GLOBALS['category_posts']["$category->cat_ID"]).')';
					}
				}
				$block['records'][] = $_record;
				if (!$arraytree) {
					foreach($chilid_block['records'] as $_record) {
						$block['records'][] = $_record;
					}
				}
			}
		}
		return $block;
	}
}

eval ('
	function b_'.$_wp_my_prefix.'categories_edit($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_categories_edit($options));
	}
	function b_'.$_wp_my_prefix.'categories_show($options) {
		$GLOBALS["wp_inblock"] = 1;
		require(XOOPS_ROOT_PATH."/modules/'.$_wp_my_dirname.'/wp-config.php");
		$GLOBALS["wp_inblock"] = 0;
		return (_b_wp_categories_show($options,"'.$_wp_my_dirnumber.'"));
	}
');

?>
