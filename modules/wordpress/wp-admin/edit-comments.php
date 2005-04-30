<?php
require_once('admin.php');

$parent_file = 'edit.php';
$this_file = 'edit-comments.php';

user_level_check();

$standalone = 0;
$title = 'Edit Comments';
require_once('admin-header.php');

init_param('GET', 'showcomments', 'integer', 10);
init_param('GET', 'commentstart', 'integer', 0);
init_param('GET', 'commentend', 'integer', 0);
init_param('GET', 'commentorder', 'string', 'DESC');

if ($commentstart && $commentend) {
	$showcomments = $commentend - $commentstart+ 1;
} else {
	if (!$commentstart) {
		$commentstart = 1;
	}
	if (!$commentend) {
		$commentend = $commentstart + $showcomments -1;
	}
}

$nextXstart = $commentend + 1;
$nextXend = $nextXstart + $showcomments -1;

$previousXstart = $commentstart-$showcomments;
$previousXend = $commentend -$showcomments;
if ($previousXstart < 1) {
	$previousXstart = 0;
	$previousXend = 0 ;
}

$selorder_desc = selected($commentorder,"DESC", false);
$selorder_asc = selected($commentorder,"ASC", false);

$criteria = new Criteria(1,1);
$criteria->setSort('comment_date');
$criteria->setOrder($commentorder);
$criteria->setStart($commentstart-1);
$criteria->setLimit($commentend-$commentstart+1);
$commentHandler =& wp_handler('Comment');
$commentObjects =& $commentHandler->getObjects($criteria);
$comment_rows = array();
if ($commentObjects) {
	$comments_found = true;
	foreach($commentObjects as $commentObject) {
		$row = $commentObject->getVarArray();
		$comment = $commentObject->exportWpObject(); //$comment global is used in template_functions.
		$postHandler =& wp_handler('Post');
		$postObject =& $postHandler->get($commentObject->getVar('comment_post_ID'));
		if ($commentObject->getVar('comment_approved') == 0) {
			$row['class'] = 'class="unapproved" ';
		} else {
			$row['class'] = '';
		}
		if ($postObject) {
			$row['post_title'] = $postObject->getVar('post_title');
		}
		$row['canEdit'] = user_can_edit($postObject->getVar('post_author'));
//		($author->getVar('user_level') < $user_level) || ($author->getVar('user_login') == $user_login);
		$row['post_title']  = ($row['post_title'] == '') ? "# $commentObject->getVar('comment_post_ID')" : $row['post_title'];
		$row['comment_author'] = comment_author(false);
		$row['comment_author_email'] = comment_author_email_link('','','',false);
		$row['comment_author_url'] = comment_author_url_link('','','',false);
		$row['comment_author_IP'] = comment_author_IP(false);
		$row['comment_content'] = comment_text(false);
		$row['comment_date'] = comment_date('Y/m/d H:i:s',false);
		$row['post_permalink'] = get_permalink($row['comment_post_ID']);
		$comment_rows[] = $row;
	}
} else {
	$comments_found = false;
}

$wpTpl =& new XoopsTpl;

$wpTpl->assign('showcomments', $showcomments);
$wpTpl->assign('previousXstart', $previousXstart);
$wpTpl->assign('previousXend', $previousXend);
$wpTpl->assign('nextXstart', $nextXstart);
$wpTpl->assign('nextXend', $nextXend);
$wpTpl->assign('commentstart', $commentstart);
$wpTpl->assign('commentend', $commentend);
$wpTpl->assign('selorder_desc', $selorder_desc);
$wpTpl->assign('selorder_asc', $selorder_asc);
$wpTpl->assign('comments_found', $comments_found);
$wpTpl->assign('comment_rows', $comment_rows);
$wpTpl->template_dir = wp_base().'/wp-admin/templates/';
$wpTpl->display('edit-comments.html');

include('admin-footer.php');
?>
