<?php

# pop3-2-b2 mail to blog
# v0.3 20020716
# with photo attachment email hack
#
# Line 223 (or so) is the line that 
# scales the image and puts it on the left.
# Change the left; to right; or whatever you want
# Change the width and height options also
# Next is to click-through to original image
#
# Line 263 (or so) has the category stuff
# there is a comment at the end of the section
#

require_once('wp-config.php');

timer_start();

$use_cache = 1;
$output_debugging_info = 0;	# =1 if you want to output debugging info
$time_difference = get_settings('time_difference');

//if ($use_phoneemail) {
//	// if you're using phone email, the email will already be in your timezone
//	$time_difference = 0;
//}

//Get Server Time Zone
// If Server Time Zone is not collect, Please comment out following line;
$server_timezone = date("O")/100;
// If Server Time Zone is not collect, Please uncomment following line and set collect timezone value;
// $server_timezone = 9

$weblog_timezone = $server_timezone + $time_difference;

error_reporting(2037);
$mailserver = "{".$mailserver_url.":".$mailserver_port."/pop3/notls}";

#Open POP3 Mailbox for checking mail
if (!($mbox = imap_open ("$mailserver", "$mailserver_login", "$mailserver_pass"))) die ("error opening mailbox");

#Check to see if there is any mail in there
if (imap_num_msg($mbox) < 1) die(); //no mail found, no need for error log

// ONLY USE THIS IF YOUR PHP VERSION SUPPORTS IT!
//register_shutdown_function($pop3->quit());

#Count number of messages to pass to the post functions
$Count = imap_num_msg($mbox);
$overview=imap_fetch_overview($mbox,"1:$Count",0);

for ($iCount=1; $iCount<=$Count; $iCount++) {

	$content = '';
	$content_type = '';
	$content_disposition = '';
	$boundary = '';
	$bodysignal = 0;
	$dmonths = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

	#Check subject line for phone-email and subject prefix, if not present, simply die
	$subject = $overview[$iCount-1]->subject;
	if ($use_phoneemail) {
		$subject = explode($phoneemail_separator, $subject);
		$subject = trim($subject[0]);
	}
	if function_exists('mb_convert_encoding') {
		$subject = trim(mb_convert_encoding(mb_decode_mimeheader($subject),$blog_charset,"auto"));
	}
	global $subjectprefix;
	if (!ereg($subjectprefix, $subject)) {
		continue;
	}
	#Get the date from the email
	$ddate = $overview[$iCount-1]->date;
	if (strpos($ddate, ',')) {
		$ddate = trim(substr($ddate, strpos($ddate, ',')+1, strlen($ddate)));
	}
	$date_arr = explode(' ', $ddate);
	$date_time = explode(':', $date_arr[3]);

	$ddate_H = $date_time[0];
	$ddate_i = $date_time[1];
	$ddate_s = $date_time[2];

	$ddate_m = $date_arr[1];
	$ddate_d = $date_arr[0];
	$ddate_Y = $date_arr[2];
	
	$mail_timezone = trim(ereg_replace("\([^)]*\)","",$date_arr[4]))/100;
	$mail_time_difference = $weblog_timezone - $mail_timezone;

	for ($i=0; $i<12; $i++) {
		if ($ddate_m == $dmonths[$i]) {
			$ddate_m = $i+1;
		}
	}
	$ddate_U = mktime($ddate_H, $ddate_i, $ddate_s, $ddate_m, $ddate_d, $ddate_Y);
	$ddate_U = $ddate_U + ($mail_time_difference * 3600);
	$post_date = date('Y-m-d H:i:s', $ddate_U);

	$ddate_today = time() + ($time_difference * 3600);
	$ddate_difference_days = ($ddate_today - $ddate_U) / 86400;

	# starts buffering the output
	ob_start();

	if ($ddate_difference_days > 14) {
		echo 'Too old<br />';
		continue;
	}
	if (preg_match('/'.$subjectprefix.'/', $subject)) {
		$userpassstring = '';

		echo '<div style="border: 1px dashed #999; padding: 10px; margin: 10px;">';
		echo "<p><b>$iCount</b></p><p><b>Subject: </b>$subject</p>\n";

		$subject = trim(str_replace($subjectprefix, '', $subject));

		#Get the content of the post
		$content = imap_fetchbody($mbox, $iCount, 1);
		$struct = imap_fetchstructure($mbox, $iCount);
		$content = trim($content);
//Please uncomment following line, only if you want to check Raw content.
//		echo "<p><b>Raw content:</b><br /><pre>".$content.'</pre></p>';

		$btpos = strpos($content, $bodyterminator);
		if ($btpos) {
			$content = substr($content, 0, $btpos);
		}
		$content = trim($content);
		$blah = explode("\n", $content);
		$firstline = $blah[0];
		$secondline = $blah[1];

		if ($use_phoneemail) {
			$btpos = strpos($firstline, $phoneemail_separator);
			if ($btpos) {
				$userpassstring = trim(substr($firstline, 0, $btpos));
				$content = trim(substr($content, $btpos+strlen($phoneemail_separator), strlen($content)));
				$btpos = strpos($content, $phoneemail_separator);
				if ($btpos) {
					$userpassstring = trim(substr($content, 0, $btpos));
					$content = trim(substr($content, $btpos+strlen($phoneemail_separator), strlen($content)));
				}
			}
			$contentfirstline = $blah[1];
		} else {
			$userpassstring = $firstline;
			$contentfirstline = '';
		}
        $flat = 999.0;
        $flon = 999.0;
        $secondlineParts = explode(':',$secondline);
        if(strncmp($secondlineParts[0],"POS",3)==0) {
            echo "Found POS:<br>\n";
            echo "Second parts is:".$secondlineParts[1];
            // the second line is the postion listing line
            $secLineParts = explode(',',$secondlineParts[1]);
            $flatStr = $secLineParts[0];
            $flonStr = $secLineParts[1];
            //echo "String are ".$flatStr.$flonStr;
            $flat = floatval($secLineParts[0]);
            $flon = floatval($secLineParts[1]);
            echo "values are ".$flat." and ".$flon;
            // ok remove that position... we should not have it in the final output
            $content = str_replace($secondline,'',$content);
        }

		$blah = explode(':', $userpassstring);
		$user_login = $blah[0];
		$user_pass = $blah[1];

		$content = $contentfirstline.str_replace($firstline, '', $content);
		$content = trim($content);

//Please uncomment following line, only if you want to check user and password.
//		echo "<p><b>Login:</b> $user_login, <b>Pass:</b> $user_pass</p>";

		#Check to see if there is an attachment, if there is, save the filename in the temp directory
		#First define some constants and message types
		$type = array("text", "multipart", "message", "application", "audio",
		"image", "video", "other");
		#message encodings
		$encoding = array("7bit", "8bit", "binary", "base64", "quoted-printable",
		"other");

		#parse message body (not really used yet, will be used for multiple attachments)
		$attach = parse($struct);
		$attach_parts = get_attachments($attach);

		#get the attachment
		$attachment = imap_fetchbody($mbox, $iCount, 2);
		if ($attachment != '') {
			$attachment = imap_base64($attachment);
			if function_exists('mb_convert_encoding') {
				$temp_file = mb_convert_encoding(mb_decode_mimeheader($struct->parts[1]->dparameters[0]->value),$blog_charset,"auto");
			} else {
				$temp_file = $struct->parts[1]->dparameters[0]->value;
			}
			echo $temp_file;
			if (!($temp_fp = fopen("attach/" . $temp_file, "w"))) {
				echo("error1");
				continue;
			}
			fputs($temp_fp, $attachment);
			fclose($temp_fp);
			wp_create_thumbnail("attach/" .$temp_file,160,"");
		}
		else $attachment = false;


		if ($xooptDB) {
			$sql = "SELECT ID, user_level FROM $tableusers WHERE user_login='$user_login' ORDER BY ID DESC LIMIT 1";
			$result = $wpdb->get_row($sql);
			if (!$result) {
				echo '<p><b>Wrong login</b></p></div>';
				continue;
			} else {
				$sql = "SELECT * FROM ".$xoopsDB->prefix('users')." WHERE uname='".trim($user_login)."' AND pass='".md5(trim($user_pass))."' ORDER BY uid DESC LIMIT 1";
				$result1 = $wpdb->get_row($sql);
		
				if (!$result1) {
					echo '<p><b>Wrong password.</b></p></div>';
					continue;
				}
			}
		} else {
			$sql = "SELECT ID, user_level FROM $tableusers WHERE user_login='".trim($user_login)."' AND user_pass='$user_pass' ORDER BY ID DESC LIMIT 1";
			$result = $wpdb->get_row($sql);

			if (!$result) {
				echo '<p><b>Wrong login or password.</b></p></div>';
				continue;
			}
		}

		$user_level = $result->user_level;
		$post_author = $result->ID;
		if ($user_level > 0) {
			$default_category= '1';
			$post_title = xmlrpc_getposttitle($content);
			$post_category = xmlrpc_getpostcategory($content);

			if ($post_title == '') {
				$post_title = $subject;
			}
			if ($post_category == '') {
				$post_category = $default_category;
			}
			if function_exists('mb_convert_encoding') {
				$content = addslashes(mb_convert_encoding(trim($content),$blog_charset,"JIS"));
			} else {
				$content = addslashes(trim($content));
			}
			if (!$emailtestonly) {
				$post_title = addslashes(trim($post_title));
				#If we find an attachment, add it to the post
				if ($attachment) {
					if (file_exists("attach/thumb-".$temp_file)) {
						$content = "<a href=\"".$siteurl."\/attach\/".$temp_file."\"><img style=\"float: left;\" hspace=\"6\" src = \"".$siteurl."\/attach\/thumb-". $temp_file."\"  alt=\"moblog\" ></a>".$content."<br clear=left>";
					} else {
						$content = "<a href=\"".$siteurl."\/attach\/".$temp_file."\"><img style=\"float: left;\" hspace=\"6\" src = \"".$siteurl."\/attach\/". $temp_file."\"  alt=\"moblog\" ></a>".$content."<br clear=left>";
					}
				}
                if($flat > 500) {
                    $sql = "INSERT INTO $tableposts (post_author, post_date, post_content, post_title, post_category) VALUES ($post_author, '$post_date', '$content', '$post_title', $post_category)";
                } else {
                    $sql = "INSERT INTO $tableposts (post_author, post_date, post_content, post_title, post_category, post_lat, post_lon) VALUES ($post_author, '$post_date', '$content', '$post_title', $post_category, $flat, $flon)";
                }
				$result = $wpdb->query($sql);
				$post_ID = $wpdb->insert_id;
				echo "The result is: ".$result;
				if (isset($sleep_after_edit) && $sleep_after_edit > 0) {
					sleep($sleep_after_edit);
				}

				$blog_ID = 1;
				if($flat < 500) {
					pingGeoUrl($post_ID);
				}
                // HACK HACK HACK this next line is commented out because I don't know what the word-press replacement
                // is.  right now it's undefined and does not work
				//rss_update($blog_ID);
				pingWeblogs($blog_ID);
//				pingCafelog($cafelogID, $post_title, $post_ID);
				pingBlogs($blog_ID);
				pingback($content, $post_ID);

				#delete successful email, mark for deletion actually
				if ($result >0) {imap_delete($mbox, $iCount);echo "deleted successfully";}
				else die ("error deleting message");
			}
			echo "\n<p><b>Posted title:</b> $post_title<br />";
			echo "\n<b>Posted content:</b><br /><pre>".$content.'</pre></p>';

# Added to make category work
#
               if (!$post_categories) $post_categories[] = 1;
                foreach ($post_categories as $post_category) {
                        // Double check it's not there already
                        $exists = $wpdb->get_row("SELECT * FROM $tablepost2cat WHERE post_id = $post_ID AND category_id = $post_category");

                         if (!$exists && $result) {
                                $wpdb->query("
                                INSERT INTO $tablepost2cat
                                (post_id, category_id)
                                VALUES
                                ($post_ID, $post_category)
                                ");
                        }
                }
#
# End of category work stuff

		} else {
			echo '<p><strong>Level 0 users can\'t post.</strong></p>';
		}
		echo '</div>';
		if ($output_debugging_info) {
			ob_end_flush();
		} else {
			ob_end_clean();
		}
	}
	#Clean out the inbox by deleting emails marked for deletion
	imap_expunge($mbox);
}

#Global Function definitions (as from PHP.net), not used yet, will be used for multiple
#attachment parsing

	function parse($structure)
	{
		global $type;
		global $encoding;

		// create an array to hold message sections
		$ret = array();

		// split structure into parts
		$parts = $structure->parts;

		for($x=0; $x<sizeof($parts); $x++)
		{
			$ret[$x]["pid"] = ($x+1);

			$this = $parts[$x];

			// default to text
			if ($this->type == "") { $this->type = 0; }
			$ret[$x]["type"] = $type[$this->type] . "/" . strtolower($this->subtype);

			// default to 7bit
			if ($this->encoding == "") { $this->encoding = 0; }
			$ret[$x]["encoding"] = $encoding[$this->encoding];

			$ret[$x]["size"] = strtolower($this->bytes);

			$ret[$x]["disposition"] = strtolower($this->disposition);

			if (strtolower($this->disposition) == "attachment")
			{
				$params = $this->dparameters;
				foreach ($params as $p)
				{
					if($p->attribute == "FILENAME")
					{
					$ret[$x]["name"] = $p->value;
					break;
					}
				}
			}
		}

	return $ret;
	}

	function get_attachments($arr)
	{
		for($x=0; $x<sizeof($arr); $x++)
		{
			if($arr[$x]["disposition"] == "attachment")
			{
			$ret[] = $arr[$x];
			}
		}
		return $ret;

	}

imap_close($mbox);

timer_stop($output_debugging_info);
exit;
function wp_create_thumbnail($file, $max_side, $effect = '') {

    // 1 = GIF, 2 = JPEG, 3 = PNG

    if(file_exists($file)) {
        $type = getimagesize($file);
        
        // if the associated function doesn't exist - then it's not
        // handle. duh. i hope.
        
        if(!function_exists('imagegif') && $type[2] == 1) {
            $error = 'Filetype not supported. Thumbnail not created.';
        }elseif(!function_exists('imagejpeg') && $type[2] == 2) {
            $error = 'Filetype not supported. Thumbnail not created.';
        }elseif(!function_exists('imagepng') && $type[2] == 3) {
            $error = 'Filetype not supported. Thumbnail not created.';
        } else {
        
            // create the initial copy from the original file
            if($type[2] == 1) {
                $image = imagecreatefromgif($file);
            } elseif($type[2] == 2) {
                $image = imagecreatefromjpeg($file);
            } elseif($type[2] == 3) {
                $image = imagecreatefrompng($file);
            }
            
			if (function_exists('imageantialias'))
	            imageantialias($image, TRUE);
            
            $image_attr = getimagesize($file);
            
            // figure out the longest side
            
            if($image_attr[0] > $image_attr[1]) {
                $image_width = $image_attr[0];
                $image_height = $image_attr[1];
                $image_new_width = $max_side;
                
                $image_ratio = $image_width/$image_new_width;
                $image_new_height = $image_height/$image_ratio;
                //width is > height
            } else {
                $image_width = $image_attr[0];
                $image_height = $image_attr[1];
                $image_new_height = $max_side;
                
                $image_ratio = $image_height/$image_new_height;
                $image_new_width = $image_width/$image_ratio;
                //height > width
            }
            
            $thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
            @imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_attr[0], $image_attr[1]);
            
            // move the thumbnail to it's final destination
            
            $path = explode('/', $file);
            $thumbpath = substr($file, 0, strrpos($file, '/')) . '/thumb-' . $path[count($path)-1];
            
            if($type[2] == 1) {
                if(!imagegif($thumbnail, $thumbpath)) {
                    $error = "Thumbnail path invalid";
                }
            } elseif($type[2] == 2) {
                if(!imagejpeg($thumbnail, $thumbpath)) {
                    $error = "Thumbnail path invalid";
                }
            } elseif($type[2] == 3) {
                if(!imagepng($thumbnail, $thumbpath)) {
                    $error = "Thumbnail path invalid";
                }
            }
            
        }
    }
    
    if(!empty($error))
    {
        return $error;
    }
    else
    {
        return 1;
    }
}

?>
