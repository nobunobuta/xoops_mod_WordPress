<?php
//Hacked by nobunobu  Keep Block option values when update
if($_POST) {
	if(($_POST['fct']=='modulesadmin')&&($_POST['op']=='update_ok')&&($_POST['dirname']==$modversion['dirname'])) {
		global $xoopsDB, $msgs;
		$query = "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname='".$modversion['dirname']."' ";
		$result = $xoopsDB->query($query);
		$record= $xoopsDB->fetcharray($result);
		if ($record) {
			$mid = $record['mid'];
			$sql = "SELECT * FROM ".$xoopsDB->prefix('newblocks')." WHERE mid=".$mid." AND block_type ='D'";
			$fresult = $xoopsDB->query($sql);
			$count = count($modversion['blocks']);
			$n_funcnum = $count;
			while ($fblock = $xoopsDB->fetchArray($fresult)) {
				$bnum = 0;
				for ($i = 1 ; $i <= $count ; $i++) {
					if (($modversion['blocks'][$i]['file'] == $fblock['func_file']) and ($modversion['blocks'][$i]['show_func'] == $fblock['show_func'])) {
						$bnum = $i;
						break;
					}
				}
				if($bnum) {
					$n_funcnum++;
					$modversion['blocks'][$n_funcnum]['file'] = $fblock['func_file'];
					$modversion['blocks'][$n_funcnum]['name'] = $fblock['name'];
					$modversion['blocks'][$n_funcnum]['description'] = $fblock['name'];
					$modversion['blocks'][$n_funcnum]['show_func'] = $fblock['show_func'];
					$modversion['blocks'][$n_funcnum]['edit_func'] = $fblock['edit_func'];
					$modversion['blocks'][$n_funcnum]['template'] = $fblock['name'];
					if ($fblock['options']) {
						$old_vals=explode("|",$fblock['options']);
						$def_vals=explode("|",$modversion['blocks'][$bnum]['options']);
						if (count($old_vals) == count($def_vals)) {
							$modversion['blocks'][$n_funcnum]['options'] = $fblock['options'];
							$msgs[] = "Duplicated Block options for <b>".$fblock['name']."</b> will be kept. (value = <b>".$fblock['options']."</b>)";
						} else if (count($old_vals) < count($def_vals)){
							for ($j=0; $j < count($old_vals); $j++) {
								$def_vals[$j] = $old_vals[$j];
							}
							$modversion['blocks'][$n_funcnum]['options'] = implode("|",$def_vals);
							$msgs[] = "Duplicateted Block options for <b>".$fblock['name']."</b> will be kept and add new option value. (value = <b>".$modversion['blocks'][$fblock['func_num']]['options']."</b>)";
						} else {
							$modversion['blocks'][$n_funcnum]['options'] = implode("|",$def_vals);
							$msgs[] = "Duplicateted Block options for <b>".$fblock['name']."</b> will be reset to default, because number of options decrease. (value = <b>".$modversion['blocks'][$n_funcnum]['options']."</b>)";
						}
					}
					$sql = "UPDATE ".$xoopsDB->prefix('newblocks')." SET func_num='$n_funcnum' WHERE mid=".$mid." AND bid='".$fblock['bid']."'";
					$iret = $xoopsDB->query($sql);

				}
			}
			$sql = "SELECT * FROM ".$xoopsDB->prefix('newblocks')." WHERE mid=".$mid." AND block_type <>'D' AND func_num > $count";
			$fresult = $xoopsDB->query($sql);
			while ($fblock = $xoopsDB->fetchArray($fresult)) {
				$msgs[] = "Non Defined Block <b>".$fblock['name']."</b> will be deleted";
				$sql = "DELETE FROM ".$xoopsDB->prefix('newblocks')." WHERE bid='".$fblock['bid']."'";
				$iret = $xoopsDB->query($sql);
			}			
			
			for ($i = 1 ; $i <= $count ; $i++) {
				$sql = "SELECT name,options FROM ".$xoopsDB->prefix('newblocks')." WHERE mid=".$mid." AND func_num=".$i." AND show_func='".addslashes($modversion['blocks'][$i]['show_func'])."' AND func_file='".addslashes($modversion['blocks'][$i]['file'])."'";
				$fresult = $xoopsDB->query($sql);
				$fblock = $xoopsDB->fetchArray($fresult);
				if ($fblock['options']) {
					$old_vals=explode("|",$fblock['options']);
					$def_vals=explode("|",$modversion['blocks'][$i]['options']);
					if (count($old_vals) == count($def_vals)) {
						$modversion['blocks'][$i]['options'] = $fblock['options'];
						$msgs[] = "Block options for <b>".$fblock['name']."</b> will be kept. (value = <b>".$fblock['options']."</b>)";
					} else if (count($old_vals) < count($def_vals)){
						for ($j=0; $j < count($old_vals); $j++) {
							$def_vals[$j] = $old_vals[$j];
						}
						$modversion['blocks'][$i]['options'] = implode("|",$def_vals);
						$msgs[] = "Block options for <b>".$fblock['name']."</b> will be kept and add new option value. (value = <b>".$modversion['blocks'][$i]['options']."</b>)";
					} else {
						$msgs[] = "Block options for <b>".$fblock['name']."</b> will be reset to default, because number of options decrease. (value = <b>".$modversion['blocks'][$i]['options']."</b>)";
					}
				}
			}
		}
	}
}
?>