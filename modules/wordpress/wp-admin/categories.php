<?php
require_once('admin.php');
$_this_file = 'categories.php';
$parent_file = 'categories.php';

$categoryHandler =& wp_handler('Category');

init_param('', 'action', 'string', '');
switch(get_param('action')) {
	//Insert New Record
	case 'addcat':
		//Check Ticket
		if ( ! $GLOBALS['xoopsWPTicket']->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $GLOBALS['xoopsWPTicket']->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'cat_name', 'string', NO_DEFAULT_PARAM, true);
		init_param('POST', 'category_description', 'html', '', true);
		init_param('POST', 'category_parent', 'integer', 0, true);
		
		$categoryObject =& $categoryHandler->create();
		$categoryObject->setVar('cat_name', get_param('cat_name'));
		$categoryObject->setVar('category_nicename',sanitize_title(get_param('cat_name')));
		$categoryObject->setVar('category_description',get_param('category_description'));
		$categoryObject->setVar('category_parent',get_param('category_parent'));
		if (!$categoryHandler->insert($categoryObject)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $categoryHandler->getErrors());
		}
		header('Location: '.$_this_file.'?message=1#addcat');
		break;
	//Show Delete Cofirmation Screen
	case 'confirmdelete':
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('GET', 'cat_ID', 'integer', NO_DEFAULT_PARAM, true);

		$GLOBALS['title'] = 'Delete Category';
		$GLOBALS['standalone'] = 0;
		require_once('admin-header.php');

		$_delete_confirm = array(
						'action' => 'delete',
						'cat_ID' => get_param('cat_ID'),
						);
		$_delete_confirm += $GLOBALS['xoopsWPTicket']->getTicketArray(__LINE__);
		$_msg = _LANG_P_CONFIRM_DELETE;
		xoops_confirm($_delete_confirm, $_this_file, $_msg);
		include('admin-footer.php');
		break;
	//Delete one Record
	case 'delete':  
		//Check Ticket
		if ( ! $GLOBALS['xoopsWPTicket']->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $GLOBALS['xoopsWPTicket']->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'cat_ID', 'integer', NO_DEFAULT_PARAM, true);

		$categoryObject =& $categoryHandler->get(get_param('cat_ID'));
		if(!$categoryHandler->delete($categoryObject)) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $categoryHandler->getErrors());
		}
		header('Location: '.$_this_file.'?message=2');
		break;
	// Show Category Editing Screen
	case 'edit':
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('GET', 'cat_ID', 'integer', NO_DEFAULT_PARAM, true);

		$GLOBALS['standalone'] = 0;
		$GLOBALS['title'] = 'Edit Categories';
		require_once ('admin-header.php');
	
		$categoryObject =& $categoryHandler->get(get_param('cat_ID'));

		$_form_id = "editcat";
		$_form_title = _LANG_C_EDIT_TITLECAT;
		$_form_cat_ID = $categoryObject->getVar('cat_ID','e');
		$_form_cat_name = $categoryObject->getVar('cat_name','e');
		$_form_category_parent = $categoryObject->getVar('category_parent','e');
		$_form_category_description = $categoryObject->getVar('category_description','e');
		$_form_category_options = Array("0"=>"None") + $categoryHandler->getParentOptionArray(get_param('cat_ID'));
		include('include/categories-form.php');
		$_form->display();
		include('admin-footer.php');
		break;
	// Update Edited Record
	case 'editedcat':
		//Check Ticket
		if ( ! $GLOBALS['xoopsWPTicket']->check() ) {
			redirect_header(wp_siteurl().'/wp-admin/'.$_this_file, 3, $GLOBALS['xoopsWPTicket']->getErrors());
		}
		//Check User_Level
		user_level_check();
		//Check Paramaters
		init_param('POST', 'cat_ID', 'integer', NO_DEFAULT_PARAM, true);
		init_param('POST', 'cat_name', 'string', NO_DEFAULT_PARAM, true);
		init_param('POST', 'category_description', 'html', '', true);
		init_param('POST', 'category_parent', 'integer', 0, true);
	
		$categoryObject =& $categoryHandler->create(false);
		
		$categoryObject->setVar('cat_ID',get_param('cat_ID'));
		$categoryObject->setVar('cat_name',get_param('cat_name'));
		$_category_nicename = sanitize_title(get_param('cat_name'));
		if ($_category_nicename == "")  $_category_nicename = "category-".get_param('cat_ID');
		$categoryObject->setVar('category_nicename', $_category_nicename);
		$categoryObject->setVar('category_description', get_param('category_description'));
		$categoryObject->setVar('category_parent', get_param('category_parent'));

		if (!$categoryHandler->insert($categoryObject)) {
			redirect_header("", 3, $categoryHandler->getErrors());
		}
		header('Location: '.$_this_file.'?message=3');
		break;
	// Show Category Administration Main Screen
	default:
		//Check User_Level
		user_level_check();

		$GLOBALS['standalone'] = 0;
		$GLOBALS['title'] = 'Admin Categories';
		require_once ('admin-header.php');

		init_param('GET', 'message', 'integer', 0);
		$_messages = array('', _LANG_C_MESS_ADD, _LANG_C_MESS_DELE, _LANG_C_MESS_UP);
		$_message = $_messages[get_param('message')];

		$categoryObjects = $categoryHandler->getNestedObjects();
		$_category_rows = array();
		$_style = "";
		foreach($categoryObjects as $categoryObject) {
			$_style = ('class="odd"' == $_style) ? 'class="even"' : 'class="odd"';
			$_row = $categoryObject->getVarArray();
			$_row['style'] = $_style;
			$_row['category_description'] = apply_filters('category_description', $_row['category_description']);
			$_row['count'] = $categoryObject->getNumPosts();
			if ($_row['count'] > 0) {
				$_row['count'] = "<a href='edit.php?cat={$_row['cat_ID']}' title='View posts'>{$_row['count']}</a>";
			}
			$_category_rows[] = $_row;
		}
		$_notice = sprintf(_LANG_C_NOTE_CATEGORY, get_catname(1));

		$_form_id = "addcat";
		$_form_title = _LANG_C_ADD_NEWCAT;
		$_form_cat_ID = 0;
		$_form_cat_name = "";
		$_form_category_parent = 0;
		$_form_category_description = "";
		$_form_category_options = Array("0"=>"None") + $categoryHandler->getParentOptionArray();
		include('include/categories-form.php');
		$_formHTML = $_form->render();

		$_wpTpl =& new WordPresTpl('wp-admin');
		$_wpTpl->assign('message', $_message);
		$_wpTpl->assign('category_rows', $_category_rows);
		$_wpTpl->assign('notice', $_notice);
		$_wpTpl->assign('formHTML', $_formHTML);
		$_wpTpl->display('categories.html');

		include('admin-footer.php');
		break;
}
?>