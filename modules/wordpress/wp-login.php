<?php
	include_once '../../mainfile.php';
	if ($xoopsUser) {
		$loc = "/modules/wordpress/";
	} else {
		$loc = "/user.php";
	}
	redirect_header($loc, 1, "");
?>
