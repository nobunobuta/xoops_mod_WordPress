<?php
require_once('admin.php');

$_this_file = 'users.php';
$GLOBALS['parent_file'] = 'users.php';

$userHandler =& wp_handler('User');

init_param('', 'action', 'string', '');
switch (get_param('action')) {
	case 'promote':
		//Check Ticket
		if (!$GLOBALS['xoopsWPTicket']->check(false)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $GLOBALS['xoopsWPTicket']->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
	    init_param('GET', 'prom', 'string', NO_DEFAULT_PARAM, true);
	    init_param('GET', 'id', 'integer', NO_DEFAULT_PARAM, true);
		//Compare User_Level with target user's level.
		$userObject =& $userHandler->get(get_param('id'));
		if (($userObject->getVar('user_level') >= $GLOBALS['user_level']) && ($GLOBALS['user_ID'] != 1)){
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 5, _LANG_WUS_WHOSE_LEVEL);
		}
		
		if (get_param('prom') == 'up') {
			$_result = $userObject->upUserLevel();
		} elseif (get_param('prom') == 'down') {
			$_result = $userObject->downUserLevel();
		}
		if (!$_result) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $userHandler->getErrors());
		}
		header('Location: '.$_this_file);
		break;

	case 'confirmdelete':
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('GET', 'id', 'integer', NO_DEFAULT_PARAM, true);

		$GLOBALS['title'] = 'Delete User';
		$GLOBALS['standalone'] = 0;
		require_once('admin-header.php');
		$_delete_confirm = array(
						'action' => 'delete',
						'id' => get_param('id'),
						);
		$_delete_confirm += $GLOBALS['xoopsWPTicket']->getTicketArray(__LINE__);
		$_msg = _LANG_P_CONFIRM_DELETE;
		xoops_confirm($_delete_confirm, $_this_file, $_msg);
		include('admin-footer.php');
		break;

	case 'delete':
		//Check Ticket
		if (!$GLOBALS['xoopsWPTicket']->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $GLOBALS['xoopsWPTicket']->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'id', 'integer', NO_DEFAULT_PARAM, true);
		//Compare User_Level with target user's level.
		$userObject =& $userHandler->get(get_param('id'));
		if ($userObject->getVar('user_level') !=0 ){
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, _LANG_WUS_CANNOT_DELU);
		}
		
		if(!$userHandler->delete($userObject)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $userHandler->getErrors());
		}
		header('Location: '.$_this_file);
		break;

	default:
		//Check User_Level
		user_level_check();

		$GLOBALS['standalone'] = 0;
		$GLOBALS['title'] = 'Admin Users';
		require_once ('admin-header.php');
		$_ticket=$GLOBALS['xoopsWPTicket']->getTicketParamString('plugins');
		
		$_criteria = new Criteria('user_level',0, '>');
		$_criteria->setSort('ID');
		$userObjects =& $userHandler->getObjects($_criteria);
		$_user_rows =& _wpGetUserRows($userObjects, $_ticket, $_this_file);

		$_criteria = new Criteria('user_level',0);
		$_criteria->setSort('ID');
		$userObjects =& $userHandler->getObjects($_criteria);
		$_user0_rows =& _wpGetUserRows($userObjects, $_ticket, $_this_file);

		$_wpTpl =& new WordPresTpl('wp-admin');
		$_wpTpl->assign('user_count', count($_user_rows));
		$_wpTpl->assign('user_rows', $_user_rows);
		$_wpTpl->assign('user0_count', count($_user0_rows));
		$_wpTpl->assign('user0_rows', $_user0_rows);
		$_wpTpl->display('users.html');
		include('admin-footer.php');
		break;
}

function &_wpGetUserRows(&$records, $ticket, $this_file) {
	$rows = array();
	if ($records) {
		$style = "";
		foreach ($records as $record) {
			$style = ('class="odd"' == $style) ? 'class="even"' : 'class="odd"';
			$row = $record->getVarArray();
			$row['style'] = $style;
			if (_LANGCODE == 'ja') {
				$row['user_fullname'] = $row['user_lastname'].' '.$row['user_firstname'];
			} else {
				$row['user_fullname'] = $row['user_firstname'].' '.$row['user_lastname'];
			}
			$user_short_url = str_replace('http://', '', stripslashes($row['user_url']));
			$user_short_url = str_replace('www.', '', $user_short_url);
			if ('/' == substr($user_short_url, -1))
				$user_short_url = substr($user_short_url, 0, -1);
			if (strlen($user_short_url) > 35)
				$user_short_url =  substr($user_short_url, 0, 32).'...';
			$row['user_short_url'] = $user_short_url;

			$row['user_numposts'] = $record->getNumPosts();
			
			if ($row['user_numposts'] > 0 ) {
				$row['user_numposts'] = "<a href='edit.php?author={$row['ID']}' title='View posts'>{$row['user_numposts']}</a>";
			}
			if ($GLOBALS['user_level'] >= 3) {
				$row['user_del'] = "<a href='$this_file?action=confirmdelete&id={$row['ID']}' style='color:red;font-weight:bold;'>X</a>";
			} else {
				$row['user_del'] = "&nbsp;";
			}
			if ((($GLOBALS['user_level'] >= 2) && ($GLOBALS['user_level'] > $row['user_level']) && ($row['user_level'] > 0)) ||
			    (($GLOBALS['user_level'] == 10) && ($GLOBALS['user_ID'] != 1))) {
				$row['level_down'] = "<a href='$this_file?action=promote&id={$row['ID']}&prom=down$ticket'>-</a>";
			} else {
				$row['level_down'] = "&nbsp;";
			}
			if ((($GLOBALS['user_level'] >= 2) && ($GLOBALS['user_level'] > ($row['user_level'] + 1))) ||
			    (($GLOBALS['user_level'] == 10) && ($row['user_level'] < 10))) {
				$row['level_up'] = "<a href='$this_file?action=promote&id={$row['ID']}&prom=up$ticket'>+</a>";
			} else {
				$row['level_up'] = "&nbsp;";
			}
			$rows[] = $row;
		}
	}
	return $rows;
}
?>