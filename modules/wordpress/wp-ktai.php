<?php

// WordPress Ktai Edition (DoCoMo)
     $Version = "0.3b";
// ��2004-06-24
//   �����λ��Ȥ��Ǥ���Ȥ���ޤǺ��������������̤�б���
//   2004-06-28
//   �����Ȥλ��ȡ���Ƥ��Ǥ���褦�ˤʤä���
//   2004-06-29
//   ����������б���
//   2004-06-30
//   ��������ʸ������֤������������ǽ̾������򻲾ȡ�
//   �Ǥ��뵡ǽ���ɲá�
//   2004-07-01
//   img�������alt°�����ʤ����Ǥ������󥯤Ǥ���褦������
//   GIF�ե������jpeg�ˤ���ɽ�����뵡ǽ���ɲá�
//   2004-07-05
//   ɽ�����٤������β����������̾��奵����($ImageResizeX)��
//   �꾮�����Ȥ��ϸ��Υ������Τޤ�ɽ������褦������
//   WordPressME 1.2.1��ư���ǧ��
//   �����ȤΥݥ��Ȥǡ�wp-comment-post.php�β�¤�ǡ����Ϥ�sjis
//   �ʤΤ�UTF-8���Ѵ�����ˤ�Ƥ�Ǥ��������������PC����Υ����
//   �ȥݥ��Ȥ�ʸ����������Ȥ����ޥ̥��ʾ㳲�������Ƥ��ޤ��Τǡ�
//   wp-ktai-comment-post.php���äƤ������Ƥ֤褦�˽�����
//   2004-07-06
//   ����HTML��ɽ�����ʤ�����˥����Ȥ�ɽ���˴ؤ���filter���ɲá�
//
// Copyright (c) 2004 Naoki Chiba All rights reserved.
// http://www.nyaos.net/pukiwiki/
//
// ----------------------------------------------------------------
// ���Υץ����ϡ�Ŵ���פ��󡢡�Tonkey�פ����MovableType��
// i-mode�Ѵ�������ץȡ�MT4i�פβ��̥��᡼�������ư��򻲹ͤ�
// WordPress����Ƥ�ɽ���Ǥ���褦PHP�ǥ����ǥ��󥰤�����ΤǤ���
// �������̤�MT4i�ˤ���������Ӥޤ���:-)
// 
// MovableType��MT4i��ȤäƤߤ������ϰʲ��򻲾Ȥ��Ƥ���������
// Ŵ�������MT4i�˴ؤ���ڡ���
//  ��http://www.hazama.nu/t2o2/mt4i.shtml
// Tonkey�����Tonkey Magic
//  ��http://tonkey.mails.ne.jp/
//
// ���㤤���ƾ嵭�Τߤʤ���ˤ��Υץ����˴ؤ������򤷤��ꤷ
// �ʤ��褦�ˡ������ޤǲ��̥��᡼���򻲹ͤˤ��������ʤΤǡ�
// ���Υץ����˴ؤ����䤤��碌�ϰʲ��ؤɤ������������������ֻ�
// �򤷤ޤ���
// PHP�ǥץ�����񤯤ΤϽ��ơ�WordPress����˻ȤäƤ��ʤ�
// �Τ��񤷤�����ϴ���:-)
// http://www.nyaos.net/pukiwiki/pukiwiki.php?%A5%B1%A1%BC%A5%BF%A5%A4%A4%C7WordPress%A4%F2%B1%DC%CD%F7
// ----------------------------------------------------------------

// ----------------------------------------------------------------
// ���Υץ����ϰ��ڤ�ư���ݾڤ򤤤����ޤ��󡣤������äơ�����
// �ץ�������Ѥ������Ȥˤ��»���������פˤĤ�������Ԥ���Ǥ
// ���餤�ޤ��󡣼��ʤ���Ǥ�ˤ����ƻ��Ѥ��Ƥ���������
// �ץ����β��Ѥϼ�ͳ�˹ԤäƤ���������
// ----------------------------------------------------------------

// ----------------------------------------------------------------
// �����͡ʤ��������
//
// ���ڡ���������ΰ���ɽ���Կ�
$ListPerPage = 6; //����������accesskey��Ȥ�����6�ʾ����ꤹ��ȶ���Ū��6�ˤʤ�ޤ���
// ���ڡ����������ɽ��ʸ����
$CharCountPerPage = 0; //ʸ����
// ������ʸ������ִ����뤫������ʤ���ִ�ʸ��������ꤹ�롣
//$ImageReplaceString = ''; //�ִ����ʤ�
$ImageReplaceString = '����:'; //'����:'���ִ����롣
// �����̾���β�������
$ImageResizeX = 132;
//�طʿ�
$BgColor = "#FFFFFF";
//�ƥ����ȿ�
$TextColor = "#000000";
//��󥯿�
$LinkColor = "#0000FF";
//�����Ȥ�ɽ����
//$CommentSort = "ASC"; //�Ť���Τ���ɽ��
$CommentSort = "DESC"; //��������Τ���ɽ��
//
// �����͡ʤ����ޤǡ�
// ----------------------------------------------------------------

//
//�ʹߤ���տ����������뤳�ȡ�
//
// HTTP ����ʸ�����󥳡��ǥ��󥰤�SJIS�����ꤹ��
//mb_http_output('SJIS');

// ���ϤΥХåե���󥰤򳫻Ϥ���������Хå��ؿ��Ȥ���"mb_output_handler"
// ����ꤹ��
//ob_start('mb_output_handler');

ini_set ('display_errors', '1');
ini_set ('error_reporting', E_ALL);
if (file_exists(dirname(__FILE__)."/xoops_version.php")) {
	require('../../mainfile.php'); //XOOPS�ξ��ˤϸƤӽФ����Ϥ���
}
require_once(dirname(__FILE__).'/wp-config.php');

if (defined('XOOPS_URL')) {
	$tableposts = wp_table('posts');
	$tablecomments = wp_table('comments');
}

if (preg_match('/DoCoMo/', $HTTP_USER_AGENT)) {
    $ua_list = explode("/", $HTTP_USER_AGENT);
    $is_docomo = substr($ua_list[3], 1);
    $is_docomo = $is_docomo*1024;
} else {
	$is_docomo = 0;
}

if ($is_docomo) {
	//�����餯���Τ��餤��Content�ʳ�����ʬ�ǻȤäƤ���Ǥ�����
	$CharCountPerPage = $is_docomo - 1024;
}
function get_post_titles($start,$count) {
	global $tableposts,$wpdb;
	$titles = $wpdb->get_results("SELECT ID,post_title,post_date "
	                           ."FROM $tableposts WHERE "
	                           ."post_status = 'publish' "
	                           ."ORDER BY post_date DESC "
	                           ."LIMIT $start,$count"
	                           );
	return $titles;
}

function get_postdata_num($num) {
	global $tableposts,$wpdb;
	$post = $wpdb->get_row("SELECT ID "
	                           ."FROM $tableposts WHERE "
	                           ."post_status = 'publish' "
	                           ."ORDER BY post_date DESC "
	                           ."LIMIT $num,1"
	                           );

	return get_postdata($post->ID);
}

function find_post($num) {
	global $tableposts,$wpdb;
	$titles = $wpdb->get_results("SELECT ID "
	                           ."FROM $tableposts WHERE "
	                           ."post_status = 'publish' "
	                           ."ORDER BY post_date DESC "
	                           ."LIMIT $num,1"
	                           );
	if($titles) {
		return true;
	}else{
		return false;
	}
}

function get_number_of_comments($ID) {
	global $tablecomments,$wpdb;
	$number = $wpdb->get_var("SELECT count(*) FROM $tablecomments WHERE comment_post_ID = $ID AND comment_approved = '1'");
	return $number;
}

function get_comments($ID) {
	global $tablecomments,$wpdb,$CommentSort;
	$comments = $wpdb->get_results("SELECT * FROM $tablecomments WHERE comment_post_ID = $ID AND comment_approved = '1' ORDER BY comment_date $CommentSort");
	return $comments;
}

$blogname = get_bloginfo('name'); //�֥��Υ����ȥ�
$ackeychar = array('&#63888;','&#63879;','&#63880;','&#63881;','&#63882;','&#63883;','&#63884;','&#63885;','&#63886;','&#63887;'); //i-mode�Υ����ֹ��ʸ��


if (!isset($_REQUEST["view"])) {
	$_REQUEST["view"] = "list";
	$_REQUEST["start"] = "0";
}
//
// ����ɽ������
//
switch ($_REQUEST["view"]) {
	case "image" :
		//����ɽ��
		$orgimg = $_REQUEST["url"];
		$imginfo = getimagesize($orgimg);
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
			//GIF�ե������̵�����jpeg���Ѵ�����ɽ�����ޤ���
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
		exit;
}

//
//page start
//
$echostring  = '<html>';
$echostring .= '<!--����-->';
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
	case "list" :
		//��ư���ɽ��
		if ($ListPerPage > 6) {
			$ListPerPage = 6;
		}
		$echostring .= '<center>'.$blogname.'<br />Ktai edition</center><hr />';
		$title_lists = get_post_titles($_REQUEST["start"],$ListPerPage);
		$line_count = 0;
		foreach ($title_lists as $title) {
			if (trim($title->post_title)=="") $title->post_title = _WP_POST_NOTITLE;
			$ackey = $line_count + 1;
			$num = $_REQUEST["start"] + $line_count;
			$tmp = substr($title->post_date,5,2).'/'.substr($title->post_date,8,2).substr($title->post_date,10,6);
			$echostring .= $ackeychar[$ackey].'.<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$num.'&start=0" accesskey="'.$ackey.'">'.$title->post_title.'</a>('.$tmp.')';
			$echostring .= '<font color="#FF00FF">['.get_number_of_comments($title->ID).']</font><br />';
			$line_count++;
		}
		$echostring .= '<hr />';
		$nextstart = $_REQUEST["start"] + $ListPerPage;
		if (find_post($nextstart)) {
			$echostring .= $ackeychar[9].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=list&start='.$nextstart.'" accesskey="9">����'.$ListPerPage.'�� &gt;</a><br/>';
		}
		$prevstart = $_REQUEST["start"] - $ListPerPage;
		if ($prevstart >= 0) {
			$echostring .= $ackeychar[7].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=list&start='.$prevstart.'" accesskey="7">&lt; ����'.$ListPerPage.'��</a><br/>';
			$echostring .= $ackeychar[0].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=list&start=0" accesskey="0">�ȥå� </a><br/>';
		}
		break;

	case "content" :
		if ($CharCountPerPage) {
			$nextpage = round($_REQUEST["start"] / $CharCountPerPage)+1;
		} else {
			$nextpage = 1;
		}
		//���ɽ��
		$post = get_postdata_num($_REQUEST["num"]);
		$nextstart = $_REQUEST["start"] + $CharCountPerPage;
		$prevstart = $_REQUEST["start"] - $CharCountPerPage;
		$tmp = substr($post['Date'],5,2).'/'.substr($post['Date'],8,2).substr($post['Date'],10,6);
		$echostring .= $post['Title'].'('.$tmp.') Page:'.$nextpage.'<hr />';
		$authordata = get_userdata($post['Author_ID']);
		$echostring .= "Author : ".the_author('',false).'<hr />';
		$pages[0] =$post['Content'];$page=1;$more=1;
		$post['Content']=get_the_content('');
		//PukiWiki�ץ饰����ʤɤǥ�����󥰤��Ƥ�����ΰ٤˥ե��륿���̤�
		$post['Content']=apply_filters('the_content',$post['Content']);
		//PukiWiki�ץ饰����ʤɤ��������줿<style>..</style>��������
		$post['Content'] = preg_replace('/<style.*?>.*?<\/style.*?>/ms','',$post['Content']);
		if ($ImageReplaceString == '') { //�����ִ����ʤ�
			$tmp = $post['Content'];
		}else{ //������������硢img���������ʸ������ִ�
			$imgstr = '<img[^>]*src\s*=\s*[\"\']([^\"\'>]*)[\"\'][^>]*alt\s*=\s*[\"\']([^\"\'>]*)[\"\'][^>]*>';
			$repstr = '&lt;<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=imagepage&num='.$_REQUEST["num"].'&url=\\1">'.$ImageReplaceString.'\\2</a>&gt;<br>';
			$tmp = mb_ereg_replace($imgstr,$repstr,stripslashes($post['Content']));
			$imgstr = '<img[^>]*src\s*=\s*[\"\']([^\"\'>]*)[\"\'][^>]*>';
			$repstr = '&lt;<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=imagepage&num='.$_REQUEST["num"].'&url=\\1">'.$ImageReplaceString.'</a>&gt;<br>';
			$tmp = mb_ereg_replace($imgstr,$repstr,$tmp);
		}

		if ($CharCountPerPage > 0) {
			//���Ӥ�ɽ�������ʸ���������˱�����ʬ��
			$tmp1 = mb_strcut($tmp,$_REQUEST["start"],$CharCountPerPage);
			//ʬ���̤ǥ���������ˤʤäƤ��ޤä����ν���
			$tmp1 = preg_replace("/^[^<]*?>/","",$tmp1);
			if (preg_match("/<[^>]*?$/",$tmp1,$match)) {
				$nextstart = $nextstart - strlen($match[0]);
				$prevstart = $prevstart - strlen($match[0]);
				$tmp1 = preg_replace("/<[^>]*?$/","",$tmp1);
			}
			//�б����륿����̵�����˶���Ū�˥������Ĥ��롣
			$tmp1 = "<div>".balanceTags($tmp1)."</div>";
			$echostring .= $tmp1;
			
			$nextpagelen = strlen(mb_strcut($tmp,$nextstart));
			if ($_REQUEST["start"] >0 ) {
				$prevstart = ($prevstart < 0) ? 0 : $prevstart;
				$echostring .= '<hr />';
				$echostring .= $ackeychar[2].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$_REQUEST["num"].'&start='.$prevstart.'" accesskey="2">&lt;&lt;����</a><br />';
			}
			if ($nextpagelen != 0) {
				if ($prevstart < 0 ) {
					$echostring .= '<hr />';
				}
				$echostring .= $ackeychar[8].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$_REQUEST["num"].'&start='.$nextstart.'" accesskey="8">³��&gt;&gt;</a><br />';
			}
		} else {
			$echostring .= $tmp;
		}
		$echostring .= '<hr />';
/*
		//post_password is empty or match cookie password
		if (empty($posts['post_password']) || $HTTP_COOKIE_VARS['wp-postpass'] == $post['post_password']) {

			$comment_author = (empty($HTTP_COOKIE_VARS["comment_author"])) ? "" : trim($HTTP_COOKIE_VARS["comment_author"]);
			$comment_author_email = (empty($HTTP_COOKIE_VARS["comment_author"])) ? "" : trim($HTTP_COOKIE_VARS["comment_author_email"]);
			$comment_author_url = (empty($HTTP_COOKIE_VARS["comment_author"])) ? "" : trim($HTTP_COOKIE_VARS["comment_author_url"]);
*/
			$count = get_number_of_comments($post['ID']);

			if ($count == 0) {
				$echostring .='<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=comment&num='.$_REQUEST["num"].'">�����Ȥ���</a><br />';
			}else{
				$echostring .='<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=comprev&num='.$_REQUEST["num"].'&page=0">������('.$count.')</a><br />';
			}
/*
		} //post_password is empty or match cookie password
*/
		$echostring .= '<hr />';

		$nextnum = $_REQUEST["num"] + 1;
		if (find_post($nextnum)) {
			$echostring .= $ackeychar[9].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$nextnum.'&page=0" accesskey="9">���ε����� &gt;</a><br />';
		}
		$prevnum = $_REQUEST["num"] - 1;
		if ($prevnum >= 0) {
			$echostring .= $ackeychar[7].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$prevnum.'&page=0" accesskey="7">&lt; ���ε�����</a><br />';
		}
		$echostring .= $ackeychar[0].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=list&start=0" accesskey="0">���������</a><br/>';
		
		break;

	case "comprev" :
		//������ɽ��
		$post = get_postdata_num($_REQUEST["num"]);
		$tmp = substr($post['Date'],5,2).'/'.substr($post['Date'],8,2).substr($post['Date'],10,6);
		$echostring .= '<b>'.$post['Title'].'('.$tmp.')�ؤΥ�����</b>';
		$echostring .= '<hr />';
		$comments = get_comments($post['ID']);
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
		$echostring .='<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=comment&num='.$_REQUEST["num"].'">�����Ȥ���</a><br />';
		$echostring .='<hr />';
		$echostring .= $ackeychar[0].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$_REQUEST["num"].'&start=0" accesskey="0">���������</a><br/>';
		break;

	case "comment" :
		//���������
		if (!defined('XOOPS_URL')) {
			$siteurl = get_settings('home');
		}
		$post = get_postdata_num($_REQUEST["num"]);
		$tmp = substr($post['Date'],5,2).'/'.substr($post['Date'],8,2).substr($post['Date'],10,6);
		$echostring .= '<b>'.$post['Title'].'('.$tmp.')�ؤΥ��������</b>';
		$echostring .= '<hr />';

		if ('open' == $post['comment_status']) {
			$echostring .= '<form action="'.$siteurl.'/wp-ktai-comments-post.php" method="post">';
			$echostring .= '̾��<br />';
			$echostring .= '<input type="text" name="author" value="" size="40" /><br />';
			$echostring .= '�᡼�륢�ɥ쥹<br />';
			$echostring .= '<input type="text" name="email" value="" size="40" /><br />';
			$echostring .= 'Web�����ȥ��ɥ쥹<br />';
			$echostring .= '<input type="text" name="url" value="" size="40" /><br />';
			$echostring .= '������<br />';
			$echostring .= '<textarea cols="30" rows="4" name="comment"></textarea><br />';
			$echostring .= '<input type="submit" name="submit" value="����" /><br />';
			$echostring .= '<input type="hidden" name="comment_post_ID" value="'.$post['ID'].'" />';
//			$echostring .= '<input type="hidden" name="redirect_to" value="'.htmlspecialchars($HTTP_SERVER_VARS["REQUEST_URI"]).'" />';
			$echostring .= '<input type="hidden" name="redirect_to" value="'.$siteurl.'/wp-ktai.php?view=comprev&num='.$_REQUEST["num"].'&start=0" />';
			$echostring .= '<input type="hidden" name="comment_autobr" value="1" />';
			$echostring .= '</form>';
		}
		$echostring .= '<hr />';
		$echostring .= $ackeychar[0].'<a href="'.$siteurl.'/wp-ktai.php?view=comprev&num='.$_REQUEST["num"].'&start=0" accesskey="0">���</a><br/>';
		break;

	case "imagepage" :
		//����ɽ���ڡ���
		$echostring .= '<br />';
		$echostring .= '<center><img src="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=image&url='.$_REQUEST["url"].'"/></center>';
		$echostring .='<hr />';
		$echostring .= $ackeychar[0].'<a href="'.$HTTP_SERVER_VARS["PHP_SELF"].'?view=content&num='.$_REQUEST["num"].'&start=0" accesskey="0">���������</a><br/>';
		break;

} 

$echostring .= '<hr />';

$echostring .= '<center><a href="http://www.nyaos.net/pukiwiki/pukiwiki.php?%A5%B1%A1%BC%A5%BF%A5%A4%A4%C7WordPress%A4%F2%B1%DC%CD%F7">WP-Ktai ver '.$Version.'</a></center>';

$echostring .= '</body>';
$echostring .= '</html>';
header("Content-Type: text/html; charset=Shift_JIS");
echo mb_convert_encoding($echostring, "sjis", "auto");
?>
