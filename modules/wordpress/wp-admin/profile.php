<?php
require_once('admin.php');

$title = "Profile";
$this_file = 'profile.php';
$parent_file = 'profile.php';

param('action', 'string', '');
switch($action) {
	case 'update':
		wp_refcheck("/wp-admin/profile.php");
		param('newuser_firstname', 'string');
		param('newuser_lastname', 'string');
		param('newuser_nickname', 'string',true);
		param('newuser_icq','string');
		param('newuser_aim','string');
		param('newuser_msn','string');
		param('newuser_yim','string');
		param('newuser_email','string',true);
		param('newuser_url','string');
		param('newuser_idmode','string');
		param('user_description','string');

		/* if the ICQ UIN has been entered, check to see if it has only numbers */
		if ($newuser_icq) {
			if ((ereg("^[0-9]+$",$newuser_icq))==false) {
				redirect_header($siteurl.'/wp-admin/profile.php',5,_LANG_WLC_RIGHT_PROM);
				exit();
			}
		}

		/* checking e-mail address */
		if (!is_email($newuser_email)) {
			redirect_header($siteurl.'/wp-admin/profile.php',5,_LANG_WPF_ERR_CORRECT);
			exit();
		}

		$newuser_firstname=$wpdb->escape($newuser_firstname);
		$newuser_lastname=$wpdb->escape($newuser_lastname);
		$newuser_nickname=$wpdb->escape($newuser_nickname);
		$newuser_icq=$wpdb->escape($newuser_icq);
		$newuser_aim=$wpdb->escape($newuser_aim);
		$newuser_msn=$wpdb->escape($newuser_msn);
		$newuser_yim=$wpdb->escape($newuser_yim);
		$newuser_email=$wpdb->escape($newuser_email);
		$newuser_url=$wpdb->escape($newuser_url);
		$newuser_idmode=$wpdb->escape($newuser_idmode);
		$user_description =$wpdb->escape($user_description);

		$query = "UPDATE {$wpdb->users[$wp_id]} SET user_firstname='$newuser_firstname', user_lastname='$newuser_lastname', user_nickname='$newuser_nickname', user_icq='$newuser_icq', user_email='$newuser_email', user_url='$newuser_url', user_aim='$newuser_aim', user_msn='$newuser_msn', user_yim='$newuser_yim', user_idmode='$newuser_idmode', user_description = '$user_description' WHERE ID = $user_ID";
		$result = $wpdb->query($query);
		if (!$result) {
			redirect_header($siteurl.'/wp-admin/profile.php',5,_LANG_WPF_ERR_PROFILE);
			exit();
		}
		
		header('Location: profile.php?updated=true');
		break;

	case 'viewprofile':
		param('user','integer');
		$profiledata = get_userdata($user);
		if (isset($xoopsUser) && ($xoopsUser->getVar('uname') == $profiledata->user_login)) {
			header ('Location: profile.php');
		}
		include_once('admin-header.php');

	switch($profiledata->user_idmode) {
			case 'nickname':	$r = $profiledata->user_nickname;	break;
			case 'login':		$r = $profiledata->user_login;		break;
			case 'firstname':	$r = $profiledata->user_firstname;	break;
			case 'lastname':	$r = $profiledata->user_lastname;	break;
			case 'namefl':		$r = $profiledata->user_firstname.' '.$profiledata->user_lastname;	break;
	 		case 'namelf':		$r = $profiledata->user_lastname.' '.$profiledata->user_firstname;	break;
	}
?>
<h2><?php echo _LANG_WPF_SUBT_VIEW; ?> &#8220;<?echo $r ?>&#8221;</h2>
  <div id="profile">
<p> 
  <strong>Login</strong> <?php echo $profiledata->user_login ?>
	  | <strong>User #</strong> <?php echo $profiledata->ID ?> 
	  | <strong>Level</strong> <?php echo $profiledata->user_level ?> 
	  | <strong>Posts</strong> <?php echo get_usernumposts($user) ?>
</p>
<p> <strong><?php echo _LANG_WPF_SUBT_FIRST; ?></strong> <?php echo $profiledata->user_firstname ?> </p>
<p> <strong><?php echo _LANG_WPF_SUBT_LAST; ?></strong> <?php echo $profiledata->user_lastname ?> </p>
<p> <strong><?php echo _LANG_WPF_SUBT_NICK; ?></strong> <?php echo $profiledata->user_nickname ?> </p>
<?php if ($user == $user_ID) { ?>
	<p> <strong><?php echo _LANG_WPF_SUBT_MAIL; ?></strong> <?php echo make_clickable($profiledata->user_email) ?> </p>
<?php } ?>
<p> <strong><?php echo _LANG_WPF_SUBT_URL; ?></strong> <?php echo $profiledata->user_url ?> </p>
<p> <strong><?php echo _LANG_WPF_SUBT_ICQ; ?></strong> 
	<?php echo ($profiledata->user_icq > 0) ? make_clickable("icq:".$profiledata->user_icq):'' ?>
</p>
<p> <strong><?php echo _LANG_WPF_SUBT_MSN; ?></strong> <?php echo $profiledata->user_msn ?> </p>
<p> <strong><?php echo _LANG_WPF_SUBT_YAHOO; ?></strong> <?php echo $profiledata->user_yim ?> </p>
</div>
	<?php
break;

case 'IErightclick':
	$bookmarklet_tbpb  = (get_settings('use_trackback')) ? '&trackback=1' : '';
	$bookmarklet_tbpb .= (get_settings('use_pingback'))  ? '&pingback=1'  : '';
	$bookmarklet_height= (get_settings('use_trackback')) ? 590 : 550;
	?>
	<div class="menutop">&nbsp;<?php echo _LANG_WPF_SUBT_ONE; ?></div>
	<table width="100%" cellpadding="20">
	<tr><td>
	<p><?php echo _LANG_WPF_SUBT_COPY; ?></p>
	<?php
	$regedit = "REGEDIT4\r\n[HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\MenuExt\Post To &WP : ".get_settings('blogname')."]\r\n@=\"$siteurl/wp-admin/bookmarklet.jp.php\"\r\n\"contexts\"=hex:31\"";
	?>
	<pre style="margin: 20px; background-color: #cccccc; border: 1px dashed #333333; padding: 5px; font-size: 12px;"><?php echo $regedit; ?></pre>
	<p><?php echo _LANG_WPF_SUBT_BOOK; ?></p>
	</td></tr>
	</table>
	<?php
	exit();
	break;
	default:
		$standalone = 0;
		include_once('admin-header.php');

		param('updated','string','');

	$profiledata=get_userdata($user_ID);

	$bookmarklet_tbpb  = (get_settings('use_trackback')) ? '&trackback=1' : '';
	$bookmarklet_tbpb .= (get_settings('use_pingback'))  ? '&pingback=1'  : '';
	$bookmarklet_height= (get_settings('use_trackback')) ? 480 : 440;

	if ($updated) {
?>
<div class="wrap">
	<p><strong><?php echo _LANG_WPF_SUBT_UPDATED; ?></strong></p>
</div>
    <?php
		} 
		include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
		$myts =& MyTextSanitizer::getInstance();
		
		$user_login = $myts->makeTboxData4Show($profiledata->user_login);
		$user_firstname = $myts->makeTboxData4Edit($profiledata->user_firstname);
		$user_lastname = $myts->makeTboxData4Edit($profiledata->user_lastname);
		$user_description = $myts->makeTareaData4Edit($profiledata->user_description);
		$user_nickname = $myts->makeTboxData4Edit($profiledata->user_nickname);
		$user_email = $myts->makeTboxData4Edit($profiledata->user_email);
		$user_url = $myts->makeTboxData4Edit($profiledata->user_url);
		$user_icq = ($profiledata->user_icq ==0)? "":$profiledata->user_icq;
		$user_aim = $myts->makeTboxData4Edit($profiledata->user_aim);
		$user_msn = $myts->makeTboxData4Edit($profiledata->user_msn);
		$user_yim = $myts->makeTboxData4Edit($profiledata->user_yim);
		$user_idmode = $myts->makeTboxData4Edit($profiledata->user_idmode);
		
		$form = new XoopsThemeForm(_LANG_WPF_SUBT_EDIT, "profile", "profile.php");
		$form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_USERID, $profiledata->ID));
		$form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_LEVEL, $profiledata->user_level));
		$form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_POSTS, get_usernumposts($user_ID)));
		$form->addElement(new XoopsFormLabel(_LANG_WPF_SUBT_LOGIN, $user_login));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_FIRST, "newuser_firstname", 50, 150, $user_firstname));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_LAST, "newuser_lastname", 50, 150, $user_lastname));
		$form->addElement(new XoopsFormTextArea(_LANG_WPF_SUBT_DESC, "user_description", $user_description, 5,60));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_NICK, "newuser_nickname", 50, 150, $user_nickname), true);
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_MAIL, "newuser_email", 50, 150, $user_email), true);
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_URL, "newuser_url", 50, 150, $user_url));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_ICQ, "newuser_icq", 50, 150, $user_icq));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_AIM, "newuser_aim", 50, 150, $user_aim));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_AIM, "newuser_msn", 50, 150, $user_msn));
		$form->addElement(new XoopsFormText(_LANG_WPF_SUBT_YAHOO, "newuser_yim", 50, 150, $user_yim));
		$form_idmode = new XoopsFormSelect(_LANG_WPF_SUBT_IDENTITY, "newuser_idmode", $user_idmode);
		$form_idmode->addOption("nickname", $profiledata->user_nickname);
		$form_idmode->addOption("login", $profiledata->user_login);
		$form_idmode->addOption("firstname", $profiledata->user_firstname);
		$form_idmode->addOption("lastname", $profiledata->user_lastname);
		$form_idmode->addOption("namefl", $profiledata->user_firstname." ".$profiledata->user_lastname);
		$form_idmode->addOption("namelf", $profiledata->user_lastname." ".$profiledata->user_firstname);
		$form->addElement($form_idmode);
		$form->addElement(new XoopsFormButton("", "submit", _LANG_WPF_SUBT_UPDATE, "submit"));
		$form->addElement(new XoopsFormHidden("checkuser_id", $user_ID));
		$form->addElement(new XoopsFormHidden("action", "update"));
		$form->display();
	?>
<?php if ($is_gecko) { ?>
    <script language="JavaScript" type="text/javascript">
		function addPanel() {
			if ((typeof window.sidebar == "object") && (typeof window.sidebar.addPanel == "function")) {
      	      window.sidebar.addPanel("WordPress Post: <?php echo get_settings('blogname') ?>","<?php echo $siteurl ?>/wp-admin/sidebar.php","");
			} else {
   	         alert(_LANG_WPF_SUBT_MOZILLA);
 	       }
		}
	</script>
    <strong><?php echo _LANG_WPF_SUBT_SIDEBAR; ?></strong><br />
    Add the <a href="#" onclick="addPanel()">WordPress Sidebar</a>! 
    <?php } elseif (($is_winIE) || ($is_macIE)) { ?>
<div class="wrap">
    <h2>SideBar</h2>
	<?php echo _LANG_WPF_SUBT_FAVORITES; ?> <a href="javascript:Q='';if(top.frames.length==0)Q=document.selection.createRange().text;void(_search=open('<?php echo $siteurl ?>/wp-admin/sidebar.php?text='+escape(Q)+'&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title),'_search'))">WordPress Sidebar</a>. 
</div>
<?php } ?>
	<?php
		break;
}
include('admin-footer.php') ?>