<?php
require_once('admin.php');

$parent_file = 'post.php';
$this_file = 'post.php';

$postHandler =& wp_handler('Post');
$commentHandler =& wp_handler('Comment');
$postmetaHandler =& wp_handler('PostMeta');
$userHandler =& wp_handler('User');

init_param('', 'action','string', '');
switch(get_param('action')) {
	//Insert New Post Record
	case 'post':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/edit.php',3,$xoopsWPTicket->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'post_title', 'string','', true);
		init_param('POST', 'post_category', 'array-int',array(1), true);
		init_param('POST', 'excerpt', 'html','');
		init_param('POST', 'wp_content', 'html', '', true);
		init_param('POST', 'post_status', 'string', get_settings('default_post_status'));
		init_param('POST', 'comment_status', 'string', get_settings('default_comment_status'));
		init_param('POST', 'ping_status', 'string', get_settings('default_ping_status'));
		init_param('POST', 'post_password', 'string', '');
		init_param('POST', 'post_pingback', 'check-01');
		init_param('POST', 'trackback_url', 'string');
		init_param('POST', 'target_charset', 'string', '');
		init_param('POST', 'useutf8', 'check-01');
		init_param('POST', 'mode', 'string', 'default');
		init_param('POST', 'saveasdraft', 'string');
		init_param('POST', 'saveasprivate', 'string');
		init_param('POST', 'publish', 'string');
		init_param('POST', 'advanced', 'string');
		init_param('POST', 'edit_date','check-01');

		//Set PostObject Variable for Insert
		$postObject =& $postHandler->create();
		$postObject->setVar('post_author', $user_ID);
		$postObject->setVar('post_content', apply_filters('content_save_pre', $wp_content));
		$postObject->setVar('post_title', $post_title);
		$postObject->setVar('post_excerpt', apply_filters('excerpt_save_pre',$excerpt));
		$postObject->setVar('comment_status', $comment_status);
		$postObject->setVar('ping_status', $ping_status);
		$postObject->setVar('post_password', $post_password);
		$postObject->setVar('post_name', sanitize_title($post_title));
		$postObject->setVar('to_ping', preg_replace('|\s+|', "\n", $trackback_url));

		if(get_settings('use_geo_positions')) {
			init_param('POST', 'post_latf', 'float', get_settings('default_geourl_lat'));
			init_param('POST', 'post_lonf', 'float', get_settings('default_geourl_lon'));
			if (($post_latf <= 90 ) && ($post_lonf >= -90)) {
				$postObject->setVar('post_lat', $post_latf);
			}
			if (($post_lonf <= 360 ) && ($post_lonf >=-360)) {
				$postObject->setVar('post_lon', $post_lonf);
			}
		}

		if (($user_level > 4) && $edit_date) {
			init_param('POST', 'aa','integer');
			init_param('POST', 'mm','integer');
			init_param('POST', 'jj','integer');
			init_param('POST', 'hh','integer');
			init_param('POST', 'mn','integer');
			init_param('POST', 'ss','integer');
			$jj = ($jj > 31) ? 31 : $jj;
			$hh = ($hh > 23) ? $hh - 24 : $hh;
			$mn = ($mn > 59) ? $mn - 60 : $mn;
			$ss = ($ss > 59) ? $ss - 60 : $ss;
			$now = "$aa-$mm-$jj $hh:$mn:$ss";
		} else {
			$now = date('Y-m-d H:i:s', (time() + (get_settings('time_difference') * 3600)));
		}
		$postObject->setVar('post_date', $now);

		// What to do based on which button they pressed
		if (!empty($saveasdraft)) $post_status = 'draft';
		if (!empty($saveasprivate)) $post_status = 'private';
		if (!empty($publish)) $post_status = 'publish';
		if (!empty($advanced)) $post_status = 'draft';
		$postObject->setVar('post_status', $post_status);

		if(!$postHandler->insert($postObject)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 3, $postHandler->getErrors());
		}

		$post_ID = $postObject->getVar('ID');
		switch($mode) {
			case 'bookmarklet':
				$location = 'bookmarklet.php?action=done';
				break;
			case 'sidebar':
				$location = 'sidebar.php?action=done';
				break;
			default:
				$location = 'post.php';
				break;
		}
		if (!empty($advanced)) {
			$location = "post.php?action=edit&post=$post_ID";
		}
		header("Location: $location");
		$postObject->assignCategories($post_category);
//	 	add_meta($post_ID);
		do_action('save_post', $post_ID);       
		if ($post_status == 'publish') {
			if((get_settings('use_geo_positions')) && ($postObject->getVar('post_latf') != null) && ($postObject->getVar('post_lonf') != null)) {
				pingGeoUrl();
			}
			pingWeblogs();
			if ($post_pingback) {
				pingback($postObject->getVar('post_content','e'), $post_ID);
			}
			do_action('publish_post', $post_ID);
			$postdata = $postObject->getVarArray();
			do_trackback($postObject, $useutf8, $target_charset);
		} // end if publish
		exit();
		break;
	//Show Post Editing Screen
	case 'edit':
		//Check User_Level
		user_level_check();
		//Rendering Admin Screen header
		$parent_file = 'edit.php';
		$title = 'Edit Post';
		$standalone = 0;
		require_once('admin-header.php');
		//Check Paramaters
		init_param('GET', 'post','integer', NO_DEFAULT_PARAM, true);
		
		$post_ID = $p = $post;
		if (!($postObject =& $postHandler->get($post_ID))) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 5, _LANG_P_OOPS_IDPOS);
		}
		$authorObject = $userHandler->get($postObject->getVar('post_author'));
		if (!user_can_edit($postObject->getVar('post_author'))) {
			redirect_header(wp_siteurl().'/wp-admin/',5, _LANG_P_DATARIGHT_EDIT.' by <strong>['.$authorObject->getVar('user_login').']</strong>');
		}
		$postdata = $postObject->getVarArray('e');
		$mode = "";
		$content = stripslashes(apply_filters('content_edit_pre', $postdata['post_content']));
		$excerpt = stripslashes(apply_filters('excerpt_edit_pre', $postdata['post_excerpt']));
		$edited_post_title = stripslashes(apply_filters('title_edit_pre', $postdata['post_title']));
		$edited_lat = $postdata['post_lat'];
		$edited_lon = $postdata['post_lon'];
		$post_status = $postdata['post_status'];
		$comment_status = $postdata['comment_status'];
		$ping_status = $postdata['ping_status'];
		$post_password = $postdata['post_password'];
		$to_ping = $postdata['to_ping'];
		$pinged = $postdata['pinged'];
		$cagegoryObjects =& $postObject->getCategories();
		foreach ($cagegoryObjects as $cagegoryObject) {
			$post_categories[] = $cagegoryObject->getVar('category_id');
		}
		$default_post_cat = get_settings('default_post_category');
		include('edit-form-advanced.php');
		include('admin-footer.php');
		break;
	case 'editpost':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/edit.php',3,$xoopsWPTicket->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'post_ID','integer',NO_DEFAULT_PARAM, true);
		init_param('POST', 'post_title', 'string','', true);
		init_param('POST', 'post_category', 'array-int',array(1), true);
		init_param('POST', 'excerpt', 'html','');
		init_param('POST', 'wp_content', 'html', '', true);
		init_param('POST', 'post_status', 'string', get_settings('default_post_status'));
		init_param('POST', 'comment_status', 'string', get_settings('default_comment_status'));
		init_param('POST', 'ping_status', 'string', get_settings('default_ping_status'));
		init_param('POST', 'post_password', 'string', '');
		init_param('POST', 'post_pingback', 'check-01');
		init_param('POST', 'trackback_url', 'string');
		init_param('POST', 'target_charset', 'string', '');
		init_param('POST', 'useutf8', 'check-01');
		init_param('POST', 'saveasdraft', 'string');
		init_param('POST', 'saveasprivate', 'string');
		init_param('POST', 'publish', 'string');
		init_param('POST', 'edit_date','check-01');
		init_param('POST', 'save','string');
		init_param('POST', 'referredby', 'string','');
		init_param('POST', 'updatemeta','string');
		init_param('POST', 'deletemeta','string');
		init_param('POST', 'meta','array');
		init_param('POST', 'deletemeta','array');

		if (!($postObject =& $postHandler->get($post_ID))) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 5, _LANG_P_OOPS_IDPOS);
		}
		$authorObject = $userHandler->get($postObject->getVar('post_author'));
		if (!user_can_edit($postObject->getVar('post_author'))) {
			redirect_header(wp_siteurl().'/wp-admin/',5, _LANG_P_DATARIGHT_EDIT.' by <strong>['.$authorObject->getVar('user_login').']</strong>');
		}
		$prev_status = $postObject->getVar('post_status');
		$post_name = sanitize_title($post_title);
		if ($post_name == "") {
			$post_name = "post-".$post_ID;
		}
		$postObject->setVar('post_content', apply_filters('content_save_pre', $wp_content));
		$postObject->setVar('post_title', $post_title);
		$postObject->setVar('post_excerpt', apply_filters('excerpt_save_pre',$excerpt));
		$postObject->setVar('comment_status', $comment_status);
		$postObject->setVar('ping_status', $ping_status);
		$postObject->setVar('post_password', $post_password);
		$postObject->setVar('post_name', $post_name);
		$postObject->setVar('to_ping', preg_replace('|\s+|', "\n", $trackback_url));

		if(get_settings('use_geo_positions')) {
			init_param('POST', 'post_latf', 'float', get_settings('default_geourl_lat'));
			init_param('POST', 'post_lonf', 'float', get_settings('default_geourl_lon'));
			if (($post_latf <= 90 ) && ($post_lonf >= -90)) {
				$postObject->setVar('post_lat', $post_latf);
			}
			if (($post_lonf <= 360 ) && ($post_lonf >=-360)) {
				$postObject->setVar('post_lon', $post_lonf);
			}
		}

		if (($user_level > 4) && $edit_date) {
			init_param('POST', 'aa','integer');
			init_param('POST', 'mm','integer');
			init_param('POST', 'jj','integer');
			init_param('POST', 'hh','integer');
			init_param('POST', 'mn','integer');
			init_param('POST', 'ss','integer');
			$jj = ($jj > 31) ? 31 : $jj;
			$hh = ($hh > 23) ? $hh - 24 : $hh;
			$mn = ($mn > 59) ? $mn - 60 : $mn;
			$ss = ($ss > 59) ? $ss - 60 : $ss;
			$postObject->setVar('post_date', "$aa-$mm-$jj $hh:$mn:$ss");
		}

		// What to do based on which button they pressed
		if (!empty($saveasdraft)) $post_status = 'draft';
		if (!empty($saveasprivate)) $post_status = 'private';
		if (!empty($publish)) $post_status = 'publish';
		if (!empty($save)) $post_status = 'publish';
		$postObject->setVar('post_status', $post_status);

		if(!$postHandler->insert($postObject, false, true)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 3, $postHandler->getErrors());
		}

		$post_ID = $postObject->getVar('ID');

		if (!empty($save)) {
			$location = $_SERVER['HTTP_REFERER'];
		} elseif (!empty($updatemeta)) {
			$location = $_SERVER['HTTP_REFERER'] . '&message=2#postcustom';
		} elseif (!empty($deletemeta)) {
			$location = $_SERVER['HTTP_REFERER'] . '&message=3#postcustom';
		} elseif (!empty($referredby)) {
			$location = urldecode($referredby);
		} else {
			$location = 'post.php';
		}
		header ('Location: ' . $location);
		$postObject->assignCategories($post_category);
		// are we going from draft/private to published?
		if ((($prev_status == 'draft') || ($prev_status == 'private')) && ($post_status == 'publish')) {
			if((get_settings('use_geo_positions')) && ($post_latf != null) && ($post_lonf != null)) {
				pingGeoUrl();
			}
			pingWeblogs();
		} // end if moving from draft/private to published
		
		if ($post_status == 'publish') {
			if ($post_pingback) {
				pingback($postObject->getVar('post_content','e'), $post_ID);
			}
			do_action('publish_post',$post_ID);
			do_trackback($postObject, $useutf8);
		}
		// Meta Stuff
		if ($meta) {
			foreach ($meta as $key => $value) {
				update_meta($key, $value['key'], $value['value']);
			}
		}
		if ($deletemeta) {
			foreach ($deletemeta as $key => $value) {
				delete_meta($key);
			}
		}
		add_meta($post_ID);
		do_action('edit_post', $post_ID);
		exit();
		break;
	//Show Delete Cofirmation Screen
	case 'confirmdelete':
		//Check User_Level
		user_level_check();
		//Rendering Admin Screen header
		$parent_file = 'edit.php';
		$title = 'Delete Post';
		$standalone = 0;
		require_once('admin-header.php');
		//Check Paramaters
		init_param('GET', 'post','integer', NO_DEFAULT_PARAM, true);
		$post_id = $post;
		if (!($postObject =& $postHandler->get($post_id))) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 5, _LANG_P_OOPS_IDPOS);
		}
		$authorObject = $userHandler->get($postObject->getVar('post_author'));
		if (!user_can_edit($postObject->getVar('post_author'))) {
			redirect_header(wp_siteurl().'/wp-admin/',5, _LANG_P_DATARIGHT_DELETE.' by <strong>['.$authorObject->getVar('user_login').']</strong>');
		}
		//Show Confirmation message
		$delete_confirm = array(
						'action' => 'delete',
						'post' => $post_id,
						);
		$delete_confirm += $xoopsWPTicket->getTicketArray(__LINE__);
		$msg = _LANG_P_CONFIRM_DELETE."<br />'".$postObject->getVar('post_title')."'";
		xoops_confirm($delete_confirm, $this_file, $msg);
		include('admin-footer.php');
		break;
	//Delete one Post Record
	case 'delete':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/edit.php',3,$xoopsWPTicket->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'post','integer', NO_DEFAULT_PARAM, true);
		$post_id = $post;
		if (!($postObject =& $postHandler->get($post_id))) {
			redirect_header(wp_siteurl().'/wp-admin/edit.php', 5, _LANG_P_OOPS_IDPOS);
		}
		$authorObject = $userHandler->get($postObject->getVar('post_author'));
		if (!user_can_edit($postObject->getVar('post_author'))) {
			redirect_header(wp_siteurl().'/wp-admin/',5, _LANG_P_DATARIGHT_DELETE.' by <strong>['.$authorObject->getVar('user_login').']</strong>');
		}

		if(!$postHandler->delete($postObject)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 3, $postHandler->getErrors());
		}

		do_action('delete_post', $post_ID);
		$location = wp_siteurl() .'/wp-admin/edit.php';
		header ('Location: ' . $location);

		if($postObject->getVar('latf') != null ) {
			pingGeoUrl($post);
		}
		exit();
		break;
   case 'editcomment':
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('GET', 'comment','integer', NO_DEFAULT_PARAM, true);

		$title = 'Edit Comment';
		$standalone = 0;
		require_once ('admin-header.php');
		
		if (!($commentObject =& $commentHandler->get($comment))) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file,5,_LANG_P_OOPS_IDPOS);
		}
		$commentdata = $commentObject->getVarArray('e');

		$content = $commentdata['comment_content'];
		$content = apply_filters('comment_edit_pre', $content);

		include('edit-form-comment.php');
		include('admin-footer.php');
		break;
	case 'confirmdeletecomment':
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		$parent_file = 'edit.php';
		
		$title = 'Delete Comment';
		$standalone = 0;
		require_once('admin-header.php');

		init_param('GET', 'comment', 'integer', NO_DEFAULT_PARAM, true);
		init_param('GET', 'p', 'integer', NO_DEFAULT_PARAM, true);
		init_param('GET', 'referredby', 'string', NO_DEFAULT_PARAM, true);

		if (!($commentObject =& $commentHandler->get($comment))) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file,5,_LANG_P_OOPS_IDPOS);
		}
		$commentdata = $commentObject->getVarArray();
		$delete_confirm = array(
						'action' => 'deletecomment',
						'p' => $p,
						'comment' => $comment,
						'referredby' => $referredby,
						);
		$delete_confirm += $xoopsWPTicket->getTicketArray(__LINE__);
?>
<?php xoops_confirm($delete_confirm, wp_siteurl().'/wp-admin/post.php',_LANG_P_CONFIRM_DELETE); ?>
<div class="wrap">
	<p><strong>Caution:</strong><?php echo _LANG_P_ABOUT_FOLLOW ?></p>
	<table border="0">
		<tr><td>Author:</td><td><?php echo $commentdata["comment_author"] ?></td></tr>
		<tr><td>E-Mail:</td><td><?php echo $commentdata["comment_author_email"] ?></td></tr>
		<tr><td>URL:</td><td><?php echo $commentdata["comment_author_url"] ?></td></tr>
		<tr><td>Comment:</td><td><?php echo apply_filters('comment_text',$commentdata["comment_content"]) ?></td></tr>
	</table>
</div>
<?php
		include('admin-footer.php');
		break;
	case 'deletecomment':
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		init_param('POST', 'comment', 'integer', NO_DEFAULT_PARAM, true);
		init_param('POST', 'p', 'integer', NO_DEFAULT_PARAM, true);
		init_param('POST', 'referredby', 'string', NO_DEFAULT_PARAM, true);

		switch($referredby) {
			case 'edit':
				$location = wp_siteurl().'/wp-admin/edit.php?p='.$p.'&c=1#comments';
				break;
			case 'edit-comments':
				$location = wp_siteurl().'/wp-admin/edit-comments.php';
				break;
			case 'moderation':
				$location = wp_siteurl().'/wp-admin/moderation.php';
				break;
			case '':
				$location = wp_siteurl().'/wp-admin/';
				break;
			default:
				$location = $referredby;
		}

		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($location,3,$xoopsWPTicket->getErrors());
		}
		
		if (!($postObject =& $postHandler->get($p))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDCOM);
		}
		$authorObject = $userHandler->get($postObject->getVar('post_author'));
		if ($user_level < $authorObject->getVar('user_level')) {
			redirect_header($location,5, _LANG_P_DATARIGHT_DELETE.' by <strong>['.$authorObject->getVar('user_nickname').']</strong>');
		}

		if (!($commentObject =& $commentHandler->get($comment))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDPOS);
		}

		if(!$commentHandler->delete($commentObject)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file, 3, $commentHandler->getErrors());
		}
		do_action('delete_comment', $comment);

		header('Location: '.$location);
		exit();
		break;
	case 'unapprovecomment':
		wp_refcheck("/wp-admin");
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
	
		init_param('GET', 'comment', 'integer', NO_DEFAULT_PARAM, true);
		init_param('GET', 'p', 'integer', NO_DEFAULT_PARAM, true);
		init_param('GET', 'noredir', 'string', '');
		if (!empty($noredir)) {
			$noredir = true;
		} else {
			$noredir = false;
		}
		if (($_SERVER['HTTP_REFERER'] != "") && (false == $noredir)) {
			$location = $_SERVER['HTTP_REFERER'];
		} else {
			$location = wp_siteurl().'/wp-admin/edit.php?p='.$p.'&c=1#comments';
		}
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($location,3,$xoopsWPTicket->getErrors());
		}
		if (!($commentObject =& $commentHandler->get($comment))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDPOS);
		}
		if (!$commentObject->unapprove(true)) {
			redirect_header($location, 3, $commentHandler->getErrors());
		}
	
		header('Location: ' . $location);
		exit();
		break;
	case 'mailapprovecomment':
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		$parent_file = 'edit.php';
		
		$title = 'Approve Comment';
		$standalone = 0;
		require_once('admin-header.php');

		init_param('GET', 'comment', 'integer', NO_DEFAULT_PARAM, true);
		init_param('GET', 'p', 'integer', NO_DEFAULT_PARAM, true);

		if (!($commentObject =& $commentHandler->get($comment))) {
			redirect_header(wp_siteurl().'/wp-admin/'.$this_file,5,_LANG_P_OOPS_IDPOS);
		}
		$commentdata = $commentObject->getVarArray();
		$delete_confirm = array(
						'action' => 'approvecomment',
						'p' => $p,
						'comment' => $comment,
						'noredir' => true,
						);
?>
<?php xoops_confirm($delete_confirm,"post.php?".$xoopsWPTicket->getTicketParamString(__LINE__,true),_LANG_WPM_MODERATE_BUTTON); ?>
<div class="wrap">
	<table border="0">
		<tr><td>Author:</td><td><?php echo $commentdata["comment_author"] ?></td></tr>
		<tr><td>E-Mail:</td><td><?php echo $commentdata["comment_author_email"] ?></td></tr>
		<tr><td>URL:</td><td><?php echo $commentdata["comment_author_url"] ?></td></tr>
		<tr><td>Comment:</td><td><?php echo apply_filters('comment_text',$commentdata["comment_content"]) ?></td></tr>
	</table>
</div>
<?php
		include('admin-footer.php');
		break;
	case 'approvecomment':
		$standalone = 1;
		wp_refcheck("/wp-admin");
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
			
		init_param(ARRAY('GET','POST'), 'comment', 'integer', NO_DEFAULT_PARAM, true);
		init_param(ARRAY('GET','POST'), 'p', 'integer', NO_DEFAULT_PARAM, true);
		init_param(ARRAY('GET','POST'), 'noredir', 'string', '');

		if (!empty($noredir)) {
			$noredir = true;
		} else {
			$noredir = false;
		}
		if (($_SERVER['HTTP_REFERER'] != "") && (false == $noredir)) {
			$location = $_SERVER['HTTP_REFERER'];
		} else {
			$location = wp_siteurl().'/wp-admin/edit.php?p='.$p.'&c=1#comments';
		}

		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($location,3,$xoopsWPTicket->getErrors());
		}
		if (!($commentObject =& $commentHandler->get($comment))) {
			redirect_header($location, 3,_LANG_P_OOPS_IDPOS);
		}
		if (!$commentObject->approve(true)) {
			redirect_header($location, 3, $commentHandler->getErrors());
		}

		if (get_settings("comments_notify") == true) {
			wp_notify_postauthor($comment);
		}
		
		header('Location: '.$location);
		exit();
		break;
	case 'editedcomment':
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/',3,$xoopsWPTicket->getErrors());
		}
		if ($user_level <= 0) {
			redirect_header(wp_siteurl().'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}

		init_param('POST', 'comment_ID', 'integer', NO_DEFAULT_PARAM, true);
		init_param('POST', 'newcomment_author', 'string', ' ', true);
		init_param('POST', 'newcomment_author_email', 'string', ' ', true);
		init_param('POST', 'newcomment_author_url', 'string', ' ', true);
		init_param('POST', 'comment_post_ID', 'integer', NO_DEFAULT_PARAM, true);
		init_param('POST', 'edit_date','integer', 0);
		init_param('POST', 'wp_content','html', '', true);
		init_param('POST', 'referredby', 'string', urlencode($this_file."?p=$comment_post_ID&c=1#comments"), true);

		if (($user_level > 4) && $edit_date) {
			init_param('POST', 'aa','integer');
			init_param('POST', 'mm','integer');
			init_param('POST', 'jj','integer');
			init_param('POST', 'hh','integer');
			init_param('POST', 'mn','integer');
			init_param('POST', 'ss','integer');
			$jj = ($jj > 31) ? 31 : $jj;
			$hh = ($hh > 23) ? $hh - 24 : $hh;
			$mn = ($mn > 59) ? $mn - 60 : $mn;
			$ss = ($ss > 59) ? $ss - 60 : $ss;
			$datemodif = "$aa-$mm-$jj $hh:$mn:$ss";
		} else {
			$datemodif = '';
		}
		$commentObject =& $commentHandler->get($comment_ID);

		$commentObject->setVar('comment_ID',$comment_ID);
		$commentObject->setVar('comment_content',apply_filters('comment_save_pre', $wp_content));
		$commentObject->setVar('comment_author',$newcomment_author);
		$commentObject->setVar('comment_author_email',$newcomment_author_email);
		$commentObject->setVar('comment_author_url',$newcomment_author_url);
		if ($datemodif) {
			$commentObject->setVar('comment_date',$datemodif);
		}

		if (!test_param('referredby') && $_SERVER['HTTP_REFERER'] != "") {
			$location = $_SERVER['HTTP_REFERER'];
		} else {
			$location = urldecode($referredby);
		}

		if (!$commentHandler->insert($commentObject,false,false)) {
			redirect_header($location, 3, $commentHandler->getErrors());
		}
		header('Location: ' . $location);
		do_action('edit_comment', $comment_ID);
		exit();
		break;

	default:
		$title = 'Create New Post';
		$standalone = 0;
		require_once ('./admin-header.php');

		if ($user_level > 0) {
			$action = 'post';
			init_param('GET', 'content', 'html','');
			init_param('GET', 'edited_post_title', 'string','');
			init_param('GET', 'excerpt', 'html','');

			draft_list($user_ID);
			//set defaults
			$post_status = get_settings('default_post_status');
			$comment_status = get_settings('default_comment_status');
			$ping_status = get_settings('default_ping_status');
			$post_pingback = get_settings('default_pingback_flag');
			$default_post_cat = get_settings('default_post_category');

			$content = apply_filters('default_content', get_param('content'));
			$edited_post_title = apply_filters('default_title', get_param('edited_post_title'));
			$excerpt = apply_filters('default_excerpt', get_param('excerpt'));
			
			$trackback_url = '';
			$pinged = '';
			$mode = '';
			$form_prevstatus = '';
			$target_charset = '';
			
			include('edit-form.php');
			show_bookmarklet_link();
		} else {
?>
<div class="wrap">
			<p><?php echo _LANG_P_NEWCOMER_MESS." : <a href=\"mailto:".get_settings('admin_email')."?subject=Promotion\">E-Mail</a>"; ?></p>
</div>
<?php
		}
		include('admin-footer.php');
		break;
} // end switch
?>
