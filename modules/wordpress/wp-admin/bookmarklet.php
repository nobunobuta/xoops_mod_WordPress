<?php
/* <Bookmarklet> */

// accepts 'post_title' and 'content' as vars passed in. Add-on from Alex King

$mode = 'bookmarklet';

$standalone = 1;
require_once('admin-header.php');

if ($user_level == 0)
	die ("Cheatin' uh?");

if ('b' == $a) {

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

//    $popuptitle = stripslashes($popuptitle);
//    $text = stripslashes($text);

	$popuptitle = sanitize_text($popuptitle);
	$text = sanitize_text($text,true);
	$popupurl = sanitize_text($popupurl,true, true);
	
    /* big funky fixes for browsers' javascript bugs */
    
    if (($is_macIE) && (!isset($IEMac_bookmarklet_fix))) {
        $popuptitle = preg_replace($wp_macIE_correction["in"],$wp_macIE_correction["out"],$popuptitle);
        $text = preg_replace($wp_macIE_correction["in"],$wp_macIE_correction["out"],$text);
    }
    
    if (($is_winIE) && (!isset($IEWin_bookmarklet_fix))) {
        $popuptitle =  preg_replace("/\%u([0-9A-F]{4,4})/e",  "'&#'.base_convert('\\1',16,10).';'", $popuptitle);
        $text =  preg_replace("/\%u([0-9A-F]{4,4})/e",  "'&#'.base_convert('\\1',16,10).';'", $text);
    }
    
    if (($is_gecko) && (!isset($Gecko_bookmarklet_fix))) {
        $popuptitle = preg_replace($wp_gecko_correction["in"],$wp_gecko_correction["out"],$popuptitle);
        $text = preg_replace($wp_gecko_correction["in"],$wp_gecko_correction["out"],$text);
    }
    
    $post_title = $_REQUEST['post_title'];
    if (!empty($post_title)) {
//        $post_title =  stripslashes($post_title);
        $post_title =  sanitize_text($post_title);
    } else {
        $post_title = $popuptitle;
    }
// I'm not sure why we're using $edited_post_title in the edit-form.php, but we are
// and that is what is being included below. For this reason, I am just duplicating
// the var instead of changing the assignment on the lines above. 
// -- Alex King 2004-01-07
    $edited_post_title = $post_title;
    
    $content = $_REQUEST['content'];
    if (!empty($content)) {
        $content =  stripslashes($content);
    } else {
        $content = '<a href="'.$popupurl.'">'.$popuptitle.'</a>'."\n$text";
    }
    
    /* /big funky fixes */
// autodetect Trackback
	$fp = fopen($popupurl,"r");
	if ($fp) {
		$tb_contents = "";
		do {
			$tb_data = fread($fp, 8192);
			if (strlen($tb_data) == 0) {
				break;
			}
			$tb_contents .= $tb_data;
		} while(true);
		if (function_exists('mb_detect_encoding')) {
			$target_charset = mb_detect_encoding($tb_contents,"auto");
		}
		fclose ($fp);
		if (preg_match_all('#<rdf:RDF[^>]*>(.*?)</rdf:RDF>#si',$tb_contents,$matches,PREG_PATTERN_ORDER)) {
			$tb_urls = array();
			$obj = new TrackBack_XML();
			foreach($matches[1] as $tb_body) {
				list($tb_url,$tb_url_nc) = $obj->parse($tb_body,$popupurl);
				if ($tb_url !== FALSE) {
					$trackback_url = $tb_url;
					break;
				}
			}
		}
	}
	
if (file_exists(XOOPS_ROOT_PATH.'/modules/wordpress'. (($wp_id=='-')?'':$wp_id) .'/themes/'.$xoopsConfig['theme_set'].'/wp-admin.css')) {
		$themes = $xoopsConfig['theme_set'];
	} else {
		$themes = "default";
	}
	$css_file = $siteurl.'/themes/'.$themes.'/wp-admin.css';
	$xoops_css = xoops_getcss($xoopsConfig['theme_set']);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div id="wpAdminMain">
<h3><?php echo get_settings('blogname');?></h2>
<?php require('edit-form.php'); ?>
</div>
</body>
</html><?php
}
// 埋め込まれたデータから TrackBack Ping urlを取得するクラス
class TrackBack_XML
{
	var $url;
	var $tb_url;
	var $tb_url_nc;
	
	function parse($buf,$url)
	{
		// 初期化
		$this->url = preg_replace('|/+$|', '', $url);
		$this->tb_url = FALSE;
		$this->tb_url_nc = FALSE;
		
		$xml_parser = xml_parser_create();
		if ($xml_parser === FALSE)
		{
			return FALSE;
		}
		xml_set_element_handler($xml_parser,array(&$this,'start_element'),array(&$this,'end_element'));
		
		if (!xml_parse($xml_parser,$buf,TRUE))
		{
/*			die(sprintf('XML error: %s at line %d in %s',
				xml_error_string(xml_get_error_code($xml_parser)),
				xml_get_current_line_number($xml_parser),
				$buf
			));
*/
			return FALSE;
		}
		return array($this->tb_url,$this->tb_url_nc);
	}
	function start_element($parser,$name,$attrs)
	{
		if ($name !== 'RDF:DESCRIPTION')
		{
			return;
		}
		
		$about = $url = $tb_url = '';
		foreach ($attrs as $key=>$value)
		{
			switch ($key)
			{
				case 'RDF:ABOUT':
					$about = preg_replace('|/+$|', '', $value);
					break;
				case 'DC:IDENTIFER':
				case 'DC:IDENTIFIER':
					$url = preg_replace('|/+$|', '', $value);
					break;
				case 'TRACKBACK:PING':
					$tb_url = preg_replace('|/+$|', '', $value);
					break;
			}
		}
		
		if ($about == $this->url or $url == $this->url)
		{
			$this->tb_url = $tb_url;
		}
		if ($tb_url) $this->tb_url_nc = $tb_url;
	}
	function end_element($parser,$name)
	{
		// do nothing
	}
}
?>
