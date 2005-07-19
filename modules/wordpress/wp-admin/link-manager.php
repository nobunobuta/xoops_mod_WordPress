<?php
// Links
// Copyright (C) 2002, 2003 Mike Little -- mike@zed1.com

require_once('admin.php');

$linkHandler =& wp_handler('Link');
$userHandler =& wp_handler('User');
$linkCategoryHandler =& wp_handler('LinkCategory');

$title = 'Manage Links';
$this_file = 'link-manager.php';
$parent_file = 'link-manager.php';

init_param(array('POST','GET'), 'action2', 'string', '');
init_param(array('POST','GET'), 'action', 'string', get_param('action2'));


switch (get_param('action')) {
	case _LANG_WLM_ASSIGN_TEXT:
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('POST', 'linkcheck', 'array-int', array(), true);
		init_param('POST', 'newowner', 'integer', -1, true);

		if (count($linkcheck) == 0) {
			header('Location: ' . $this_file);
			exit;
		}
		if (!$userHandler->get($newowner)) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 5,'No owner ID');
		}
		
		$criteria =& new Criteria('link_id', "(".implode(',', $linkcheck).")", 'IN'); 
		$links =& $linkHandler->getObjects($criteria);
		$ids_to_change = array();
		foreach($links as $link) {
			$user =& $userHandler->get($link->getVar('link_owner'));
			if (!get_settings('links_use_adminlevels') || ($user_level >= $user->getVar('user_level'))) { // ok to proceed
				$ids_to_change[] = $link->getVar('link_id');
			}
		}
		$criteria =& new Criteria('link_id', "(".implode(',', $ids_to_change).")", 'IN'); 
		$linkHandler->updateAll('link_owner',$newowner, $criteria);
		header('Location: ' . $this_file);
		break;

	case _LANG_WLM_VISIVILITY_TEXT:
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/', 5, _LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('POST', 'linkcheck', 'array-int', array(), true);

		if (count($linkcheck) == 0) {
		    header('Location: ' . $this_file);
		    exit;
		}

    	//for each link id (in $linkcheck[]): toggle the visibility
		$criteria =& new Criteria('link_id', "(".implode(',', $linkcheck).")", 'IN'); 
		$links =& $linkHandler->getObjects($criteria);
		// should now have two arrays of links to change
		$ids_to_turnon = array();
		$ids_to_turnoff = array();
		foreach($links as $link) {
		    if ($link->getVar('link_visible') == 'Y') { // ok to proceed
		        $ids_to_turnoff[] = $link->getVar('link_id');
		    } else {
		        $ids_to_turnon[] = $link->getVar('link_id');
		    }
		}
		if (count($ids_to_turnoff)) {
			$criteria =& new Criteria('link_id', "(".implode(',', $ids_to_turnoff).")", 'IN'); 
			$linkHandler->updateAll('link_visible','N', $criteria);
		}

		if (count($ids_to_turnon)) {
			$criteria =& new Criteria('link_id', "(".implode(',', $ids_to_turnon).")", 'IN'); 
			$linkHandler->updateAll('link_visible','Y', $criteria);
		}

		header('Location: ' . $this_file);
		break;
	case _LANG_WLM_MOVE_TEXT:
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/', 5, _LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('POST', 'linkcheck', 'array-int', array(), true);
		init_param('POST', 'category', 'integer', -1, true );

		if (count($linkcheck) == 0) {
		    header('Location: ' . $this_file);
		    exit;
		}

		if (!$linkCategoryHandler->get($category)) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 5,'No category ID');
		}

		$criteria =& new Criteria('link_id', "(".implode(',', $linkcheck).")", 'IN'); 
		$linkHandler->updateAll('link_category',$category, $criteria);

		header('Location: ' . $this_file);
		break;
 case 'Add':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/', 5, _LANG_P_CHEATING_ERROR);
		}
		//Check Paramaters
		init_param('POST', 'link_url', 'string', NO_DEFAULT_PARAM, true);
		init_param('POST', 'link_name', 'string', NO_DEFAULT_PARAM, true);
		init_param('POST', 'link_image', 'string', '', true);
		init_param('POST', 'link_target', 'string', '', true);
		init_param('POST', 'link_category', 'integer', 1, true);
		init_param('POST', 'link_description', 'string', '', true);
		init_param('POST', 'link_visible', 'string-yn', 'Y', true);
		init_param('POST', 'link_rating', 'integer', 0, true);
		init_param('POST', 'link_rel', 'string', '', true);
		init_param('POST', 'link_notes', 'html', '', true);
		init_param('POST', 'link_rss', 'string', '', true);

		$linkRecord = $linkHandler->create();

		$linkRecord->setVar('link_url', $link_url);
		$linkRecord->setVar('link_name', $link_name);
		$linkRecord->setVar('link_image', $link_image);
		$linkRecord->setVar('link_target', $link_target);
		$linkRecord->setVar('link_category', $link_category);
		$linkRecord->setVar('link_description',$link_description);
		$linkRecord->setVar('link_visible',$link_visible);
		$linkRecord->setVar('link_rating',$link_rating);
		$linkRecord->setVar('link_rel',$link_rel);
		$linkRecord->setVar('link_notes',$link_notes);
		$linkRecord->setVar('link_rss',$link_rss);
		
		$linkHandler->insert($linkRecord);
		
		// if we are in an auto toggle category and this one is visible then we
		// need to make the others invisible before we add this new one.
	    $auto_toggle = get_autotoggle($link_category);
		if (($auto_toggle == 'Y') && ($link_visible == 'Y')) {
			$criteria = new Criteria('link_category', $link_category);
			$linkHandler->updateAll('link_visible', 'N', $criteria);
		}
		header('Location: ' . $this_file);
		break;
  	case 'editlink':
		//Check Ticket
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		//Check User_Level
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		init_param('POST', 'submit', 'string', NO_DEFAULT_PARAM, true);
		if ($submit == _LANG_WLM_SAVE_CHANGES) {
			//Check Paramaters
			init_param('POST', 'link_id', 'integer', NO_DEFAULT_PARAM, true);
			init_param('POST', 'link_url', 'string', NO_DEFAULT_PARAM, true);
			init_param('POST', 'link_name', 'string', NO_DEFAULT_PARAM, true);
			init_param('POST', 'link_image', 'string', '', true);
			init_param('POST', 'link_target', 'string', '', true);
			init_param('POST', 'link_category', 'integer', 1, true);
			init_param('POST', 'link_description', 'string', '', true);
			init_param('POST', 'link_visible', 'string-yn', 'Y', true);
			init_param('POST', 'link_rating', 'integer', 0, true);
			init_param('POST', 'link_rel', 'string', '', true);
			init_param('POST', 'link_notes', 'html', '', true);
			init_param('POST', 'link_rss', 'string', '', true);

			$linkRecord = $linkHandler->create(false);

			$linkRecord->setVar('link_id', $link_id);
			$linkRecord->setVar('link_url', $link_url);
			$linkRecord->setVar('link_name', $link_name);
			$linkRecord->setVar('link_image', $link_image);
			$linkRecord->setVar('link_target', $link_target);
			$linkRecord->setVar('link_category', $link_category);
			$linkRecord->setVar('link_description',$link_description);
			$linkRecord->setVar('link_visible',$link_visible);
			$linkRecord->setVar('link_rating',$link_rating);
			$linkRecord->setVar('link_rel',$link_rel);
			$linkRecord->setVar('link_notes',$link_notes);
			$linkRecord->setVar('link_rss',$link_rss);

			$linkHandler->insert($linkRecord);

			// if we are in an auto toggle category and this one is visible then we
			// need to make the others invisible before we add this new one.
		    $auto_toggle = get_autotoggle($link_category);
			if (($auto_toggle == 'Y') && ($link_visible == 'Y')) {
				$criteria = new Criteria('link_category', $link_category);
				$linkHandler->updateAll('link_visible', 'N', $criteria);
			}
		}
		header('Location: ' . $this_file);
		break;
	case 'confirmdelete':
		$title = 'Delete Link';
		$standalone = 0;
		require_once('admin-header.php');

		init_param('GET', 'link_id','integer',NO_DEFAULT_PARAM, true);

		$delete_confirm = array(
						'action' => 'Delete',
						'link_id' => $link_id,
						);
		$delete_confirm += $xoopsWPTicket->getTicketArray(__LINE__);
		$msg = _LANG_P_CONFIRM_DELETE;
		xoops_confirm($delete_confirm, $this_file, $msg);
		include('admin-footer.php');
		break;
  case 'Delete':
		if ( ! $xoopsWPTicket->check() ) {
			redirect_header($siteurl.'/wp-admin/'.$this_file, 3, $xoopsWPTicket->getErrors());
		}
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
		}
		init_param('POST', 'link_id', 'integer', NO_DEFAULT_PARAM, true);
		
		$linkRecord =& $linkHandler->create(false);
		$linkRecord->setVar('link_id', $link_id);
		
		if(!$linkHandler->delete($linkRecord)) {
			redirect_header("", 3, $linkHandler->getErrors());
		}
		header('Location: '.$this_file);
		break;
	case 'linkedit':
		$standalone=0;
		$xfn = true;
		include_once ('admin-header.php');
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_WLM_LEVEL_ERROR);
		}
		init_param('GET', 'link_id', 'integer', NO_DEFAULT_PARAM, true);

		$linkRecord =& $linkHandler->get($link_id);

		if ($linkRecord) {
			$form_title = _LANG_WLM_EDIT_LINK;
			$form_id = "editlink";
			
			$link_url = $linkRecord->getVar('link_url');
			$link_name = $linkRecord->getVar('link_name');
			$link_rss = $linkRecord->getVar('link_rss');
			$link_image = $linkRecord->getVar('link_image');
			$link_description = $linkRecord->getVar('link_description');
			$link_rel = $linkRecord->getVar('link_rel');
			$link_rels = explode(" ",$link_rel);
			
			$friendship = array_intersect($link_rels,array('acquaintance', 'friend'));
			sort($friendship);
			$friendship = (count($friendship)==0) ? '': $friendship[0];

			$physical = array_intersect($link_rels,array('met'));
			
			$professional = array_intersect($link_rels,array('co-worker', 'colleague'));

			$geographical = array_intersect($link_rels,array('co-resident','neighbor'));
			sort($geographical);
			$geographical = (count($geographical)==0) ? '': $geographical[0];

			$family = array_intersect($link_rels,array('child','parent','sibling','spouse'));
			sort($family);
			$family = (count($family)==0) ? '': $family[0];

			$romantic = array_intersect($link_rels,array('muse','crush','date','sweetheart'));

			$link_notes = $linkRecord->getVar('link_notes');
			$link_rating = $linkRecord->getVar('link_rating');
			$link_target = $linkRecord->getVar('link_target');
			$link_visible = $linkRecord->getVar('link_visible');
			$link_category = $linkRecord->getVar('link_category');

			$category_options = $linkCategoryHandler->getOptionArray();
			include('include/link-manager-form.php');
		}
		include('admin-footer.php');
		break;
	case _LANG_WLM_SHOW_BUTTONTEXT:
		init_param('POST', 'cat_id', 'string', 'All', true);
		init_param('POST', 'order_by', 'string', 'link_name', true);

		$_SESSION[wp_prefix().'links_show_cat_id'] = intval($cat_id);
		$_SESSION[wp_prefix().'links_show_order'] = $order_by;
 	   //break; fall through
	default:
		$links_show_cat_id = init_param('SESSION',wp_prefix().'links_show_cat_id', 'integer', '');
		$links_show_order = init_param('SESSION',wp_prefix().'links_show_order', 'string', '');
		if (!empty($links_show_cat_id)) {
			$cat_id = intval($links_show_cat_id);
		}
		if (empty($cat_id)) {
			if (empty($links_show_cat_id)) {
				$cat_id = 'All';
			}
		}
		if (!empty($links_show_order)) {
			$order_by = $links_show_order;
		}
		if (empty($order_by)) {
			$order_by = 'link_name';
		}
		
		$standalone=0;
		include_once ("./admin-header.php");
		if ($user_level < get_settings('links_minadminlevel')) {
			redirect_header($siteurl.'/wp-admin/',5,_LANG_WLM_LEVEL_ERROR);
		}
		include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
		$selectLinkCat = new XoopsFormSelect("", "cat_id", $cat_id);
		$selectLinkCat->addOptionArray(Array('All' => 'All')+$linkCategoryHandler->getOptionArray());
		$selectLinkCatControl = $selectLinkCat->render();

		$selectOrder = new XoopsFormSelect("", "order_by", $order_by);
		$selectOrder->addOptionArray($linkCategoryHandler->getSortOptionArray());
		$selectOrderControl = $selectOrder->render();

		$ticketHiddenContorl = $xoopsWPTicket->getTicketHtml(__LINE__);
		$helpLink =	 gethelp_link($this_file,'list_o_links');

		$selectSetLinkCat = new XoopsFormSelect("", "category");
		$selectSetLinkCat->addOptionArray($linkCategoryHandler->getOptionArray());
		$selectSetLinkCatControl = $selectSetLinkCat->render();
		
		$selectSetUser = new XoopsFormSelect("", "newowner");
		$selectSetUser->addOptionArray($userHandler->getOptionArray());
		$selectSetUserControl = $selectSetUser->render();

		if (isset($cat_id) && ($cat_id != 'All')) {
			$criteria = new Criteria('link_category', $cat_id);
		} else {
			$criteria = new Criteria(1,1);
		}
		$criteria->setSort($order_by);
		$links = $linkHandler->getObjects($criteria);
		$style = "";
		if ($links) {
			$link_rows = array();
			foreach ($links as $link) {
				$style = ('class="odd"' == $style) ? 'class="even"' : 'class="odd"';
				$row = $link->getVarArray();
				$row['style'] = $style;

				$short_url = str_replace('http://', '', stripslashes($row['link_url']));
				$short_url = str_replace('www.', '', $short_url);
				if ('/' == substr($short_url, -1)) {
					$short_url = substr($short_url, 0, -1);
				}
				if (strlen($short_url) > 35) {
					$short_url =  substr($short_url, 0, 32).'...';
				}
				$row['short_url'] = $short_url;
				$row['image'] = ($row['link_image'] != null) ? 'Yes' : 'No';
				$row['visible'] = ($row['link_visible'] == 'Y') ? 'Yes' : 'No';

				$linkcat = $linkCategoryHandler->get($row['link_category']);
				$row['category'] = $linkcat->getVar('cat_name');
				$linkowner = $userHandler->get($row['link_owner']);
				$linkowner_user_level = $linkowner->getVar('user_level');
				
				if (get_settings('links_use_adminlevels') && ($linkowner_user_level > $user_level)) {
					$row['show_buttons'] = 0;
				} else {
					$row['show_buttons'] = 1;
				}
				$link_rows[] = $row;
			}
		}
		
		$_wpTpl =& new WordPresTpl('wp-admin');
		$_wpTpl->assign('selectLinkCatControl', $selectLinkCatControl);
		$_wpTpl->assign('selectOrderControl', $selectOrderControl);
		$_wpTpl->assign('ticketHiddenContorl', $ticketHiddenContorl);
		$_wpTpl->assign('selectSetLinkCatControl', $selectSetLinkCatControl);
		$_wpTpl->assign('selectSetUserControl', $selectSetUserControl);
		$_wpTpl->assign('helpLink', $helpLink);
		$_wpTpl->assign('link_rows', $link_rows);
		$_wpTpl->display('link-manager.html');

		include('admin-footer.php');
		break;
} // end case
?>
