<?php 
include("../../../include/cp_header.php");
header("Location: ".XOOPS_URL."/modules/system/admin.php?fct=blocksadmin&selmod=".$xoopsModule->getVar("mid"));
?>