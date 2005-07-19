<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_GENERAL_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_GENERAL_INCLUDED' , 1 ) ;
/* Note: these tags go anywhere in the template */
function bloginfo($show='', $echo=true) {
    $info = apply_filters('bloginfo', get_bloginfo($show));
    return _echo(convert_chars($info), $echo);
}

function bloginfo_rss($show='', $echo=true) {
	$info = strip_tags(get_bloginfo($show));
	return _echo(wp_convert_rss_charset($info), $echo);
}

function bloginfo_unicode($show='', $echo=true) {
    $info = get_bloginfo($show);
    return _echo(convert_chars($info), $echo);
}

function get_bloginfo($show='') {
    if (get_settings('permalink_structure') != '') {
        $do_perma = 1;
		// Get any static stuff from the front
		$front = preg_match('#^/index.php/#' ,get_settings('permalink_structure')) ? '/index.php' : '';
	    $site_url = wp_siteurl();
        $feed_url = wp_siteurl().$front.'/feed';
        $comment_feed_url = wp_siteurl().$front.'/comments/feed';
    } else {
	    $do_perma = 0;
	    $site_url = wp_siteurl();
	    $feed_url = wp_siteurl();
	    $comment_feed_url = wp_siteurl();
    }

    switch($show) {
        case 'url':
		case 'siteurl':
			$output = $site_url.'/index.php';
            break;
        case 'description':
            $output = get_settings('blogdescription');
            break;
        case 'rdf_url':
            $output = $site_url.'/wp-rdf.php';
            if ($do_perma) {
                $output = $feed_url . '/rdf/';
            }
            break;
        case 'rss_url':
            $output = $site_url.'/wp-rss.php';
            if ($do_perma) {
                $output = $feed_url . '/rss/';
            }
            break;
        case 'rss2_url':
            $output = $site_url.'/wp-rss2.php';
            if ($do_perma) {
                $output = $feed_url . '/rss2/';
            }
            break;
        case 'atom_url':
            $output = $site_url.'/wp-atom.php';
            if ($do_perma) {
                $output = $feed_url . '/atom/';
            }
            break;        
        case 'comments_rss2_url':
            $output = $site_url.'/wp-commentsrss2.php';
            if ($do_perma) {
                $output = $comment_feed_url . '/rss2/';
            }
            break;
        case 'pingback_url':
            $output = $site_url.'/xmlrpc.php';
            break;
        case 'admin_email':
            $output = get_settings('admin_email');
            break;
		case 'charset':
			$output = $GLOBALS['blog_charset'];
			if ('' == $output) $output = 'UTF-8';
			break;
		case 'version':
			$output = $GLOBALS['wp_version'];
			break;
        case 'name':
        default:
            $output = get_settings('blogname');
            break;
    }
    return $output;
}

function wp_title($sep = '&raquo;', $echo = true) {
	// If there's a category
   $title = '';
   if(!empty($GLOBALS['cat'])) {
        if (!stristr($GLOBALS['cat'],'-')) { // category excluded
            $title = get_the_category_by_ID($GLOBALS['cat']);
        }
    }
	if (!empty($GLOBALS['category_name'])) {
		$categoryHandler =& wp_handler('Category');
		$categoryObject =& $categoryHandler->getByNiceName($GLOBALS['category_name']);
		$title = $categoryObject->getVar('cat_name');
	}

	if(!empty($GLOBALS['monthnum']) && !empty($GLOBALS['year'])) {
		$my_year = $GLOBALS['year'];
		$my_month = $GLOBALS['month'][zeroise($GLOBALS['monthnum'],2)];
		if (!empty($GLOBALS['day'])) {
			$my_month = zeroise($GLOBALS['monthnum'], 2);
			$my_day = zeroise($GLOBALS['day'], 2);
		}
	} elseif(!empty($GLOBALS['m'])) {
		$my_year = substr($GLOBALS['m'], 0, 4);
		$my_month = $GLOBALS['month'][substr($GLOBALS['m'], 4, 2)];
		if (strlen($GLOBALS['m']) == 6) {
			$my_month = substr($GLOBALS['m'], 4, 2);
			$my_day = substr($GLOBALS['m'], 6, 2);
		}
	}
	if (!empty($my_day)) {
		$title = mysql2date($GLOBALS['dateformat'], $my_year.'-'.$my_month.'-'.$my_day.' 00:00:00');
	} else if (!empty($my_month)) {
		$title = ereg_replace('%MONTH', $my_month, $GLOBALS['wp_month_format']);
		$title = ereg_replace('%YEAR', $my_year, $title);
	}

	// If there's a post
	if ((!empty($GLOBALS['p']) && intval($GLOBALS['p'])) || (!empty($GLOBALS['name']) && $GLOBALS['name'] != '')) {
		if (empty($GLOBALS['p'])) {
			$criteria = new CriteriaCompo(new Criteria('post_name',$GLOBALS['name']));
			if (!empty($GLOBALS['year'])) {
				$criteria->add(new Criteria('YEAR(post_date)', $GLOBALS['year']));
			}
			if (!empty($GLOBALS['monthnum'])) {
				$criteria->add(new Criteria('MONTH(post_date)', $GLOBALS['monthnum']));
			}
			if (!empty($GLOBALS['day'])) {
				$criteria->add(new Criteria('DAYOFMONTH(post_date)', $GLOBALS['day']));
			}
			$postHandler =& wp_handler('Post');
			$postObjects =& $postHandler->getObjects($criteria);
			$GLOBALS['p'] = $postObjects[0]->getVar('ID');
		}
		$post_data = get_postdata($GLOBALS['p']);
		$title = strip_tags($post_data['Title']);
		if (trim($title)=="") $title = _WP_POST_NOTITLE;
		$title = apply_filters('single_post_title', $title);
	}

	$userObject = false;
	if (!empty($GLOBALS['author_name'])) {
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->getByLogin($GLOBALS['author_name']);
	} elseif (!empty($GLOBALS['author'])) {
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->get($GLOBALS['author']);
	} elseif (!empty($GLOBALS['p'])) {
		$postHandler =& wp_handler('Post');
		$postObject =& $postHandler->get($GLOBALS['p']);
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->get($postObject->getVar('post_author'));
	}
	if ($userObject) {
		$result = $userObject->exportWpObject();
		$idmode = $result->user_idmode;
	    if ($idmode == 'nickname')    $id = $result->user_nickname;
	    if ($idmode == 'login')    $id = $result->user_login;
	    if ($idmode == 'firstname')    $id = $result->user_firstname;
	    if ($idmode == 'lastname')    $id = $result->user_lastname;
	    if ($idmode == 'namefl')    $id = $result->user_firstname.' '.$result->user_lastname;
	    if ($idmode == 'namelf')    $id = $result->user_lastname.' '.$result->user_firstname;
	    if ($idmode == 'ID')        $id = $result->ID;
	    if (!$idmode) $id = $result->user_nickname;
	    $title .= " by $id";
	}
	if (!empty($title)) {
		$title = $sep.$title;
	}
	return _echo($title, $echo);
}

function single_post_title($prefix = '', $echo = true) {
	$title = '';
	if ((!empty($GLOBALS['p']) && intval($GLOBALS['p'])) || (!empty($GLOBALS['name']) && $GLOBALS['name'] != '')) {
		$criteria = new CriteriaCompo(new Criteria('post_name',$GLOBALS['name']));
		if (empty($GLOBALS['p'])) {
			if (!empty($GLOBALS['year'])) {
				$criteria->add(new Criteria('YEAR(post_date)', $GLOBALS['year']));
			}
			if (!empty($GLOBALS['monthnum'])) {
				$criteria->add(new Criteria('MONTH(post_date)', $GLOBALS['monthnum']));
			}
			if (!empty($GLOBALS['day'])) {
				$criteria->add(new Criteria('DAYOFMONTH(post_date)', $GLOBALS['day']));
			}
			$postHandler =& wp_handler('Post');
			$postObjects =& $postHandler->getObjects($criteria);
			$GLOBALS['p'] = $postObjects[0]->getVar('ID');
		}
		$post_data = get_postdata($GLOBALS['p']);
		$title = strip_tags($post_data['Title']);
		if (trim($title)=="") $title = _WP_POST_NOTITLE;
		$title = apply_filters('single_post_title', $title);
	}
	if (!empty($title)) {
		$title = $prefix.$title;
	}
	return _echo($title, $echo);
}

function single_author_title($prefix = '', $echo = true ) {
	$title = '';
	$userObject = false;
	if (!empty($GLOBALS['author_name'])) {
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->getByLogin($GLOBALS['author_name']);
	} elseif (!empty($GLOBALS['author'])) {
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->get($GLOBALS['author']);
	} elseif (!empty($GLOBALS['p'])) {
		$postHandler =& wp_handler('Post');
		$postObject =& $postHandler->get($GLOBALS['p']);
		$userHandler =& wp_handler('User');
		$userObject =& $userHandler->get($postObject->getVar('post_author'));
	}
	if ($userObject) {
		$result = $userObject->exportWpObject();
		$idmode = $result->user_idmode;
	    if ($idmode == 'nickname')    $id = $result->user_nickname;
	    if ($idmode == 'login')    $id = $result->user_login;
	    if ($idmode == 'firstname')    $id = $result->user_firstname;
	    if ($idmode == 'lastname')    $id = $result->user_lastname;
	    if ($idmode == 'namefl')    $id = $result->user_firstname.' '.$result->user_lastname;
	    if ($idmode == 'namelf')    $id = $result->user_lastname.' '.$result->user_firstname;
	    if ($idmode == 'ID')        $id = $result->ID;
	    if (!$idmode) $id = $result->user_nickname;
	}
	if (!empty($title)) {
		$title = $prefix.$title;
	}
	return _echo($title, $echo);
}

function single_cat_title($prefix = '', $echo = true ) {
	$title = '';
	if ($GLOBALS['cat']) {
		if (!stristr($GLOBALS['cat'], '-')) { // category excluded
		    $title = get_the_category_by_ID($GLOBALS['cat']);
		}
	}
	if ($GLOBALS['category_name']) {
		$categoryHandler =& wp_handler('Category');
		$categoryObject =& $categoryHandler->getByNiceName($GLOBALS['category_name']);
		$title = $categoryObject->getVar('cat_name');
	}
	if (!empty($title)) {
		$title = $prefix.strip_tags($title);
	}
	return _echo($title, $echo);
}

function single_month_title($prefix = '', $echo = true ) {
	$title = '';
	if(empty($GLOBALS['p'])) {
		if(!empty($GLOBALS['monthnum']) && !empty($GLOBALS['year'])) {
			$my_year = $GLOBALS['year'];
			$my_month = $GLOBALS['month'][zeroise($GLOBALS['monthnum'],2)];
			if (!empty($GLOBALS['day'])) {
				$my_month = zeroise($GLOBALS['monthnum'], 2);
				$my_day = zeroise($GLOBALS['day'], 2);
			}
		} elseif(!empty($GLOBALS['m'])) {
			$my_year = substr($GLOBALS['m'], 0, 4);
			$my_month = $GLOBALS['month'][substr($GLOBALS['m'], 4, 2)];
			if (strlen($GLOBALS['m']) == 6) {
				$my_month = substr($GLOBALS['m'], 4, 2);
				$my_day = substr($GLOBALS['m'], 6, 2);
			}
		}
		if (!empty($my_day)) {
			$title = mysql2date($GLOBALS['dateformat'], $my_year.'-'.$my_month.'-'.$my_day.' 00:00:00');
		} else if (!empty($my_month)) {
			$title = ereg_replace('%MONTH', $my_month, $GLOBALS['wp_month_format']);
			$title = ereg_replace('%YEAR', $my_year, $title);
		}
	}
	if (!empty($title)) {
		$title = $prefix.strip_tags($title);
	}
	return _echo($title, $echo);
}

/* link navigation hack by Orien http://icecode.com/ */
function get_archives_link($url, $text, $format = "html", $before = "", $after = "", $selected = false) {
	if ('link' == $format) {
		return "\t".'<link rel="archives" title="'.$text.'" href="'.$url.'" />'."\n";
	} else if ('option' == $format) {
		$select = $selected ? 'selected="selected"' : '';
		return '<option value="'.$url.'" '. $select . ' >'.$text.$after.'</option>'."\n";
	} else if ('html' == $format) {
		return "\t".'<li><a href="'.$url.'" title="'.$text.'">'.$text.'</a>'.$after.'</li>'."\n";
	} else { // custom
		return "\t".$before.'<a href="'.$url.'" title="'.$text.'">'.$text.'</a>'.$after."\n";
	}
}


function wp_get_archives($args = '', $echo=true) {
	parse_str($args, $r);
	if (!isset($r['type'])) $r['type'] = '';
	if (!isset($r['limit'])) $r['limit'] = '';
	if (!isset($r['format'])) $r['format'] = 'html';
	if (!isset($r['before'])) $r['before'] = '';
	if (!isset($r['after'])) $r['after'] = '';
	if (!isset($r['show_post_count'])) $r['show_post_count'] = false;
	if (!isset($r['selvalue'])) $r['selvalue'] = '';
	get_archives($r['type'], $r['limit'], $r['format'], $r['before'], $r['after'], $r['show_post_count'],$r['selvalue'], $echo);
}

function get_archives($type='', $limit='', $format='html', $before = "", $after = "", $show_post_count = false, $selvalue='', $echo=true) {	$get_archives = '';
    if (!$type) {
        $type = get_settings('archive_mode');
    }
	// this is what will separate dates on weekly archive links
	$archive_week_separator = '&#8211;';

	// archive link url
	$archive_link_m = wp_siteurl().'/index.php?m=';	# monthly archive;
	$archive_link_w = wp_siteurl().'/index.php?w=';	# weekly archive;
	$archive_link_p = wp_siteurl().'/index.php?p=';	# post-by-post archive;

    // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
    $archive_date_format_over_ride = 0;

    // options for daily archive (only if you over-ride the general date format)
    $archive_day_date_format = 'Y/m/d';

    // options for weekly archive (only if you over-ride the general date format)
    $archive_week_start_date_format = 'Y/m/d';
    $archive_week_end_date_format   = 'Y/m/d';

    if (!$archive_date_format_over_ride) {
        $archive_day_date_format = $GLOBALS['dateformat'];
        $archive_week_start_date_format = $GLOBALS['dateformat'];
        $archive_week_end_date_format = $GLOBALS['dateformat'];
    }

	$now = current_time('mysql');

	$postHandler =& wp_handler('Post');
	if ('monthly' == $type) {
		$criteria =& new CriteriaCompo(new Criteria('post_date', $now, '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		$criteria->setGroupby('YEAR(post_date), MONTH(post_date)');
		if ($limit) $criteria->setLimit($limit);
		$postObjects =& $postHandler->getObjects($criteria, false, 'DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts');
		if ($postObjects) {
			foreach($postObjects as $postObject) {
				$this_year = $postObject->getExtraVar('year');
				$this_month = $postObject->getExtraVar('month');
				$url  = get_month_link($this_year, $this_month);
				if ($show_post_count) {
					$text = ereg_replace('%MONTH',$GLOBALS['month'][zeroise($this_month,2)],$GLOBALS['wp_month_format']);
					$text = ereg_replace('%YEAR',sprintf("%d",$this_year),$text);
					$after = "&nbsp;(".$postObject->getExtraVar('posts').")";
				} else {
					$text = ereg_replace('%MONTH',$GLOBALS['month'][zeroise($this_month,2)],$GLOBALS['wp_month_format']);
					$text = ereg_replace('%YEAR',sprintf("%d",$this_year),$text);
				}
				$selected = ($selvalue == $this_year.zeroise($this_month,2));
				$get_archives .= get_archives_link($url, $text, $format, $before, $after, $selected);
			}
		}
	} elseif ('daily' == $type) {
		$criteria =& new CriteriaCompo(new Criteria('post_date', $now, '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		if ($limit) $criteria->setLimit($limit);
		$postObjects =& $postHandler->getObjects($criteria, false, 'DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`');
		if ($postObjects) {
			foreach($postObjects as $postObject) {
				$this_year = $postObject->getExtraVar('year');
				$this_month = $postObject->getExtraVar('month');
				$this_day = $postObject->getExtraVar('dayofmonth');
				$url  = get_day_link($this_year, $this_month, $this_day);
				$date = sprintf("%d-%02d-%02d 00:00:00", $this_year, $this_month, $this_day);
				$text = mysql2date($archive_day_date_format, $date);
				$get_archives .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ('weekly' == $type) {
		$criteria =& new CriteriaCompo(new Criteria('post_date', $now, '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		if ($limit) $criteria->setLimit($limit);
		$postObjects =& $postHandler->getObjects($criteria, false, "DISTINCT WEEK(post_date, ".get_settings('start_of_week').") AS `week`, YEAR(post_date) AS yr, DATE_FORMAT(post_date, '%Y-%m-%d') AS yyyymmdd");
		$arc_w_last = '';
		if ($postObjects) {
			foreach($postObjects as $postObject) {
				$arc_week = $postObject->getExtraVar('week');
				$arc_year = $postObject->getExtraVar('yr');
				$arc_date = $postObject->getExtraVar('yyyymmdd');
				if ($arc_week != $arc_w_last) {
					$arc_w_last = $arc_week;
					$arc_week_days = get_weekstartend($arc_date, get_settings('start_of_week'));
					$arc_week_start = date_i18n($archive_week_start_date_format, $arc_week_days['start']);
					$arc_week_end = date_i18n($archive_week_end_date_format, $arc_week_days['end']);
					$url  = sprintf("%s/index.php?m=%s&amp;w=%d", wp_siteurl(), $arc_year, $arc_week);
					$text = $arc_week_start . $archive_week_separator . $arc_week_end;
					$get_archives .= get_archives_link($url, $text, $format, $before, $after);
				}
			}
		}
	} elseif ('postbypost' == $type) {
		$criteria =& new CriteriaCompo(new Criteria('post_date', $now, '<'));
		$criteria->add(new Criteria('post_status', 'publish'));
		$criteria->setSort('post_date');
		$criteria->setOrder('DESC');
		if ($limit) $criteria->setLimit($limit);
		$postObjects =& $postHandler->getObjects($criteria, false, 'ID, post_date, post_title');
		if ($postObjects) {
			foreach($postObjects as $postObject) {
                if ($postObject->getVar('post_date') != '0000-00-00 00:00:00') {
                    $url  = get_permalink($postObject->getVar('ID'));
                    $arc_title = $postObject->getVar('post_title');
                    if ($arc_title) {
                        $text = strip_tags($arc_title);
                    } else {
                        $text = _WP_POST_NOTITLE;;
                    }
                    $get_archives .= get_archives_link($url, $text, $format, $before, $after);
                }
            }
        }
	}
	return _echo($get_archives, $echo);
}

function get_calendar($daylength = 1, $echo=true) {
	$postHandler =& wp_handler('Post');
    // Quick check. If we have no posts at all, abort!
    if (empty($GLOBALS['posts'])) {
    	$criteria =& new Criteria('post_status', 'publish');
    	if (!$postHandler->getCount($criteria)) {
    		return _echo('', $echo);
    	}
    }
	// Let's figure out when we are
	if (!empty($GLOBALS['monthnum']) && !empty($GLOBALS['year'])) {
		$thismonth = ''.intval($GLOBALS['monthnum']);
		$thisyear = ''.intval($GLOBALS['year']);
	} elseif (!empty($GLOBALS['w'])) {
		$thisyear = ''.intval(substr($GLOBALS['m'], 0, 4));
		$wst = 8-intval(date('w',mktime(0,0,0,1,1,$thisyear)));
		$d = ($GLOBALS['w']-1)*7+$wst;
		$thismonth = intval(date('m', mktime(0,0,0,1,$d,$thisyear)));
	} elseif (!empty($GLOBALS['m'])) {
		$calendar = substr($GLOBALS['m'], 0, 6);
		$thisyear = ''.intval(substr($GLOBALS['m'], 0, 4));
		if (strlen($GLOBALS['m']) < 6) {
			$thismonth = '01';
		} else {
			$thismonth = ''.intval(substr($GLOBALS['m'], 4, 2));
		}
	} else {
		$thisyear = intval(date('Y', current_time('timestamp')));
		$thismonth = intval(date('m', current_time('timestamp')));
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);

	// Get the next and previous month and year with at least one post
	$criteria =& new CriteriaCompo(new Criteria('post_date', "$thisyear-$thismonth-01", '<'));
	$criteria->add(new Criteria('post_status', 'publish'));
	$criteria->setSort('post_date');
	$criteria->setOrder('DESC');
	$criteria->setLimit(1);
	
	$prevPostObjects =& $postHandler->getObjects($criteria, false, 'post_date');
	
	$nextyear = date('Y', mktime(0,0,0,$thismonth+1,1,$thisyear));
	$nextmonth = date('m', mktime(0,0,0,$thismonth+1,1,$thisyear)); // this means year of next month.
	$criteria =& new CriteriaCompo(new Criteria('post_date', "$nextyear-$nextmonth-01", '>='));
	$criteria->add(new Criteria('post_status', 'publish'));
	$criteria->setSort('post_date');
	$criteria->setOrder('ASC');
	$criteria->setLimit(1);
	$nextPostObjects =& $postHandler->getObjects($criteria, false, 'post_date');
	
	$month_str = ereg_replace('%MONTH',$GLOBALS['month'][zeroise($thismonth, 2)],$GLOBALS['wp_month_format']);
	$month_str = ereg_replace('%YEAR',date('Y', $unixmonth),$month_str);
	$get_calendar = "<table id='wp-calendar' summary='wp-calendar'>\n<caption>$month_str</caption>\n<thead>\n\t<tr>";
	foreach ($GLOBALS['weekday'] as $wd) {
		if (function_exists('mb_substr')) {
			$get_calendar .="\n\t\t<th abbr='$wd' scope='col' title='$wd'>".mb_substr($wd, 0, $daylength, $GLOBALS['blog_charset']).'</th>';
		} else {
			$get_calendar .="\n\t\t<th abbr='$wd' scope='col' title='$wd'>".substr($wd, 0, $daylength).'</th>';
		}
	}
	$get_calendar .= "\n\t</tr>\n</thead>\n<tfoot>\n\t<tr>";

	if ($prevPostObjects) {
		$prev_year = substr($prevPostObjects[0]->getVar('post_date'),0,4);
		$prev_month = substr($prevPostObjects[0]->getVar('post_date'),5,2);
		if (function_exists('mb_convert_encoding')) {
			$smonth_name = mb_substr($GLOBALS['month'][zeroise($prev_month, 2)], 0, 3,$GLOBALS['blog_charset']);
		} else {
			$smonth_name = substr($GLOBALS['month'][zeroise($prev_month, 2)], 0, 3);
		}
		$month_str = ereg_replace('%MONTH',$GLOBALS['month'][zeroise($prev_month, 2)],$GLOBALS['wp_month_format']);
		$month_str = ereg_replace('%YEAR',date('Y', mktime(0, 0 , 0, $prev_month, 1, $prev_year)),$month_str);
		$get_calendar .= "\n\t\t".'<td abbr="' . $GLOBALS['month'][zeroise($prev_month, 2)] . '" colspan="3" id="prev"><a href="' .
				get_month_link($prev_year, $prev_month) . '" title="View posts for ' . $month_str . '">&laquo; ' . $smonth_name . '</a></td>';
	} else {
		$get_calendar .= "\n\t\t".'<td colspan="3" id="prev" class="pad">&nbsp;</td>';
	}

	$get_calendar .= "\n\t\t".'<td class="pad">&nbsp;</td>';
	if ($nextPostObjects) {
		$next_year = substr($nextPostObjects[0]->getVar('post_date'),0,4);
		$next_month = substr($nextPostObjects[0]->getVar('post_date'),5,2);
		if (function_exists('mb_substr')) {
			$smonth_name = mb_substr($GLOBALS['month'][zeroise($next_month, 2)], 0, 3,$GLOBALS['blog_charset']);
		} else {
			$smonth_name = substr($GLOBALS['month'][zeroise($next_month, 2)], 0, 3);
		}
		$month_str = ereg_replace('%MONTH',$GLOBALS['month'][zeroise($next_month, 2)],$GLOBALS['wp_month_format']);
		$month_str = ereg_replace('%YEAR',date('Y', mktime(0, 0 , 0, $next_month, 1, $next_year)),$month_str);
		$get_calendar .= "\n\t\t".'<td abbr="' . $GLOBALS['month'][zeroise($next_month, 2)] . '" colspan="3" id="next"><a href="' .
				get_month_link($next_year, $next_month) . '" title="View posts for ' . $month_str . '">' . $smonth_name . ' &raquo;</a></td>';
	} else {
		$get_calendar .= "\n\t\t".'<td colspan="3" id="next" class="pad">&nbsp;</td>';
	}

	$get_calendar .= "\n\t</tr>\n</tfoot>\n<tbody>\n\t<tr>";

	if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") ||
		  strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), "camino") ||
		  strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), "safari")) {
		$ak_title_separator = "\n";
	} else {
		$ak_title_separator = ", ";
	}

	// Get days with posts
	$criteria =& new CriteriaCompo(new Criteria('MONTH(post_date)', $thismonth));
	$criteria->add(new Criteria('YEAR(post_date)', $thisyear));
	$criteria->add(new Criteria('post_date', current_time('mysql'), '<'));
	$criteria->add(new Criteria('post_status', 'publish'));
	$monthlyPostObjects =& $postHandler->getObjects($criteria, false, 'post_title, post_date');

	if ($monthlyPostObjects) {
		foreach ($monthlyPostObjects as $postObject) {
			$d = intval(substr($postObject->getVar('post_date'),8,2));
			$daywithpost[] = $d;
			if (empty($ak_titles_for_day["day_".$d])) {
				$ak_titles_for_day["day_".$d] = '';
			}
			if (empty($ak_titles_for_day["$d"])) { // first one
				$ak_titles_for_day["$d"] = htmlspecialchars($postObject->getVar('post_title'));
			} else {
				$ak_titles_for_day["$d"] .= $ak_title_separator . htmlspecialchars($postObject->getVar('post_title'));
			}
		}
		$daywithpost = array_unique($daywithpost);
	} else {
		$daywithpost = array();
	}

	// See how much we should pad in the beginning
	$pad = intval(date('w', $unixmonth));
	if ($pad) $get_calendar .= "\n\t\t<td colspan='$pad' class='pad'>&nbsp;</td>";

	$daysinmonth = intval(date('t', $unixmonth));
	for ($day = 1; $day <= $daysinmonth; ++$day) {
		if (!empty($newrow)) {
			$get_calendar .= "\n\t</tr>\n\t<tr>\n\t\t";
		}
		$newrow = false;

		if ($day == date('j', current_time('timestamp')) && $thismonth == date('m', current_time('timestamp')))
			$get_calendar .= '<td id="today">';
		else
			$get_calendar .= "<td>";

		if (in_array($day, $daywithpost)) { // any posts today?
			$get_calendar .= '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"$ak_titles_for_day[$day]\">$day</a>";
		} else {
			$get_calendar .= $day;
		}
		$get_calendar .= '</td>';

		if (6 == date('w', mktime(0,0,0, $thismonth, $day, $thisyear))) {
			$newrow = true;
		}
	}

	$pad = 7 - date('w', mktime(0,0,0, $thismonth, $day, $thisyear));
	if ($pad != 0 && $pad != 7) {
		$get_calendar .= "\n\t\t<td class='pad' colspan='$pad'>&nbsp;</td>";
	}
	$get_calendar .= "\n\t</tr>\n\t</tbody>\n\t</table>";
	
	return _echo($get_calendar ,$echo);
}

function allowed_tags() {
	$allowed = "";
	foreach($GLOBALS['allowedtags'] as $tag => $attributes) {
		$allowed .= "<$tag";
		if (0 < count($attributes)) {
			foreach ($attributes as $attribute => $limits) {
				$allowed .= " $attribute=\"\"";
			}
		}
		$allowed .= "> ";
	}
	return htmlentities($allowed);
}

/***** Date/Time tags *****/
function the_date_xml($echo=true) {
    $the_date_xml = mysql2date("Y-m-d",$GLOBALS['post']->post_date);
    return _echo($the_date_xml, $echo);
}

function the_date($d='', $before='', $after='', $echo=true) {
	$the_date = '';
	if (empty($GLOBALS['previousday']) || ($GLOBALS['day'] != $GLOBALS['previousday'])) {
		if ($d=='') {
			$d = $GLOBALS['dateformat'];
		}
		$the_date .= $before . mysql2date($d, $GLOBALS['post']->post_date) . $after;
		$GLOBALS['previousday'] = $GLOBALS['day'];
	}
	$the_date = apply_filters('the_date', $the_date);
	return _echo($the_date, $echo);
}

function the_time($d='', $echo = true) {
	if ($d=='') {
		$the_time = mysql2date($GLOBALS['timeformat'], $GLOBALS['post']->post_date);
	} else {
		$the_time = mysql2date($d, $GLOBALS['post']->post_date);
	}
	$the_time = apply_filters('the_time', $the_time);
	return _echo($the_time, $echo);
}

function the_modtime($d='', $echo = true) {
	if ($GLOBALS['post']->post_modified == '0000-00-00 00:00:00') {
		$modified = $GLOBALS['post']->post_date;
	} else {
		$modified = $GLOBALS['post']->post_modified;
	}
	if ($d=='') {
		$the_modtime = mysql2date($GLOBALS['timeformat'], $modified);
	} else {
		$the_modtime = mysql2date($d, $modified);
	}
	$the_modtime = apply_filters('the_time', $the_modtime);
	return _echo($the_modtime, $echo);
}

function the_weekday($echo=true) {
	$the_weekday = $GLOBALS['weekday'][mysql2date('w', $GLOBALS['post']->post_date)];
	$the_weekday = apply_filters('the_weekday', $the_weekday);
	return _echo($the_weekday, $echo);
}

function the_weekday_date($before='',$after='', $echo=true) {
	$the_weekday_date = '';
	if (empty($GLOBALS['previousweekday']) || ($GLOBALS['day'] != $GLOBALS['previousweekday'])) {
		$the_weekday_date .= $before . $GLOBALS['weekday'][mysql2date('w', $GLOBALS['post']->post_date)]. $after;
		$GLOBALS['previousweekday'] = $GLOBALS['day'];
	}
	$the_weekday_date = apply_filters('the_weekday_date', $the_weekday_date);
	return _echo($the_weekday_date, $echo);
}
}
?>