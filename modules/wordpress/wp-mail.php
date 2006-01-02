<?php
if (file_exists(dirname(__FILE__) .'/wp-mail-conf.php')) {
	@include_once(dirname(__FILE__) .'/wp-mail-conf.php');
	if ($exec_key) {
		if (!(isset($_GET['execkey'])) || $_GET['execkey']!=$exec_key) {
			return;
		}
	}
}
function wp_mail_quit() {
  global $wp_pop3;
  $wp_pop3->quit();
}
function wp_mail_receive() {
  global $xoopsDB, $wpdb, $wp_id, $siteurl, $blog_charset, $wp_pop3;
  
	require_once(ABSPATH . WPINC . '/class-pop3.php');
	timer_start();
	$use_cache = 1;
	$time_difference = get_settings('time_difference');

	// Get Server Time Zone
	// If Server Time Zone is not collect, Please comment out following line;
	$server_timezone = date("O");
	// echo "Server TimeZone is ".date('O')."<br />";

	// If Server Time Zone is not collect, Please uncomment following line and set collect timezone value;
	// $server_timezone = "+0900"; //This is a sample value for JST+0900

	$server_timezone = $server_timezone / 100;
	$weblog_timezone = $server_timezone + $time_difference;

	error_reporting(2037);

	$wp_pop3 = new POP3();

	if (!$wp_pop3->connect(get_settings('mailserver_url'), get_settings('mailserver_port'))) {
		echo "Ooops $wp_pop3->ERROR <br />\n";
		return;
	} 

	$Count = $wp_pop3->login(get_settings('mailserver_login'), get_settings('mailserver_pass'));
	if ($Count == false) {
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
	
	for ($iCount = 1; $iCount <= $Count; $iCount++) {
		$MsgOne = $wp_pop3->get($iCount);
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
				if (preg_match('/^Content-Type:\s*(.*?)\;/i', $line,$match)) {
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
					$date_arr = explode(' ', $ddate);
					$date_time = explode(':', $date_arr[3]);

					$ddate_H = $date_time[0];
					$ddate_i = $date_time[1];
					$ddate_s = $date_time[2];

					$ddate_m = $date_arr[1];
					$ddate_d = $date_arr[0];
					$ddate_Y = $date_arr[2];

					$mail_timezone = trim(ereg_replace("\([^)]*\)", "", $date_arr[4])) / 100; 
					// echo "Email TimeZone is {$date_arr[4]}<br />";
					$mail_time_difference = $weblog_timezone - $mail_timezone;
					for ($i = 0; $i < 12; $i++) {
						if ($ddate_m == $dmonths[$i]) {
							$ddate_m = $i + 1;
						} 
					} 
					$ddate_U = mktime($ddate_H, $ddate_i, $ddate_s, $ddate_m, $ddate_d, $ddate_Y);
					$ddate_U = $ddate_U + ($mai_time_difference * 3600);
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
			echo "<p><b>$iCount</b></p><p><b>Subject: </b>$subject</p>\n";

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
			if (function_exists('mb_convert_encoding')) {
				$user_login = mb_convert_encoding(trim($user_login), $blog_charset, $charset);
			} else {
				$user_login = trim($user_login);
			}
			
			$content = $contentfirstline . str_replace($firstline, '', $content);
			$content = trim($content); 
			// Please uncomment following line, only if you want to check user and password.
			// echo "<p><b>Login:</b> $user_login, <b>Pass:</b> $user_pass</p>";
			echo "<p><b>Login:</b> $user_login, <b>Pass:</b> *********</p>";
			if ($xoopsDB) {
				$sql = "SELECT ID, user_level FROM {$wpdb->users[$wp_id]} WHERE user_login='$user_login' ORDER BY ID DESC LIMIT 1";
				$result = $wpdb->get_row($sql);
				if (!$result) {
					echo "<p><b>Wrong Login.</b></p></div>\n";
					continue;
				} else {
					$sql = "SELECT * FROM " . $xoopsDB->prefix('users') . " WHERE uname='$user_login' AND pass='" . md5(trim($user_pass)) . "' ORDER BY uid DESC LIMIT 1";
					$result1 = $wpdb->get_row($sql);

					if (!$result1) {
						echo "<p><b>Wrong login or password.</b></p></div>\n";
						continue;
					} 
				} 
			} else {
				$sql = "SELECT ID, user_level FROM {$wpdb->users[$wp_id]} WHERE user_login='$user_login' AND user_pass='$user_pass' ORDER BY ID DESC LIMIT 1";
				$result = $wpdb->get_row($sql);

				if (!$result) {
					echo "<p><b>Wrong login or password.</b></p></div>\n";
					continue;
				} 
			} 

			$user_level = $result->user_level;
			$post_author = $result->ID;

			if ($user_level > 0) {
				$post_title = xmlrpc_getposttitle($content);
				if ($post_title == '') {
					$post_title = $subject;
				} 

				$post_category = get_settings('default_category');
				if (preg_match('/<category>(.+?)<\/category>/is', $content, $matchcat)) {
					$post_category = xmlrpc_getpostcategory($content);
				} 
				if ($post_category == '') {
					$post_category = get_settings('default_post_category');
				} 
				if (function_exists('mb_convert_encoding')) {
					echo "Subject : " . mb_convert_encoding($subject, $blog_charset, $sub_charset) . " <br />\n";
				} else {
					echo "Subject : " . $subject . " <br />\n";
				} 
				echo "Category : $post_category <br />\n";
				if (!get_settings('emailtestonly')) {
					// Attaching Image Files Save
					if ($att_boundary != "") {
						$attachment = wp_getattach($contents[2], trim($user_login), 1);
					} 
					if (($boundary != "") && ($hatt_boundary != "")) {
						for ($i = 2; $i < count($contents); $i++) {
							$hattachment = wp_getattach($contents[$i], trim($user_login), 0);
							if ($hattachment) {
								if (preg_match("/Content-Id: \<([^\>]*)>/i", $contents[$i], $matches)) {
									$content = preg_replace("/(cid:" . preg_quote($matches[1]) . ")/", "$siteurl/attach/" . $hattachment, $content);
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
					if (function_exists('mb_convert_encoding')) {
						$content = addslashes(mb_convert_encoding(trim($content), $blog_charset, $charset));
						$post_title = addslashes(trim(mb_convert_encoding($post_title, $blog_charset, $sub_charset)));
					} else {
						$content = addslashes(trim($content));
						$post_title = addslashes(trim($post_title));
					}
					$post_name = sanitize_title($post_title);
					// If we find an attachment, add it to the post
					if ($attachment) {
						if (file_exists("attach/thumb-" . $attachment)) {
							$content = "<a href=\"" . $siteurl . "/attach/" . $attachment . "\"><img style=\"float: left;\" hspace=\"6\" src =\"" . $siteurl . "/attach/thumb-" . $attachment . "\" alt=\"moblog\" /></a>" . $content . "<br clear=\"left\" />";
						} else {
							$content = "<a href=\"" . $siteurl . "/attach/" . $attachment . "\"><img style=\"float: left;\" hspace=\"6\" src =\"" . $siteurl . "/attach/" . $attachment . "\" alt=\"moblog\" /></a>" . $content . "<br clear=\"left\" />";
						} 
					} 
					if ($flat > 500) {
						$sql = "INSERT INTO {$wpdb->posts[$wp_id]} (post_author, post_date, post_content, post_title, post_category, post_name) VALUES ($post_author, '$post_date', '$content', '$post_title', $post_category, '$post_name')";
					} else {
						$sql = "INSERT INTO {$wpdb->posts[$wp_id]} (post_author, post_date, post_content, post_title, post_category, post_name, post_lat, post_lon) VALUES ($post_author, '$post_date', '$content', '$post_title', $post_category, '$post_name', $flat, $flon)";
					} 
					$result = $wpdb->query($sql);
					if ($result) {
						$post_ID = $wpdb->insert_id;
		
						if ($post_name == "") {
							$post_name = "post-".$post_ID;
							$wpdb->query("UPDATE {$wpdb->posts[$wp_id]} SET post_name='$post_name' WHERE ID = $post_ID");
						}
						echo "Post ID = $post_ID<br />\n";
						$blog_ID = 1;
						if ($flat < 500) {
							pingGeoUrl($post_ID);
						} 
						// Double check it's not there already
						$exists = $wpdb->get_row("SELECT * FROM {$wpdb->post2cat[$wp_id]} WHERE post_id = $post_ID AND category_id = $post_category");
						if (!$exists && $result) {
							$wpdb->query("
							INSERT INTO {$wpdb->post2cat[$wp_id]}
							(post_id, category_id)
							VALUES
							($post_ID, $post_category)
							");
						} 

						pingWeblogs($blog_ID);
						pingBlogs($blog_ID);
						do_action('publish_post', $post_ID);
						do_action('publish_phone', $post_ID);
						echo "\n<p><b>Posted title:</b> $post_title<br />\n";
						echo "<b>Posted content:</b><br /><pre>" . $content . "</pre></p>\n";

						if (!$wp_pop3->delete($iCount)) {
							echo "<p>Oops " . $wp_pop3->ERROR . "</p></div>\n";
							$wp_pop3->reset();
							return;
						} else {
							echo "<p>Mission complete, message <strong>$iCount</strong> deleted.</p>\n";
						} 
					} else {
						echo "<p><b>Error: </b>Could not insert record to database</p>\n";
					}
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
		if (($prefix == 0) && eregi("name=\"?([^\"\n]+)\"?", $contents[0], $filereg)) {
			$filename = ereg_replace("[\t\r\n]", "", $filereg[1]);
			if (function_exists('mb_convert_encoding')) {
				$temp_file = mb_convert_encoding(mb_decode_mimeheader($filename, $blog_charset, "auto"));
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
				$temp_file_base = basename($temp_file, "." . $temp_file_info["extension"]);
			} 
			$i = 0;
			$temp_file = $temp_file_base . ".$subtype";
			while (file_exists("attach/" . $temp_file)) {
				$temp_file = $temp_file_base . "-" . $i . ".$subtype";;
				$i++;
			} 
			if (!($temp_fp = fopen("attach/" . $temp_file, "wb"))) {
				echo("Attachment File Writing Error<br />\n");
				return false;
			} 
			fputs($temp_fp, $tmp);
			fclose($temp_fp);
			if ($create_thumbs) {
				wp_create_thumbnail("attach/" . $temp_file, 180, "");
			} 
		} 
		echo "$temp_file <br />\n";
		return $temp_file;
	} 
	return false;
} 

function wp_create_thumbnail($file, $max_side, $effect = '')
{ 
	// 1 = GIF, 2 = JPEG, 3 = PNG
	if (file_exists($file)) {
		$type = getimagesize($file); 
		// if the associated function doesn't exist - then it's not
		// handle. duh. i hope.
		if (!function_exists('imagegif') && $type[2] == 1) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} elseif (!function_exists('imagejpeg') && $type[2] == 2) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} elseif (!function_exists('imagepng') && $type[2] == 3) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} else {
			// create the initial copy from the original file
			if ($type[2] == 1) {
				$image = imagecreatefromgif($file);
			} elseif ($type[2] == 2) {
				$image = imagecreatefromjpeg($file);
			} elseif ($type[2] == 3) {
				$image = imagecreatefrompng($file);
			} 

			if (function_exists('imageantialias'))
				imageantialias($image, true);

			$image_attr = getimagesize($file); 
			// figure out the longest side
			if ($image_attr[0] > $image_attr[1]) {
				$image_width = $image_attr[0];
				$image_height = $image_attr[1];
				$image_new_width = $max_side;

				$image_ratio = $image_width / $image_new_width;
				$image_new_height = $image_height / $image_ratio; 
				// width is > height
			} else {
				$image_width = $image_attr[0];
				$image_height = $image_attr[1];
				$image_new_height = $max_side;

				$image_ratio = $image_height / $image_new_height;
				$image_new_width = $image_width / $image_ratio; 
				// height > width
			} 
            if (function_exists('gd_info')) {
	            $gdver=gd_info();
	            if(strstr($gdver["GD Version"],"1.")!=false){
	            	//For GD
	                $thumbnail = imagecreate($image_new_width, $image_new_height);
	            }else{
	            	//For GD2
	                $thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
	            }
			} else {
                $thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
			}
			@imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_attr[0], $image_attr[1]); 
			// move the thumbnail to it's final destination
			$path = explode('/', $file);
			$thumbpath = substr($file, 0, strrpos($file, '/')) . '/thumb-' . $path[count($path)-1];
			touch($thumbpath);
			
			if ($type[2] == 1) {
				if (!imagegif($thumbnail, $thumbpath)) {
					$error = "Thumbnail path invalid";
				} 
			} elseif ($type[2] == 2) {
				if (!imagejpeg($thumbnail, $thumbpath)) {
					$error = "Thumbnail path invalid";
				} 
			} elseif ($type[2] == 3) {
				if (!imagepng($thumbnail, $thumbpath)) {
					$error = "Thumbnail path invalid";
				} 
			} 
		} 
	} 

	if (!empty($error)) {
		return $error;
	} else {
		return 1;
	} 
} 

require_once(dirname(__FILE__) . '/wp-config.php');

//$output_debugging_info = 0; # =0 if you don't want to output any debugging info.
$output_debugging_info = 1; # =1 if you want to output debugging info to screen.
//$output_debugging_info = 2; # =2 if you want to output debugging info to log file. TODO.

if ( function_exists('debug_backtrace') ) {
	$scriptpath = debug_backtrace();
	if ( count($scriptpath) ) { // Is this file included from another file ?
		$output_debugging_info = 0;  // in this case, shouldn't output any messages.
	}
}

ob_start();
if ($output_debugging_info) {
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
if ($output_debugging_info) {
	echo "</body></html>";
	ob_end_flush();
} else {
	ob_end_clean();
}
?>
