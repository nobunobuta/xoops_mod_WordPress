<?php
/* <Bookmarklet> */
// accepts 'post_title' and 'content' as vars passed in. Add-on from Alex King
require_once('admin.php');
$mode = 'bookmarklet';
$standalone = 1;
$title = "WordPress Bookmarklet";
require_once('admin-header.php');

if ($user_level == 0) {
	redirect_header($siteurl.'/wp-admin/',5,_LANG_P_CHEATING_ERROR);
	exit();
}

param('action','string','');

if ($action == 'done') {

?><html>
<head>
<script language="javascript" type="text/javascript">
<!--
window.close()
-->
</script>
</head>
<body></body>
</html><?php

} else {
	param('popuptitle','string','');
	param('popupurl','string','');
	param('text','html','');
	param('post_pingback','integer',0);

	$action = 'post';
	$pinged = "";
    $default_post_cat = get_settings('default_post_category');

    /* big funky fixes for browsers' javascript bugs */
    $popuptitle = fix_js_param($popuptitle);
    $text = fix_js_param($text);

	$popuptitle = sanitize_text($popuptitle);
	$text = sanitize_text($text,true);
	$popupurl = sanitize_text($popupurl,true, true);
	
    $post_title = $popuptitle;
    $edited_post_title = $post_title;
    $content = '<a href="'.$popupurl.'">'.$popuptitle.'</a>'."\n$text";
    
// autodetect Trackback

	$tb_obj = new TrackBack_XMS_collection;
	$trackback_url = $tb_obj->get($popupurl);
	$target_charset = $tb_obj->charset;
	
	$css_file = get_custom_url('wp-admin.css');
	$xoops_css = xoops_getcss($xoopsConfig['theme_set']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WordPress > Bookmarklet</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset ?>" />
<link rel="stylesheet" href="<?php echo $xoops_css ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo $css_file ?>" type="text/css" />
<link rel="shortcut icon" href="../wp-images/wp-favicon.png" />
<script type="text/javascript" language="javascript">
<!--
function launchupload() {
	window.open ("upload.php", "wpupload", "width=380,height=360,location=0,menubar=0,resizable=1,scrollbars=yes,status=1,toolbar=0");
}

//-->
</script>
<style type="text/css">
<!--
#wpbookmarklet textarea,input,select {
	border-width: 1px;
	border-style: solid;
	padding: 2px;
	margin: 1px;
}

#wpbookmarklet .checkbox {
	border-width: 0px;
	padding: 0px;
	margin: 0px;
}

#wpbookmarklet textarea {
	height:180px;
}

#wpbookmarklet .wrap {
    border: 0px;
}	

#wpbookmarklet #postdiv {
    margin-bottom: 0.5em;
}

#wpbookmarklet #titlediv {
    margin-bottom: 1em;
}

-->
</style>
</head>
<body id="wpbookmarklet">
<h2>New Post to "<?php echo get_settings('blogname');?>"</h2>
<div id="wpAdminMain">
<?php require('edit-form.php'); ?>
</div>
</body>
</html>
<?php
}
// 埋め込まれたデータから TrackBack Ping urlを取得するクラス
class TrackBack_XMS_collection
{
	var $url;
	var $xml_parts;
	var $charset;
	var $tb_urls;
	var $tb_url;

	function TrackBack_XML_collection($url="") {
		if ($url) {
			$this->url = preg_replace('|/+$|', '', $url);
		}
		$this->xml_parts = array();
		$this->tb_urls = array();
	}
	
	function get_content($url) {
		if ($url) {
			$this->url = preg_replace('|/+$|', '', $url);
		}
		$fp = fopen($this->url,"r");
		if ($fp) {
			$tb_contents = "";
			while( $tb_data = fread($fp, 8192) ) {
				$tb_contents .= $tb_data;
			}
			if (function_exists('mb_detect_encoding')) {
				$this->charset = mb_detect_encoding($tb_contents,"auto");
			}
			fclose ($fp);
			if (preg_match_all('#<rdf:RDF[^>]*>(.*?)</rdf:RDF>#si',$tb_contents,$matches,PREG_PATTERN_ORDER)) {
				foreach($matches[1] as $tb_body) {
					$this->xml_parts[] = $tb_body;
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	function get($url) {
		if ($this->get_content($url)) {
			$obj = new TrackBack_XML();
			$this->tb_urls = array();
			$this->tb_url = "";
			foreach($this->xml_parts as $xmlpart) {
				$tb_obj = $obj->parse($xmlpart,$this->url);
				$this->tb_urls[] = $tb_obj;
				if ($tb_obj['match']) {
					$this->tb_url = $tb_obj['url'];
				}
			}
		}
		return $this->tb_url;
	}
}
class TrackBack_XML
{
	var $url;
	var $tb_url;
	var $tb_url_nc;
	var $tb_title;
	var $match_url;

	function parse($buf,$url) {
		// 初期化
		$this->url = preg_replace('|/+$|', '', $url);
		$this->tb_url = "";
		$this->tb_title = "";
		$this->match_url = false;
		
		$xml_parser = xml_parser_create();
		if ($xml_parser === FALSE) {
			return FALSE;
		}
		xml_set_element_handler($xml_parser,array(&$this,'start_element'),array(&$this,'end_element'));
		
		if (!xml_parse($xml_parser,$buf,TRUE)) {
			return FALSE;
		}
		return array('url'=>$this->tb_url,'title'=>$this->tb_title,'match'=>$this->match_url);
	}
	function start_element($parser,$name,$attrs)
	{
		if ($name !== 'RDF:DESCRIPTION') {
			return;
		}
		$about = $url = $tb_url = '';
		foreach ($attrs as $key=>$value) {
			switch ($key) {
				case 'RDF:ABOUT':
					$about = preg_replace('|/+$|', '', $value);
					break;
				case 'DC:IDENTIFER':
				case 'DC:IDENTIFIER':
					$url = preg_replace('|/+$|', '', $value);
					break;
				case 'DC:TITLE':
					$this->tb_title = $value;
					break;
				case 'TRACKBACK:PING':
					$this->tb_url = $value;
					break;
			}
		}
		if ($about == $this->url || $url == $this->url) {
			$this->match_url = true;
		} else {
			$this->match_url = false;
		}
	}
	function end_element($parser,$name)
	{
		// do nothing
	}
}
?>
