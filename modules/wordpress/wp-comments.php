<?php // Do not delete these lines
	if ('wp-comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ();
	if (!empty($withcomments) || !empty($c)) {
		if (get_xoops_option(wp_mod(),'wp_use_xoops_comments') == 0) {
			$criteria =& new CriteriaCompo(new Criteria('comment_post_ID', $GLOBALS['wp_post_id']));
			$criteria->add(new Criteria('comment_approved', '1 '));// Trick for numeric chars only string compare
			$commentHandler =& wp_handler('Comment');
			$results = $commentHandler->open($criteria);
			$comments = array();
			while($commentObject =& $commentHandler->getNext($results)) {
				$comments[] =& $commentObject->exportWpObject();
			}
        	if (!empty($post->post_password)) { // if there's a password
        	    if ($_COOKIE['wp-postpass_'.$GLOBALS['cookiehash']] != $post->post_password) {  // and it doesn't match the cookie
        	        echo('<p>Enter your password to view comments.<p>');
        	        return;
        	    }
        	}
 			$comment_author = (isset($_COOKIE['comment_author_'.$GLOBALS['cookiehash']])) ? trim($_COOKIE['comment_author_'.$GLOBALS['cookiehash']]) : '';
            if (!$comment_author) {
                if (!empty($xoopsUser)) {
                    $comment_author = $xoopsUser->getVar('name') ? $xoopsUser->getVar('name') :$xoopsUser->getVar('uname');
                }
            }
        	$comment_author_email = (isset($_COOKIE['comment_author_email_'.$GLOBALS['cookiehash']])) ? trim($_COOKIE['comment_author_email_'.$GLOBALS['cookiehash']]) : '';
 			$comment_author_url = (isset($_COOKIE['comment_author_url_'.$GLOBALS['cookiehash']])) ? trim($_COOKIE['comment_author_url_'.$GLOBALS['cookiehash']]) : '';
			$id = $wp_post_id;
			include(get_custom_path('comments-template.php'));
		} else {
			$criteria =& new CriteriaCompo(new Criteria('comment_post_ID', $GLOBALS['wp_post_id']));
			$criteria->add(new Criteria('comment_approved', '1 '));// Trick for numeric chars only string compare
			$criteria_c =& new CriteriaCompo(new Criteria('comment_content', '<trackback />%', 'like'));
			$criteria_c->add(new Criteria('comment_content', '<pingback />%', 'like'), 'OR');
			$criteria_c->add(new Criteria('comment_type', 'trackback'), 'OR');
			$criteria_c->add(new Criteria('comment_type', 'pingback'), 'OR');
			$criteria->add($criteria_c);
			$commentHandler =& wp_handler('Comment');
			$results = $commentHandler->open($criteria);
			$comments = array();
			while($commentObject =& $commentHandler->getNext($results)) {
				$comments[] =& $commentObject->exportWpObject();
			}
			$id = $wp_post_id;
			include(get_custom_path('xoops-comments-template.php'));
		}
	}
?>
