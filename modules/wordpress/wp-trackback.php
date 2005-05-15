<?php
if (file_exists(dirname(__FILE__).'/xoops_version.php')) {
	require_once(dirname(__FILE__) . '/wp-config.php');
} else {
	if (file_exists(dirname(dirname(__FILE__)). '/xoops_version.php')) {
		require_once(dirname(dirname(__FILE__)) . '/wp-config.php');
	}
}
$trackback_filename = get_settings('trackback_filename') ? get_settings('trackback_filename') : 'wp-trackback.php';
if ($wp_base().'/'.$trackback_filename != __FILE__ ) {
	trackback_response(1, 'Sorry, Invalid Request.');
}

// trackback is done by a POST
$_tb_id = explode('/', $_SERVER['REQUEST_URI']);
$_tb_id = intval($_tb_id[count($_tb_id)-1]);

init_param('', 'url','string','');
init_param('', 'title','string','');
init_param('', 'excerpt','html','');
init_param('', 'blog_name','string','');
init_param('', 'charset','string','');
init_param('', 'p','integer','');
init_param('', 'name','string','');
init_param('', '__mode','string','');

require_once('wp-blog-header.php');

//Anti Trackback SPAM
$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : (isset($_ENV['HTTP_REFERER']) ? $_ENV['HTTP_REFERER'] : '');
if ($ref) {
	// Most of Trackbacks don't have HTTP_REFERER
	header('Location: ' . get_permalink($tb_id));
}

if ( (test_param('p') && (get_param('p') != 'all')) || (test_param('name')) ) {
    $_tb_id = $GLOBALS['posts'][0]->ID;
}

if (!test_param('title') && !test_param('url') && !test_param('blog_name')) {
	// If it doesn't look like a trackback at all...
	header('Location: ' . get_permalink($_tb_id));
}

if (!empty($_tb_id) && !test_param('__mode') && test_param('url')) {
	@header('Content-Type: text/xml');

	if (!get_settings('use_trackback')) {
		trackback_response(1, 'Sorry, this weblog does not allow you to trackback its posts.');
	}

	$_title = get_param('title');
	$_excerpt = get_param('excerpt');
	$_blog_name = get_param('blog_name');
	$_charset = get_param('charset');
	if ($GLOBALS['wp_debug']) {
		$_debug_file = $wp_base().'/log/trackback_r.log';
		$_fp = fopen($_debug_file, 'a');
		fwrite($_fp, "Title(Orig) =$_title\n");
		fwrite($_fp, "Excerpt(Orig) =$_excerpt\n");
		fwrite($_fp, "BlogName(Orig) =$_blog_name\n");
		fwrite($_fp, "CharSet(Orig) =$_charset\n\n");
	}

	$postHandler =& wp_handler('Post');
	$postObject =& $postHandler->get($_tb_id);

	if (!$postObject) {
		trackback_response(1, 'Sorry, no post is exist for this post id.');
	}
	if ($postObject->getVar('ping_status') == 'closed') {
		trackback_response(1, 'Sorry, trackbacks are closed for this item.');
	}

	if (get_settings('check_trackback_content')) {
		// Let's check the remote site
		require_once(XOOPS_ROOT_PATH.'/class/snoopy.php');
		$snoopy = New Snoopy;
		if ($snoopy->fetch(get_param('url'))) {
			$orig_contents = $snoopy->results;
		}

		if (!strpos($orig_contents, wp_siteurl())) {
			if ($GLOBALS['wp_debug']) {
				fwrite($_fp, 'Error: Sorry, your contents does not contain any URL of my site.');
			}
			trackback_response(1, 'Sorry, your contents does not contain any URL of my site.');
		}
	}
	
	if (function_exists('mb_convert_encoding')) {
		if (($_charset !="")&&((mb_http_input("P")=="")||(strtolower(ini_get("mbstring.http_input"))=="pass"))) {
			$_charset = strtoupper(trim($_charset));
		} else {
			$_charset="auto";
		}
		if ($_charset == "auto") {
			$_charset = mb_detect_encoding($_title.$_excerpt.$_blog_name,$_charset);
		}
		$_title = mb_conv($_title, $blog_charset, $_charset);
		$_excerpt = mb_conv($_excerpt, $blog_charset, $_charset);
		$_blog_name = mb_conv($_blog_name, $blog_charset, $_charset);
		if ($GLOBALS['wp_debug']) {
			fwrite($_fp, "Title(Conv) =$_title\n");
			fwrite($_fp, "Excerpt(Conv) =$_excerpt\n");
			fwrite($_fp, "BlogName(Conv) =$_blog_name\n");
			fwrite($_fp, "CharSet(Conv) =$_charset\n");
			fwrite($_fp, "\n\n");
			fclose($_fp);
		}
	}

	$_title = strip_tags($_title);
	$_title = (strlen($_title) > 255) ? substr($_title, 0, 252).'...' : $_title;
	$_excerpt = strip_tags($_excerpt);
	$_excerpt = (strlen($_excerpt) > 255) ? substr($_excerpt, 0, 252).'...' : $_excerpt;
	$_blog_name = htmlspecialchars($_blog_name);
	$_blog_name = (strlen($_blog_name) > 255) ? substr($_blog_name, 0, 252).'...' : $_blog_name;

	$_content = "<trackback /><strong>$_title</strong>\n$_excerpt";
	$_content = convert_chars($_content);
	$_content = apply_filters('format_to_post', $_content);

	$moderation_notify = get_settings('moderation_notify');
	if (get_settings('comment_moderation') == 'manual') {
		$_approved = 0;
	} else if (get_settings('comment_moderation') == 'auto') {
		$_approved = 0;
	} else { // none
		$_approved = 1;
	}

	$commentHandler =& wp_handler('Comment');
	$commentObject =& $commentHandler->create();
	$commentObject->setVar('comment_post_ID',$_tb_id);
	$commentObject->setVar('comment_author',$_blog_name);
	$commentObject->setVar('comment_author_email','');
	$commentObject->setVar('comment_author_url',get_param('url'));
	$commentObject->setVar('comment_author_IP',$_SERVER['REMOTE_ADDR']);
	$commentObject->setVar('comment_date',current_time('mysql'));
	$commentObject->setVar('comment_content',$_content);
	$commentObject->setVar('comment_approved',$_approved);
	if(!$commentHandler->insert($commentObject, true)) {
		die ("There is an error with the database, it can't store your comment...<br />Please contact the <a href='mailto:".get_settings('admin_email')."'>webmaster</a>.");
	} else {
		$_comment_ID = $commentObject->getVar('comment_ID');
		do_action('trackback_post', $_comment_ID);
		if (get_settings('comments_notify'))
			wp_notify_postauthor($_comment_ID, 'trackback');
		trackback_response(0);
	}
}
?>