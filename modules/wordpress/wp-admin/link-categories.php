<?php
// Links
// Copyright (C) 2002, 2003 Mike Little -- mike@zed1.com
require_once('admin.php');

$linkCategoryHandler =& $wpLinkCategoryHandler[$wp_prefix[$wp_id]];

$this_file='link-categories.php';
$parent_file = 'link-manager.php';

init_param(array('POST','GET'), 'action', 'string', '');

switch ($action) {
  case 'addcat':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('POST', 'cat_name', 'string', NO_DEFAULT_PARAM, true);
		init_param('POST', 'auto_toggle', 'string-yn');
		init_param('POST', 'show_images', 'string-yn');
		init_param('POST', 'show_description', 'string-yn');
		init_param('POST', 'show_rating', 'string-yn');
		init_param('POST', 'show_updated', 'string-yn');
		init_param('POST', 'sort_order', 'string', '', true);
		init_param('POST', 'sort_desc', 'string-yn');
		init_param('POST', 'text_before_link', 'html', '', true);
		init_param('POST', 'text_after_link', 'html', '', true);
		init_param('POST', 'text_after_all', 'html', '', true);
		init_param('POST', 'list_limit', 'integer', -1,  true);

		$linkCategory =& $linkCategoryHandler->create();
		
		$linkCategory->setVar('cat_name', $cat_name);
		$linkCategory->setVar('auto_toggle', $auto_toggle);
		$linkCategory->setVar('show_images', $show_images);
		$linkCategory->setVar('show_description', $show_description);
		$linkCategory->setVar('show_rating', $show_rating);
		$linkCategory->setVar('show_updated', $show_updated);
		$linkCategory->setVar('sort_order', $sort_order);
		$linkCategory->setVar('sort_desc', $sort_desc);
		$linkCategory->setVar('text_before_link', $text_before_link);
		$linkCategory->setVar('text_after_link', $text_after_link);
		$linkCategory->setVar('text_after_all', $text_after_all);
		$linkCategory->setVar('list_limit', $list_limit);
		
		if(!$linkCategoryHandler->insert($linkCategory)) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $linkCategoryHandler->getErrors());
		}
		header('Location: '.$this_file);
		break;

	case 'confirmdelete':
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('GET', 'cat_id', 'integer', NO_DEFAULT_PARAM, true);

		$title = 'Delete Link Category';
		$standalone = 0;
		require_once('admin-header.php');

		$delete_confirm = array(
						'action' => 'delete',
						'cat_id' => $cat_id,
						);
		$delete_confirm += $xoopsWPTicket->getTicketArray(__LINE__);
		$msg = _LANG_P_CONFIRM_DELETE;
		xoops_confirm($delete_confirm, $this_file, $msg);
		include('admin-footer.php');
		break;

	case 'delete':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('POST', 'cat_id', 'integer', NO_DEFAULT_PARAM, true);

		$linkCategory =& $linkCategoryHandler->get($cat_id);
		if(!$linkCategoryHandler->delete($linkCategory)) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $linkCategoryHandler->getErrors());
		}

		header('Location: '.$this_file);
		break;

	case 'edit':
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('GET', 'cat_id', 'integer', NO_DEFAULT_PARAM, true);

		$title = 'Edit Link Category';
        $standalone=0;
        include_once ('admin-header.php');
		
		$linkCat = $linkCategoryHandler->get($cat_id);

        if ($linkCat) {
			$form_title = _LANG_WLC_TITLE_TEXT.$linkCat->getVar('cat_name')."&#8221;";
			$form_id = "editcat";
			$cat_name = $linkCat->getVar('cat_name','e');
			$auto_toggle = $linkCat->getVar('auto_toggle','e');
			$show_images = $linkCat->getVar('show_images','e');
			$show_description = $linkCat->getVar('show_description','e');
			$show_rating = $linkCat->getVar('show_rating','e');
			$show_updated = $linkCat->getVar('show_updated','e');
			$sort_order = $linkCat->getVar('sort_order','e');
			$sort_desc = $linkCat->getVar('sort_desc','e');
			$text_before_link = $linkCat->getVar('text_before_link','e');
			$text_after_link = $linkCat->getVar('text_after_link','e');
			$text_after_all = $linkCat->getVar('text_after_all','e');
			$list_limit = $linkCat->getVar('list_limit','e');
            if ($list_limit == -1) {
                $list_limit = '';
            }
			include('include/link-categories-form.php');
			$formHTML = $form->display();
    } // end if row
	include('admin-footer.php');
    break;
  case "editedcat":
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
			exit();
		}
		init_param('POST', 'submit','string', '');
		if ($submit == _LANG_WLC_SAVEBUTTON_TEXT) {
			//Check Paramaters
			init_param('POST', 'cat_id', 'integer', NO_DEFAULT_PARAM, true);
			init_param('POST', 'cat_name', 'string', NO_DEFAULT_PARAM, true);
			init_param('POST', 'auto_toggle', 'string-yn');
			init_param('POST', 'show_images', 'string-yn');
			init_param('POST', 'show_description', 'string-yn');
			init_param('POST', 'show_rating', 'string-yn');
			init_param('POST', 'show_updated', 'string-yn');
			init_param('POST', 'sort_order', 'string', '', true);
			init_param('POST', 'sort_desc', 'string-yn');
			init_param('POST', 'text_before_link', 'html', '', true);
			init_param('POST', 'text_after_link', 'html', '', true);
			init_param('POST', 'text_after_all', 'html', '', true);
			init_param('POST', 'list_limit', 'integer', -1, true);

			$linkCategory =& $linkCategoryHandler->create(false);
			
			$linkCategory->setVar('cat_id', $cat_id);
			$linkCategory->setVar('cat_name', $cat_name);
			$linkCategory->setVar('auto_toggle', $auto_toggle);
			$linkCategory->setVar('show_images', $show_images);
			$linkCategory->setVar('show_description', $show_description);
			$linkCategory->setVar('show_rating', $show_rating);
			$linkCategory->setVar('show_updated', $show_updated);
			$linkCategory->setVar('sort_order', $sort_order);
			$linkCategory->setVar('sort_desc', $sort_desc);
			$linkCategory->setVar('text_before_link', $text_before_link);
			$linkCategory->setVar('text_after_link', $text_after_link);
			$linkCategory->setVar('text_after_all', $text_after_all);
			$linkCategory->setVar('list_limit', $list_limit);
		
			if(!$linkCategoryHandler->insert($linkCategory)) {
				redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $linkCategoryHandler->getErrors());
			}
		}
		header('Location: '.$this_file);
	    break;
	default:
        $standalone=0;
		$title = 'Link Categories';
        include_once ("./admin-header.php");
        if ($user_level < get_settings('links_minadminlevel')) {
			    redirect_header($siteurl.'/wp-admin/',5,_LANG_WLC_RIGHT_PROM);
			    exit();
        }
		$criteria = new Criteria(1,1);
		$criteria->setSort('cat_id');
		
		$linkCats = $linkCategoryHandler->getObjects($criteria);
		$linkCat_rows = array();
		$style = "";
		foreach ($linkCats as $linkCat) {
			$style = ('class="odd"' == $style) ? 'class="even"' : 'class="odd"';
			$row = $linkCat->getVarArray();
			$row['style'] = $style;
			if ($row['list_limit'] == -1) {
				$row['list_limit'] = 'none';
			}
			$linkCat_rows[] = $row;
		}

		$form_title = _LANG_WLC_ADD_TITLE;
		$form_id = "addcat";
		$cat_name = "";
		$auto_toggle = "";
		$show_images = "";
		$show_description = "";
		$show_rating = "";
		$show_updated = "";
		$sort_order = "name";
		$sort_desc = "";
		$text_before_link = "&lt;li&gt;";
		$text_after_link = "&lt;br /&gt;";
		$text_after_all = "&lt;/li&gt;";
		$list_limit = "";
		include('include/link-categories-form.php');
		$formHTML = $form->render();
		
		$defcat = $linkCategoryHandler->get(1);
		$note_name = $defcat->getVar('cat_name');
		
		$wpTpl =& new XoopsTpl;

		$wpTpl->assign('linkCat_rows', $linkCat_rows);
		$wpTpl->assign('note_name', $note_name);
		$wpTpl->assign('formHTML', $formHTML);
		$wpTpl->display(ABSPATH."wp-admin/templates/link-categories.html");

		include('admin-footer.php');
	    break;
}
?>
