<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

if ( !is_object($xoopsUser) || !is_object($xoopsModule) || !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
	exit("Access Denied");
}
include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
include XOOPS_ROOT_PATH."/modules/system/admin/blocksadmin/blocksadmin.php";

$op = "list";
if ( isset($_POST) ) {
	foreach ( $_POST as $k => $v ) {
		$$k = $v;
  	}
}

if ( isset($_GET['op']) ) {
	if ($_GET['op'] == "edit" || $_GET['op'] == "delete" || $_GET['op'] == "delete_ok" || $_GET['op'] == "clone" || $_GET['op'] == 'previewpopup') {
		$op = $_GET['op'];
		$bid = isset($_GET['bid']) ? intval($_GET['bid']) : 0;
	}
}

if (isset($previewblock)) {
	xoops_cp_header();
	include_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl();
	$xoopsTpl->xoops_setCaching(0);
	if (isset($bid)) {
		$block['bid'] = $bid;
		$block['form_title'] = _AM_EDITBLOCK;
		$myblock = new XoopsBlock($bid);
		$block['name'] = $myblock->getVar('name');
	} else {
		if ($op == 'save') {
			$block['form_title'] = _AM_ADDBLOCK;
		} else {
			$block['form_title'] = _AM_CLONEBLOCK;
		}
		$myblock = new XoopsBlock();
		$myblock->setVar('block_type', 'C');
	}
	$myts =& MyTextSanitizer::getInstance();
	$myblock->setVar('title', $myts->stripSlashesGPC($btitle));
	$myblock->setVar('content', $myts->stripSlashesGPC($bcontent));
	$dummyhtml = '<html><head><meta http-equiv="content-type" content="text/html; charset='._CHARSET.'" /><meta http-equiv="content-language" content="'._LANGCODE.'" /><title>'.$xoopsConfig['sitename'].'</title><link rel="stylesheet" type="text/css" media="all" href="'.getcss($xoopsConfig['theme_set']).'" /></head><body><table><tr><th>'.$myblock->getVar('title').'</th></tr><tr><td>'.$myblock->getContent('S', $bctype).'</td></tr></table></body></html>';

	$dummyfile = '_dummyfile_'.time().'.html';
	$fp = fopen(XOOPS_CACHE_PATH.'/'.$dummyfile, 'w');
	fwrite($fp, $dummyhtml);
	fclose($fp);
	$block['edit_form'] = false;
	$block['template'] = '';
	$block['op'] = $op;
	$block['side'] = $bside;
	$block['weight'] = $bweight;
	$block['visible'] = $bvisible;
	$block['title'] = $myblock->getVar('title', 'E');
	$block['content'] = $myblock->getVar('content', 'E');
	$block['modules'] =& $bmodule;
	$block['ctype'] = isset($bctype) ? $bctype : $myblock->getVar('c_type');
	$block['is_custom'] = true;
	$block['cachetime'] = intval($bcachetime);
	echo '<a href="admin.php?fct=blocksadmin">'. _AM_BADMIN .'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'.$block['form_title'].'<br /><br />';
	include XOOPS_ROOT_PATH.'/modules/system/admin/blocksadmin/blockform.php';
	$form->display();
	xoops_cp_footer();
	echo '<script type="text/javascript">
	<!--//
	preview_window = openWithSelfMain("'.XOOPS_URL.'/modules/system/admin.php?fct=blocksadmin&op=previewpopup&file='.$dummyfile.'", "popup", 250, 200);
	//-->
	</script>';
	exit();
}

if ($op == 'previewpopup') {
	$file = str_replace('..', '', XOOPS_CACHE_PATH.'/'.trim($_GET['file']));
	if (file_exists($file)) {
		include $file;
		@unlink($file);
	}
	exit();
}

if ( $op == "list" ) {
	xoops_cp_header();
	list_blocks();
	xoops_cp_footer();
	exit();
}
if ( $op == "order" ) {
	foreach (array_keys($bid) as $i) {
		if( $side[$i] < 0 ) {
			$visible[$i] = 0 ;
			$side[$i] = -1 ;
		} else {
			$visible[$i] = 1 ;
		}

		$bmodule[$i] = (isset($bmodule[$i]) && is_array($bmodule[$i])) ? $bmodule[$i] : array(-1) ;

		myblocksadmin_update_block($i, $side[$i], $weight[$i], $visible[$i], $title[$i], '', '', $bcachetime[$i], $bmodule[$i], array());

//		if ( $oldweight[$i] != $weight[$i] || $oldvisible[$i] != $visible[$i] || $oldside[$i] != $side[$i] )
//		order_block($bid[$i], $weight[$i], $visible[$i], $side[$i]); GIJ
	}
//	redirect_header("admin.php?fct=blocksadmin",1,_AM_DBUPDATED); GIJ
	redirect_header("myblocksadmin.php",1,_AM_DBUPDATED);
	exit();
}
if ( $op == "save" ) {
	save_block($bside, $bweight, $bvisible, $btitle, $bcontent, $bctype, $bmodule, $bcachetime);
	exit();
}

if ( $op == "update" ) {
	$bcachetime = isset($bcachetime) ? intval($bcachetime) : 0;
	
	if( empty($options) ) $options = array();
	else if( ! is_array( $options ) ) $options = explode( '|' , $options ) ;

	$bcontent = isset($bcontent) ? $bcontent : '';
	$bctype = isset($bctype) ? $bctype : '';
//	update_block($bid, $bside, $bweight, $bvisible, $btitle, $bcontent, $bctype, $bcachetime, $bmodule, $options);
	global $xoopsConfig;
	if (empty($bmodule)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_NOTSELNG, _AM_VISIBLEIN));
		xoops_cp_footer();
		exit();
	}
	$myblock = new XoopsBlock($bid);
	$myblock->setVar('side', $bside);
	$myblock->setVar('weight', $bweight);
	$myblock->setVar('visible', $bvisible);
	$myblock->setVar('title', $btitle);
	$myblock->setVar('content', $bcontent);
	$myblock->setVar('bcachetime', $bcachetime);
	if ( isset($options) && (count($options) > 0) ) {
		$options = implode('|', $options);
		$myblock->setVar('options', $options);
	}
	if ($myblock->getVar('block_type') == 'C') {
		switch ($bctype) {
		case 'H':
			$name = _AM_CUSTOMHTML;
			break;
		case 'P':
			$name = _AM_CUSTOMPHP;
			break;
		case 'S':
			$name = _AM_CUSTOMSMILE;
			break;
		default:
			$name = _AM_CUSTOMNOSMILE;
			break;
		}
		$myblock->setVar('name', $name);
		$myblock->setVar('c_type', $bctype);
	} else {
		$myblock->setVar('c_type', 'H');
	}
	$msg = _AM_DBUPDATED;
	if ($myblock->store() != false) {
		$db =& Database::getInstance();
		$sql = sprintf("DELETE FROM %s WHERE block_id = %u", $db->prefix('block_module_link'), $bid);
		$db->query($sql);
		foreach ($bmodule as $bmid) {
			$sql = sprintf("INSERT INTO %s (block_id, module_id) VALUES (%u, %d)", $db->prefix('block_module_link'), $bid, intval($bmid));
			$db->query($sql);
		}
		include_once XOOPS_ROOT_PATH.'/class/template.php';
		$xoopsTpl = new XoopsTpl();
		$xoopsTpl->xoops_setCaching(2);
		if ($myblock->getVar('template') != '') {
			if ($xoopsTpl->is_cached('db:'.$myblock->getVar('template'))) {
				if (!$xoopsTpl->clear_cache('db:'.$myblock->getVar('template'))) {
					$msg = 'Unable to clear cache for block ID'.$bid;
				}
			}
		} else {
			if ($xoopsTpl->is_cached('db:system_dummy.html', 'block'.$bid)) {
				if (!$xoopsTpl->clear_cache('db:system_dummy.html', 'block'.$bid)) {
					$msg = 'Unable to clear cache for block ID'.$bid;
				}
			}
		}
	} else {
		$msg = 'Failed update of block. ID:'.$bid;
	}
	redirect_header('myblocksadmin.php',1,$msg);
	exit();
}


if ( $op == "delete_ok" ) {
//	delete_block_ok($bid);
	$myblock = new XoopsBlock($bid);

	if ( $myblock->getVar('block_type') == 'S' ) {
		$message = _AM_SYSTEMCANT;
		redirect_header('admin.php?fct=blocksadmin',4,$message);
		exit();
	} elseif ($myblock->getVar('block_type') == 'M') {
		$message = _AM_MODULECANT;
		redirect_header('admin.php?fct=blocksadmin',4,$message);
		exit();
	} else {
		$myblock->delete();
		redirect_header('myblocksadmin.php',1,_AM_DBUPDATED);
		exit();
	}
}

if ( $op == "delete" ) {
    xoops_cp_header();

	$myblock = new XoopsBlock($bid);

	if ( $myblock->getVar('block_type') == 'S' ) {
		$message = _AM_SYSTEMCANT;
		redirect_header('admin.php?fct=blocksadmin',4,$message);
		exit();
	} elseif ($myblock->getVar('block_type') == 'M') {
		$message = _AM_MODULECANT;
		redirect_header('admin.php?fct=blocksadmin',4,$message);
		exit();
	} else {
		xoops_confirm(array('fct' => 'blocksadmin', 'op' => 'delete_ok', 'bid' => $myblock->getVar('bid')), 'admin.php', sprintf(_AM_RUSUREDEL,$myblock->getVar('title')));
	}

    xoops_cp_footer();
	exit();
}


if ( $op == "edit" ) {
    xoops_cp_header();

	$myblock = new XoopsBlock($bid);
	$db =& Database::getInstance();
	$sql = 'SELECT module_id FROM '.$db->prefix('block_module_link').' WHERE block_id='.intval($bid);
	$result = $db->query($sql);
	$modules = array();
	while ($row = $db->fetchArray($result)) {
		$modules[] = intval($row['module_id']);
	}
	$is_custom = ($myblock->getVar('block_type') == 'C' || $myblock->getVar('block_type') == 'E') ? true : false;
	$block = array('form_title' => _AM_EDITBLOCK, 'name' => $myblock->getVar('name'), 'side' => $myblock->getVar('side'), 'weight' => $myblock->getVar('weight'), 'visible' => $myblock->getVar('visible'), 'title' => $myblock->getVar('title', 'E'), 'content' => $myblock->getVar('content', 'E'), 'modules' => $modules, 'is_custom' => $is_custom, 'ctype' => $myblock->getVar('c_type'), 'cachetime' => $myblock->getVar('bcachetime'), 'op' => 'update', 'bid' => $myblock->getVar('bid'), 'edit_form' => $myblock->getOptions(), 'template' => $myblock->getVar('template'), 'options' => $myblock->getVar('options'));
	echo '<a href="myblocksadmin.php">'. _AM_BADMIN .'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'._AM_EDITBLOCK.'<br /><br />';
	include 'blockform.php';
	$form->display();

    xoops_cp_footer();
	exit();
}


if ($op == 'clone') {
	xoops_cp_header();
	$myblock = new XoopsBlock($bid);

	$db =& Database::getInstance();
	$sql = 'SELECT module_id FROM '.$db->prefix('block_module_link').' WHERE block_id='.intval($bid);
	$result = $db->query($sql);
	$modules = array();
	while ($row = $db->fetchArray($result)) {
		$modules[] = intval($row['module_id']);
	}
	$is_custom = ($myblock->getVar('block_type') == 'C' || $myblock->getVar('block_type') == 'E') ? true : false;
	$block = array('form_title' => _AM_CLONEBLOCK, 'name' => $myblock->getVar('name'), 'side' => $myblock->getVar('side'), 'weight' => $myblock->getVar('weight'), 'visible' => $myblock->getVar('visible'), 'content' => $myblock->getVar('content', 'N'), 'title' => $myblock->getVar('title','E'), 'modules' => $modules, 'is_custom' => $is_custom, 'ctype' => $myblock->getVar('c_type'), 'cachetime' => $myblock->getVar('bcachetime'), 'op' => 'clone_ok', 'bid' => $myblock->getVar('bid'), 'edit_form' => $myblock->getOptions(), 'template' => $myblock->getVar('template'), 'options' => $myblock->getVar('options'));
	echo '<a href="admin.php?fct=blocksadmin">'. _AM_BADMIN .'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'._AM_CLONEBLOCK.'<br /><br />';
	include 'blockform.php';
	$form->display();
	xoops_cp_footer();
	exit();
}


if ($op == 'clone_ok') {
	$block = new XoopsBlock($bid);

	if( empty($options) ) $options = array();
	elseif( ! is_array( $options ) ) $options = explode( '|' , $options ) ;

	if (method_exists($block, 'xoopsClone')) {
		$clone =& $block->xoopsClone();
	} else {
		$clone =& $block->clone();
	}
	if (empty($bmodule)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_NOTSELNG, _AM_VISIBLEIN));
		xoops_cp_footer();
		exit();
	}
	$clone->setVar('side', $bside);
	$clone->setVar('weight', $bweight);
	$clone->setVar('visible', $bvisible);
	$clone->setVar('title', $btitle);
	$clone->setVar('bcachetime', $bcachetime);
	if ( isset($options) && (count($options) > 0) ) {
		$options = implode('|', $options);
		$clone->setVar('options', $options);
	}
	$clone->setVar('bid', 0);
	$clone->setVar('block_type', 'D');
	$newid = $clone->store();
	if (!$newid) {
		xoops_cp_header();
		$clone->getHtmlErrors();
		xoops_cp_footer();
		exit();
	}
	$db =& Database::getInstance();
	foreach ($bmodule as $bmid) {
		$sql = 'INSERT INTO '.$db->prefix('block_module_link').' (block_id, module_id) VALUES ('.$newid.', '.$bmid.')';
		$db->query($sql);
	}

	$sql = "SELECT gperm_groupid FROM ".$db->prefix('group_permission')." WHERE gperm_name='block_read' AND gperm_modid='1' AND gperm_itemid='$bid'" ;
	$result = $db->query($sql);
	while( list( $gid ) = $db->fetchRow( $result ) ) {
		$sql = "INSERT INTO ".$db->prefix('group_permission')." (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) VALUES ($gid, $newid, 1, 'block_read')";
		$db->query($sql);
	}

	redirect_header('myblocksadmin.php',1,_AM_DBUPDATED);
}

	// import from modules/system/admin/blocksadmin/blocksadmin.php
	function myblocksadmin_update_block($bid, $bside, $bweight, $bvisible, $btitle, $bcontent, $bctype, $bcachetime, $bmodule, $options=array())
	{
		global $xoopsConfig;
		if (empty($bmodule)) {
			xoops_cp_header();
			xoops_error(sprintf(_AM_NOTSELNG, _AM_VISIBLEIN));
			xoops_cp_footer();
			exit();
		}
		$myblock = new XoopsBlock($bid);
		if( $bside >= 0 ) $myblock->setVar('side', $bside);
		$myblock->setVar('weight', $bweight);
		$myblock->setVar('visible', $bvisible);
		$myblock->setVar('title', $btitle);
		$myblock->setVar('content', $bcontent);
		$myblock->setVar('bcachetime', $bcachetime);
		if ( isset($options) && (count($options) > 0) ) {
			$options = implode('|', $options);
			$myblock->setVar('options', $options);
		}
		if ($myblock->getVar('block_type') == 'C') {
			switch ($bctype) {
			case 'H':
				$name = _AM_CUSTOMHTML;
				break;
			case 'P':
				$name = _AM_CUSTOMPHP;
				break;
			case 'S':
				$name = _AM_CUSTOMSMILE;
				break;
			default:
				$name = _AM_CUSTOMNOSMILE;
				break;
			}
			$myblock->setVar('name', $name);
			$myblock->setVar('c_type', $bctype);
		} else {
			$myblock->setVar('c_type', 'H');
		}
		$msg = _AM_DBUPDATED;
		if ($myblock->store() != false) {
			$db =& Database::getInstance();
			$sql = sprintf("DELETE FROM %s WHERE block_id = %u", $db->prefix('block_module_link'), $bid);
			$db->query($sql);
			foreach ($bmodule as $bmid) {
				$sql = sprintf("INSERT INTO %s (block_id, module_id) VALUES (%u, %d)", $db->prefix('block_module_link'), $bid, intval($bmid));
				$db->query($sql);
			}
			include_once XOOPS_ROOT_PATH.'/class/template.php';
			$xoopsTpl = new XoopsTpl();
			$xoopsTpl->xoops_setCaching(2);
			if ($myblock->getVar('template') != '') {
				if ($xoopsTpl->is_cached('db:'.$myblock->getVar('template'))) {
					if (!$xoopsTpl->clear_cache('db:'.$myblock->getVar('template'))) {
						$msg = 'Unable to clear cache for block ID'.$bid;
					}
				}
			} else {
				if ($xoopsTpl->is_cached('db:system_dummy.html', 'block'.$bid)) {
					if (!$xoopsTpl->clear_cache('db:system_dummy.html', 'block'.$bid)) {
						$msg = 'Unable to clear cache for block ID'.$bid;
					}
				}
			}
		} else {
			$msg = 'Failed update of block. ID:'.$bid;
		}
		return $msg ;
	}

?>