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
	header('Content-Type: text/html; charset='.$GLOBALS['blog_charset']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo _LANGCODE ?>" lang="<?php echo _LANGCODE ?>">
<head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP" />
</head><body>
<?php
}
wp_mail_receive();
if ($GLOBALS['wp_mail_debug']) {
	echo "</body></html>";
	ob_end_flush();
} else {
	ob_end_clean();
}

function wp_mail_quit() {
  $GLOBALS['wp_pop3']->quit();
}

function wp_mail_receive() {
  global $img_target;
  
	require_once(wp_base() .'/wp-includes/class-pop3.php');
	timer_start();
	$use_cache = 1;
	$time_difference = get_settings('time_difference');

	error_reporting(2037);

	$GLOBALS['wp_pop3'] = new POP3();
	if (! $GLOBALS['wp_pop3']->connect(get_settings('mailserver_url'), get_settings('mailserver_port'))) {
		echo "Ooops {$GLOBALS['wp_pop3']}->ERROR <br />\n";
		return;
	} 

	$mail_count = $GLOBALS['wp_pop3']->login(get_settings('mailserver_login'), get_settings('mailserver_pass'));
	if ($mail_count == false) {
		if (!$GLOBALS['wp_pop3']->FP) {
			echo "Oooops Login Failed: $wp_pop3->ERROR<br />\n";
		} else {
			echo "No Message<br />\n";
			$GLOBALS['wp_pop3']->quit();
		}
		return;
	}
	
	// ONLY USE THIS IF YOUR PHP VERSION SUPPORTS IT!
	register_shutdown_function('wp_mail_quit');
	
	for ($mail_num = 1; $mail_num <= $mail_count; $mail_num++) {
		$MsgOne = $GLOBALS['wp_pop3']->get($mail_num);
		if ((!$MsgOne) || (gettype($MsgOne) != 'array')) {
			echo "oops, {$GLOBALS['wp_pop3']}->ERROR<br />\n";
			$GLOBALS['wp_pop3']->quit();
			return;
		} 

		$content = '';
		$content_type = '';
		$boundary = '';
		$alt_boundary = '';
		$emb_boundary = '';
		$dmonths = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
			'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		
		$mailMsg = '';
		while (list ($lineNum, $line) = each ($MsgOne)) {
			$mailMsg .= $line;
		}
		$mailParts = parse_msg($mailMsg);

		if (!empty($mailParts['header']['date'])) {
			$ddate = trim($mailParts['header']['date'][0]);
			if (strpos($ddate, ',')) {
				$ddate = trim(substr($ddate, strpos($ddate, ',') + 1, strlen($ddate)));
			}
			$ddate_U = strtotime ($ddate) + $time_difference*3600;
			$post_date = date('Y-m-d H:i:s', $ddate_U);
		} 

		if (!empty($mailParts['header']['subject'])) {
			$subject = trim($mailParts['header']['subject'][0]);
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

			$attaches = array();

			if ($mailParts['type'] == 'multipart') {
				if ($mailParts['subtype'] == 'mixed') {
					for ($i = 1; $i < count($mailParts['body']) ; $i++) {
						$attaches[] = array(
										'type'=>'mix',
										'body'=>$mailParts['body'][$i]
									);
					}
					if (!is_array($mailParts['body'][0]['body'])) {
						$content = $mailParts['body'][0]['body'];
						$charset = $mailParts['body'][0]['charset'];
					} else {
						$mailParts = $mailParts['body'][0];
					}
				}
				if (($mailParts['type'] == 'multipart')&&($mailParts['subtype'] == 'related')) {
					if (($mailParts['body'][0]['type']=='multipart')&&($mailParts['body'][0]['subtype']=='alternative')) {
						$content = $mailParts['body'][0]['body'][1]['body'];
						$charset = $mailParts['body'][0]['body'][1]['charset'];
					} else {
						$content = $mailParts['body'][0]['body'];
						$charset = $mailParts['body'][0]['charset'];
					}
					$content = preg_replace('/(\<.*?\>)/es' ,'str_replace(array("\n","\r"), array(" ", " "), "\\1")', $content);
					$content = strip_tags($content, '<img><p><br><i><b><u><em><strong><strike><font><span><div><dl><dt><dd><ol><ul><li>,<table><tr><td>');
					for ($i = 1; $i < count($mailParts['body']) ; $i++) {
						$attaches[] = array(
										'type' => 'relate',
										'body' => $mailParts['body'][$i],
										'id' => preg_replace('/<(.*)>/','$1',$mailParts['body'][$i]['header']['content-id'][0])
									);
					}
				}
				if (($mailParts['type'] == 'multipart')&&($mailParts['subtype'] == 'alternative')) {
					if (($mailParts['body'][1]['type']=='multipart')&&($mailParts['body'][1]['subtype']=='related')) {
						$content = $mailParts['body'][1]['body'][0]['body'];
						$charset = $mailParts['body'][1]['body'][0]['charset'];
						for ($i = 1; $i < count($mailParts['body'][1]['body']) ; $i++) {
							$attaches[] = array(
											'type' => 'relate',
											'body' => $mailParts['body'][1]['body'][$i],
											'id' => preg_replace('/<(.*)>/','$1',$mailParts['body'][1]['body'][$i]['header']['content-id'][0])
										);
						}
					} else {
						$content = $mailParts['body'][1]['body'];
						$charset = $mailParts['body'][1]['charset'];
					}
					$content = preg_replace('/(\<.*?\>)/es' ,'str_replace(array("\n","\r"), array(" ", " "), "\\1")', $content);
					$content = strip_tags($content, '<img><p><br><i><b><u><em><strong><strike><font><span><div><dl><dt><dd><ol><ul><li>,<table><tr><td>');
				}
			} else {
				$content = $mailParts['body'];
				$charset = $mailParts['charset'];
			}
			

			$content = trim($content);

			echo "<p><b>Content-type:</b> $content_type, <b>boundary:</b> $boundary</p>\n";
			echo "<p><b>alt_boundary:</b> $alt_boundary, <b>emb_boundary:</b> $emb_boundary</p>\n";
			echo "<p><b>charset:</b>$charset, <b>BLOG charset:</b>".$GLOBALS['blog_charset']."</p>\n"; 
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
			$user_login = mb_conv(trim($user_login), $GLOBALS['blog_charset'], $charset);
			
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

				echo "Subject : " . mb_conv($post_title, $GLOBALS['blog_charset'], $sub_charset) . " <br />\n";

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
					$content = preg_replace("|\n([^\n])|", " $1", $content);
					$content = preg_replace("/\=([0-9a-fA-F]{2,2})/e", "pack('c',base_convert('\\1',16,10))", $content);
					$content = mb_conv(trim($content), $GLOBALS['blog_charset'], $charset);
					$content_before = "";
					$content_after = "";
					for ($i =0; $i < count($attaches); $i++) {
						$create_thumbs = ($attaches[$i]['type']=='mix') ? 1: 0;
						list($file_name, $is_img, $orig_name) = wp_getattach($attaches[$i]['body'], "user-".trim($post_author), $create_thumbs);
						if ($file_name) {
							if ($attaches[$i]['type']=='relate') {
								$content = preg_replace("/cid:" . preg_quote($attaches[$i]['id']) . "/", get_settings('fileupload_url') .'/'. $file_name, $content);
							} else {
								if (isset($img_target) && $img_target) {
									$img_target = ' target="'.$img_target.'"';
								} else {
									$img_target = '';
								}
								if ($is_img) {
									if (file_exists(get_settings('fileupload_realpath')."/thumb-" . $file_name)) {
										$content_before .= "<a href=\"" . get_settings('fileupload_url') . '/' . rawurlencode($file_name) . "\"".$img_target."><img style=\"float: left;\" hspace=\"6\" src=\"" . get_settings('fileupload_url') . '/thumb-' . rawurlencode($file_name) . "\" alt=\"".$orig_name."\" title=\"".$orig_name."\" /></a>";
									} else {
										$content_before .= "<a href=\"" . get_settings('fileupload_url') . '/' . rawurlencode($file_name) . "\"".$img_target."><img style=\"float: left;\" hspace=\"6\" src=\"" . get_settings('fileupload_url') . '/' . rawurlencode($file_name) . "\" alt=\"".$orig_name."\" title=\"".$orig_name."\" /></a>";
									}
								} else {
									$content_after .= "<a href=\"" . wp_siteurl()."/wp-download.php?from=".rawurlencode($file_name)."&amp;fname=" .urlencode($orig_name). "\"".$img_target."><img style=\"float: left;\" hspace=\"6\" src=\"" . wp_siteurl(). "/wp-images/file.gif\" alt=\"".$orig_name."\" title=\"".$orig_name."\" />".$orig_name."</a>";
								}
							}
						}
					}
 					$content = $content_before . $content . "<br clear=\"left\" />" . $content_after;
					$postHandler =& wp_handler('Post');
					$postObject =& $postHandler->create();
					$postObject->setVar('post_content', $content);
					$postObject->setVar('post_title', trim(mb_conv($post_title, $GLOBALS['blog_charset'], $sub_charset)));
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

				if (!$GLOBALS['wp_pop3']->delete($mail_num)) {
					echo "<p>Oops " . $GLOBALS['wp_pop3']->ERROR . "</p></div>\n";
					$GLOBALS['wp_pop3']->reset();
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

	$GLOBALS['wp_pop3']->quit();

	timer_stop($GLOBALS['wp_mail_debug']);
	return;
}
function wp_getattach(&$content, $prefix = "", $create_thumbs = 0)
{
	$allowedtypes = explode(' ', trim(get_settings('fileupload_allowedtypes')));
	$allowedimage = array_intersect($allowedtypes, array('gig', 'jpg', 'jpeg', 'png'));
	$subtype = $content['subtype'];
	if (!empty($content['name'])) {
		$origname = $content['name'];
		if (function_exists('mb_convert_encoding')) {
			$origname = mb_conv(mb_decode_mimeheader($origname), $GLOBALS['blog_charset'], "auto");
		}
		$filename_info = pathinfo($origname);
		$subtype = $filename_info["extension"];
//		$filename_base = basename($filename, "." . $filename_info["extension"]);
	}
	$filename_base = $prefix . "_" . time();
	if (in_array($subtype, $allowedtypes)) {
		if (!empty($content['encodings'])&&($content['encodings']=='base64')) {
			$tmp = base64_decode($content['body']);
			$i = 0;
			$filename = $filename_base . ".$subtype";
			while (file_exists(get_settings('fileupload_realpath') . '/' . $filename)) {
				$filename = $filename_base . "-" . $i . ".$subtype";
				$i++;
			} 
			if (!($fp = fopen(get_settings('fileupload_realpath') . '/' . $filename, "wb"))) {
				echo("Error : Could not write attatched file.<br />\n");
				return false;
			} 
			fputs($fp, $tmp);
			fclose($fp);
			if (in_array($subtype, $allowedimage)) {
				if ($create_thumbs) {
					wp_create_thumbnail(get_settings('fileupload_realpath') . '/' . $filename, 180, "");
				}
			}
		} 
		echo "$filename <br />\n";
		return array($filename, in_array($subtype, $allowedimage), $origname);
	} 
	return false;
} 

function parse_msg($mail_part) {
	$retval = array();
	$mail_part = explode("\r\n\r\n",$mail_part, 2);
	$mail_part_header = $mail_part[0]."\r\n";
	$mail_part_header = preg_replace('/\r\n\s+/', ' ', $mail_part_header);
	$mail_part_body = $mail_part[1];
	if (preg_match('/^Content-Type:\s*(.*?)\/(.*?)\s*(?:$|;).*$/im',$mail_part_header, $line)) {
		$retval['type'] = trim(strtolower($line[1]));
		$retval['subtype'] = trim(strtolower($line[2]));
		if ($retval['type'] == 'multipart') {
			if (preg_match('/boundary=(?:")?([^;"\s\n]*?)(?:")?\s*(?:$|;)/im',$line[0], $match)) {
				$retval['boundary'] = $match[1];
			}
			$sub_content = explode('--'.$retval['boundary'], $mail_part_body);
			$mail_part_body = array();
			for ($i=1; $i<count($sub_content); $i++) {
				$sub_body = parse_msg($sub_content[$i]);
				if (is_array($sub_body['body'])|| trim($sub_body['body'])) $mail_part_body[] = $sub_body;
			}
		}
		if (preg_match('/charset=(?:")?([^;"\s\n]*?)(?:")?\s*(?:$|;)/im',$line[0], $match)) {
			$retval['charset'] = $match[1];
		}
		if (preg_match('/name=(?:")?([^;"]*?)(?:")?\s*(?:$|;)/im',$line[0], $match)) {
			$retval['name'] = $match[1];
		}
	}
	if (preg_match('/^Content-Transfer-Encoding:\s*(.*?)\s*(?:$|;).*$/im',$mail_part_header, $line)) {
		$retval['encodings'] = strtolower($line[1]);
	}
	if (preg_match('/^Content-Disposition:\s*(.*?)\s*(?:$|;).*$/im',$mail_part_header, $line)) {
		$retval['disposition'] = strtolower($line[1]);
		if (preg_match('/filename=(?:")?([^;"]*?)(?:")?\s*(?:$|;)/im',$line[0], $match)) {
			$retval['filename'] = $match[1];
		}
	}
	$mail_part_headers = explode("\r\n", $mail_part_header);
	foreach($mail_part_headers as $line) {
		if (preg_match('/^(.+?):\s*(.*)$/', $line, $match)) {
			$retval['header'][strtolower($match[1])][] = $match[2];
		}
	}
	
	$retval['body'] = $mail_part_body;
	return $retval;
}
?>
