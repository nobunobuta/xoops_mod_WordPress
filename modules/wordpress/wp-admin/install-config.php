<?php
	include_once '../../../mainfile.php';
	if ($xoopsUser) {
		$loc = XOOPS_URL."/modules/". basename(dirname(dirname(__FILE__)));
	} else {
		$loc = XOOPS_URL."/";
	}
	redirect_header($loc, 1, "This function is not available in XOOPS Environment.");
?>
