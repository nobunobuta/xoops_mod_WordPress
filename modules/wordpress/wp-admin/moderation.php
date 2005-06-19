<?php
require_once('admin.php');
$this_file = 'moderation.php';
$parent_file = 'edit.php';

$commentHandler =& wp_handler('Comment');
$postHandler =& wp_handler('Post');

init_param(array('POST','GET'), 'action', 'string', '');

switch($action) {
	case 'update':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file,3,$xoopsWPTicket->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'comment','array',array(), true);

		$item_ignored = 0;
		$item_deleted = 0;
		$item_approved = 0;
		
		foreach($comment as $key => $value) {
			$commentObject =& $commentHandler->get(intval($key));
			$postObject =& $postHandler->get($commentObject->getVar('comment_post_ID'));
		    if (user_can_edit($postObject->getVar('post_author'))) {
			    switch($value) {
					case 'later':
						++$item_ignored;
						break;
					
					case 'delete':
						if (!$commentHandler->delete($commentObject)) {
							redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $categoryHandler->getErrors());
						}
						++$item_deleted;
						break;
					
					case 'approve':
						if (!$commentObject->approve()) {
							redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $categoryHandler->getErrors());
						}
						if (get_settings('comments_notify') == true) {
							wp_notify_postauthor($key);
						}
						++$item_approved;
						break;
				}
			}
		}
		header("Location: $this_file?ignored=$item_ignored&deleted=$item_deleted&approved=$item_approved");
		exit();
		break;
	default:
		//Check User_Level
		user_level_check();

	    $standalone = 0;
		$title = 'Moderate comments';
		require_once('admin-header.php');
		//Check Paramaters
		init_param('GET', 'ignored','integer',0);
		init_param('GET', 'deleted','integer',0);
		init_param('GET', 'approved','integer',0);
		
		$criteria = new Criteria('comment_approved', '0 '); // Trick for numeric chars only string compare
		$commentObjects =& $commentHandler->getObjects($criteria);
		$comment_rows = array();
		foreach($commentObjects as $commentObject) {
			$row = $commentObject->getVarArray();
			$comment = $commentObject->exportWpObject();
			$postObject =& $postHandler->get($commentObject->getVar('comment_post_ID'));
			if ($postObject) {
				$row['post_title'] = $postObject->getVar('post_title');
			}
			$row['comment_date'] = mysql2date(get_settings("date_format") . " @ " . get_settings("time_format"), $commentObject->comment_date);
			$row['post_title']  = ($row['post_title'] == '') ? "# $commentObject->getVar('comment_post_ID')" : $row['post_title'];
			$row['comment_author'] = comment_author(false);
			$row['comment_author_email'] = comment_author_email_link('','','',false);
			$row['comment_author_url'] = comment_author_url_link('','','',false);
			$row['comment_author_IP'] = comment_author_IP(false);
			$row['comment_content'] = comment_text(false);
			if (user_can_edit($postObject->getVar('post_author'))) {
				$comment_rows[] = $row;
			}
		}
		$ticket = $xoopsWPTicket->getTicketHtml(__LINE__);

		$wpTpl =& new XoopsTpl;
		$wpTpl->error_reporting = error_reporting();
		$wpTpl->assign('ignored', $ignored);
		$wpTpl->assign('deleted', $deleted);
		$wpTpl->assign('approved', $approved);
		$wpTpl->assign('comments_notify', get_settings('comments_notify'));
		$wpTpl->assign('comment_rows', $comment_rows);
		$wpTpl->assign('ticket', $ticket);
		$wpTpl->template_dir = wp_base().'/wp-admin/templates/';
		$wpTpl->display('moderation.html');
		include('admin-footer.php');
		break;
}
