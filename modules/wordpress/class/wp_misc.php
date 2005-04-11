<?php
// 埋め込まれたデータから TrackBack Ping urlを取得するクラス
if( ! class_exists( 'WP_TrackBack_XML_collection' ) ) {
class WP_TrackBack_XML_collection
{
	var $url;
	var $xml_parts;
	var $charset;
	var $tb_urls;
	var $tb_url;

	function WP_TrackBack_XML_collection($url="") {
		if ($url) {
			$this->url = preg_replace('|/+$|', '', $url);
			$this->url = preg_replace('|#.*$|', '', $this->url);
		}
		$this->xml_parts = array();
		$this->tb_urls = array();
	}
	
	function get_content($url) {
		require_once(XOOPS_ROOT_PATH.'/class/snoopy.php');
		if ($url) {
			$this->url = preg_replace('|/+$|', '', $url);
			$this->url = preg_replace('|#.*$|', '', $this->url);
		}
		$snoopy = New Snoopy;
		if ($snoopy->fetch($this->url)) {
			$tb_contents = $snoopy->results;
			if (function_exists('mb_detect_encoding')) {
				$this->charset = mb_detect_encoding($tb_contents,"auto");
			}
			if (preg_match_all('#<rdf:RDF[^>]*>(.*?)</rdf:RDF>#si',$tb_contents,$matches,PREG_PATTERN_ORDER)) {
				foreach($matches[1] as $tb_body) {
					//thanks  kenken
					$this->xml_parts[] = preg_replace('|dc:description=\"[^\"]*\"|', '', $tb_body);
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
			$obj = new WP_TrackBack_XML();
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
}
if( ! class_exists( 'WP_TrackBack_XML' ) ) {
class WP_TrackBack_XML
{
	var $url;
	var $tb_url;
	var $tb_url_nc;
	var $tb_title;
	var $match_url;

	function parse($buf,$url) {
		// 初期化
		$this->url = preg_replace('|/+$|', '', $url);
		$this->url = preg_replace('|#.*$|', '', $this->url);
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
}
?>
