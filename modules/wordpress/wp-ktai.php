<?php
// WordPress Ktai Edition (DoCoMo)
     $Version = "0.5.0";
//
// Copyright (c) 2004 Naoki Chiba All rights reserved.
// http://www.nyaos.net/pukiwiki/
//
// ----------------------------------------------------------------
// このプログラムは「鉄太」さん、「Tonkey」さんのMovableType用
// i-mode変換スクリプト「MT4i」の画面イメージおよび動作を参考に
// WordPressの投稿を表示できるようPHPでコーディングしたものです。
// あらゆる面でMT4iには全くおよびませんが:-)
// 
// MovableTypeでMT4iを使ってみたい方は以下を参照してください。
// 鉄太さんのMT4iに関するページ
//  →http://www.hazama.nu/t2o2/mt4i.shtml
// TonkeyさんのTonkey Magic
//  →http://tonkey.mails.ne.jp/
//
// 勘違いして上記のみなさんにこのプログラムに関する質問をしたりし
// ないように。あくまで画面イメージを参考にしただけなので。
// このプログラムに関する問い合わせは以下へどうぞ。気が向いたら返事
// をします。
// PHPでプログラムを書くのは初めて＆WordPressもろくに使っていない
// ので難しい質問は勘弁:-)
// http://www.nyaos.net/pukiwiki/pukiwiki.php?%A5%B1%A1%BC%A5%BF%A5%A4%A4%C7WordPress%A4%F2%B1%DC%CD%F7
// ----------------------------------------------------------------

// ----------------------------------------------------------------
// このプログラムは一切の動作保証をいたしません。したがって、この
// プログラムを使用したことによる損害、不利益について著作者は責任
// を負いません。自己の責任において使用してください。
// プログラムの改変は自由に行ってください。
// ----------------------------------------------------------------
if (file_exists(dirname(__FILE__)."/xoops_version.php")) {
	require('../../mainfile.php'); //XOOPSの場合には呼び出されるはず。
}
require_once(dirname(__FILE__).'/wp-config.php');
// ----------------------------------------------------------------
// 設定値（ここから）
//
// １ページあたりの一覧表示行数
$ListPerPage = 6; //ケータイのaccesskeyを使うため6以上を指定すると強制的に6になります。
$CommentPerPage = 10;
// １ページあたりの表示文字数
$CharCountPerPage = 0; //文字数
// 画像を文字列に置換するか？するならば置換文字列を設定する。
//$ImageReplaceString = ''; //置換しない
$ImageReplaceString = '画像'; //'画像'に置換する。
// 画像縮小後の横サイズ
$ImageResizeX = 132;
//背景色
$BgColor = "#FFFFFF";
//テキスト色
$TextColor = "#000000";
//リンク色
$LinkColor = "#0000FF";
//コメントの表示順
//$CommentSort = "ASC"; //古いものから表示
$CommentSort = "DESC"; //新しいものから表示
//XOOPSのSESSIONを使用してコメント投稿にチケットを使用する。
if (defined('XOOPS_URL')) {
	$UseSession = true;
}
// 設定値（ここまで）
// ----------------------------------------------------------------
ini_set ('display_errors', '1');
ini_set ('error_reporting', E_ALL);

if (defined('XOOPS_URL')) {
	$tableposts = wp_table('posts');
	$tablecomments = wp_table('comments');
} else {
	$siteurl = get_settings('home');
}
$myurl = $siteurl.'/'.basename(__FILE__);

if (preg_match('/DoCoMo/', $HTTP_USER_AGENT)) {
    $ua_list = explode("/", $HTTP_USER_AGENT);
    $is_docomo = substr($ua_list[3], 1);
    $is_docomo = $is_docomo*1024;
} else {
	$is_docomo = 0;
}
if ($UseSession) {
    $ses_param = (SID) ? '&'.SID : '';
	$do_redir = true;
} else {
	$ses_param = '';
}

if ($is_docomo) {
	//おそらくこのくらいがContent以外の部分で使っているであろう。
	$CharCountPerPage = $is_docomo - 1024;
}
function get_post_titles($start,$count) {
	global $tableposts,$wpdb;
	$now = current_time('mysql');
	$titles = $wpdb->get_results('SELECT ID,post_title,post_date '
	                           .'FROM '.$tableposts.' WHERE '
	                           .'post_status = \'publish\' '
                               .'AND post_date <= \''.$now.'\' '
	                           .'ORDER BY post_date DESC '
	                           .'LIMIT '.$start.','.$count
	                           );
	return $titles;
}

function find_post($num) {
	global $tableposts,$wpdb;
	$now = current_time('mysql');
	$post = $wpdb->get_row('SELECT ID '
	                           .'FROM '.$tableposts.' WHERE '
	                           .'post_status = \'publish\' '
                               .'AND post_date <= \''.$now.'\' '
	                           .'ORDER BY post_date DESC '
	                           .'LIMIT '.$num.',1'
	                           );
	if($post) {
		return $post->ID;
	}else{
		return false;
	}
}

function get_number_of_comments($ID) {
	global $tablecomments,$wpdb;
	$number = $wpdb->get_var("SELECT count(*) FROM $tablecomments WHERE comment_post_ID = $ID AND comment_approved = '1'");
	return $number;
}

function get_comments($ID,$start,$count) {
	global $tablecomments,$wpdb,$CommentSort;
	$comments = $wpdb->get_results("SELECT * FROM $tablecomments WHERE comment_post_ID = $ID AND comment_approved = '1' ORDER BY comment_date $CommentSort LIMIT $start ,$count");
	return $comments;
}

if (!function_exists('wp_get_fullurl')) {
	function wp_get_fullurl($url) {
		preg_match('#(http://[^/]*)#' , XOOPS_URL, $my_host);
		$my_host = $my_host[0];
		$test = parse_url($url);
		if (!isset($test['host']) && ($url[0] == '/')) {
			$url = $my_host.$url;
		}
		return($url);
	}
}

$blogname = get_bloginfo('name'); //ブログのタイトル
$ackeychar = array('&#63888;','&#63879;','&#63880;','&#63881;','&#63882;','&#63883;','&#63884;','&#63885;','&#63886;','&#63887;'); //i-modeのキー番号の文字


if (!isset($_REQUEST["view"])) {
	$_REQUEST["view"] = "list";
	$_REQUEST["start"] = "0";
}
//
// 画像表示処理
//
switch ($_REQUEST["view"]) {
	case "image" :
		//画像表示
		$orgimg = $_REQUEST["url"];
		if (defined('XOOPS_URL')) {
			error_reporting(E_ERROR);
			require_once '../../class/snoopy.php';
			$snoopy =& new Snoopy;
			$snoopy->fetch($orgimg);
			$orgimg = tempnam(XOOPS_ROOT_PATH.'/cache', 'wp_ktai_img');
			$fp=fopen($orgimg,'w');
			fwrite($fp, $snoopy->results);
			fclose($fp);
		}
		$imginfo = getimagesize($orgimg) ;
		if (eregi('.jpeg',$orgimg) || eregi('.jpg',$orgimg) || $imginfo[2]==IMAGETYPE_JPEG ) {
			header("Content-type: image/jpeg");
			header("Cache-control: no-cache");

			$image = ImageCreateFromJPEG($orgimg);

			$orgX = ImageSX($image);
			$orgY = ImageSY($image);
			if ($orgX < $ImageResizeX) {
				$newX = $orgX;
				$newY = $orgY;
			} else {
				$newX = $ImageResizeX;
				$newY = $orgY / $orgX * $ImageResizeX;
			}

			$newimage = ImageCreateTrueColor($newX,$newY);

			ImageCopyResized($newimage, $image, 0, 0, 0, 0, $newX, $newY,$orgX,$orgY);

			imagedestroy($image);

			imageJPEG($newimage);

			imagedestroy($newimage);
			
		}else if (eregi('.gif',$orgimg)|| $imginfo[2]==IMAGETYPE_GIF) {
			//GIFファイルは無理やりjpegに変換して表示します。
			header("Content-type: image/jpeg");
			header("Cache-control: no-cache");

			$image = ImageCreateFromGIF($orgimg);

			$orgX = ImageSX($image);
			$orgY = ImageSY($image);
			if ($orgX < $ImageResizeX) {
				$newX = $orgX;
				$newY = $orgY;
			} else {
				$newX = $ImageResizeX;
				$newY = $orgY / $orgX * $ImageResizeX;
			}

			$newimage = ImageCreateTrueColor($newX,$newY);

			$white = imagecolorallocate($newimage, 255, 255, 255);
			imagefilledrectangle($newimage, 0, 0, $newX, $newY, $white);
			imagecolortransparent($newimage,$white);

			ImageCopyResized($newimage, $image, 0, 0, 0, 0, $newX, $newY,$orgX,$orgY);

			imagedestroy($image);

			imagejpeg($newimage);

			imagedestroy($newimage);
		}
		if (defined('XOOPS_URL')) {
			unlink($orgimg);
		}
		exit;
}

//
//page start
//
$echostring  = '<html>';
$echostring .= '<!--美乳-->';
$echostring .= '<head>';
$echostring .= '<title>'.$blogname.' Ktai edition</title>';
$echostring .= '<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />';
$echostring .= '</head>';

$echostring .= '<body bgcolor='.$BgColor.' text='.$TextColor.' link='.$LinkColor.'>';

if (!isset($_REQUEST["view"])) {
	$_REQUEST["view"] = "list";
	$_REQUEST["start"] = "0";
}
switch ($_REQUEST["view"]) {
    case 'redir'  :
    	$url = ereg_replace(";ampchar;","&",$_GET['url']);
		$echostring .= '<center>'.$blogname.'<br />Ktai edition</center><hr />';
		$echostring .= '<p>当サイトの外にリンクしています。場合によっては、携帯端末では表示できない可能性があります。</p>';
		$echostring .= '<a href="'.$url.'">GO!</a>';
		$do_redir = false;
		$hidefooter = true;
    	break;
	case "list" :
		$start = intval($_REQUEST["start"]);
		//投稿一覧表示
		if ($ListPerPage > 6) {
			$ListPerPage = 6;
		}
		$echostring .= '<center>'.$blogname.'<br />Ktai edition</center><hr />';
		$title_lists = get_post_titles($start, $ListPerPage);
		$line_count = 0;
		foreach ($title_lists as $title) {
			if (trim($title->post_title)=="") $title->post_title = _WP_POST_NOTITLE;
			$ackey = $line_count + 1;
			$num = $start + $line_count;
			$date = mysql2date('m/d H:i', $title->post_date);
			$echostring .= $ackeychar[$ackey].'.<a href="'.$myurl.'?view=content&num='.$num.'&p='.$title->ID.'&start=0'.$ses_param.'" accesskey="'.$ackey.'">'.$title->post_title.'</a>('.$date.')';
			$echostring .= '<font color="#FF00FF">['.get_number_of_comments($title->ID).']</font><br />';
			$line_count++;
		}
		$echostring .= '<hr />';
		$nextstart = $start + $ListPerPage;
		if (find_post($nextstart)) {
			$echostring .= $ackeychar[9].'<a href="'.$myurl.'?view=list&start='.$nextstart.$ses_param.'" accesskey="9">次の'.$ListPerPage.'件 &gt;</a><br/>';
		}
		$prevstart = $start - $ListPerPage;
		if ($prevstart >= 0) {
			$echostring .= $ackeychar[7].'<a href="'.$myurl.'?view=list&start='.$prevstart.$ses_param.'" accesskey="7">&lt; 前の'.$ListPerPage.'件</a><br/>';
			$echostring .= $ackeychar[0].'<a href="'.$myurl.'?view=list&start=0'.$ses_param.'" accesskey="0">トップ </a><br/>';
		}
		break;

	case "content" :
		$start = intval($_REQUEST["start"]);
		$num = intval($_REQUEST["num"]);
		$p = intval($_REQUEST["p"]);
		
		if ($CharCountPerPage) {
			$nextpage = round($start / $CharCountPerPage)+1;
		} else {
			$nextpage = 1;
		}
		//投稿表示
		$postdata = get_postdata($p);
		$nextstart = $start + $CharCountPerPage;
		$prevstart = $start - $CharCountPerPage;
		$date = mysql2date('m/d H:i', $postdata['Date']);
		$echostring .= $postdata['Title'].'('.$date.') Page:'.$nextpage.'<hr />';
		$authordata = get_userdata($postdata['Author_ID']);
		$echostring .= "Author   : ".the_author('',false).'<br>Category: '.strip_tags(the_category('-', '', false)).'<hr />';
		if (empty($GLOBALS['post']->post_password)) {
			$pages[0] =$postdata['Content'];$page=1;$more=1;
			$postdata['Content']=get_the_content('');
			//PukiWikiプラグインなどでレンダリングしている場合の為にフィルタを通す
			$postdata['Content']=apply_filters('the_content',$postdata['Content']);
			//PukiWikiプラグインなどで挿入された<style>..</style>タグを削除
			$postdata['Content'] = preg_replace('/<style.*?>.*?<\/style.*?>/ms','',$postdata['Content']);
			if ($ImageReplaceString == '') { //画像置換しない
				$content = $postdata['Content'];
			}else{ //画像削除する場合、imgタグを指定文字列に置換
				$imgstr = array();
				$repstr = array();
				$imgstr[] = '/<img[^>]*src\s*=\s*[\"\']([^\"\'>]*)[\"\'][^>]*alt\s*=\s*[\"\']([^\"\'>]*)[\"\'][^>]*>/ie';
				$repstr[] = '"&lt;<a href=\"'.$siteurl.'/wp-ktai.php?view=imagepage&num='.$num.'&p='.$p.'&url=".urlencode("$1")."'.$ses_param.'\">'.$ImageReplaceString.':\\2</a>&gt;<br>"';
				$imgstr[] = '/<img[^>]*src\s*=\s*[\"\']([^\"\'>]*)[\"\'][^>]*>/ie';
				$repstr[] = '"&lt;<a href=\"'.$siteurl.'/wp-ktai.php?view=imagepage&num='.$num.'&p='.$p.'&url=".urlencode("$1")."'.$ses_param.'\">'.$ImageReplaceString.'</a>&gt;<br>"';
				$content = preg_replace($imgstr,$repstr,$postdata['Content']);
			}

			if ($CharCountPerPage > 0) {
				//携帯で表示出来る文字サイズに応じて分割
				$content_1 = mb_strcut($content, $start, $CharCountPerPage);
				//分割結果でタグの途中になってしまった場合の処理
				$content_1 = preg_replace("/^[^<]*?>/","",$content_1);
				if (preg_match("/<[^>]*?$/",$content_1,$match)) {
					$nextstart = $nextstart - strlen($match[0]);
					$prevstart = $prevstart - strlen($match[0]);
					$content_1 = preg_replace("/<[^>]*?$/","",$content_1);
				}
				//対応するタグが無い場合に強制的にタグを閉じる。
				$content_1 = "<div>".balanceTags($content_1)."</div>";
				$echostring .= $content_1;
				
				$nextpagelen = strlen(mb_strcut($content,$nextstart));
				if ($start >0 ) {
					$prevstart = ($prevstart < 0) ? 0 : $prevstart;
					$echostring .= '<hr />';
					$echostring .= $ackeychar[2].'<a href="'.$myurl.'?view=content&num='.$num.'&p='.$p.'&start='.$prevstart.$ses_param.'" accesskey="2">&lt;&lt;手前</a><br />';
				}
				if ($nextpagelen != 0) {
					if ($prevstart < 0 ) {
						$echostring .= '<hr />';
					}
					$echostring .= $ackeychar[8].'<a href="'.$myurl.'?view=content&num='.$num.'&p='.$p.'&start='.$nextstart.$ses_param.'" accesskey="8">続き&gt;&gt;</a><br />';
				}
			} else {
				$echostring .= $content;
			}
			$echostring .= '<hr />';
			$count = get_number_of_comments($postdata['ID']);
			if ($count == 0) {
				$echostring .='<a href="'.$myurl.'?view=comment&num='.$num.'&p='.$p.$ses_param.'">コメントする</a><br />';
			}else{
				$echostring .='<a href="'.$myurl.'?view=comprev&num='.$num.'&p='.$p.'&page=0'.$ses_param.'">コメント('.$count.')</a><br />';
			}
		} else {
			$echostring .=  '<font color="red">[パスワードで保護された記事は携帯ではご覧になれません。]</font>';
		}
		$echostring .= '<hr />';

		$nextnum = $num + 1;
		if ($next_p = find_post($nextnum)) {
			$echostring .= $ackeychar[9].'<a href="'.$myurl.'?view=content&num='.$nextnum.'&p='.$next_p.'&page=0'.$ses_param.'" accesskey="9">次の記事へ &gt;</a><br />';
		}
		$prevnum = $num - 1;
		if ($prev_p = find_post($prevnum)) {
			$echostring .= $ackeychar[7].'<a href="'.$myurl.'?view=content&num='.$prevnum.'&p='.$prev_p.'&page=0'.$ses_param.'" accesskey="7">&lt; 前の記事へ</a><br />';
		}
		$echostring .= $ackeychar[0].'<a href="'.$myurl.'?view=list&start=0'.$ses_param.'" accesskey="0">一覧へ戻る</a><br/>';
		
		break;

	case "comprev" :
		$num = intval($_REQUEST["num"]);
		$p = intval($_REQUEST["p"]);
		$start = intval(isset($_REQUEST["start"]) ? $_REQUEST["start"]: 0);
		if ($CommentPerPage > 10) {
			$CommentPerPage = 10;
		}
		//コメント表示
		$postdata = get_postdata($p);
		$tmp = substr($postdata['Date'],5,2).'/'.substr($postdata['Date'],8,2).substr($postdata['Date'],10,6);
		$echostring .= '<b>'.$postdata['Title'].'('.$tmp.')へのコメント</b>';
		$echostring .= '<hr />';
		$comment_num = get_number_of_comments($postdata['ID']);
		$comments = get_comments($postdata['ID'], $start, $CommentPerPage);
		if ($comments) {
			foreach ($comments as $comment) {
				$author = apply_filters('comment_author', $comment->comment_author);
				if (empty($author)) {
					$author = 'Anonymous';
				}
				$echostring .= '<b>by '.$author;
				$tmp = substr($comment->comment_date,5,2).'/'.substr($comment->comment_date,8,2).substr($comment->comment_date,10,6);
				$echostring .= '('.$tmp.')</b><br /><br />';
				$comment_text = str_replace('<trackback />', '', $comment->comment_content);
				$comment_text = str_replace('<pingback />', '', $comment_text);
				$echostring .= apply_filters('comment_text', $comment_text);
				$echostring .= '<hr />';
			}
		}
		if (defined('XOOPS_URL')) {
			if (!get_xoops_option(wp_mod(), 'wp_use_xoops_comments')) {
				$echostring .='<a href="'.$myurl.'?view=comment&num='.$num.'&p='.$p.$ses_param.'">コメントする</a><br />';
			}
		} else {
			if (!get_option('comment_registration')) {
				$echostring .='<a href="'.$myurl.'?view=comment&num='.$num.'&p='.$p.$ses_param.'">コメントする</a><br />';
			}
		}
		if ($comment_num > $start+$CommentPerPage) {
			$echostring .= $ackeychar[9].'<a href="'.$myurl.'?view=comprev&start='.($start+$CommentPerPage).'&num='.$num.'&p='.$p.$ses_param.'" accesskey="9">次の'.$CommentPerPage.'件のコメント &gt;</a><br/>';
		}
		if (0 <= $start-$CommentPerPage) {
			$echostring .= $ackeychar[7].'<a href="'.$myurl.'?view=comprev&start='.($start-$CommentPerPage).'&num='.$num.'&p='.$p.$ses_param.'" accesskey="9">前の'.$CommentPerPage.'件のコメント &gt;</a><br/>';
		}
		$echostring .='<hr />';
		$echostring .= $ackeychar[0].'<a href="'.$myurl.'?view=content&num='.$num.'&p='.$p.'&start=0'.$ses_param.'" accesskey="0">記事へ戻る</a><br/>';
		break;

	case "comment" :
		$num = intval($_REQUEST["num"]);
		$p = intval($_REQUEST["p"]);
		//コメント投稿
		$postdata = get_postdata($p);
		$tmp = substr($postdata['Date'],5,2).'/'.substr($postdata['Date'],8,2).substr($postdata['Date'],10,6);
		$echostring .= '<b>'.$postdata['Title'].'('.$tmp.')へのコメント投稿</b>';
		$echostring .= '<hr />';

		if ('open' == $postdata['comment_status']) {
			$echostring .= '<form action="'.$siteurl.'/wp-ktai-comments-post.php" method="post">';
			$echostring .= '名前<br />';
			$echostring .= '<input type="text" name="author" value="" size="40" /><br />';
			$echostring .= 'メールアドレス<br />';
			$echostring .= '<input type="text" name="email" value="" size="40" /><br />';
			$echostring .= 'Webサイトアドレス<br />';
			$echostring .= '<input type="text" name="url" value="" size="40" /><br />';
			$echostring .= 'コメント<br />';
			$echostring .= '<textarea cols="30" rows="4" name="comment"></textarea><br />';
			$echostring .= '<input type="submit" name="submit" value="送信" /><br />';
			$echostring .= '<input type="hidden" name="comment_post_ID" value="'.$postdata['ID'].'" />';
			$echostring .= '<input type="hidden" name="redirect_to" value="'.$siteurl.'/wp-ktai.php?view=comprev&num='.$num.'&p='.$p.'&start=0'.$ses_param.'" />';
			$echostring .= '<input type="hidden" name="comment_autobr" value="1" />';
			if ($UseSession) {
				$echostring .= '<input type="hidden" name="use_session" value="1" />';
			    $echostring .=  $xoopsWPTicket->getTicketHtml(__LINE__, 3600);
				if ($ses_param) {
				    $echostring .= '<input type="hidden" name="PHPSESSID" value="'.session_id().'" />';
			    }
			} else {
				$echostring .= '<input type="hidden" name="use_session" value="0" />';
			}
			$echostring .= '</form>';
		}
		$echostring .= '<hr />';
		$echostring .= $ackeychar[0].'<a href="'.$siteurl.'/wp-ktai.php?view=comprev&num='.$num.'&p='.$p.'&start=0'.$ses_param.'" accesskey="0">戻る</a><br/>';
		break;

	case "imagepage" :
		//画像表示ページ
		$num = intval($_REQUEST["num"]);
		$p = intval($_REQUEST["p"]);
		$url = urlencode(wp_get_fullurl(htmlspecialchars($_REQUEST['url'])));

		$echostring .= '<br />';
		$echostring .= '<center><img src="'.$myurl.'?view=image&url='.$url.'"/></center>';
		$echostring .='<hr />';
		$echostring .= $ackeychar[0].'<a href="'.$myurl.'?view=content&num='.$num.'&p='.$p.'&start=0'.$ses_param.'" accesskey="0">記事へ戻る</a><br/>';
		break;

} 

$echostring .= '<hr />';
if (empty($hidefooter)) {
	$echostring .= '<center><a href="http://www.nyaos.net/pukiwiki/pukiwiki.php?%A5%B1%A1%BC%A5%BF%A5%A4%A4%C7WordPress%A4%F2%B1%DC%CD%F7">WP-Ktai ver '.$Version.'</a></center>';
}
$echostring .= '</body>';
$echostring .= '</html>';
if ($do_redir) {
	preg_match_all("{<(?:img|a)[^>]*(?:href|src)=([\"'])((http://|https://|/)[^\\1]*?)\\1[^>]*>}i", $echostring, $post_links_temp);
	for($i = 0; $i < count($post_links_temp[0]); $i++) {
		$link_test = wp_get_fullurl($post_links_temp[2][$i]);
		$test = parse_url($link_test);
		if (!strstr($link_test,$siteurl)) {
			$src[] = $post_links_temp[0][$i];
			$t_url = $myurl.'?view=redir&url='.urlencode(preg_replace('|&amp;|',';ampchar;', $link_test));
			$target[] = str_replace($post_links_temp[2][$i],$t_url, $post_links_temp[0][$i]);
		}
	}
	$echostring = str_replace($src,$target,$echostring);
}
header('Content-Type: text/html; charset=Shift_JIS');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
echo mb_convert_encoding($echostring, 'SJIS', 'auto');
?>
