<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_CATEGORY_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_CATEGORY_INCLUDED' , 1 ) ;
function get_the_category($id=false) {
    if (!$id) {
        $id = $GLOBALS['post']->ID;
    }
    $id = intval($id);
    if (!empty($GLOBALS['category_cache'][wp_id()][$id])) {
    	return $GLOBALS['category_cache'][wp_id()][$id];
	} else {
		$postHandler =& wp_handler('Post');
		$postObject =& $postHandler->get($id);
		$post2CatObjects =& $postObject->getCategories();
		$categories = array();
		$categoryHandler =& wp_handler('Category');
		foreach($post2CatObjects as $post2CatObject) {
			$categoryObject =& $categoryHandler->get($post2CatObject->getVar('category_id'));
			$category =& $categoryObject->exportWpObject();
			$category->category_id = $category->cat_ID;
			$categories[] = $category;
			$GLOBALS['category_cache'][wp_id()][$id][] = $category;
		}
		return $categories;
	}
}

function get_category_link($echo = false, $category_id, $category_nicename = '') {
	$category_id = intval($category_id);
	$cat_ID = $category_id;
	$permalink_structure = get_settings('permalink_structure');
	if ('' == $permalink_structure) {
		$file = wp_siteurl()."/index.php";
		$link = $file.'?cat='.$cat_ID;
	} else {
		if (!$category_nicename) {
			$category_nicename = $GLOBALS['cache_categories'][wp_id()][$category_id]->category_nicename;
		}
		// Get any static stuff from the front
		$front = substr($permalink_structure, 0, strpos($permalink_structure, '%'));
		$link = wp_siteurl() . $front . 'category/' ;
        if ($parent=$GLOBALS['cache_categories'][wp_id()][$category_id]->category_parent) {
        	$link .= get_category_parents($parent, FALSE, '/', TRUE);
        }
        $link .= $category_nicename . '/';
	}
	return _echo($link, $echo);
}

function get_category_rss_link($echo = false, $category_id, $category_nicename, $feed='feed') {
	$category_id = intval($category_id);
	$cat_ID = $category_id;
	$permalink_structure = get_settings('permalink_structure');

	if ('' == $permalink_structure) {
	   if ($feed=='feed') $feed='rss2';
	   $file = wp_siteurl() . '/wp-'.$feed.'.php';
	   $link = $file .'?cat='. $category_id;
	} else {
		$link = get_category_link(0, $category_id, $category_nicename);
	    $link = $link . "$feed/";
	}
	return _echo($link, $echo);
}

function the_category($seperator = '', $parents='', $echo=true) {
    $categories = get_the_category();
    $thelist = '';
    if ('' == $seperator) {
        $thelist .= '<ul class="post-categories">';
        foreach ($categories as $category) {
            $category->cat_name = $category->cat_name;
            $thelist .= "\n\t<li>";
            switch(strtolower($parents)) {
                case 'multiple':
                    if ($category->category_parent) {
                        $thelist .= get_category_parents($category->category_parent, TRUE);
                    }
                    $thelist .= '<a href="' . get_category_link(0, $category->category_id, $category->category_nicename) . '" title="' . sprintf("View all posts in %s", $category->cat_name) . '">'.$category->cat_name.'</a></li>';
                    break;
                case 'single':
                    $thelist .= '<a href="' . get_category_link(0, $category->category_id, $category->category_nicename) . '" title="' . sprintf("View all posts in %s", $category->cat_name) . '>';
                    if ($category->category_parent) {
                        $thelist .= get_category_parents($category->category_parent, FALSE);
                    }
                    $thelist .= $category->cat_name.'</a></li>';
                    break;
                case '':
                default:
                    $thelist .= '<a href="' . get_category_link(0, $category->category_id, $category->category_nicename) . '" title="' . sprintf("View all posts in %s", $category->cat_name) . '">'.$category->cat_name.'</a></li>';
            }
        }
        $thelist .= '</ul>';
    } else {
        $i = 0;
        foreach ($categories as $category) {
            $category->cat_name = $category->cat_name;
            if (0 < $i) $thelist .= $seperator . ' ';
            switch(strtolower($parents)) {
                case 'multiple':
                    if ($category->category_parent)    $thelist .= get_category_parents($category->category_parent, TRUE);
                    $thelist .= '<a href="' . get_category_link(0, $category->category_id, $category->category_nicename) . '" title="' . sprintf("View all posts in %s", $category->cat_name) . '">'.$category->cat_name.'</a>';
                    break;
                case 'single':
                    $thelist .= '<a href="' . get_category_link(0, $category->category_id, $category->category_nicename) . '" title="' . sprintf("View all posts in %s", $category->cat_name) . '">';
                    if ($category->category_parent)    $thelist .= get_category_parents($category->category_parent, FALSE);
                    $thelist .= "$category->cat_name</a>";
                    break;
                case '':
                default:
                    $thelist .= '<a href="' . get_category_link(0, $category->category_id, $category->category_nicename) . '" title="' . sprintf("View all posts in %s", $category->cat_name) . '">'.$category->cat_name.'</a>';
            }
            ++$i;
        }
    }
    return _echo(apply_filters('the_category', $thelist), $echo);
}

function the_category_rss($type = 'rss', $echo=true) {
    $categories = get_the_category();
    $the_list = '';
    foreach ($categories as $category) {
        $category->cat_name = convert_chars($category->cat_name);
        if ('rdf' == $type) {
            $the_list .= "\n\t<dc:subject>$category->cat_name</dc:subject>";
        } else {
            $the_list .= "\n\t<category>$category->cat_name</category>";
        }
    }
	return _echo(wp_convert_rss_charset(apply_filters('the_category_rss', $the_list)), $echo);
}

function get_the_category_by_ID($cat_ID) {
    if ( !$GLOBALS['cache_categories'][wp_id()][$cat_ID] ) {
		$categoryHandler =& wp_handler('Category');
		if ($categoryObject = $categoryHandler->get($cat_ID)) {
			$cat_name = $categoryObject->getVar('cat_name');
        	$GLOBALS['cache_categories'][wp_id()][$cat_ID] = $categoryObject->exportWpObject();
        } else {
        	$cat_name = "";
        }
    } else {
        $cat_name = $GLOBALS['cache_categories'][wp_id()][$cat_ID]->cat_name;
    }
    return($cat_name);
}

function get_category_parents($id, $link = FALSE, $separator = '/', $nicename = FALSE){
    $chain = '';
    $parent = $GLOBALS['cache_categories'][wp_id()][$id];
    if ($nicename) {
        $name = $parent->category_nicename;
    } else {
        $name = $parent->cat_name;
    }
    if ($parent->category_parent) $chain .= get_category_parents($parent->category_parent, $link, $separator, $nicename);
    if ($link) {
        $chain .= '<a href="' . get_category_link(0, $parent->cat_ID, $parent->category_nicename) . '" title="' . sprintf("View all posts in %s", $parent->cat_name) . '">'.$name.'</a>' . $separator;
    } else {
        $chain .= $name.$separator;
    }
    return $chain;
}

function get_category_children($id, $before = '/', $after = '') {
    $c_cache = $GLOBALS['cache_categories'][wp_id()]; // Can't do recursive foreach on a global, have to make a copy
	$chain = '';
    foreach ($c_cache as $category){
        if ($category->category_parent == $id){
            $chain .= $before.$category->cat_ID.$after;
            $chain .= get_category_children($category->cat_ID, $before, $after);
        }
    }
    return $chain;
}
	
// Deprecated.
function the_category_ID($echo = true) {
    // Grab the first cat in the list.
    $categories = get_the_category();
    $cat = $categories[0]->category_id;
    return _echo($cat, $echo);
}

// Deprecated.
function the_category_head($before='', $after='', $echo = true) {
    // Grab the first cat in the list.
    $categories = get_the_category();
    $GLOBALS['currentcat'] = $categories[0]->category_id;
    if ($GLOBALS['currentcat'] != $GLOBALS['previouscat']) {
        $GLOBALS['previouscat'] = $GLOBALS['currentcat'];
        return _echo($before.get_the_category_by_ID($GLOBALS['currentcat']).$after, $echo);
    }
    return "";
}

function category_description($category = 0) {
    if (!$category) {
    	$category = $GLOBALS['cat'];
    }
    $category_description = $GLOBALS['cache_categories'][wp_id()][$category]->category_description;
    $category_description = apply_filters('category_description', $category_description);
    return $category_description;
}

// out of the WordPress loop
function dropdown_cats($optionall = 1, $all = 'All', $sort_column = 'ID', $sort_order = 'asc',
        $optiondates = 0, $optioncount = 0, $hide_empty = 0, $optionnone=false,
        $selected=0, $hide=0, $hierarchical=true, $child_of=0, $link=false, $level=0, $echo = true, $categoryObjects = null) {
    $dropdown_cats = "";
    if (!$selected) $selected = (empty($GLOBALS['cat']) ? 0 : $GLOBALS['cat']);
    if (!isset($categoryObjects)) {
	    $criteria =& new CriteriaCompo(new Criteria('cat_ID', 0 ,'>'));
	    if ($hide) {
	    	$criteria->add(new Criteria('cat_ID', $hide, '!='));
			$catc = trim(get_category_children($hide, '', ' '));
			$catc_array = explode(' ',$catc);
		    for ($i = 0; $i < (count($catc_array)); $i++) {
				$criteria->add(new Criteria('category_id', intval($catc_array[$i]), '!='));
		    }
	    }
	    $criteria->setGroupBy('cat_ID');
	    $criteria->setSort('cat_'.$sort_column);
	    $criteria->setOrder($sort_order);
		$joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'cat_ID', 'category_id', 'INNER');
		$joinCriteria->cascade(new XoopsJoinCriteria(wp_table('posts'), 'post_id', 'ID', 'INNER'));
		$categoryHandler =& wp_handler('Category');
		$categoryObjects =& $categoryHandler->getObjects($criteria, false,
					 'cat_ID, cat_name, category_nicename,category_parent, category_description cat_description,
					  COUNT('.wp_table('post2cat').'.post_id) AS cat_count,DAYOFMONTH(MAX(post_date)) AS lastday,
					  MONTH(MAX(post_date)) AS lastmonth', false, $joinCriteria);
	}
    if ($level==0) {
    	$dropdown_cats .= "<select name='cat' class='postform'>\n";
    }
    if (intval($optionall) == 1) {
        $all = apply_filters('list_cats', $all);
        if ($link) {
        	$dropdown_cats .= "\t<option value='".wp_siteurl()."'>$all</option>\n";
        } else {
        	$dropdown_cats .= "\t<option value='all'>$all</option>\n";
        }
    }
    if (intval($optionnone) == 1) $dropdown_cats .= "\t<option value='0'>None</option>\n";
    if ($categoryObjects) {
        foreach ($categoryObjects as $categoryObject) {
        	if (!$hierarchical || ($child_of == $categoryObject->getVar('category_parent'))) {
				if ((intval($hide_empty) != 1) || ($categoryObject->getVar('cat_count')>0)) {
					$pad = str_repeat('&#8211; ', $level);
					$cat_name = apply_filters('list_cats', $pad.$categoryObject->getVar('cat_name'));
					if ($link) {
						$dropdown_cats .= "\t<option value=\"".get_category_link(false,$categoryObject->getVar('cat_ID'),$categoryObject->getVar('category_nicename'))."\"";
					} else {
						$dropdown_cats .= "\t<option value=\"".$categoryObject->getVar('cat_ID')."\"";
					}
					if ($categoryObject->getVar('cat_ID') == $selected)
					    $dropdown_cats .= ' selected="selected"';
					$dropdown_cats .= '>';
					$dropdown_cats .= $cat_name;
					if (intval($optioncount) == 1) $dropdown_cats .= '&nbsp;&nbsp;('.$categoryObject->getExtraVar('cat_count').')';
					if (intval($optiondates) == 1) $dropdown_cats .= '&nbsp;&nbsp;'.$categoryObject->getExtraVar('lastday').'/'.$categoryObject->getExtraVar('lastmonth');
					$dropdown_cats .= "</option>\n";
				}
				$dropdown_cats .= dropdown_cats(0,'',$sort_column, $sort_order,$optiondates,$optioncount,$hide_empty,$optionnone,$selected,$hide,$hierarchical=true, $categoryObject->getVar('cat_ID'), $link, $level+1, false, $categoryObjects);
			}
        }
    }
    if ($level==0) {
	    $dropdown_cats .= "</select>\n";
	}
	return _echo($dropdown_cats, $echo);
}

// out of the WordPress loop
function wp_list_cats($args = '', $echo=true) {
	parse_str($args, $r);
	if (!isset($r['optionall'])) $r['optionall'] = 0;
    if (!isset($r['all'])) $r['all'] = 'All';
	if (!isset($r['sort_column'])) $r['sort_column'] = 'ID';
	if (!isset($r['sort_order'])) $r['sort_order'] = 'asc';
	if (!isset($r['file'])) $r['file'] = '';
	if (!isset($r['list'])) $r['list'] = true;
	if (!isset($r['optiondates'])) $r['optiondates'] = 0;
	if (!isset($r['optioncount'])) $r['optioncount'] = 0;
	if (!isset($r['hide_empty'])) $r['hide_empty'] = 1;
	if (!isset($r['use_desc_for_title'])) $r['use_desc_for_title'] = 1;
	if (!isset($r['children'])) $r['children'] = true;
	if (!isset($r['child_of'])) $r['child_of'] = 0;
	if (!isset($r['categories'])) $r['categories'] = null;
	if (!isset($r['recurse'])) $r['recurse'] = 0;
	if (!isset($r['feed'])) $r['feed'] = '';
	if (!isset($r['feed_image'])) $r['feed_image'] = '';
	if (!isset($r['exclude'])) $r['exclude'] = '';
	if (!isset($r['hierarchical'])) $r['hierarchical'] = true;

	return list_cats($r['optionall'], $r['all'], $r['sort_column'], $r['sort_order'], $r['file'],	$r['list'], $r['optiondates'], $r['optioncount'], $r['hide_empty'], $r['use_desc_for_title'], $r['children'], $r['child_of'], $r['categories'], $r['recurse'], $r['feed'], $r['feed_image'], $r['exclude'], $r['hierarchical'], $echo);
}

function list_cats($optionall = 1, $all = 'All', $sort_column = 'ID', $sort_order = 'asc', $file = '', $list = true, $optiondates = 0, $optioncount = 0, $hide_empty = 1, $use_desc_for_title = 1, $children=FALSE, $child_of=0, $categoryObjects=null, $recurse=0, $feed = '', $feed_image = '', $exclude = '', $hierarchical=FALSE, $echo=true) {
	$list_cats = '';
	// Optiondates now works
	if ('' == $file) {
		$file = wp_siteurl() . '/index.php';
	}

	$excludeCriteria = null;
	if (!empty($exclude)) {
		$excats = preg_split('/[\s,]+/',$exclude);
		if (count($excats)) {
			$excludeCriteria = new CriteriaCompo();
			foreach ($excats as $excat) {
				$exclusions .= ' AND cat_ID <> ' . intval($excat) . ' ';
		    	$excludeCriteria->add(new Criteria('cat_ID', $excat, '!='));
				$catc = trim(get_category_children($excat, '', ' '));
				$catc_array = explode(' ',$catc);
			    for ($i = 0; $i < (count($catc_array)); $i++) {
					$excludeCriteria->add(new Criteria('category_id', intval($catc_array[$i]), '!='));
			    }
			}
		}
	}
	$categoryHandler =& wp_handler('Category');
	if (!$categoryObjects){
		$criteria =& new CriteriaCompo(new Criteria('cat_ID', 0, '>'));
		if ($excludeCriteria) {
			$criteria->add($excludeCriteria);
		}
		$criteria->setSort('cat_'.$sort_column);
		$criteria->setOrder($sort_order);
		$categoryObjects =& $categoryHandler->getObjects($criteria,false, 
		                     'cat_ID, cat_name, category_nicename, category_description cat_description, category_parent');
	}
	if (empty($GLOBALS['category_posts']) || !count($GLOBALS['category_posts'])) {
		$criteria =& new CriteriaCompo('post_status', 'publish');
		if ($excludeCriteria) {
			$criteria->add($excludeCriteria);
		}
	    $criteria->setGroupBy('category_id');
		$joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'cat_ID', 'category_id', 'INNER');
		$joinCriteria->cascade(new XoopsJoinCriteria(wp_table('posts'), 'post_id', 'ID', 'INNER'));
		$categoryPostsObjects =& $categoryHandler->getObjects($criteria, false, 'cat_ID, COUNT('.wp_table('post2cat').'.post_id) AS cat_count', false, $joinCriteria);
        if ($categoryPostsObjects) {
			foreach ($categoryPostsObjects as $categoryObject) {
				if (intval($hide_empty) != 1  || $categoryObject->getExtraVar('cat_count') > 0) {
					$GLOBALS['category_posts'][$categoryObject->getVar('cat_ID')] = $categoryObject->getExtraVar('cat_count');
				}
			}
		}
	}
	
	if (intval($optiondates) == 1) {
		$criteria =& new CriteriaCompo('post_status', 'publish');
		if ($excludeCriteria) {
			$criteria->add($excludeCriteria);
		}
	    $criteria->setGroupBy('category_id');
		$joinCriteria =& new XoopsJoinCriteria(wp_table('post2cat'), 'cat_ID', 'category_id', 'INNER');
		$joinCriteria->cascade(new XoopsJoinCriteria(wp_table('posts'), 'post_id', 'ID', 'INNER'));
		$categoryDateObjects =& $categoryHandler->getObjects($criteria, false, 'cat_ID, DAYOFMONTH(MAX(post_date)) AS lastday,
		                                                     MONTH(MAX(post_date)) AS lastmonth', false, $joinCriteria);
		foreach ($categoryDateObjects as $categoryObject) {
			$category_lastday["".$categoryObject->getVar('cat_ID')] = $categoryObject->getExtraVar('lastday');
			$category_lastmonth["".$categoryObject->getVar('cat_ID')] = $categoryObject->getExtraVar('lastmonth');
		}
	}
	
	if (intval($optionall) == 1 && !$child_of && $categoryObjects) {
		$all = apply_filters('list_cats', $all);
		$link = "<a href=\"".$file.'?cat=all">'.$all."</a>";
		if ($list) {
			$list_cats .= "\n\t<li>$link</li>";
		} else {
			$list_cats .= "\t$link<br />\n";
		}
	}
	
	$num_found=0;
	$thelist = "";
	
	foreach ($categoryObjects as $categoryObject) {
		$category = $categoryObject->exportWpObject();
		$child_list = '';
		if ((!$hierarchical || $category->category_parent == $child_of) && ($children || $category->category_parent == 0)) {
			if ($hierarchical && $children) {
				$child_list = list_cats($optionall, $all, $sort_column, $sort_order, $file, $list, $optiondates, $optioncount, $hide_empty, $use_desc_for_title, $hierarchical, $category->cat_ID, $categoryObjects, 1, $feed, $feed_image, $exclude, $hierarchical);
			}
			if (intval($hide_empty) == 0 || isset($GLOBALS['category_posts']["$category->cat_ID"]) || $child_list) {
				$num_found++;
				$link = '<a href="'.get_category_link(0, $category->cat_ID, $category->category_nicename).'" ';
				if ($use_desc_for_title == 0 || empty($category->cat_description)) {
					$link .= 'title="'. sprintf("View all posts filed under %s", htmlspecialchars($category->cat_name)) . '"';
				} else {
					$link .= 'title="' . htmlspecialchars(strip_tags($category->cat_description)) . '"';
				}
				$link .= '>';
				$link .= apply_filters('list_cats', $category->cat_name).'</a>';

				if ( (! empty($feed_image)) || (! empty($feed)) ) {
					$link .= ' ';
					if (empty($feed_image)) {
						$link .= '(';
					}
					$link .= '<a href="' . get_category_rss_link(0, $category->cat_ID, $category->category_nicename)  . '"';
					if ( !empty($feed) ) {
						$title =  ' title="' . $feed . '"';
						$alt = ' alt="' . $feed . '"';
						$name = $feed;
						$link .= $title;
					}
					$link .= '>';
					if (! empty($feed_image)) {
						$link .= "<img src=\"$feed_image\" border=\"0\"$alt$title" . ' />';
					} else {
						$link .= $name;
					}
					$link .= '</a>';
					if (empty($feed_image)) {
						$link .= ')';
					}
				}
				if (intval($optioncount) == 1) {
					$link .= ' ('.intval($GLOBALS['category_posts']["$category->cat_ID"]).')';
				}
				if (intval($optiondates) == 1) {
					$link .= ' '.$category_lastday["$category->cat_ID"].'/'.$category_lastmonth["$category->cat_ID"];
				}
				if ($list) {
					$thelist .= "\t<li>$link\n";
				} else {
					$thelist .= "\t$link<br />\n";
				}
				if ($hierarchical && $children) $thelist .= $child_list;
				if ($list) $thelist .= "</li>\n";
			}
		}
	}
	if (!$num_found && !$child_of){
		if ($list) {
			$before = '<li>';
			$after = '</li>';
		}
		return _echo($before . "No categories" . $after . "\n", $echo);
	}
	if ($list && $child_of && $num_found && $recurse) {
		$pre = "\t\t<ul class='children'>";
		$post = "\t\t</ul>\n";
	} else {
		$pre = $post = '';
	}
	$thelist = $pre . $thelist . $post;
	if ($recurse) {
		return $thelist;
	}
	$list_cats .= apply_filters('list_cats', $thelist);
	return _echo($list_cats, $echo);
}

function in_category($category) { // Check if the current post is in the given category
	$cats = '';
	foreach ($GLOBALS['category_cache'][wp_id()][$GLOBALS['post']->ID] as $cat) :
		$cats[] = $cat->category_id;
	endforeach;

	if ( in_array($category, $cats) )
		return true;
	else
		return false;
}
///
function the_category_unicode($echo = true) {
	$category = get_the_category();
	$category = apply_filters('the_category_unicode', $category);
	return _echo(convert_chars($category, 'unicode'),$echo);
}
}
?>