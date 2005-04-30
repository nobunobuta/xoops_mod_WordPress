<?php
$GLOBALS['mimetypes'] = array(
	'jpg'=>'image/jpeg' ,
	'jpg'=>'image/jpeg' ,
	'gif'=>'image/gif' ,
	'png'=>'image/png' ,
	'pdf'=>'application/pdf' ,
	'swf'=>'application/x-shockwave-flash' ,
	'mpg'=>'video/mpg' ,
	'rm'=>'application/vnd.rn-realmedia' ,
	'mov'=>'video/quicktime' ,
	'avi'=>'video/avi' ,
	'wmv'=>'video/x-ms-wmv' ,
	'mp3'=>'audio/mp3' ,
	'wav'=>'audio/wav' ,
	'wave'=>'audio/wav' ,
	'ra'=>'audio/vnd.rn-realaudio' ,
	'ram'=>'audio/vnd.rn-realaudio' ,
	'mid'=>'audio/midi' ,
	'midi'=>'audio/midi' ,
	'zip'=>'application/x-zip-compressed' ,
	'lzh'=>'application/x-lzh-compressed' ,
	'gz'=>'application/x-gzip' ,
	'bz2'=>'application/x-bz2-compressed' ,
	'z'=>'application/x-compress' ,
	'tgz'=>'application/x-compress' ,
	'cab'=>'application/x-cab-compressed' ,
	'sit'=>'application/x-stuffit' ,
	'tar'=>'application/x-tar' ,
	'txt'=>'text/plain' ,
	'text'=>'text/plain' ,
	'dat'=>'text/plain' ,
	'jis'=>'text/plain' ,
	'euc'=>'text/plain' ,
	'sjis'=>'text/plain' ,
	'sjs'=>'text/plain' ,
	'asc'=>'text/plain' ,
	'utf'=>'text/plain' ,
	'utf8'=>'text/plain' ,
	'csv'=>'text/plain' ,
	'html'=>'text/html' ,
	'htm'=>'text/html' ,
	'svg'=>'image/svg-xml' ,
	'exe'=>'application/ms-download' ,
	'doc'=>'application/ms-word' ,
	'xls'=>'application/ms-excel' ,
	'mdb'=>'application/ms-access' ,
	'mde'=>'application/ms-access' ,
	'ppt'=>'application/ms-powerpoint' ,
	'pps'=>'application/ms-powerpoint' ,
);

require_once(dirname(__FILE__) . '/wp-config.php');
$fname=urldecode($_GET['fname']);
$from=$_GET['from'];
$file=get_settings('fileupload_realpath').'/'.$from;
if ($GLOBALS['is_IE']) {
	$fname=mb_conv($fname,'SJIS',get_settings('blog_charset'));
}

$obj = &new DocumentFile($file);
if ($obj->getstatus()) {
	$obj->download($fname);
}

//-------- クラス
//ファイル
class DocumentFile
{
	var $page,$file,$age,$basename,$filename,$logname;
	var $time = 0;
	var $size = 0;
	var $time_str = '';
	var $size_str = '';
	var $status = array('count'=>array(0),'age'=>'','pass'=>'','freeze'=>FALSE);
	
	function DocumentFile($filename)
	{
		$this->file = basename($filename);
		$this->filename = $filename;
		$this->exist = file_exists($this->filename);
	}
//
	function getstatus()
	{
		if (!$this->exist)
		{
			return FALSE;
		}
		$this->size = filesize($this->filename);
		$this->size_str = sprintf('%01.1f',round($this->size)/1000,1).'KB';
		$this->type = document_mime_content_type($this->filename);
		
		return TRUE;
	}
	function download($fname)
	{
		$this->getstatus();
		
		$fname = htmlspecialchars($fname);
		header('Content-Disposition: attachment; filename="'.$fname.'"');
		header('Content-Length: '.$this->size);
		header('Content-Type: '.$this->type.'; charset=Shift_JIS');
		@readfile($this->filename);
		exit;
	}
}
// mime-typeを記述したページ
define('ATTACH_CONFIG_PAGE_MIME','plugin/attach/mime-type');

//-------- サービス
//mime-typeの決定
function document_mime_content_type($filename)
{
	$filename_info = pathinfo($filename);
	$filename_ext = $filename_info['extension'];
	
	$mimetype = 'application/octet-stream'; //default
	if (array_key_exists($filename_ext, $GLOBALS['mimetypes'])) {
		$mimetype = $GLOBALS['mimetypes'][$filename_ext];
	}
	return $mimetype;
}
?>
