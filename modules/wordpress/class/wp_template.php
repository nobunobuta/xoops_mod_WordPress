<?php
require_once(XOOPS_ROOT_PATH.'/class/template.php');
class WordPresTpl extends XoopsTpl
{
	function WordPresTpl($tplbase="")
	{
		$this->XoopsTpl();
		$this->template_dir = wp_base().'/'.$tplbase.'/templates/';
		$this->error_reporting = error_reporting();
	}
}
?>