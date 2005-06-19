<?php
if( ! defined( 'WP_TEMPLATE_FUNCTIONS_AUTHOR_INCLUDED' ) ) {
	define( 'WP_TEMPLATE_FUNCTIONS_AUTHOR_INCLUDED' , 1 ) ;
function the_author($idmode = '', $echo=true) {
    if (empty($idmode)) {
        $idmode = $GLOBALS['authordata']->user_idmode;
    }

    if ($idmode == 'nickname')    $id = $GLOBALS['authordata']->user_nickname;
    if ($idmode == 'login')    $id = $GLOBALS['authordata']->user_login;
    if ($idmode == 'firstname')    $id = $GLOBALS['authordata']->user_firstname;
    if ($idmode == 'lastname')    $id = $GLOBALS['authordata']->user_lastname;
    if ($idmode == 'namefl')    $id = $GLOBALS['authordata']->user_firstname.' '.$GLOBALS['authordata']->user_lastname;
    if ($idmode == 'namelf')    $id = $GLOBALS['authordata']->user_lastname.' '.$GLOBALS['authordata']->user_firstname;
    if ($idmode == 'ID')        $id = $GLOBALS['authordata']->ID;
    if (!$idmode) $id = $GLOBALS['authordata']->user_nickname;

    return _echo($id, $echo);
}

function the_author_description($echo=true) {
	return _echo($GLOBALS['authordata']->user_description, $echo);
}
function the_author_login($echo=true) {
	return _echo($GLOBALS['authordata']->user_login, $echo);
}

function the_author_firstname($echo=true) {
	return _echo($GLOBALS['authordata']->user_firstname, $echo);
}

function the_author_lastname($echo=true) {
	return _echo($GLOBALS['authordata']->user_lastname, $echo);
}

function the_author_nickname($echo=true) {
	return _echo($GLOBALS['authordata']->user_nickname, $echo);
}

function the_author_ID($echo=true) {
	return _echo($GLOBALS['authordata']->ID, $echo);
}

function the_author_email($echo=true) {
	return _echo(antispambot($GLOBALS['authordata']->user_email), $echo);
}

function the_author_url($echo=true) {
	return _echo($GLOBALS['authordata']->user_url, $echo);
}

function the_author_icq($echo=true) {
	return _echo($GLOBALS['authordata']->user_icq, $echo);
}

function the_author_aim($echo=true) {
	return _echo(str_replace(' ', '+', $GLOBALS['authordata']->user_aim), $echo);
}

function the_author_yim($echo=true) {
	return _echo($GLOBALS['authordata']->user_yim, $echo);
}

function the_author_msn($echo=true) {
	return _echo($GLOBALS['authordata']->user_msn, $echo);
}

function the_author_posts($echo=true) {
	return _echo(get_usernumposts($GLOBALS['post']->post_author), $echo);
}

function the_author_posts_link($idmode='', $echo=true) {
    return _echo('<a href="' . get_author_link(0, $GLOBALS['authordata']->ID, $GLOBALS['authordata']->user_login) . '" title="' . sprintf("Posts by %s", htmlspecialchars(the_author($idmode, false))) . '">' . stripslashes(the_author($idmode, false)) . '</a>', $echo);
}

function the_author_info_link($idmode='', $echo=true) {
    return _echo('<a href="' . XOOPS_URL . '/userinfo.php?uid=' .the_author('ID',false) . '" title="' . sprintf("Posts by %s", htmlspecialchars(the_author($idmode, false))) . '">' . stripslashes(the_author($idmode, false)) . '</a>', $echo);
}

function get_author_link($echo = false, $author_id, $author_name="") {
    $permalink_structure = get_settings('permalink_structure');
    
    if ($permalink_structure == '') {
        $link = wp_siteurl() . '/index.php?author='.$author_id;
    } else {
        if ($author_name =='') $author_name = $GLOBALS['cache_userdata'][wp_id()][$author_id]->author_name;
        // Get any static stuff from the front
        $front = substr($permalink_structure, 0, strpos($permalink_structure, '%'));
        $link = wp_siteurl() . $front . 'author/';
        $link .= rawurlencode($author_name) . '/';
    }
	return _echo($link, $echo);
}

function get_author_rss_link($echo = false, $author_id, $author_name="") {
	if (get_settings('permalink_structure') == '') {
	   $file = wp_siteurl() . '/wp-rss2.php';
	   $link = $file . '?author=' . $author_id;
	} else {
	   $link = get_author_link(0, $author_id, $author_name);
	   $link = $link . "feed/";
	}
	return _echo($link, $echo);
}

function wp_list_authors($args = '', $echo=true) {
	parse_str($args, $r);
	if (!isset($r['optioncount'])) $r['optioncount'] = false;
    if (!isset($r['exclude_admin'])) $r['exclude_admin'] = true;
    if (!isset($r['show_fullname'])) $r['show_fullname'] = false;
	if (!isset($r['hide_empty'])) $r['hide_empty'] = true;
    if (!isset($r['feed'])) $r['feed'] = '';
    if (!isset($r['feed_image'])) $r['feed_image'] = '';

	list_authors($r['optioncount'], $r['exclude_admin'], $r['show_fullname'], $r['hide_empty'], $r['feed'], $r['feed_image'], $echo);
}

function list_authors($optioncount = false, $exclude_admin = true, $show_fullname = false, $hide_empty = true, $feed = '', $feed_image = '', $echo=true) {
	$list_authors = '';
	if ($exclude_admin) {
		$criteria = new Criteria('ID', 1 , '<>');
	} else {
		$criteria = new CriteriaCompo();
	}
	$criteria->setSort('user_nickname');
	$userHandler =& wp_handler('User');
	$userObjects =& $userHandler->getObjects($criteria);
    foreach($userObjects as $userObject) {
    	$author =& $userObject->exportWpObject();
        $posts = get_usernumposts($author->ID);
        $name = $author->user_nickname;

        if ($show_fullname && ($author->user_firstname != '' && $author->user_lastname != '')) {
            $name = "$author->user_firstname $author->user_lastname";
        }
        
        if (! ($posts == 0 && $hide_empty)) $list_authors .= "<li>";
        if ($posts == 0) {
            if (! $hide_empty) $list_authors .= $name;
        } else {
            $link = '<a href="' . get_author_link(0, $author->ID, $author->user_login) . '" title="' . sprintf("Posts by %s", htmlspecialchars($author->user_nickname)) . '">' . stripslashes($name) . '</a>';

            if ( (! empty($feed_image)) || (! empty($feed)) ) {
                $link .= ' ';
                if (empty($feed_image)) {
                    $link .= '(';
                }
                $link .= '<a href="' . get_author_rss_link(0, $author->ID, $author->user_login)  . '"';
                if (! empty($feed)) {
                    $title =  ' title="' . stripslashes($feed) . '"';
                    $alt = ' alt="' . stripslashes($feed) . '"';
                    $name = stripslashes($feed);
                    $link .= $title;
                }
                $link .= '>';
                if (! empty($feed_image)) {
                    $link .= "<img src=\"$feed_image\" border=\"0\" align=\"bottom\"$alt$title" . ' />';
                } else {
                    $link .= $name;
                }
                $link .= '</a>';
                if (empty($feed_image)) {
                    $link .= ')';
                }
            }
            if ($optioncount) {
                $link .= ' ('. $posts . ')';
            }
        }
        if (! ($posts == 0 && $hide_empty)) $list_authors .= "$link</li>";
    }
    return _echo($list_authors , $echo);
}

function list_authors2($optioncount = false, $exclude_admin = true, $idmode = '', $hide_empty = true, $feed = '', $feed_image = '', $echo=true) {
	$list_authors2 = '';
	if ($exclude_admin) {
		$criteria = new Criteria('ID', 1 , '<>');
	} else {
		$criteria = new CriteriaCompo();
	}
	$criteria->setSort('user_nickname');
	$userHandler =& wp_handler('User');
	$userObjects =& $userHandler->getObjects($criteria);
    foreach($userObjects as $userObject) {
    	$author =& $userObject->exportWpObject();
        $posts = get_usernumposts($author->ID);
        $name = $author->user_nickname;
	    if (empty($idmode)) {
	        $idmode = $author->user_idmode;
	    }
	    if ($idmode == 'nickname')    $name = $author->user_nickname;
	    if ($idmode == 'login')    $name = $author->user_login;
	    if ($idmode == 'firstname')    $name = $author->user_firstname;
	    if ($idmode == 'lastname')    $name = $author->user_lastname;
	    if ($idmode == 'namefl')    $name = $author->user_firstname.' '.$author->user_lastname;
	    if ($idmode == 'namelf')    $name = $author->user_lastname.' '.$author->user_firstname;
	    if (!$idmode) $name = $author->user_nickname;

        if (! ($posts == 0 && $hide_empty)) $list_authors2 .= "<li>";
        if ($posts == 0) {
            if (! $hide_empty) $list_authors2 .= $name;
        } else {
            $link = '<a href="' . get_author_link(0, $author->ID, $author->user_login) . '" title="' . sprintf("Posts by %s", htmlspecialchars($author->user_nickname)) . '">' . stripslashes($name) . '</a>';

            if ( (! empty($feed_image)) || (! empty($feed)) ) {
                $link .= ' ';
                if (empty($feed_image)) {
                    $link .= '(';
                }
                $link .= '<a href="' . get_author_rss_link(0, $author->ID, $author->user_login)  . '"';
                if (! empty($feed)) {
                    $title =  ' title="' . stripslashes($feed) . '"';
                    $alt = ' alt="' . stripslashes($feed) . '"';
                    $name = stripslashes($feed);
                    $link .= $title;
                }
                $link .= '>';
                if (! empty($feed_image)) {
                    $link .= "<img src=\"$feed_image\" border=\"0\" align=\"bottom\"$alt$title" . ' />';
                } else {
                    $link .= $name;
                }
                $link .= '</a>';
                if (empty($feed_image)) {
                    $link .= ')';
                }
            }
            if ($optioncount) {
                $link .= ' ('. $posts . ')';
            }
        }
        if (! ($posts == 0 && $hide_empty)) $list_authors2 .= "$link</li>";
    }
    return _echo($list_authors2 , $echo);
}

function the_author_rss($echo=true)
{
	return _echo(wp_convert_rss_charset(the_author('',false)), $echo);
}
}
?>