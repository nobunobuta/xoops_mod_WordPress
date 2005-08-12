<?php
// Sortable Nicer Archive for WordPress XOOPS Module Japanese Kanji Edition.
//  Original Sortable Nicer Archives for WordPress 
//    http://weblogtoolscollection.com/archives/2004/05/23/sortable-nicer-archives-for-wordpress/
//  Ported for XOOPS by Nobuki Kowa
//    http://www.kowa.org

// Settings
// Caution: if you want to customize following parameter,
//          you should set them at themes/xxxx/wp-config-custom.php
$GLOBALS['wp_arc_posts_per_page'] = '-1';                 // Max number for listing (-1 means no limit)
$GLOBALS['wp_arc_display_authors']  = 1;                  // 0:Don't show Autor list  1:Show Autor list.
$GLOBALS['wp_arc_display_categories']  = 1;               // 0:Don't show Category list  1:Show Category list.
$GLOBALS['wp_arc_display_keyword']  = 1;                  // 0:Don't show Keyword input  1:Show Keyword input.
$GLOBALS['wp_arc_default_orderby'] = 'date';
$GLOBALS['wp_arc_default_order'] = 'DESC';

if (empty($_GET['orderby'])) $_GET['orderby'] = $GLOBALS['wp_arc_default_orderby'];
if (empty($_GET['order'])) $_GET['order'] = $GLOBALS['wp_arc_default_order'];

function show_year_select() {
	if (test_param('m')) {
    	$m = substr(get_param('m'),0,4);
    }
	$criteria =& new CriteriaCompo(new Criteria('post_date', current_time('mysql'), '<'));
	$criteria->add(new Criteria('post_status', 'publish'));
	$criteria->setSort('year');
	$criteria->setOrder('ASC');
	$criteria->setGroupby('YEAR(post_date), MONTH(post_date)');
	$postHandler =& wp_handler('Post');
	$postObjects =& $postHandler->getObjects($criteria, false, 'DISTINCT YEAR(post_date) AS `year`');
    $output = '<option value="">'._LANG_NKA_ALL_YEAR.'</option>'."\n";
    foreach ($postObjects as $postObject) {
    	$year = $postObject->getExtraVar('year');
        $output .= '<option value="'.$year.'"';
        if (!empty($m) && ($year == $m)) {
            $output .= ' selected="selected"';
        }
        $output .= '>'.$year._LANG_NKA_YEAR_SUFFIX.'</option>';
    }
    $output  = '<select name="m">'."\n".$output.'</select>'."\n";
    echo $output;
}

function show_author_select() {
	$userHandler =& wp_handler('User');
	$criteria = new Criteria('user_level', '0', '>');
	$users =& $userHandler->getObjects($criteria);
    $output = '<option value="">'._LANG_NKA_ALL_AUTHOR.'</option>'."\n";
    foreach ($users as $user) {
    	$id = $user->getVar('ID');
    	$user_nickname = $user->getVar('user_nickname');
        $output .= '<option value="'.$id.'"';
        if (test_param('author') && (get_param('author') == $id)) {
            $output .= 'selected="selected"';
        }
        $output .= '>'.$user_nickname.'</option>'."\n";
    }
    $output = '<select name="author">'."\n".$output.'</select>'."\n";
    echo $output;
}

function show_category_select() {
	$categoryHandler =& wp_handler('Category');
	$categories =& $categoryHandler->getParentOptionArray();
    $output = '<option value="0">'._WP_LIST_CAT_ALL.'</option>'."\n";
	foreach($categories as $cat_id =>$cat_name) {
        $output .= '<option value="'.$cat_id.'"';
        if (test_param('cat') && ($cat_id == get_param('cat'))) {
            $output .= 'selected="selected"';
        }
        $output .= '>'.$cat_name.'</option>'."\n";
	}
    $output = '<select name="cat">'."\n".$output.'</select>'."\n";
    echo $output;
}

function show_orderby_select() {
	if (test_param('orderby')) {
    	$orderby = explode(' ', get_param('orderby'));
	    $orderby = $orderby[0];
    } else {
    	$orderby = '';
    }
    if ($orderby == 'date') {
       $output = '<option value="date" selected="selected">'._LANG_NKA_ORDER_DATE.'</option>'."\n";
    } else {
       $output = '<option value="date">'._LANG_NKA_ORDER_DATE.'</option>'."\n";
    }
    if ($orderby == 'title') {
       $output .= '<option value="title" selected="selected">'._LANG_NKA_ORDER_TITLE.'</option>'."\n";
    } else {
       $output .= '<option value="title">'._LANG_NKA_ORDER_TITLE.'</option>'."\n";
    }
    if ($orderby == 'category') {
       $output .= '<option value="category" selected="selected">'._LANG_NKA_ORDER_CATEGORY.'</option>'."\n";
    } else {
       $output .= '<option value="category">'._LANG_NKA_ORDER_CATEGORY.'</option>'."\n";
    }
    if ($orderby == 'author') {
       $output .= '<option value="author" selected="selected">'._LANG_NKA_ORDER_AUTHOR.'</option>'."\n";
    } else {
       $output .= '<option value="author">'._LANG_NKA_ORDER_AUTHOR.'</option>'."\n";
    }
    $output = '<select name="orderby" onchange="Choose(this)">'."\n".$output.'</select>'."\n";
    echo $output;
}

function show_keyword() {
	if(test_param('s')) {
		$s = htmlspecialchars(get_param('s'));
	} else {
		$s = '';
	}
	echo '<input name="s" size="8" value="'.$s.'" />';
}

function show_order_select() {
    if (get_param('order') == 'ASC') {
       $output = '<option value="ASC" selected="selected">'._LANG_NKA_SORT_ASC.'</option>'."\n";
    } else {
       $output = '<option value="ASC">'._LANG_NKA_SORT_ASC.'</option>'."\n";
    }
    if (get_param('order') == 'DESC') {
       $output .= '<option value="DESC" selected="selected">'._LANG_NKA_SORT_DSC.'</option>'."\n";
    } else {
       $output .= '<option value="DESC">'._LANG_NKA_SORT_DSC.'</option>'."\n";
   }
   $output = '<select name="order" id="asc_desc">'."\n".$output.'</select>'."\n";
   echo $output;
}

function archive_header(&$post, $before='', $after='') {
  static $previous = '';
	if (test_param('orderby')) {
    	$orderby = explode(' ', get_param('orderby'));
	    $orderby = $orderby[0];
    } else {
    	$orderby = '';
    }
    switch($orderby) {
      case 'title':
    	if (_LANGCODE == 'ja') {
	    	$thisletter = ucfirst(mb_substring($post->yomi,0,1,$GLOBALS['blog_charset']));
    		if ($thisletter > "¤ó") $thisletter = "´Á»ú";
    	} else {
    		$thisletter = ucfirst(substr($post->yomi,0,1));
    	}
    	if ($thisletter == "") $thisletter = _WP_POST_NOTITLE;
   		
        if ($previous==='' || $thisletter !== $previous) {
            $output = "<br/>".$thisletter;
        }
        $previous = $thisletter;
		break;
      case 'category':
        $thiscategory = $post->cat_ID;
        if ($thiscategory != $previous) {
            $output = '<br/><strong><a href="'.get_category_link(false,$thiscategory).'">'.get_catname($thiscategory).'</a></strong>';
        }
        $previous = $thiscategory;
        break;
      case 'author':
        $thisauthor = $post->post_author;
        if ($thisauthor != $previous) {
            $output = '<br/><strong><a href="'.get_author_link(false,$thisauthor).'">'.the_author('',false).'</a></strong>';
        }
        $previous = $thisauthor;
        break;
       case 'date':
       case '':
        $thismonth = mysql2date('m', $post->post_date);
        $thisyear = mysql2date('Y', $post->post_date);
        $thisdate = $thisyear.$thismonth;
        if ($thisdate != $previous) {
			$monthstr = format_month(sprintf("%d",$thisyear), $GLOBALS['month'][zeroise($thismonth,2)]);
            $output = '<strong><br/><a href="'.get_month_link($thisyear,$thismonth).'">'.$monthstr.'</a></strong>';
        }
        $previous = $thisdate;
        break;
    }
    if (!empty($output)) {
        $output = $before.$output.$after."\n";
        echo $output;
    }
}

function archive_date(&$post, $format='Y-m-d H:i:s') {
    echo mysql2date($format, $post->post_date);
}

function title_ja_cmp($a, $b) {
    if (get_param('order') == 'ASC') {
		return strcasecmp($a->yomi, $b->yomi);
	} else {
		return strcasecmp($b->yomi, $a->yomi);
	}
}

function &title_sort(&$posts) {
	$enable_kakasi    = $GLOBALS['xoopsModuleConfig']['wp_use_kakasi_for_archive'];
	$kakasi           = $GLOBALS['xoopsModuleConfig']['wp_kakasi_path'];
	$kakasi_encode    = $GLOBALS['xoopsModuleConfig']['wp_kakasi_charset'];
	$blog_charset     = $GLOBALS['blog_charset'];
	if (_LANGCODE == 'ja') {
		if ($enable_kakasi) {
			$descriptorspec = array(
				0 => array('pipe', 'r'),  // stdin is a pipe that the child will read from
				1 => array('pipe', 'w'),  // stdout is a pipe that the child will write to
				2 => array('pipe', 'w'),  // stdout is a pipe that the child will write to
			);
			// Precheck for kakasi (file_exists cannot be used in safemode);
			$process = proc_open($kakasi." -?", $descriptorspec, $pipes);
			if (is_resource($process)) {
				if (!preg_match('/^KAKASI /',fgets($pipes[2]))) $enable_kakasi=false;
				proc_close($process);
			}
			if ($enable_kakasi) {
				$process = proc_open($kakasi.' -kH -KH -JH', $descriptorspec, $pipes);
				if (is_resource($process)) {
			    	for($i = 0; $i < count($posts); $i++) {
						fputs($pipes[0], mb_conv($posts[$i]->post_title."\n", $kakasi_encode, $blog_charset));
					}
					fclose($pipes[0]);
			    	for($i = 0; $i < count($posts); $i++) {
						$posts[$i]->yomi = mb_conv(fgets ($pipes[1]), $blog_charset, $kakasi_encode);
						$posts[$i]->yomi = preg_replace('/[\r\n]*$/','',$posts[$i]->yomi);
			    	}
					fclose($pipes[1]);
					$return_value = proc_close($process);
				}
			} else {
	    		if (function_exists('mb_convert_kana')) {
			    	for($i = 0; $i < count($posts); $i++) {
						$posts[$i]->yomi = mb_convert_kana($posts[$i]->post_title,'KcV', $blog_charset);
					}
				} else {
					for($i = 0; $i < count($posts); $i++) {
						$posts[$i]->yomi = $posts[$i]->post_title;
					}
				}
			}
		} else {
    		if (function_exists('mb_convert_kana')) {
		    	for($i = 0; $i < count($posts); $i++) {
					$posts[$i]->yomi = mb_convert_kana($posts[$i]->post_title,'KcV', $blog_charset);
				}
			} else {
				for($i = 0; $i < count($posts); $i++) {
					$posts[$i]->yomi = $posts[$i]->post_title;
				}
			}
		}
	} else {
    	for($i = 0; $i < count($posts); $i++) {
			$posts[$i]->yomi = $posts[$i]->post_title;
		}
	}
	usort($posts, 'title_ja_cmp');
	return $posts;
}

function post_count_exceeds() {
	$postHandler =& wp_handler('Post');
	$GLOBALS['current_posts_criteria']->setGroupBy('');
	$postObjects =& $postHandler->getObjects($GLOBALS['current_posts_criteria'], false, 'count(DISTINCT ID) numposts', '',$GLOBALS['current_posts_join']);
    $numposts = $postObjects[0]->getExtraVar('numposts');
    if ($GLOBALS['posts_per_page'] != -1 && $numposts > $GLOBALS['posts_per_page'])
    echo '<p><b>'.sprintf(_LANG_NKA_EXCEEDS_COUNT,$GLOBALS['posts_per_page']).'</b></p>';
}

$GLOBALS['show_cblock'] =0;
include('header.php');

if (get_param('orderby') == 'title') {
	title_sort($posts);
}

?>
<div id="rap">
<h2 id="header"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h2>
<div id="wpMainContent">
<script language="javascript" type="text/javascript">
function Choose(whichSort) {
    if (whichSort.selectedIndex == 0) {
        document.getElementById('asc_desc').selectedIndex = 1;
    } else {
        document.getElementById('asc_desc').selectedIndex = 0;
    }
}
</script>
<?php echo _LANG_NKA_ARCHIVE ?> :
<form action="<?php getenv('PHP_SELF') ?>" method="GET">
<?php show_orderby_select() ?>
<?php show_order_select() ?>
<?php show_year_select() ?>
<?php if ($GLOBALS['wp_arc_display_categories']) show_category_select() ?>
<?php if ($GLOBALS['wp_arc_display_authors']) show_author_select(); ?>
<?php if ($GLOBALS['wp_arc_display_keyword']) show_keyword(); ?>
<input type="submit" name="submit" value="<?php echo _LANG_NKA_ACTION_SORT ?>" />
</form>
<?php post_count_exceeds() ?>
<?php if ($posts) { foreach ($posts as $post) { start_wp(); ?>
<?php archive_header($post, '<h3>', '</h3>') ?>
<?php archive_date($post, 'Y/m/d H:i') ?> : <a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a><br />
<?php } }
?>
<p class="credit"><?php echo $GLOBALS['wpdb']->querycount; ?> queries. <?php timer_stop(1); ?> sec.<br /><cite>Powered by <a href="http://www.kowa.org/" title="NobuNobu XOOPS"><strong>WordPress Module</strong></a> based on <a href="http://wordpress.xwd.jp/" title="Powered by WordPress Japan"><strong>WordPress ME</strong></a> & <a href="http://www.wordpress.org/" title="Powered by WordPress"><strong>WordPress</strong></a></cite></p>
</div>
</div>
<?php include(XOOPS_ROOT_PATH.'/footer.php'); ?>
