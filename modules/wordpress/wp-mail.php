<?php
//$GLOBALS['wp_mail_debug'] = 0; # =0 if you don't want to output any debugging info.
$GLOBALS['wp_mail_debug'] = 1; # =1 if you want to output debugging info to screen.
//$GLOBALS['wp_mail_debug'] = 2; # =2 if you want to output debugging info to log file. TODO.

if (file_exists(dirname(__FILE__).'/xoops_version.php')) {
	require_once(dirname(__FILE__) . '/wp-config.php');
} else {
	if (file_exists(dirname(dirname(__FILE__)). '/xoops_version.php')) {
		require_once(dirname(dirname(__FILE__)) . '/wp-config.php');
	}
}

if (file_exists(dirname(__FILE__) .'/wp-mail-conf.php')) {
	@include_once(dirname(__FILE__) .'/wp-mail-conf.php');
}

if ( function_exists('debug_backtrace') ) {
	$scriptpath = debug_backtrace();
	if ( count($scriptpath) ) { // Is this file included from another file ?
		$GLOBALS['wp_mail_debug'] = 0;  // in this case, shouldn't output any messages.
	} else if (!empty($GLOBALS['exec_key'])) {
		if (!(isset($_GET['execkey'])) || $_GET['execkey']!=$GLOBALS['exec_key']) {
			$GLOBALS['wp_mail_debug'] = 0;  // in this case, shouldn't output any messages.
		}
	}
}

ob_start();
if ($GLOBALS['wp_mail_debug']) {
	header("Content-Type: text/html; charset=EUC-JP");
	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP" />
</head><body>
EOD;
}
wp_mail_receive();
if ($GLOBALS['wp_mail_debug']) {
	echo "</body></html>";
	ob_end_flush();
} else {
	ob_end_clean();
}

function wp_mail_quit() {
  global $wp_pop3;
  $wp_pop3->quit();
}

function wp_mail_receive() {
  global $wpdb, $wp_pop3, $img_target;
  
	require_once(ABSPATH . WPINC . '/class-pop3.php');
	timer_start();
	$use_cache = 1;
	$time_difference = get_settings('time_difference');
	$blog_charset = get_settings('blog_charset');

	error_reporting(2037);

	$wp_pop3 = new POP3();
	if (!$wp_pop3->connect(get_settings('mailserver_url'), get_settings('mailserver_port'))) {
		echo "Ooops $wp_pop3->ERROR <br />\n";
		return;
	} 

	$mail_count = $wp_pop3->login(get_settings('mailserver_login'), get_settings('mailserver_pass'));
	if ($mail_count == false) {
		if (!$wp_pop3->FP) {
			echo "Oooops Login Failed: $wp_pop3->ERROR<br />\n";
		} else {
			echo "No Message<br />\n";
			$wp_pop3->quit();
		}
		return;
	}
	
	// ONLY USE THIS IF YOUR PHP VERSION SUPPORTS IT!
	register_shutdown_function('wp_mail_quit');
	
	for ($mail_num = 1; $mail_num <= $mail_count; $mail_num++) {
		$MsgOne = $wp_pop3->get($mail_num);
		if ((!$MsgOne) || (gettype($MsgOne) != 'array')) {
			echo "oops, $wp_pop3->ERROR<br />\n";
			$wp_pop3->quit();
			return;
		} 

		$content = '';
		$content_type = '';
		$boundary = '';
		$att_boundary = '';
		$hatt_boundary = '';
		$bodysignal = 0;
		$dmonths = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
			'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		while (list ($lineNum, $line) = each ($MsgOne)) {
			if (strlen($line) < 3) {
				$bodysignal = 1;
			} 
			if ($bodysignal) {
				$content .= $line;
			} else {
				if (preg_match('/^Content-Type:\s+(.*?)\;/i', $line,$match)) {
					$content_type = $match[1];
					$content_type = strtolower($match[1]);
				} 
				if (($content_type == 'multipart/mixed') && (preg_match('/boundary=(?:")?([^;"\s\n]*?)(?:")?\s*(?:$|;)/',$line,$match)) && ($att_boundary == '')) {
					$att_boundary = trim($match[1]);
				} 

				if (($content_type == 'multipart/alternative') && (preg_match('/boundary=(?:")?([^;"\s\n]*?)(?:")?\s*(?:$|;)/',$line,$match)) && ($boundary == '')) {
					$boundary = trim($match[1]);
				} 

				if (($content_type == 'multipart/related') && (preg_match('/boundary=(?:")?([^;"\s\n]*?)(?:")?\s*(?:$|;)/',$line,$match)) && ($hatt_boundary == '')) {
					$hatt_boundary = trim($match[1]);
				} 
				if (preg_match('/Subject: /', $line)) {
					$subject = trim($line);
					$subject = substr($subject, 9, strlen($subject)-9);
					if (function_exists('mb_decode_mimeheader')) {
						$subject1 = mb_decode_mimeheader($subject);
						if ($subject != $subject) {
							$sub_charset = mb_internal_encoding();
						} else {
							$sub_charset = "auto";
						} 
						$subject = $subject1;
					} 
					if (get_settings('use_phoneemail')) {
						$subject = explode(get_settings('phoneemail_separator'), $subject);
						$subject = trim($subject[0]);
					} 
				} 
				if (preg_match('/Date: /', $line)) { // of the form '20 Mar 2002 20:32:37'
					$ddate = trim($line);
					$ddate = str_replace('Date: ', '', $ddate);
					if (strpos($ddate, ',')) {
						$ddate = trim(substr($ddate, strpos($ddate, ',') + 1, strlen($ddate)));
					}
					$ddate_U = strtotime ($ddate) + $time_difference*3600;
					$post_date = date('Y-m-d H:i:s', $ddate_U);
				} 
			} 
		} 
		if (!ereg(get_settings('subjectprefix'), $subject)) {
			continue;
		} 

		$charset = "";
		$ncharset = preg_match("/\s?charset=\"?([A-Za-z0-9\-]*)\"?/i", $content, $matches);
		if ($ncharset) $charset = $matches[1];

		$ddate_today = time() + ($time_difference * 3600);
		$ddate_difference_days = ($ddate_today - $ddate_U) / 86400; 

		if ($ddate_difference_days > 14) {
			echo "Too old<br />\n";
			continue;
		} 
		if (preg_match('/' . get_settings('subjectprefix') . '/', $subject)) {
			$userpassstring = '';

			echo "<div style=\"border: 1px dashed #999; padding: 10px; margin: 10px;\">\n";
			echo "<p><b>$mail_num</b></p><p><b>Subject: </b>$subject</p>\n";

			$subject = trim(str_replace(get_settings('subjectprefix'), '', $subject));

			$attachment = false;

			if ($att_boundary) {
				$contents = explode('--' . $att_boundary, $content);
				$content = $contents[1];
				$ncharset = preg_match("/\s?charset=\"?([A-Za-z0-9\-]*)\"?/i", $content, $matches);
				if ($ncharset) $charset = $matches[1];
				$content = explode("\r\n\r\n", $content, 2);
				$content = $content[1];
			} 
			if ($hatt_boundary) {
				$contents = explode('--' . $hatt_boundary, $content);
				$content = $contents[1];
				if (preg_match('/Content-Type: multipart\/alternative\;\s*boundary\=(?:")?([^";\s\n]*?)(?:")?\s*(?:;|\n|$)"/i', $content, $matches)) {
					$boundary = trim($matches[1]);
					$content = explode('--' . $boundary, $content);
					$content = $content[2];
				} 
				$ncharset = preg_match("/charset=\"?([^\"]*)\"?/i", $content, $matches);
				if ($ncharset) $charset = $matches[1];
					$content = explode('Content-Transfer-Encoding: quoted-printable', $content);
				$content = strip_tags($content[1], '<img><p><br><i><b><u><em><strong><strike><font><span><div><dl><dt><dd><ol><ul><li>,<table><tr><td>');
			} else if ($boundary) {
				$content = explode('--' . $boundary, $content);
				$content = $content[2];
				if (preg_match('/Content-Type: multipart\/related\;\s*boundary=(?:")?([^";\s\n]*?)(?:")?\s*(?:;|\n|$)/i', $content, $matches)) {
					$hatt_boundary = trim($matches[1]);
					$contents = explode('--' . $hatt_boundary, $content);
					$content = $contents[1];
				} 
				$ncharset = preg_match("/charset=\"?([^\"]*)\"?/i", $content, $matches);
				if ($ncharset) $charset = $matches[1];
				$content = explode('Content-Transfer-Encoding: quoted-printable', $content);
				$content = strip_tags($content[1], '<img><p><br><i><b><u><em><strong><strike><font><span><div><dl><dt><dd><ol><ul><li>,<table><tr><td>');
			} 
			$content = trim($content);
			echo "<p><b>Content-type:</b> $content_type, <b>boundary:</b> $boundary</p>\n";
			echo "<p><b>att_boundary:</b> $att_boundary, <b>hatt_boundary:</b> $hatt_boundary</p>\n";
			echo "<p><b>charset:</b>$charset, <b>BLOG charset:</b>$blog_charset</p>\n"; 
			// echo "<p><b>Raw content:</b><br /><pre>".$content.'</pre></p>';

			if (($charset == "") || (trim(strtoupper($charset)) == "ISO-2022-JP")) $charset = "JIS";
			if (trim(strtoupper($charset)) == "SHIFT_JIS") $charset = "SJIS";

			$btpos = strpos($content, get_settings('bodyterminator'));
			if ($btpos) {
				$content = substr($content, 0, $btpos);
			} 
			$content = trim($content);

			$blah = explode("\n", preg_replace("/^[\n\r\s]*/", "", strip_tags($content)));
			$firstline = preg_replace("/[\n\r]/", "", $blah[0]);
			$secondline = $blah[1];

			if (get_settings('use_phoneemail')) {
				echo "<p><b>Use Phone Mail:</b> Yes</p>\n";
				$btpos = strpos($firstline, get_settings('phoneemail_separator'));
				if ($btpos) {
					$userpassstring = trim(substr($firstline, 0, $btpos));
					$content = trim(substr($content, $btpos + strlen(get_settings('phoneemail_separator')), strlen($content)));
					$btpos = strpos($content, get_settings('phoneemail_separator'));
					if ($btpos) {
						$userpassstring = trim(substr($content, 0, $btpos));
						$content = trim(substr($content, $btpos + strlen(get_settings('phoneemail_separator')), strlen($content)));
					} 
				} 
				$contentfirstline = $blah[1];
			} else {
				echo "<p><b>Use Phone Mail:</b> No</p>\n";
				$userpassstring = strip_tags($firstline);
				$contentfirstline = '';
			} 

			$flat = 999.0;
			$flon = 999.0;
			$secondlineParts = explode(':', strip_tags($secondline));
			if (strncmp($secondlineParts[0], "POS", 3) == 0) {
				echo "Found POS:<br />\n"; 
				// echo "Second parts is:".$secondlineParts[1];
				// the second line is the postion listing line
				$secLineParts = explode(',', $secondlineParts[1]);
				$flatStr = $secLineParts[0];
				$flonStr = $secLineParts[1]; 
				// echo "String are ".$flatStr.$flonStr;
				$flat = floatval($secLineParts[0]);
				$flon = floatval($secLineParts[1]); 
				// echo "values are ".$flat." and ".$flon;
				// ok remove that position... we should not have it in the final output
				$content = str_replace($secondline, '', $content);
			} 

			$blah = explode(':', $userpassstring);
			$user_login = $blah[0];
			$user_pass = $blah[1];
			$user_login = mb_conv(trim($user_login), $blog_charset, $charset);
			
			$content = $contentfirstline . str_replace($firstline, '', $content);
			$content = trim($content); 
			// Please uncomment following line, only if you want to check user and password.
			// echo "<p><b>Login:</b> $user_login, <b>Pass:</b> $user_pass</p>";
			echo "<p><b>Login:</b> $user_login, <b>Pass:</b> *********</p>";
			if (!user_pass_ok($user_login, $user_pass)) {
				echo "<p><b>Error: Wrong Login.</b></p></div>\n";
				continue;
			} 
			$userdata = get_userdatabylogin($user_login);
			$user_level = $userdata->user_level;
			$post_author = $userdata->ID;

			if ($user_level > 0) {
				$post_title = xmlrpc_getposttitle($content);
				if ($post_title == '') {
					$post_title = $subject;
				} 

				echo "Subject : " . mb_conv($post_title, $blog_charset, $sub_charset) . " <br />\n";

				$post_category = get_settings('default_category');
				if (preg_match('/<category>(.+?)<\/category>/is', $content, $matchcat)) {
					$post_category = xmlrpc_getpostcategory($content);
				} 
				if (empty($post_category)) {
					$post_category = get_settings('default_post_category');
				}
				echo "Category : $post_category <br />\n";

				$post_category = explode(',', $post_category);

				if (!get_settings('emailtestonly')) {
					// Attaching Image Files Save
					if ($att_boundary != "") {
						$attachment = wp_getattach($contents[2], "user-".trim($post_author), 1);
					} 
					if (($boundary != "") && ($hatt_boundary != "")) {
						for ($i = 2; $i < count($contents); $i++) {
							$hattachment = wp_getattach($contents[$i], "user-".trim($post_author), 0);
							if ($hattachment) {
								if (preg_match("/Content-Id: \<([^\>]*)>/i", $contents[$i], $matches)) {
									$content = preg_replace("/(cid:" . preg_quote($matches[1]) . ")/", get_settings('fileupload_url') .'/'. $hattachment, $content);
								} 
							} 
						} 
					} 
					if ($boundary != "") {
						$content = preg_replace("/\=[\r\n]/", "", $content);
						$content = preg_replace("/[\r\n]/", " ", $content);
					} 

					$content = preg_replace("|\n([^\n])|", " $1", $content);
					$content = preg_replace("/\=([0-9a-fA-F]{2,2})/e", "pack('c',base_convert('\\1',16,10))", $content);
					$content = mb_conv(trim($content), $blog_charset, $charset);

					// If we find an attachment, add it to the post
					if ($attachment) {
						if (isset($img_target) && $img_target) {
							$img_target = ' target="'.$img_target.'"';
						} else {
							$img_target = '';
						}

						if (file_exists(get_settings('fileupload_realpath')."/thumb-" . $attachment)) {
							$content = "<a href=\"" . get_settings('fileupload_url') . '/' . rawurlencode($attachment) . "\"".$img_target."><img style=\"float: left;\" hspace=\"6\" src = \"" . get_settings('fileupload_url') . '/thumb-' . rawurlencode($attachment) . "\" alt=\"".$attachment."\" title=\"".$attachment."\" /></a>" . $content . "<br clear=\"left\" />";
						} else {
							$content = "<a href=\"" . get_settings('fileupload_url') . '/' . rawurlencode($attachment) . "\"".$img_target."><img style=\"float: left;\" hspace=\"6\" src = \"" . get_settings('fileupload_url') . '/' . rawurlencode($attachment) . "\" alt=\"".$attachment."\" title=\"".$attachment."\" /></a>" . $content . "<br clear=\"left\" />";
						} 
					} 
					$postHandler =& wp_handler('Post');
					$postObject =& $postHandler->create();
					$postObject->setVar('post_content', $content);
					$postObject->setVar('post_title', trim(mb_conv($post_title, $blog_charset, $sub_charset)));
					$postObject->setVar('post_date', $post_date);
					$postObject->setVar('post_author', $post_author);
					$postObject->setVar('post_category', $post_category[0]);
					$postObject->setVar('post_name', sanitize_title($post_title));
					if ($flat < 500) {
						$postObject->setVar('post_lat',$flat);
						$postObject->setVar('post_lon', $flon);
					}

					if (!$postHandler->insert($postObject, true)) {
						echo "<b>Error: Insert New Post</b><br />";
					}
					$post_ID = $postObject->getVar('ID');
					echo "Post ID = $post_ID<br />\n";
					$postObject->assignCategories($post_category);
					do_action('publish_post', $post_ID);
					do_action('publish_phone', $post_ID);
					if ($flat < 500) {
						pingGeoUrl($post_ID);
					} 
					$blog_ID = 1;
					pingWeblogs($blog_ID);
					pingBlogs($blog_ID);
					pingback($content, $post_ID);
				} 
				echo "\n<p><b>Posted title:</b> $post_title<br />\n";
				echo "<b>Posted content:</b><br /><pre>" . $content . "</pre></p>\n";

				if (!$wp_pop3->delete($mail_num)) {
					echo "<p>Oops " . $wp_pop3->ERROR . "</p></div>\n";
					$wp_pop3->reset();
					return;
				} else {
					echo "<p>Mission complete, message <strong>$mail_num</strong> deleted.</p>\n";
				} 
			} else {
				echo "<p><strong>Level 0 users can\'t post.</strong></p>\n";
			} 
			echo "</div>\n";
		} 
	} 

	$wp_pop3->quit();

	timer_stop($output_debugging_info);
	return;
}
function wp_getattach($content, $prefix = "", $create_thumbs = 0)
{
	$contents = explode("\r\n\r\n", $content);
	$subtype = preg_match("/Content-Type: [^\/]*\/([^\;]*);/", $contents[0], $matches);
	if ($subtype) $subtype = strtolower($matches[1]);
	$temp_file = "";
	if (in_array($subtype, array("gif", "jpg", "jpeg", "png"))) {
		if (eregi("name=\"?([^\"]+)\"?", $contents[0], $filereg)) {
			$filename = ereg_replace("[\t\r\n]", "", $filereg[1]);
			if (function_exists('mb_convert_encoding')) {
				$temp_file = mb_conv(mb_decode_mimeheader($filename), get_settings('blog_charset'), "auto");
			} else {
				$temp_file = $filename;
			}
			
		} 
		// 添付データをデコードして保存
		if (eregi("Content-Transfer-Encoding:.*base64", $contents[0])) {
			$tmp = base64_decode($contents[1]);
			if (!$temp_file) {
				$temp_file_base = $prefix . "_" . time();
			} else {
				$temp_file_info = pathinfo($temp_file);
				if (in_array($temp_file_info["extension"],array("gif", "jpg", "jpeg", "png"))) {
					$subtype = $temp_file_info["extension"];
				}
				$temp_file_base = basename($temp_file, "." . $temp_file_info["extension"]);
			} 
			$i = 0;
			$temp_file = $temp_file_base . ".$subtype";
			while (file_exists(get_settings('fileupload_realpath') . '/' . $temp_file)) {
				$temp_file = $temp_file_base . "-" . $i . ".$subtype";
				$i++;
			} 
			if (!($temp_fp = fopen(get_settings('fileupload_realpath') . '/' . $temp_file, "wb"))) {
				echo("Error : Could not write attatched file.<br />\n");
				return false;
			} 
			fputs($temp_fp, $tmp);
			fclose($temp_fp);
			if ($create_thumbs) {
				wp_create_thumbnail(get_settings('fileupload_realpath') . '/' . $temp_file, 180, "");
			} 
		} 
		echo "$temp_file <br />\n";
		return $temp_file;
	} 
	return false;
} 
?>
