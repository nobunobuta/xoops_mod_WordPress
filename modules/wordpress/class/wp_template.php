<?php
if( ! class_exists( 'WordPresTpl' ) ) {
require_once(XOOPS_ROOT_PATH.'/class/template.php');
class WordPresTpl extends XoopsTpl
{
	var $tplbase;
	function WordPresTpl($tplbase="")
	{
		$this->XoopsTpl();
		$this->tplbase = $tplbase;
		$this->error_reporting = error_reporting();
	}
	function tpl_exists($tplfile='')
	{
		if (empty($tplfile)) return false;
		if ($this->tplbase == 'base') {
			$tpldir = wp_base().'/templates';
		} else if ($this->tplbase == 'theme') {
			$tplpath = get_custom_path('templates/'.$tplfile);
			$tpldir = dirname($tplpath);
			$tplfile = basename($tplpath);
		} else {
			$tpldir = wp_base().'/'.$this->tplbase.'/templates';
		}
		return file_exists($tpldir.'/'.$tplfile);
	}
	function fetch($tplfile, $cache_id = null, $compile_id = null, $display = false)
	{
		if ($this->tplbase == 'base') {
			$tpldir = wp_base().'/templates';
		} else if ($this->tplbase == 'theme') {
			$tplpath = get_custom_path('templates/'.$tplfile);
			$tpldir = dirname($tplpath);
			$tplfile = basename($tplpath);
		} else {
			$tpldir = wp_base().'/'.$this->tplbase.'/templates';
		}
		$this->template_dir = $tpldir;
		if (!$compile_id) {
			if ($this->tplbase == 'theme') {
				$compile_id = wp_prefix().$GLOBALS['xoopsConfig']['theme_set'].'_';
			} else {
				$compile_id = wp_prefix().$this->tplbase.'_';
			}
		}
		return parent::fetch($tplfile, $cache_id, $compile_id, $display);
	}
}
}
?>