<?php
require_once('admin.php');

$parent_file = 'post.php';

param('action','string', '');
switch($action) {
	case 'post':
		wp_refcheck("/wp-admin/");
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('post_title','string');
		param('post_category','array-int',array(1));
		param('excerpt','html');
		param('wp_content','html');
		param('post_status','string',get_settings('default_post_status'));
		param('comment_status','string',get_settings('default_comment_status'));
		param('ping_status','string',get_settings('default_ping_status'));
		param('post_password','string');
		param('post_pingback','integer',0);
		param('trackback_url','string');
		param('target_charset','string');
		param('useutf8','integer');
		param('mode','string','default');
		param('saveasdraft','string');
		param('saveasprivate','string');
		param('publish','string');
		param('advanced','string');

		$post_name = sanitize_title($post_title);

		$excerpt = apply_filters('excerpt_save_pre',$excerpt);
		$excerpt = format_to_post($excerpt);

		$content = apply_filters('content_save_pre', $wp_content);
		$content = format_to_post($content);

		if(get_settings('use_geo_positions')) {
			param('post_latf','float',get_settings('default_geourl_lat'));
			param('post_lonf','float',get_settings('default_geourl_lon'));

			if (($post_latf > 90 ) || ($post_lonf < -90)) {
				$post_latf='NULL';
			}
			if (($post_lonf > 360 ) || ($post_lonf < -360)) {
				$post_lonf='NULL';
			}
		} else {
			$post_latf='NULL';
			$post_lonf='NULL';
		}

		$trackback = preg_replace('|\s+|', '\n', $trackback_url);

		param('edit_date','integer',0);
		if (($user_level > 4) && $edit_date) {
			param('aa','integer');
			param('mm','integer');
			param('jj','integer');
			param('hh','integer');
			param('mn','integer');
			param('ss','integer');
			$jj = ($jj > 31) ? 31 : $jj;
			$hh = ($hh > 23) ? $hh - 24 : $hh;
			$mn = ($mn > 59) ? $mn - 60 : $mn;
			$ss = ($ss > 59) ? $ss - 60 : $ss;
			$now = "$aa-$mm-$jj $hh:$mn:$ss";
		} else {
			$now = date('Y-m-d H:i:s', (time() + ($time_difference * 3600)));
		}
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

		// What to do based on which button they pressed
		if ('' != $saveasdraft) $post_status = 'draft';
		if ('' != $saveasprivate) $post_status = 'private';
		if ('' != $publish) $post_status = 'publish';
		if ('' != $advanced) $post_status = 'draft';

		$postquery ="INSERT INTO {$wpdb->posts[$wp_id]}
				(ID, post_author, post_date, post_content, post_title, post_lat, post_lon, post_excerpt,  post_status, comment_status, ping_status, post_password, post_name, to_ping)
				VALUES
				('0', '$user_ID', '$now', '$content', '$post_title', $post_latf, $post_lonf,'$excerpt', '$post_status', '$comment_status', '$ping_status', '$post_password', '$post_name', '$trackback')
				";
		$result = $wpdb->query($postquery);

		$post_ID = $wpdb->get_var("SELECT LAST_INSERT_ID()");
		if ($post_name == "") {
			$post_name = "post-".$post_ID;
			$wpdb->query("UPDATE {$wpdb->posts[$wp_id]} SET post_name='$post_name' WHERE ID = $post_ID");
		}

		if ('' != $advanced) {
			$location = "post.php?action=edit&post=$post_ID";
		}

		if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
			sleep($sleep_after_edit);
		}

		header("Location: $location");

	 	add_meta($post_ID);

		$post_categories = $post_category;
		foreach ($post_categories as $post_category) {
			// Double check it's not there already
			$exists = $wpdb->get_row("SELECT * FROM {$wpdb->post2cat[$wp_id]} WHERE post_id = $post_ID AND category_id = $post_category");
			 if (!$exists && $result) { 
				$wpdb->query("
				INSERT INTO {$wpdb->post2cat[$wp_id]}
				(post_id, category_id)
				VALUES
				($post_ID, $post_category)
				");
			}
		}
		
		do_action('save_post', $post_ID);       

		if ($post_status == 'publish') {
			if((get_settings('use_geo_positions')) && ($post_latf != null) && ($post_lonf != null)) {
				pingGeoUrl($post_ID);
			}
			pingWeblogs($blog_ID);
			pingBlogs($blog_ID);

			if ($post_pingback) {
				pingback($content, $post_ID);
			}
			
			do_action('publish_post', $post_ID);

			do_trackback($post_ID, $post_title, $content, $excerpt, $useutf8, $target_charset);

		} // end if publish

		exit();
		break;

	case 'edit':
		$parent_file = 'edit.php';
		$title = 'Edit Post';
		$standalone = 0;
		require_once('admin-header.php');
		if ($user_level > 0) {
			param('post','integer');
			$post_ID = $p = $post;

			$postdata = get_postdata($post);
			$authordata = get_userdata($postdata['Author_ID']);
			if ($user_level < $authordata->user_level) {
				redirect_header($siteurl.'/wp-admin/',5, _LANG_P_DATARIGHT_EDIT.' by <strong>['.$authordata[1].']</strong>');
				exit();
			}
			$content = $postdata['Content'];
			$content = format_to_edit($content);
			$content = apply_filters('content_edit_pre', $content);

			$excerpt = $postdata['Excerpt'];
			$excerpt = format_to_edit($excerpt);
			$excerpt = apply_filters('excerpt_edit_pre', $excerpt);

			$edited_post_title = format_to_edit($postdata['Title']);
			$edited_post_title = apply_filters('title_edit_pre', $edited_post_title);

			$edited_lat = $postdata['Lat'];
			$edited_lon = $postdata['Lon'];

			$post_status = $postdata['post_status'];
			$comment_status = $postdata['comment_status'];
			$ping_status = $postdata['ping_status'];
			$post_password = $postdata['post_password'];

			$to_ping = $postdata['to_ping'];
			$pinged = $postdata['pinged'];
			$default_post_cat = get_settings('default_post_category');
			include('edit-form-advanced.php');
		} else {
?>
			<p><?php echo _LANG_P_NEWCOMER_MESS." : <a href=\"mailto:".get_settings('admin_email')."?subject=Promotion\">E-Mail</a>"; ?></p>
<?php
		}
		break;
	case 'editpost':
		wp_refcheck("/wp-admin");
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}

		param('blog_ID','integer',1);
		param('post_ID','integer',true);
		param('post_autobr','integer');
		param('post_title','string');
		param('post_category','array-int',array(1));
		param('excerpt','html');
		param('wp_content','html');
		param('post_status','string',get_settings('default_post_status'));
		param('comment_status','string',get_settings('default_comment_status'));
		param('ping_status','string',get_settings('default_ping_status'));
		param('post_password','string');
		param('post_pingback','integer',0);
		param('trackback_url','string');
		param('target_charset','string');
		param('useutf8','integer');
		param('publish','string');
		param('edit_date','integer',0);
		param('save','string');
		param('updatemeta','string');
		param('deletemeta','string');
		param('meta','array');
		param('deletemeta','array');


		$post_name = sanitize_title($post_title);
		if ($post_name == "") {
			$post_name = "post-".$post_ID;
		}

		$excerpt = apply_filters('excerpt_save_pre',$excerpt);
		$excerpt = format_to_post($excerpt);

		$content = apply_filters('content_save_pre', $wp_content);
		$content = format_to_post($content);

		if(get_settings('use_geo_positions')) {
			param('post_latf','float',get_settings('default_geourl_lat'));
			param('post_lonf','float',get_settings('default_geourl_lon'));
			if (($post_latf > 90 ) || ($post_lonf < -90)) {
				$post_latf='NULL';
			}
			if (($post_lonf > 360 ) || ($post_lonf < -360)) {
				$post_lonf='NULL';
			}
		} else {
			$post_latf='NULL';
			$post_lonf='NULL';
		}
		$trackback = preg_replace('|\s+|', '\n', $trackback_url);
		if ('' != $publish) $post_status = 'publish';

		if (($user_level > 4) && $edit_date) {
			param('aa','integer');
			param('mm','integer');
			param('jj','integer');
			param('hh','integer');
			param('mn','integer');
			param('ss','integer');
			$jj = ($jj > 31) ? 31 : $jj;
			$hh = ($hh > 23) ? $hh - 24 : $hh;
			$mn = ($mn > 59) ? $mn - 60 : $mn;
			$ss = ($ss > 59) ? $ss - 60 : $ss;
			$datemodif = ", post_date=\"$aa-$mm-$jj $hh:$mn:$ss\"";
		} else {
			$datemodif = '';
		}

		$result = $wpdb->query("
			UPDATE {$wpdb->posts[$wp_id]} SET
				post_content = '$content',
				post_excerpt = '$excerpt',
				post_title = '$post_title',
				post_lat = $post_latf,
				post_lon = $post_lonf"
				.$datemodif.",
				post_status = '$post_status',
				comment_status = '$comment_status',
				ping_status = '$ping_status',
				post_password = '$post_password',
				post_name = '$post_name',
				to_ping = '$trackback'
			WHERE ID = $post_ID ");

		if (isset($save)) {
			$location = $_SERVER['HTTP_REFERER'];
		} elseif (isset($updatemeta)) {
			$location = $_SERVER['HTTP_REFERER'] . '&message=2#postcustom';
		} elseif (isset($deletemeta)) {
			$location = $_SERVER['HTTP_REFERER'] . '&message=3#postcustom';
		} else {
			$location = 'post.php';
		}

		if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
			sleep($sleep_after_edit);
		}

		header ('Location: ' . $location);

		// Now it's category time!
		// First the old categories
		$old_categories = $wpdb->get_col("SELECT category_id FROM {$wpdb->post2cat[$wp_id]} WHERE post_id = $post_ID");
		
		// Delete any?
		foreach ($old_categories as $old_cat) {
			if (!in_array($old_cat, $post_category)) // If a category was there before but isn't now
				$wpdb->query("DELETE FROM {$wpdb->post2cat[$wp_id]} WHERE category_id = $old_cat AND post_id = $post_ID LIMIT 1");
		}
		
		// Add any?
		foreach ($post_category as $new_cat) {
			if (!in_array($new_cat, $old_categories))
				$wpdb->query("INSERT INTO {$wpdb->post2cat[$wp_id]} (post_id, category_id) VALUES ($post_ID, $new_cat)");
		}
		
		// are we going from draft/private to published?
		if ((($prev_status == 'draft') || ($prev_status == 'private')) && ($post_status == 'publish')) {
			if((get_settings('use_geo_positions')) && ($post_latf != null) && ($post_lonf != null)) {
				pingGeoUrl($post_ID);
			}
			pingWeblogs($blog_ID);
			pingBlogs($blog_ID);
		} // end if moving from draft/private to published
		
		if ($post_status == 'publish') {
			if ($post_pingback) {
				pingback($content, $post_ID);
			}
			do_action('publish_post', $post_ID);
			do_trackback($post_ID, $post_title, $content, $excerpt, $useutf8);
		} // end if publish

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

	case 'confirmdelete':
		$parent_file = 'edit.php';
		$title = 'Delete Post';
		$standalone = 0;
		require_once('admin-header.php');

		param('post','integer');

		$post_id = $post;
		if (!($postdata = get_postdata($post_id))) {
			redirect_header($siteurl.'/wp-admin/edit.php',5,_LANG_P_OOPS_IDPOS);
			exit;
		}
		$delete_confirm = array(
						'action' => 'delete',
						'post' => $post_id,
						);
		$delete_confirm += $xoopsWPTicket->getTicketArray(__LINE__);
		$msg = _LANG_P_SURE_THAT."<br>'".htmlspecialchars($postdata['Title'])."'";
		xoops_confirm($delete_confirm,'post.php',$msg);
		break;
	case 'delete':
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/edit.php',3,$xoopsWPTicket->getErrors());
		}
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('post','integer');
		
		$post_id = $post;
		if (!($postdata = get_postdata($post_id))) {
			redirect_header($siteurl.'/wp-admin/edit.php',5,_LANG_P_OOPS_IDPOS);
			exit;
		}
		$authordata = get_userdata($postdata['Author_ID']);

		if ($user_level < $authordata->user_level) {
			redirect_header($siteurl.'/wp-admin/',5, _LANG_P_DATARIGHT_DELETE.' by <strong>['.$authordata[1].']</strong>');
			exit();
		}

		// send geoURL ping to "erase" from their DB
		$query = "SELECT post_lat from {$wpdb->posts[$wp_id]} WHERE ID=$post_id";
		$rows = $wpdb->query($query); 
		$myrow = $rows[0];
		$latf = $myrow->post_lat;
		if($latf != null ) {
			pingGeoUrl($post);
		}

		$result = $wpdb->query("DELETE FROM {$wpdb->posts[$wp_id]} WHERE ID=$post_id");
		if (!$result) {
			redirect_header($siteurl.'/wp-admin/edit.php',5,_LANG_P_DATARIGHT_ERROR);
			exit;
		}

		$result = $wpdb->query("DELETE FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID=$post_id");

		if (get_xoops_option($wp_mod[$wp_id],'wp_use_xoops_comments')) {
			$result = $wpdb->query("DELETE FROM ".$xoopsDB->prefix('xoopscomments')." WHERE com_modid=".$xoopsModule->getVar('mid')." AND com_itemid=$post_id");
		}
		$categories = $wpdb->query("DELETE FROM {$wpdb->post2cat[$wp_id]} WHERE post_id = $post_id");

		$meta = $wpdb->query("DELETE FROM {$wpdb->postmeta[$wp_id]} WHERE post_id = $post_id");

		if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
			sleep($sleep_after_edit);
		}
	
		do_action('delete_post', $post_ID);

		$location = $siteurl .'/wp-admin/edit.php';
		header ('Location: ' . $location);

		break;

   case 'editcomment':
		$title = 'Edit Comment';
		$standalone = 0;
		require_once ('admin-header.php');
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('comment','integer');
		if (!($commentdata = get_commentdata($comment, 1, true))) {
			redirect_header($siteurl.'/wp-admin/post.php',5,_LANG_P_OOPS_IDPOS);
			exit;
		}
		$content = $commentdata['comment_content'];
		$content = format_to_edit($content);
		$content = apply_filters('comment_edit_pre', $content);

		include('edit-form-comment.php');

		break;

	case 'confirmdeletecomment':
		$parent_file = 'edit.php';
		$title = 'Delete Comment';
		$standalone = 0;
		require_once('admin-header.php');

		param('comment','integer');
		param('p','integer',0);
		param('referredby','string','');

		if (!($commentdata = get_commentdata($comment, 1, true))) {
			redirect_header($siteurl.'/wp-admin/post.php',5,_LANG_P_OOPS_IDPOS);
			exit;
		}
		$delete_confirm = array(
						'action' => 'deletecomment',
						'p' => $p,
						'comment' => $comment,
						'referredby' => $referredby,
						);
		$delete_confirm += $xoopsWPTicket->getTicketArray(__LINE__);
?>
<?php xoops_confirm($delete_confirm,'post.php',_LANG_P_SURE_THAT); ?>
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
		break;

	case 'deletecomment':
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		param('comment','integer');
		param('p','integer');
		param('noredir', 'string');
		param('referredby','string','');

		switch($referredby) {
			case 'edit':
				$location = $siteurl.'/wp-admin/edit.php?p='.$p.'&c=1#comments';
				break;
			case 'edit-comments':
				$location = $siteurl.'/wp-admin/edit-comments.php';
				break;
			case 'moderation':
				$location = $siteurl.'/wp-admin/moderation.php';
				break;
			default:
				$location = $siteurl.'/wp-admin/';
		}

		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($location,3,$xoopsWPTicket->getErrors());
		}
		
		if (!($postdata = get_postdata($p))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDCOM);
		}
		if (!($commentdata = get_commentdata($comment, 1, true))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDPOS);
			exit;
		}
		$authordata = get_userdata($postdata['Author_ID']);
		if ($user_level < $authordata->user_level) {
			redirect_header($location,5, _LANG_P_DATARIGHT_DELETE.' by <strong>['.$authordata->user_nickname.']</strong>');
			exit;
		}
		
		wp_set_comment_status($comment, "delete");
		do_action('delete_comment', $comment);

		header('Location: '.$location);
		break;
	case 'unapprovecomment':
		wp_refcheck("/wp-admin");
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
	
		param('comment','integer');
		param('p','integer');
		param('noredir', 'string');
		if (isset($noredir)) {
			$noredir = true;
		} else {
			$noredir = false;
		}
		if (($_SERVER['HTTP_REFERER'] != "") && (false == $noredir)) {
			$location = $_SERVER['HTTP_REFERER'];
		} else {
			$location = $siteurl.'/wp-admin/edit.php?p='.$p.'&c=1#comments';
		}

		if (!($commentdata = get_commentdata($comment, 1, true))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDPOS);
			exit;
		}
	
		wp_set_comment_status($comment, "hold");
	
		header('Location: ' . $location);
	
		break;
	case 'mailapprovecomment':
		$standalone = 0;
		require_once('./admin-header.php');
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
	
		param('comment','integer');
		param('p','integer');
	
		if (!($commentdata = get_commentdata($comment, 1, true))) {
			redirect_header($siteurl.'/wp-admin/', 5,_LANG_P_OOPS_IDPOS);
			exit;
		}

		wp_set_comment_status($comment, "approve");
		if (get_settings("comments_notify") == true) {
			wp_notify_postauthor($comment);
		}
?>
<div class="wrap">
	<p><?php echo _LANG_P_COMHAS_APPR ?></p>
	<form action="<?php echo "$siteurl/wp-admin/edit.php?p=$p&c=1#comments"?>" method="get">
		<input type="hidden" name="p" value="<?php echo $p ?>" />
		<input type="hidden" name="c" value="1" />
		<input type="submit" value="Ok" />
	</form>
</div>
<?php	
		break;
	case 'approvecomment':
		$standalone = 1;
		wp_refcheck("/wp-admin");
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
			
		param('comment','integer');
		param('p','integer');
		param('noredir', 'string');
		if (isset($noredir)) {
			$noredir = true;
		} else {
			$noredir = false;
		}
		if (($_SERVER['HTTP_REFERER'] != "") && (false == $noredir)) {
			$location = $_SERVER['HTTP_REFERER'];
		} else {
			$location = $siteurl.'/wp-admin/edit.php?p='.$p.'&c=1#comments';
		}

		if (!($commentdata = get_commentdata($comment, 1, true))) {
			redirect_header($location, 5,_LANG_P_OOPS_IDPOS);
			exit;
		}
		
		wp_set_comment_status($comment, "approve");

		if (get_settings("comments_notify") == true) {
			wp_notify_postauthor($comment);
		}
		
		header('Location: '.$location);
		
		break;
	case 'editedcomment':
		wp_refcheck("/wp-admin");
		if ($user_level == 0) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}

		param('comment_ID','integer');
		param('newcomment_author','string');
		param('newcomment_author_email','string');
		param('newcomment_author_url','string');
		param('comment_post_ID','integer');
		param('edit_date','integer',0);
		param('wp_content','html');
		param('referredby','string', "edit.php?p=$comment_post_ID&c=1#comments");

		$newcomment_author = addslashes($newcomment_author);
		$newcomment_author_email = addslashes($newcomment_author_email);
		$newcomment_author_url = addslashes($newcomment_author_url);

		if (($user_level > 4) && $edit_date) {
			param('aa','integer');
			param('mm','integer');
			param('jj','integer');
			param('hh','integer');
			param('mn','integer');
			param('ss','integer');
			$jj = ($jj > 31) ? 31 : $jj;
			$hh = ($hh > 23) ? $hh - 24 : $hh;
			$mn = ($mn > 59) ? $mn - 60 : $mn;
			$ss = ($ss > 59) ? $ss - 60 : $ss;
			$datemodif = ", comment_date = '$aa-$mm-$jj $hh:$mn:$ss'";
		} else {
			$datemodif = '';
		}
		$content = apply_filters('comment_save_pre', $wp_content);
		$content = format_to_post($content);

		$result = $wpdb->query("
			UPDATE {$wpdb->comments[$wp_id]} SET
				comment_content = '$content',
				comment_author = '$newcomment_author',
				comment_author_email = '$newcomment_author_email',
				comment_author_url = '$newcomment_author_url'".$datemodif."
			WHERE comment_ID = $comment_ID"
			);

		header('Location: ' . $referredby);

		do_action('edit_comment', $comment_ID);
		break;

	default:
		$title = 'Create New Post';
		$standalone = 0;
		require_once ('./admin-header.php');

		if ($user_level > 0) {
			$action = 'post';

			param('content','html','');
			param('edited_post_title','string','');
			param('excerpt','html','');

			draft_list($user_ID);
			//set defaults
			$post_status = get_settings('default_post_status');
			$comment_status = get_settings('default_comment_status');
			$ping_status = get_settings('default_ping_status');
			$post_pingback = get_settings('default_pingback_flag');
			$default_post_cat = get_settings('default_post_category');

			$content = apply_filters('default_content', $content);
			$edited_post_title = apply_filters('default_title', $edited_post_title);
			$excerpt = apply_filters('default_excerpt', $excerpt);
			
			$trackback_url = '';
			$pinged = '';
			$mode = '';
			$form_prevstatus = '';
			
			include('edit-form.php');
			show_bookmarklet_link();
		} else {
?>
<div class="wrap">
			<p><?php echo _LANG_P_NEWCOMER_MESS." : <a href=\"mailto:".get_settings('admin_email')."?subject=Promotion\">E-Mail</a>"; ?></p>
</div>
<?php
		}
		break;
} // end switch

include('admin-footer.php');
?>
