<?php
// ------------------------------------------------------------------------- //
//                            myblocksadmin.php                              //
//                - XOOPS block admin for each modules -                     //
//                          GIJOE <http://www.peak.ne.jp/>                   //
// ------------------------------------------------------------------------- //

include_once( '../../../include/cp_header.php' ) ;
include_once( 'mygrouppermform.php' ) ;
include_once( XOOPS_ROOT_PATH.'/class/xoopsblock.php' ) ;


$xoops_system_url = XOOPS_URL . '/modules/system' ;
$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system' ;

// language files
$language = $xoopsConfig['language'] ;
if( ! file_exists( "$xoops_system_path/language/$language/admin/blocksadmin.php") ) $language = 'english' ;

include_once( "$xoops_system_path/constants.php" ) ;
include_once( "$xoops_system_path/language/$language/admin.php" ) ;
include_once( "$xoops_system_path/language/$language/admin/blocksadmin.php" ) ;
$group_defs = file( "$xoops_system_path/language/$language/admin/groups.php" ) ;
foreach( $group_defs as $def ) {
	if( strstr( $def , '_AM_ACCESSRIGHTS' ) || strstr( $def , '_AM_ACTIVERIGHTS' ) ) eval( $def ) ;
}


// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( XOOPS_URL.'/user.php' , 1 , _NOPERM ) ;

// check access right (needs system_admin of BLOCK)
$sysperm_handler =& xoops_gethandler('groupperm');
if (!$sysperm_handler->checkRight('system_admin', XOOPS_SYSTEM_BLOCK, $xoopsUser->getGroups())) redirect_header( XOOPS_URL.'/user.php' , 1 , _NOPERM ) ;

// get blocks owned by the module
$db =& Database::getInstance();
$sql = $sql = "SELECT * FROM ".$db->prefix("newblocks")." WHERE mid=". $xoopsModule->mid()." ORDER BY side,weight,bid";
$result = $db->query($sql);
$block_arr = array();
while( $myrow = $db->fetchArray($result) ) {
	$block_arr[] = new XoopsBlock($myrow);
}

function list_blocks()
{
	global $xoopsUser , $xoopsConfig , $xoopsDB , $xoopsModule ;
	global $block_arr , $xoops_system_url ;

	// displaying TH
	echo "
	<form action='admin.php' name='blockadmin' method='post'>
		<table width='90%' class='outer' cellpadding='4' cellspacing='1'>
		<tr valign='middle'>
			<th width='20%'>"._AM_BLKDESC."</th>
			<th>"._AM_TITLE."</th>
			<th align='center' nowrap='nowrap'>"._AM_SIDE."</th>
			<th align='center'>"._AM_WEIGHT."</th>
			<th align='center'>"._AM_VISIBLE."</th>
			<th align='center'>"._AM_ACTION."</th>
		</tr>\n" ;

	$mydirname = $xoopsModule->dirname() ;

	// blocks displaying loop
	$class = 'even' ;
	foreach( array_keys( $block_arr ) as $i ) {
		$sel0 = $sel1 = $ssel0 = $ssel1 = $ssel2 = $ssel3 = $ssel4 = "";

		$weight = $block_arr[$i]->getVar("weight") ;
		$name = $block_arr[$i]->getVar("name") ;
		$bid = $block_arr[$i]->getVar("bid") ;

		$title4edit = "<input type='text' name='title[$bid]' value='".$block_arr[$i]->getVar("title")."' size='20' />" ;
		$appendix_operations = "<a href='admin.php?fct=blocksadmin&amp;op=clone&amp;bid=$bid'>"._CLONE."</a>" ;
		if( $block_arr[$i]->getVar('block_type') == 'D' ) $appendix_operations .= "&nbsp;<a href='admin.php?fct=blocksadmin&amp;op=delete&amp;bid=$bid'>"._DELETE."</a>" ;

		if ( $block_arr[$i]->getVar("visible") == 1 ) {
			$sel1 = " checked='checked' style='background-color:#00FF00;'";
		} else {
			$sel0 = " checked='checked' style='background-color:#FF0000;'";
		}

		switch( $block_arr[$i]->getVar("side") ) {
			default :
			case XOOPS_SIDEBLOCK_LEFT :
				$ssel0 = " checked='checked' style='background-color:#00FF00;'";
				break ;
			case XOOPS_SIDEBLOCK_RIGHT :
				$ssel1 = " checked='checked' style='background-color:#00FF00;'";
				break ;
			case XOOPS_CENTERBLOCK_LEFT :
				$ssel2 = " checked='checked' style='background-color:#00FF00;'";
				break ;
			case XOOPS_CENTERBLOCK_RIGHT :
				$ssel4 = " checked='checked' style='background-color:#00FF00;'";
				break ;
			case XOOPS_CENTERBLOCK_CENTER :
				$ssel3 = " checked='checked' style='background-color:#00FF00;'";
				break ;
		}

		echo "
		<tr valign='top'>
			<td class='$class'>$name</td>
			<td class='$class'>$title4edit</td>
			<td class='$class' align='center' nowrap='nowrap'>
				<input type='radio' name='side[$bid]' value='".XOOPS_SIDEBLOCK_LEFT."'$ssel0 />-<input type='radio' name='side[$bid]' value='".XOOPS_CENTERBLOCK_LEFT."'$ssel2 /><input type='radio' name='side[$bid]' value='".XOOPS_CENTERBLOCK_CENTER."'$ssel3 /><input type='radio' name='side[$bid]' value='".XOOPS_CENTERBLOCK_RIGHT."'$ssel4 />-<input type='radio' name='side[$bid]' value='".XOOPS_SIDEBLOCK_RIGHT."'$ssel1 />
			</td>
			<td class='$class' align='center'>
				<input type='text' name=weight[$bid] value='$weight' size='5' maxlength='5' style='text-align:right;' />
			</td>
			<td class='$class' align='center' nowrap='nowrap'>
				<input type='radio' name='visible[$bid]' value='1'$sel1>"._YES."
				<input type='radio' name='visible[$bid]' value='0'$sel0>"._NO."
			</td>
			<td class='$class' align='left'>
				<a href='admin.php?fct=blocksadmin&amp;op=edit&amp;bid=$bid'>"._EDIT."</a>
				$appendix_operations
				<input type='hidden' name='bid[$bid]' value='$bid' />
			</td>
		</tr>\n" ;

		$class = ( $class == 'even' ) ? 'odd' : 'even' ;
	}

	echo "
		<tr>
			<td class='foot' align='center' colspan='6'>
				<input type='hidden' name='fct' value='blocksadmin' />
				<input type='hidden' name='op' value='order' />
				<input type='submit' name='submit' value='"._SUBMIT."' />
			</td>
		</tr>
		</table>
	</form>\n" ;
}


function list_groups()
{
	global $xoopsUser , $xoopsConfig , $xoopsDB ;
	global $xoopsModule , $block_arr , $xoops_system_url ;

	foreach( array_keys( $block_arr ) as $i ) {
		$item_list[ $block_arr[$i]->getVar("bid") ] = $block_arr[$i]->getVar("title") ;
	}

	$form = new MyXoopsGroupPermForm( _MD_AM_ADGS , 1 , 'block_read' , '' ) ;
	$form->addAppendix('module_admin',$xoopsModule->mid(),$xoopsModule->name().' '._AM_ACTIVERIGHTS);
	$form->addAppendix('module_read',$xoopsModule->mid(),$xoopsModule->name().' '._AM_ACCESSRIGHTS);
	foreach( $item_list as $item_id => $item_name) {
		$form->addItem( $item_id , $item_name ) ;
	}
	echo $form->render() ;
}



if( ! empty( $_POST['submit'] ) ) {
	include( "mygroupperm.php" ) ;
	redirect_header( XOOPS_URL."/modules/".$xoopsModule->dirname()."/admin/myblocksadmin.php" , 1 , _MD_AM_DBUPDATED );
}

xoops_cp_header() ;
if( file_exists( './mymenu.php' ) ) include( './mymenu.php' ) ;

echo "<h3 style='text-align:left;'>".$xoopsModule->name()."</h3>\n" ;
echo "<h4 style='text-align:left;'>"._AM_BADMIN."</h4>\n" ;
list_blocks() ;
list_groups() ;
xoops_cp_footer() ;

?>
