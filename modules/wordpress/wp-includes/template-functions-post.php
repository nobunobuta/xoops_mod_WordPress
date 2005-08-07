<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_POST_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_POST_INCLUDED' , 1 ) ;
function get_the_password_form($echo=true) {
	$output = "<form action='" .wp_siteurl() . "/wp-pass.php' method='post'>
	<p>This post is password protected. To view it please enter your password below:</p>
	<p><label>Password: <input name='post_password' type='text' size='20' /></label> <input type='submit' name='Submit' value='Submit' /></p>
	</form>
	";
	return _echo($output, $echo);
}

function the_ID($echo=true) {
	return _echo($GLOBALS['wp_post_id'], $echo);
}

function the_title($before = '', $after = '', $echo = true) {
	$title = get_the_title();
	if (!empty($title)) {
		$title = apply_filters('the_title', $before . $title . $after);
	}
	return _echo($title, $echo);
}

function the_title_rss($echo=true, $title='') {
	if (!$title) $title = get_the_title();
	$title = apply_filters('the_title', $title);
	$title = apply_filters('the_title_rss', $title);
	return _echo(wp_convert_rss_charset($title), $echo);
}

function get_the_title() {
	$output = $GLOBALS['post']->post_title;
	if (trim($output)=="")
		$output = _WP_POST_NOTITLE;
	if (!empty($GLOBALS['post']->post_password)) { // if there's a password
		$output = 'Protected: ' . $output;
	}
	return $output;
}

function the_content($more_link_text=_WP_TPL_MORE, $stripteaser=0, $more_file='', $echo=true) {
	if (!empty($GLOBALS['post']->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_'.$GLOBALS['cookiehash']] != $GLOBALS['post']->post_password) {  // and it doesn't match the cookie
			$output = get_the_password_form(false);
			return _echo($output, $echo);
		}
	}
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return _echo($content, $echo);
}

function the_content_rss($more_link_text='(more...)', $stripteaser=0, $more_file='', $cut = 0, $encode_html = 0, $echo=true) {
	if (!empty($GLOBALS['post']->post_password)) { // if there's a password
		$output = "<p>This post is password protected. To view it please enter your password below:</p>";
		return _echo($output, $echo);
	}
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = preg_replace('/<style.*?>.*?<\/style.*?>/ms','',$content);
	if ($cut && !$encode_html) {
		$encode_html = 2;
	}
	if ($encode_html == 1) {
		$content = htmlspecialchars($content);
		$cut = 0;
	} elseif ($encode_html == 0) {
		$content = preg_replace('/(<br .*?>|<\/tr>|<\/table>|<\/li>|<\/h\d>|<\/p>)/ms',"_rss_cr_",$content);
		$content = htmlspecialchars(make_url_footnote($content));
		$content = preg_replace('/_rss_cr_/ms','&lt;br /&gt;',$content);
	} elseif ($encode_html == 2) {
		$content = preg_replace('/(<br .*?>|<\/tr>|<\/table>|<\/li>|<\/h\d>|<\/p>)/ms',"_rss_cr_",$content);
		$content = htmlspecialchars(strip_tags($content));
		$content = preg_replace('/_rss_cr_/ms','&lt;br /&gt;',$content);
	} elseif ($encode_html == 3) {
		$content = convert_smilies($content);
		$cut = 0;
	}
	$excerpt = '';
	if ($cut) {
		$blah = explode(' ', $content);
		if (count($blah) > $cut) {
			$k = $cut;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
		for ($i=0; $i<$k; $i++) {
			$excerpt .= $blah[$i].' ';
		}
		$excerpt .= ($use_dotdotdot) ? '...' : '';
		$content = $excerpt;
	}
	$content = str_replace(']]>', ']]&gt;', $content);
	return _echo(wp_convert_rss_charset($content), $echo);
}

function get_the_content($more_link_text='(more...)', $stripteaser=0, $more_file='') {
	$output = '';

	if ($more_file != '') {
		$file = $more_file;
	} else {
		$file = $GLOBALS['pagenow'];
	}
	$content = $GLOBALS['pages'][$GLOBALS['page']-1];
    $content = explode('<!--more-->', $content);
	if ((preg_match('/<!--noteaser-->/', $GLOBALS['post']->post_content) && ((!$GLOBALS['multipage']) || ($GLOBALS['page']==1)))) {
		$stripteaser = 1;
	}
	$teaser = $content[0];
	if (!empty($GLOBALS['more']) && ($stripteaser)) {
		$teaser = '';
	}
	$output .= $teaser;
	if (count($content)>1) {
		if (!empty($GLOBALS['more'])) {
			$output .= '<a id="more-'.$GLOBALS['wp_post_id'].'"></a>'.$content[1];
		} else {
            $output .= ' <a href="'. get_permalink() . '#more-'.$GLOBALS['wp_post_id'].'">'.$more_link_text.'</a>';
		}
	}
	if (!empty($GLOBALS['preview'])) { // preview fix for javascript bug with foreign languages
		$output =  preg_replace('/\%u([0-9A-F]{4,4})/e',  "'&#'.base_convert('\\1',16,10).';'", $output);
	}
	return $output;
}

function the_excerpt($echo=true) {
    return _echo(apply_filters('the_excerpt', get_the_excerpt()), $echo);
}

function the_excerpt_rss($cut = 0, $encode_html = 0, $echo=true) {
	$output = apply_filters('the_excerpt', get_the_excerpt(true));
    if ($cut && !$encode_html) {
        $encode_html = 2;
    }
    if ($encode_html == 1) {
        $output = htmlspecialchars($output);
        $cut = 0;
    } elseif ($encode_html == 0) {
        $output = make_url_footnote($output);
    } elseif ($encode_html == 2) {
        $output = htmlspecialchars(strip_tags($output));
    }
    if ($cut) {
        $excerpt = '';
        $blah = explode(' ', $output);
        if (count($blah) > $cut) {
            $k = $cut;
            $use_dotdotdot = 1;
        } else {
            $k = count($blah);
            $use_dotdotdot = 0;
        }
        for ($i=0; $i<$k; $i++) {
            $excerpt .= $blah[$i].' ';
        }
        $excerpt .= ($use_dotdotdot) ? '...' : '';
        $output = $excerpt;
    }
    $output = str_replace(']]>', ']]&gt;', $output);
	return _echo(wp_convert_rss_charset(apply_filters('the_excerpt_rss', $output)), $echo);
}

function get_the_excerpt($fakeit = false) {
	$output = '';
	$output = $GLOBALS['post']->post_excerpt;
	if (!empty($GLOBALS['post']->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_'.$GLOBALS['cookiehash']] != $GLOBALS['post']->post_password) {  // and it doesn't match the cookie
			$output = "There is no excerpt because this is a protected post.";
			return $output;
		}
	}
    //if we haven't got an excerpt, make one in the style of the rss ones
    if (($output == '') && $fakeit) {
        $output = get_the_content();
        $output = strip_tags($output);
        $blah = explode(' ', $output);
        $excerpt_length = 120;
        if (count($blah) > $excerpt_length) {
			$k = $excerpt_length;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
        $excerpt = '';
		for ($i=0; $i<$k; $i++) {
			$excerpt .= $blah[$i].' ';
		}
		$excerpt .= ($use_dotdotdot) ? '...' : '';
		$output = $excerpt;
    } // end if no excerpt
	if (!empty($GLOBALS['preview'])) { // preview fix for javascript bug with foreign languages
		$output =  preg_replace('/\%u([0-9A-F]{4,4})/e',  "'&#'.base_convert('\\1',16,10).';'", $output);
	}
	return $output;
}

function wp_link_pages($args = '', $echo=true) {
	parse_str($args, $r);
	if (!isset($r['before'])) $r['before'] = '<p>' . 'Pages:';
	if (!isset($r['after'])) $r['after'] = '</p>';
	if (!isset($r['next_or_number'])) $r['next_or_number'] = 'number';
	if (!isset($r['nextpagelink'])) $r['nextpagelink'] = 'Next page';
	if (!isset($r['previouspagelink'])) $r['previouspagelink'] = 'Previous page';
	if (!isset($r['pagelink'])) $r['pagelink'] = '%';
	if (!isset($r['more_file'])) $r['more_file'] = '';
	link_pages($r['before'], $r['after'], $r['next_or_number'], $r['nextpagelink'], $r['previouspagelink'], $r['pagelink'], $r['more_file'], $echo);
}

function link_pages($before='<br />', $after='<br />', $next_or_number='number', $nextpagelink='next page', $previouspagelink='previous page', $pagelink='%', $more_file='', $echo=true) {
	$link_pages = '';
	if ($more_file != '') {
		$file = $more_file;
	} else {
		$file = $GLOBALS['pagenow'];
	}
	if (($GLOBALS['multipage'])) {
		if ($next_or_number=='number') {
			$link_pages .= $before;
			for ($i = 1; $i < ($GLOBALS['numpages']+1); $i = $i + 1) {
				$j=str_replace('%',"$i",$pagelink);
				$link_pages .= " ";
				if (($i != $GLOBALS['page']) || ((!$GLOBALS['more']) && ($GLOBALS['page']==1))) {
				if ('' == get_settings('permalink_structure')) {
					$link_pages .= '<a href="'.get_permalink().'&amp;page='.$i.'">';
				} else {
					$link_pages .= '<a href="'.get_permalink().$i.'/">';
				}
				}
				$link_pages .= $j;
				if (($i != $GLOBALS['page']) || ((!$GLOBALS['more']) && ($GLOBALS['page']==1)))
					$link_pages .= '</a>';
			}
			$link_pages .= $after;
		} else {
			if ($GLOBALS['more']) {
				$link_pages .= $before;
				$i = $GLOBALS['page']-1;
				if ($i && $GLOBALS['more']) {
				if ('' == get_settings('permalink_structure')) {
					$link_pages .= '<a href="'.get_permalink().'&amp;page='.$i.'">';
				} else {
					$link_pages .= '<a href="'.get_permalink().$i.'/">';
				}
				}
				$i = $GLOBALS['page']+1;
				if ($i<=$GLOBALS['numpages'] && $GLOBALS['more']) {
				if ('' == get_settings('permalink_structure')) {
					$link_pages .= '<a href="'.get_permalink().'&amp;page='.$i.'">';
				} else {
					$link_pages .= '<a href="'.get_permalink().$i.'/">';
				}
				}
				$link_pages .= $after;
			}
		}
	}
	return _echo($link_pages, $echo);
}


function previous_post($format='%', $previous='previous post: ', $title='yes', $in_same_cat='no', $limitprev=1, $excluded_categories='', $echo=true) {
	if(!empty($GLOBALS['p']) || ($GLOBALS['posts_per_page'] == 1) || !empty($GLOBALS['single'])) {

		$current_post_date = $GLOBALS['post']->post_date;
		$current_category = $GLOBALS['post']->post_category;

		$criteria =& new CriteriaCompo(new Criteria('post_date', $current_post_date, '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		if ($in_same_cat != 'no') {
			$criteria->add(new Criteria('post_category', $current_category));
		}
		if (!empty($excluded_categories)) {
			$blah = explode('and', $excluded_categories);
			foreach($blah as $category) {
				$category = intval($category);
				$criteria->add(new Criteria('post_category', $category, '!='));
			}
		}
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		$criteria->setStart($limitprev-1);
		$criteria->setLimit(1);
		$postHandler =& wp_handler('Post');
		$postObjects =& $postHandler->getObjects($criteria);
		if (count($postObjects)) {
			$lastPost =& $postObjects[0];
			$string = '<a href="'.get_permalink($lastPost->getVar('ID')).'">'.$previous;
			if ($title == 'yes') {
				$post_title = $lastPost->getVar('post_title');
				if (trim($post_title)=="") $post_title = _WP_POST_NOTITLE;
                $string .= apply_filters('the_title', $post_title);
            }
			$string .= '</a>';
			$format = str_replace('%', $string, $format);
			return _echo($format, $echo);
		}
	}
}

function next_post($format='%', $next='next post: ', $title='yes', $in_same_cat='no', $limitnext=1, $excluded_categories='', $echo=true) {
	if(!empty($GLOBALS['p']) || ($GLOBALS['posts_per_page'] == 1) || !empty($GLOBALS['single'])) {
		$current_post_date = $GLOBALS['post']->post_date;
		$current_category = $GLOBALS['post']->post_category;

		$criteria =& new CriteriaCompo(new Criteria('post_date', $current_post_date, '>'));
		$criteria->add(new Criteria('post_date', current_time('mysql'), '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		if ($in_same_cat != 'no') {
			$criteria->add(new Criteria('post_category', $current_category));
		}
		if (!empty($excluded_categories)) {
			$blah = explode('and', $excluded_categories);
			foreach($blah as $category) {
				$category = intval($category);
				$criteria->add(new Criteria('post_category', $category, '!='));
			}
		}
		$criteria->setSort('post_date');
		$criteria->setStart($limitnext-1);
		$criteria->setLimit(1);
		$postHandler =& wp_handler('Post');
		$postObjects =& $postHandler->getObjects($criteria);
		if (count($postObjects)) {
			$nextPost =& $postObjects[0];
			$string = '<a href="'.get_permalink($nextPost->getVar('ID')).'">'.$next;
			if ($title == 'yes') {
				$post_title = $nextPost->getVar('post_title');
				if (trim($post_title)=="") $post_title = _WP_POST_NOTITLE;
                $string .= apply_filters('the_title', $post_title);
            }
			$string .= '</a>';
			$format = str_replace('%', $string, $format);
			return _echo($format, $echo);
		}
	}
}

function next_posts($max_page = 0, $echo=true) { // original by cfactor at cooltux.org
	if (empty($GLOBALS['p']) && (get_settings('what_to_show') == 'paged')) {
		$qstr = $_SERVER['QUERY_STRING'];
		if (!empty($qstr)) {
			$qstr = preg_replace("/&paged=\d{0,}/","",$qstr);
			$qstr = preg_replace("/paged=\d{0,}/","",$qstr);
		} elseif (stristr($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'] )) {
			if ('' != $qstr = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']) ) {
				$qstr = preg_replace("/^\//", "", $qstr);
				$qstr = preg_replace("/paged\/\d{0,}\//", "", $qstr);
				$qstr = preg_replace("/paged\/\d{0,}/", "", $qstr);
				$qstr = preg_replace("/\/$/", "", $qstr);
			}
		}
		if (!$GLOBALS['paged']) $GLOBALS['paged'] = 1;
		$nextpage = intval($GLOBALS['paged']) + 1;
		if (!$max_page || $max_page >= $nextpage) {
			return _echo(wp_siteurl().'/'.$GLOBALS['pagenow'].'?'.($qstr=='' ? '':$qstr.'&amp;').'paged='.$nextpage , $echo);
		}
	}
	return _echo('', $echo);
}

function next_posts_link($label='Next Page &raquo;', $max_page=0, $echo=true) {
	if (get_settings('what_to_show') == 'paged') {
		if (!$max_page) {
			$postHandler =& wp_handler('Post');
			$GLOBALS['current_posts_criteria']->setGroupBy('');
			$postObjects =& $postHandler->getObjects($GLOBALS['current_posts_criteria'], false, 'count(DISTINCT ID) numposts', '',$GLOBALS['current_posts_join']);
	        $numposts = $postObjects[0]->getExtraVar('numposts');
			$max_page = ceil($numposts / $GLOBALS['posts_per_page']);
		}
		if (empty($GLOBALS['paged'])) {
            $GLOBALS['paged'] = 1;
        }
		$nextpage = intval($GLOBALS['paged']) + 1;
		if (empty($GLOBALS['p']) && (empty($GLOBALS['paged']) || $nextpage <= $max_page)) {
			return _echo('<a href="'.next_posts($max_page, false).'">'.preg_replace('/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $label) .'</a>', $echo);
		}
	}
	return _echo('', $echo);
}

function previous_posts($echo=true) { // original by cfactor at cooltux.org
	if (empty($GLOBALS['p']) && (get_settings('what_to_show') == 'paged')) {
		$qstr = $_SERVER['QUERY_STRING'];
		if (!empty($qstr)) {
			$qstr = preg_replace("/&paged=\d{0,}/","",$qstr);
			$qstr = preg_replace("/paged=\d{0,}/","",$qstr);
		} elseif (stristr($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'] )) {
			if ('' != $qstr = str_replace($_SERVER['SCRIPT_NAME'], '',
											$_SERVER['REQUEST_URI']) ) {
				$qstr = preg_replace("/^\//", "", $qstr);
				$qstr = preg_replace("/paged\/\d{0,}\//", "", $qstr);
				$qstr = preg_replace("/paged\/\d{0,}/", "", $qstr);
				$qstr = preg_replace("/\/$/", "", $qstr);
			}
		}
		$nextpage = intval($GLOBALS['paged']) - 1;
		if ($nextpage < 1) $nextpage = 1;
		return _echo(wp_siteurl().'/'.$GLOBALS['pagenow'].'?'.($qstr=='' ? '':$qstr.'&amp;').'paged='.$nextpage, $echo);
	}
	return _echo('', $echo);
}

function previous_posts_link($label='&laquo; Previous Page', $echo=true) {
	if (empty($GLOBALS['p']) && !empty($GLOBALS['paged']) && ($GLOBALS['paged'] > 1) && (get_settings('what_to_show') == 'paged')) {
		return _echo('<a href="'.previous_posts(false).'">'. preg_replace('/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $label) .'</a>', $echo);
	}
	return _echo('', $echo);
}

function posts_nav_link($sep=' :: ', $prelabel='<< Previous Page', $nxtlabel='Next Page >>', $echo=true) {
	if (empty($GLOBALS['p']) && (get_settings('what_to_show') == 'paged')) {
		$postHandler =& wp_handler('Post');
		$GLOBALS['current_posts_criteria']->setGroupBy('');
		$postObjects =& $postHandler->getObjects($GLOBALS['current_posts_criteria'], false, 'count(DISTINCT ID) numposts', '',$GLOBALS['current_posts_join']);
        $numposts = $postObjects[0]->getExtraVar('numposts');
		$max_page = ceil($numposts / $GLOBALS['posts_per_page']);
		if ($max_page > 1) {
			return _echo(previous_posts_link($prelabel, false).preg_replace('/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $sep).next_posts_link($nxtlabel, $max_page, false), $echo);
		}
	}
	return _echo('', $echo);
}
/*
 * Post-meta: Custom per-post fields.
 */
 
function get_post_custom() {
	return $GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']];
}

function get_post_custom_keys() {
	if (!is_array($GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']]))
		return;
	if ($keys = array_keys($GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']]))
		return $keys;
}

function get_post_custom_values($key='') {
	return $GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']][$key];
}

// this will probably change at some point...
function the_meta($echo=true) {
	$the_meta = '';
	if ($keys = get_post_custom_keys()) {
		$the_meta .= "<ul class='post-meta'>\n";
		foreach ($keys as $key) {
			$values = array_map('trim',$GLOBALS['post_meta_cache'][wp_id()][$GLOBALS['wp_post_id']][$key]);
			$value = implode($values,', ');
			$the_meta .= "<li><span class='post-meta-key'>$key:</span> $value</li>\n";
		}
		$the_meta .= "</ul>\n";
	}
	return _echo($the_meta, $echo);
}
}
?>
