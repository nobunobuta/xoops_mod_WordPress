<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_COMMENT_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_COMMENT_INCLUDED' , 1 ) ;
function clean_url($url) {
	if ('' == $url) return $url;
	$url = preg_replace('|[^a-z0-9-~+_.?#=&;,/:]|i', '', $url);
	$url = str_replace(';//', '://', $url);
	$url = (!strstr($url, '://')) ? 'http://'.$url : $url;
	$url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url);
	return $url;
}

function comments_number($zero='No Comments', $one='1 Comment', $more='% Comments', $number='', $echo = true) {
	if ('' == $number) {
		$criteria =& new CriteriaCompo(new Criteria('comment_post_ID', $GLOBALS['wp_post_id']));
		$criteria->add(new Criteria('comment_approved', '1 '));// Trick for numeric chars only string compare
		$commentHandler =& wp_handler('Comment');
		$number = $commentHandler->getCount($criteria);
	}
	if ($number == 0) {
		$blah = $zero;
	} elseif ($number == 1) {
		$blah = $one;
	} elseif ($number  > 1) {
		$blah = str_replace('%', $number, $more);
	}
    return _echo(apply_filters('comments_number', $blah), $echo);
}

function comments_link($file='', $echo=true) {
	if ($file == '')	$file = $GLOBALS['pagenow'];
	if ($file == '/')	$file = '';
	return _echo(get_permalink() . '#comments', $echo);
}

function comments_popup_script($width=400, $height=400, $file='wp-comments-popup.php', $echo=true) {
	$GLOBALS['wpcommentspopupfile'] = $file;
	$GLOBALS['wpcommentsjavascript'] = 1;
	$javascript = "<script type='text/javascript'>\nfunction wpopen (macagna) {\n    window.open(macagna, '_blank', 'width=$width,height=$height,scrollbars=yes,status=yes');\n}\n</script>\n";
	return _echo($javascript, $echo);
}

function comments_popup_link($zero='No Comments', $one='1 Comment', $more='% Comments', $CSSclass='', $none='Comments Off', $echo = true) {
	if (get_xoops_option(wp_mod(),'wp_use_xoops_comments') == 0) {
		if (empty($GLOBALS['comment_count_cache'][wp_id()]["{$GLOBALS['wp_post_id']}"])) {
			$criteria =& new CriteriaCompo(new Criteria('comment_post_ID', $GLOBALS['wp_post_id']));
			$criteria->add(new Criteria('comment_approved', '1 '));// Trick for numeric chars only string compare
			$commentHandler =& wp_handler('Comment');
			$number = $commentHandler->getCount($criteria);
		} else {
			$number = $GLOBALS['comment_count_cache'][wp_id()]["{$GLOBALS['wp_post_id']}"];
		}
	} else {
		$criteria =& new CriteriaCompo(new Criteria('comment_post_ID', $GLOBALS['wp_post_id']));
		$criteria->add(new Criteria('comment_approved', '1 '));// Trick for numeric chars only string compare
		$criteria_c =& new CriteriaCompo(new Criteria('comment_content', "<trackback />%", 'like'));
		$criteria_c->add(new Criteria('comment_content', "<pingback />%", 'like'), 'OR');
		$criteria->add($criteria_c);
		$commentHandler =& wp_handler('Comment');
		$number = $commentHandler->getCount($criteria);
	}
	$comments_popup_link = "";
	if (0 == $number && 'closed' == $GLOBALS['post']->comment_status && 'closed' == $GLOBALS['post']->ping_status) {
		return _echo($none, $echo);
	} else {
        if (!empty($GLOBALS['post']->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_'.$GLOBALS['cookiehash']] != $GLOBALS['post']->post_password) {  // and it doesn't match the cookie
                return _echo("Enter your password to view comments", $echo);
            }
        }
        $comments_popup_link .= '<a href="';
        if (!empty($GLOBALS['wpcommentsjavascript'])) {
            $comments_popup_link .=  wp_siteurl().'/'.$GLOBALS['wpcommentspopupfile'].'?p='.$GLOBALS['wp_post_id'].'&amp;c=1';
            $comments_popup_link .= '" onclick="wpopen(this.href); return false"';
        } else {
            // if comments_popup_script() is not in the template, display simple comment link
            $comments_popup_link .= comments_link('', false);
            $comments_popup_link .=  '"';
        }
        $comments_popup_link .= ' title="Comment for \'\''.apply_filters('the_title',$GLOBALS['post']->post_title).'\'\'"';
        if (!empty($CSSclass)) {
            $comments_popup_link .=  ' class="'.$CSSclass.'"';
        }
        $comments_popup_link .=  '>';
        $comments_popup_link .= comments_number($zero, $one, $more, $number, false);
        $comments_popup_link .=  '</a>';
        return _echo($comments_popup_link, $echo);
    }
}

function xcomments_link($file='', $echo=true) {
	if ($file == '')	$file = $GLOBALS['pagenow'];
	if ($file == '/')	$file = '';
	return _echo(get_permalink() . '#xcomments', $echo);
}

function xcomments_popup_link($zero='No Comments', $one='1 Comment', $more='% Comments', $CSSclass='', $none='Comments Off', $echo=true) {
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname(wp_mod());
	$mid = $module->getVar('mid');

	$number = xoops_comment_count($mid, $GLOBALS['wp_post_id']);
	$xcomments_popup_link = "";
	if (0 == $number && 'closed' == $GLOBALS['post']->comment_status) {
		return _echo($none, $echo);
	} else {
        if (!empty($GLOBALS['post']->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_'.$GLOBALS['cookiehash']] != $GLOBALS['post']->post_password) {  // and it doesn't match the cookie
                return _echo("Enter your password to view comments", $echo);
            }
        }
        $xcomments_popup_link .= '<a href="';
        if (!empty($GLOBALS['wpcommentsjavascript'])) {
            $xcomments_popup_link .= wp_siteurl().'/'.$GLOBALS['wpcommentspopupfile'].'?p='.$GLOBALS['wp_post_id'].'&amp;c=1';
            $xcomments_popup_link .= '" onclick="wpopen(this.href); return false"';
        } else {
            // if comments_popup_script() is not in the template, display simple comment link
            $xcomments_popup_link .= xcomments_link('', false);
            $xcomments_popup_link .= '"';
        }
        if (!empty($CSSclass)) {
            $xcomments_popup_link .= ' class="'.$CSSclass.'"';
        }
        $xcomments_popup_link .= '>';
        $xcomments_popup_link .= comments_number($zero, $one, $more, $number, false);
        $xcomments_popup_link .= '</a>';
        return _echo($xcomments_popup_link, $echo);
    }
}

function comment_ID($echo = true) {
	return _echo($GLOBALS['comment']->comment_ID, $echo);
}

function comment_author($echo = true) {
	$author = apply_filters('comment_author', $GLOBALS['comment']->comment_author);
	if (empty($author)) {
		$author = "Anonymous";
	}
	return _echo($author, $echo);
}

function comment_author_email($echo = true) {
	$author_email = apply_filters('author_email', $GLOBALS['comment']->comment_author_email);
	return _echo($author_email, $echo);
}

function comment_author_link($echo = true) {
	$url = apply_filters('comment_url', $GLOBALS['comment']->comment_author_url);
	$author = apply_filters('comment_author', $GLOBALS['comment']->comment_author);
	if (!$author) $author = 'Anonymous';

	if (empty($url)) {
		$url = $author;
	} else {
		$url = "<a href='$url' rel='external'>$author</a>";
	}
	return _echo($url, $echo);
}

function comment_type($commenttxt = 'Comment', $trackbacktxt = 'Trackback', $pingbacktxt = 'Pingback', $echo=true) {
	if (preg_match('|<trackback />|', $GLOBALS['comment']->comment_content))
		return _echo($trackbacktxt, $echo);
	elseif (preg_match('|<pingback />|', $GLOBALS['comment']->comment_content))
		return _echo($pingbacktxt, $echo);
	else
		return _echo($commenttxt, $echo);
}

function comment_author_url($echo = true) {
	$author_url = apply_filters('comment_url', $GLOBALS['comment']->comment_author_url);
	return _echo($author_url, $echo);
}

function comment_author_email_link($linktext='', $before='', $after='',$echo = true ) {
	$email = apply_filters('comment_email', $GLOBALS['comment']->comment_author_email);
	$link = "";
	if ((!empty($email)) && ($email != '@')) {
		$display = ($linktext != '') ? $linktext : $email;
		$link = $before ."<a href='mailto:$email'>$display</a>". $after;
	}
	return _echo($link, $echo);
}

function comment_author_url_link($linktext='', $before='', $after='', $echo = true) {
	$url = apply_filters('comment_url', $GLOBALS['comment']->comment_author_url);
	$link = "";
	if ((!empty($url)) && ($url != 'http://') && ($url != 'http://url')) {
		$display = ($linktext != '') ? $linktext : $url;
		$link = "$before<a href='$url' rel='external'>$display</a>$after";
	}
	return _echo($link, $echo);
}

function comment_author_IP($echo=true) {
	$ip = $GLOBALS['comment']->comment_author_IP;
	return _echo($ip, $echo);
}

function comment_text($echo=true) {
	$comment_text = str_replace('<trackback />', '', $GLOBALS['comment']->comment_content);
	$comment_text = str_replace('<pingback />', '', $comment_text);
	$comment_text =  apply_filters('comment_text', stripslashes($comment_text));
	return _echo($comment_text, $echo);
}

function comment_excerpt($echo=true) {
	$comment_text = str_replace('<trackback />', '', $GLOBALS['comment']->comment_content);
	$comment_text = str_replace('<pingback />', '', $comment_text);
	$comment_text = strip_tags(stripslashes($comment_text));
	$blah = explode(' ', $comment_text);
	if (count($blah) > 20) {
		$k = 20;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '...' : '';
	$excerpt = apply_filters('comment_excerpt', $excerpt);
	return _echo($excerpt, $echo);
}

function comment_date($d='', $echo = true) {
	if ('' == $d) {
		$date = mysql2date(get_settings('date_format'), $GLOBALS['comment']->comment_date);
	} else {
		$date = mysql2date($d, $GLOBALS['comment']->comment_date);
	}
	return _echo($date, $echo);
}

function comment_time($d='', $echo = true) {
	if ($d == '') {
		$time = mysql2date(get_settings('time_format'), $GLOBALS['comment']->comment_date);
	} else {
		$time = mysql2date($d, $GLOBALS['comment']->comment_date);
	}
	return _echo($time, $echo);
}

function comments_rss_link($link_text='Comments RSS', $commentsrssfilename = 'wp-commentsrss2.php', $echo = true) {
	$url = comments_rss($commentsrssfilename);
	return _echo("<a href='$url'>$link_text</a>", $echo);
}

function comments_rss($commentsrssfilename = 'wp-commentsrss2.php') {
	if ('' != get_settings('permalink_structure')) {
		$url = trailingslashit(get_permalink()) . 'feed/';
	} else {
		$url = wp_siteurl() . '/' . $commentsrssfilename.'?p='.$GLOBALS['wp_post_id'];
	}
	return $url;
}

function comment_author_rss($echo = true) {
	if (empty($GLOBALS['comment']->comment_author)) {
		$author_rss = 'Anonymous';
	} else {
		$author_rss = wp_convert_rss_charset(htmlspecialchars(apply_filters('comment_author', $GLOBALS['comment']->comment_author)));
	}
	return _echo($author_rss, $echo);
}

function comment_text_rss($echo = true) {
	$comment_text = str_replace('<trackback />', '', $GLOBALS['comment']->comment_content);
	$comment_text = str_replace('<pingback />', '', $comment_text);
	$comment_text = apply_filters('comment_text', $comment_text);
	$comment_text = strip_tags($comment_text);
	$comment_text = htmlspecialchars($comment_text);
	return _echo(wp_convert_rss_charset($comment_text), $echo);
}

function comment_link_rss($echo = true) {
	return _echo(get_permalink($GLOBALS['comment']->comment_post_ID).'#comments', $echo);
}

function permalink_comments_rss($echo = true) {
	return _echo(get_permalink($GLOBALS['comment']->comment_post_ID), $echo);
}

function trackback_url($echo = true) {
    $trackback_filename = get_settings('trackback_filename') ? get_settings('trackback_filename') : 'wp-trackback.php';
	$tb_url = wp_siteurl() . '/'.$trackback_filename.'/'. $GLOBALS['wp_post_id'];
	
	if ('' != get_settings('permalink_structure')) {
		$tb_url = trailingslashit(get_permalink()) . 'trackback/';
	}
	return _echo($tb_url, $echo);
}


function trackback_rdf($timezone = 0, $echo= true) {
	$trackback_rdf = '';
	if (!stristr($_SERVER['HTTP_USER_AGENT'], 'W3C_Validator')) {
		$trackback_rdf .= '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
		    xmlns:dc="http://purl.org/dc/elements/1.1/"
		    xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
			<rdf:Description rdf:about="'.get_permalink().'"'."\n";
		$trackback_rdf .=  '    dc:identifier="'.get_permalink().'"'."\n";
		$trackback_rdf .=  '    dc:title="'.str_replace('--', '&#x2d;&#x2d;', wptexturize(strip_tags(get_the_title()))).'"'."\n";
		$trackback_rdf .=  '    trackback:ping="'.trackback_url(0).'"'." />\n";
		$trackback_rdf .=  '</rdf:RDF>';
	}
	return _echo($trackback_rdf, $echo);
}
}
?>