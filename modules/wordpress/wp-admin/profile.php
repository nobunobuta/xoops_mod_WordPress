<?php
require_once('admin.php');

$_this_file = 'profile.php';
$GLOBALS['parent_file'] = 'profile.php';

$userHandler =& wp_handler('User');

init_param('', 'action', 'string', '');

switch(get_param('action')) {
	case 'update':
		//Check Ticket
		if (!$GLOBALS['xoopsWPTicket']->check()) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $GLOBALS['xoopsWPTicket']->getErrors());
		}
		//Check Paramaters
		init_param('POST', 'newuser_firstname', 'string', '', true);
		init_param('POST', 'newuser_lastname', 'string', '', true);
		init_param('POST', 'newuser_nickname', 'string', NO_DEFAULT_PARAM, true);
		init_param('POST', 'newuser_icq', 'string', '', true);
		init_param('POST', 'newuser_aim', 'string', '', true);
		init_param('POST', 'newuser_msn', 'string', '', true);
		init_param('POST', 'newuser_yim', 'string', '', true);
		init_param('POST', 'newuser_email', 'string', true, true);
		init_param('POST', 'newuser_url', 'string', '', true);
		init_param('POST', 'newuser_idmode', 'string', '', true);
		init_param('POST', 'user_description', 'html', '', true);

		$userObject =& $userHandler->create(false);

		$userObject->setVar('ID', $GLOBALS['user_ID']);
		$userObject->setVar('user_firstname', get_param('newuser_firstname'));
		$userObject->setVar('user_lastname', get_param('newuser_lastname'));
		$userObject->setVar('user_nickname', get_param('newuser_nickname'));
		$userObject->setVar('user_icq', get_param('newuser_icq'));
		$userObject->setVar('user_aim', get_param('newuser_aim'));
		$userObject->setVar('user_msn', get_param('newuser_msn'));
		$userObject->setVar('user_yim', get_param('newuser_yim'));
		$userObject->setVar('user_email', get_param('newuser_email'));
		$userObject->setVar('user_url', get_param('newuser_url'));
		$userObject->setVar('newuser_idmode', get_param('newuser_idmode'));
		$userObject->setVar('user_description', get_param('user_description'));
		
		if (!$userHandler->insert($userObject, false, true)) {
			redirect_header($_this_file, 3, $userHandler->getErrors());
		}
		header('Location: '.$_this_file.'?updated=true');
		break;

	case 'viewprofile':
		init_param('GET', 'user', 'integer', NO_DEFAULT_PARAM, true);
		$userObject =& $userHandler->get(get_param('user'));
		if (!$userObject) {
			redirect_header(wp_siteurl(), 0, _LANG_P_CHEATING_ERROR);
		}
		if (isset($GLOBALS['xoopsUser']) && ($GLOBALS['xoopsUser']->getVar('uname') == $userObject->getVar('user_login'))) {
			header ('Location: '.$_this_file.'?standalone=1');
		}
		$GLOBALS['standalone'] = 1;
		$GLOBALS['title'] = "View Profile";
		require_once('admin-header.php');
		$_userinfo =& $userObject->getVarArray();
		$_userinfo['uniqname'] = $userObject->get_uniqname();
		$_userinfo['numposts'] = $userObject->getNumPosts(wp_prefix());
		$_userinfo['user_email'] = make_clickable($_userinfo['user_email']);
		$_userinfo['user_url'] =  make_clickable($_userinfo['user_url']);
		$_userinfo['user_icq'] =  $_userinfo['user_icq'] >0 ? make_clickable($_userinfo['user_icq']) : '';

		$_wpTpl =& new WordPresTpl('wp-admin');
		$_wpTpl->assign('user_ID', $GLOBALS['user_ID']);
		$_wpTpl->assign('userinfo', $_userinfo);
		$_wpTpl->display('profile-viewprofile.html');

		include('admin-footer.php');
		break;

	case 'IErightclick':
		$GLOBALS['standalone'] = 1;
		$GLOBALS['title'] = 'IE Right Click Register';
		require_once('admin-header.php');
		require_once(XOOPS_ROOT_PATH.'/class/template.php');
		$_regedit = "REGEDIT4\r\n[HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\MenuExt\Post To &WP : ".get_settings('blogname')."]\r\n@=\"".wp_siteurl()."/wp-admin/bookmarklet.jp.php\"\r\n\"contexts\"=hex:31\"";
		
		$_wpTpl =& new WordPresTpl('wp-admin');
		$_wpTpl->assign('regedit', $_regedit);
		$_wpTpl->display('profile-IErightclick.html');
		include('admin-footer.php');
		break;
	default:
		init_param('GET', 'standalone', 'integer', 0);
		$GLOBALS['standalone'] = get_param('standalone');
		$GLOBALS['title'] = 'Edit Profile';
		include_once('admin-header.php');
		require_once(XOOPS_ROOT_PATH.'/class/template.php');
		
		init_param('GET', 'updated','string','');

		$userObject =& $userHandler->get($GLOBALS['user_ID']);

		include XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
		$_form = new XoopsThemeForm(_LANG_WPF_SUBT_EDIT, 'profile', $_this_file);
		$_form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_USERID, $userObject->getVar('ID','e')));
		$_form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_LEVEL, $userObject->getVar('user_level','e')));
		$_form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_POSTS, $userObject->getNumPosts($wp_prefix[$wp_id])));
		$_form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_LOGIN, $userObject->getVar('user_login','e')));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_FIRST, 'newuser_firstname', 50, 150, $userObject->getVar('user_firstname','e')));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_LAST, 'newuser_lastname', 50, 150, $userObject->getVar('user_lastname','e')));
		$_form->addElement(new XoopsFormTextArea(_LANG_WPF_SUBT_DESC, 'user_description', $userObject->getVar('user_description','e'), 5,60));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_NICK, 'newuser_nickname', 50, 150, $userObject->getVar('user_nickname','e')), true);
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_MAIL, 'newuser_email', 50, 150, $userObject->getVar('user_email','e')), true);
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_URL, 'newuser_url', 50, 150, $userObject->getVar('user_url','e')));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_ICQ, 'newuser_icq', 50, 150, ($userObject->getVar('user_icq','e'))?($userObject->getVar('user_icq','e')):''));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_AIM, 'newuser_aim', 50, 150, $userObject->getVar('user_aim','e')));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_MSN, 'newuser_msn', 50, 150, $userObject->getVar('user_msn','e')));
		$_form->addElement(new XoopsFormText(_LANG_WPF_SUBT_YAHOO, 'newuser_yim', 50, 150, $userObject->getVar('user_yim','e')));
		$_form_idmode = new XoopsFormSelect(_LANG_WPF_SUBT_IDENTITY, 'newuser_idmode', $userObject->getVar('user_idmode','e'));
		$_form_idmode->addOption('nickname', $userObject->getVar('user_nickname'));
		$_form_idmode->addOption('login', $userObject->getVar('user_login'));
		$_form_idmode->addOption('firstname', $userObject->getVar('user_firstname'));
		$_form_idmode->addOption('lastname', $userObject->getVar('user_lastname'));
		$_form_idmode->addOption('namefl', $userObject->getVar('user_firstname').' '.$userObject->getVar('user_lastname'));
		$_form_idmode->addOption('namelf', $userObject->getVar('user_lastname').' '.$userObject->getVar('user_firstname'));
		$_form->addElement($_form_idmode);
		$_form->addElement(new XoopsFormButton('', 'submit', _LANG_WPF_SUBT_UPDATE, 'submit'));
		$_form->addElement(new XoopsFormHidden('checkuser_id', $GLOBALS['user_ID']));
		$_form->addElement(new XoopsFormHidden('action', 'update'));
		$_form->addElement($GLOBALS['xoopsWPTicket']->getTicketXoopsForm(__LINE__,600));
		$_formHTML = $_form->render();

		$_wpTpl =& new WordPresTpl('wp-admin');
		$_wpTpl->assign('updated', get_param('updated'));
		$_wpTpl->assign('formHTML', $_formHTML);
		$_wpTpl->assign('blogname', get_settings('blogname'));
		$_wpTpl->assign('siteurl', wp_siteurl());
		$_wpTpl->assign('is_gecko', $GLOBALS['is_gecko']);
		$_wpTpl->assign('is_IE', ($GLOBALS['is_winIE']) || ($GLOBALS['is_macIE']));
		$_wpTpl->display('profile.html');
		include('admin-footer.php');
		break;
}
?>