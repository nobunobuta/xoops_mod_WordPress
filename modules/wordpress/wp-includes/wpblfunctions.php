<?php
/*
 clean a given string so that it will work with regex
 */
function sanctify($url) {
	// modify Jay Allen stuff to work with PHP
	if (strpos($url, '[\w\-_.]')) {
		$url = str_replace('[\w\-_.]','[-\w\_.]',$url);
	}
	// get rid of all unescaped forwardslashes
	$ps = strpos($url, '/');
	while ($ps !== False) {
		if ($ps == 0) {
			// slash at beginning, escape
			$url = '\\' + $url;
		} else if (substr($url, $ps-1, 1) != '\\') {
			$url = substr_replace($url, '\/', $ps, 1);
		}
		$ps = strpos($url, '/', $ps+2);
	}
	$buf = mysql_escape_string(trim($url));
	return $buf;
}

/*
 remove trailing slash on a URL
 */
function remove_trailer($url) {
	$len = strlen($url)-1;
	$last = $url[$len];
	if ($last == '/') {
		$url = substr($url, 0, $len);
	}
	return $url;
}

if (!function_exists('_e')) {
	function _e($string) {
		echo $string;
	}
}
if (!function_exists('__')) {
	function __($string) {
		return $string;
	}
}

if (!function_exists('add_magic_quotes')) {
	function add_magic_quotes($array) {
	    foreach ($array as $k => $v) {
	        if (is_array($v)) {
	            $array[$k] = add_magic_quotes($v);
	        } else {
	            $array[$k] = addslashes($v);
	        }
	    }
	    return $array;
	}
}

?>
