<?php
/* ÈþÆý */
require(dirname(__FILE__) . '/wp-config.php');

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

if (!get_magic_quotes_gpc()) {
	$HTTP_GET_VARS    = add_magic_quotes($HTTP_GET_VARS);
	$HTTP_POST_VARS   = add_magic_quotes($HTTP_POST_VARS);
	$HTTP_COOKIE_VARS = add_magic_quotes($HTTP_COOKIE_VARS);
}

$wpvarstoreset = array('action');
for ($i=0; $i<count($wpvarstoreset); $i += 1) {
	$wpvar = $wpvarstoreset[$i];
	if (!isset($$wpvar)) {
		if (empty($HTTP_POST_VARS["$wpvar"])) {
			if (empty($HTTP_GET_VARS["$wpvar"])) {
				$$wpvar = '';
			} else {
				$$wpvar = $HTTP_GET_VARS["$wpvar"];
			}
		} else {
			$$wpvar = $HTTP_POST_VARS["$wpvar"];
		}
	}
}

if (!$users_can_register) {
	$action = 'disabled';
}

switch($action) {

case 'register':

	function filter($value)	{
		return ereg('^[a-zA-Z0-9\_-\|]+$',$value);
	}

	$user_login = $HTTP_POST_VARS['user_login'];
	$pass1 = $HTTP_POST_VARS['pass1'];
	$pass2 = $HTTP_POST_VARS['pass2'];
	$user_email = $HTTP_POST_VARS['user_email'];
		
	/* checking login has been typed */
	if ($user_login == '') {
		die ('<strong>ERROR</strong>: Please enter a login.');
	}

	/* checking the password has been typed twice */
	if ($pass1 == '' || $pass2 == '') {
		die ('<strong>ERROR</strong>: Please enter your password twice.');
	}

	/* checking the password has been typed twice the same */
	if ($pass1 != $pass2)	{
		die ('<strong>ERROR</strong>: Please type the same password in the two password fields.');
	}
	$user_nickname = $user_login;

	/* checking e-mail address */
	if ($user_email == '') {
		die ('<strong>ERROR</strong>: Please type your e-mail address.');
	} else if (!is_email($user_email)) {
		die ('<strong>ERROR</strong>: The email address isn&#8217;t correct.');
	}

	/* checking the login isn't already used by another user */
	$result = $wpdb->get_results("SELECT user_login FROM $tableusers WHERE user_login = '$user_login'");
    if (count($result) >= 1) {
		die ('<strong>ERROR</strong>: This login is already registered, please choose another one.');
	}

	$user_ip = $_SERVER['REMOTE_ADDR'] ;
	$user_domain = gethostbyaddr($_SERVER['REMOTE_ADDR'] );
	$user_browser = $_SERVER['HTTP_USER_AGENT'];

	$user_login = addslashes($user_login);
	$pass1 = addslashes($pass1);
	$user_nickname = addslashes($user_nickname);
	$now = current_time('mysql');

	$result = $wpdb->query("INSERT INTO $tableusers 
		(user_login, user_pass, user_nickname, user_email, user_ip, user_domain, user_browser, dateYMDhour, user_level, user_idmode)
	VALUES 
		('$user_login', '$pass1', '$user_nickname', '$user_email', '$user_ip', '$user_domain', '$user_browser', '$now', '$new_users_can_blog', 'nickname')");
	
	if ($result == false) {
		die ('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:'.$admin_email.'">webmaster</a> !');
	}

	$stars = '';
	for ($i = 0; $i < strlen($pass1); $i = $i + 1) {
		$stars .= '*';
	}

	$message  = "$blogname: "._LANG_R_USER_REGISTRATION."\r\n\r\n";
	$message .= "Login: $user_login\r\n\r\nE-mail: $user_email";
	$wpm_title = "[$blogname] "._LANG_R_MAIL_REGISTRATION;
	$header = "From: $admin_email\r\nErrors-To: $admin_email";

	if (function_exists('mb_send_mail')) {
	mb_send_mail($admin_email, $wpm_title, $message, $header);
	} else {
	@mail($admin_email, $wpm_title, $message, $header);
	}

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>WordPress &raquo; Registration Complete</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset; ?>" />	
<style media="screen" type="text/css">
    <!--
	body {
		font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
		margin-left: 15%;
		margin-right: 15%;
	}
	#logo {
		margin: 0;
		padding: 0;
		background-image: url(wp-images/wordpress.gif);
		background-repeat: no-repeat;
		height: 60px;
		border-bottom: 1px solid #dcdcdc;
	}
	#logo a {
		display: block;
		height: 60px;
	}
	#logo a span {
		display: none;
	}
	p, li {
		line-height: 140%;
	}
    -->
	</style>
</head>
<body>
<h1 id="logo"><a href="http://wordpress.xwd.jp/"><span>WordPress Japan</span></a></h1>
<div> 
	<p><?php echo _LANG_R_R_COMPLETE; ?></p>
	<p><?php echo _LANG_R_USER_LOGIN; ?> <strong><?php echo $user_login; ?></strong><br />
	<?php echo _LANG_R_USER_PASSWORD; ?> <strong><?php echo $stars; ?></strong><br />
	<?php echo _LANG_R_USER_EMAIL; ?> <strong><?php echo $user_email; ?></strong></p>
	<form action="wp-login.php" method="post" name="login">
		<input type="hidden" name="log" value="<?php echo $user_login; ?>" />
		<input type="submit" value="Login" name="submit" />
	</form>
</div>
</body>
</html>

	<?php
break;

case 'disabled':

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>WordPress &raquo; Registration Currently Disabled</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset; ?>">
<style media="screen" type="text/css">
    <!--
	body {
		font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
		margin-left: 15%;
		margin-right: 15%;
	}
	#logo {
		margin: 0;
		padding: 0;
		background-image: url(wp-images/wordpress.gif);
		background-repeat: no-repeat;
		height: 60px;
		border-bottom: 1px solid #dcdcdc;
	}
	#logo a {
		display: block;
		height: 60px;
	}
	#logo a span {
		display: none;
	}
	p, li {
		line-height: 140%;
	}
    -->
	</style>
</head>
<body>
<h1 id="logo"><a href="http://wordpress.xwd.jp/"><span>WordPress Japan</span></a></h1>
<div>
	<p><?php echo _LANG_R_R_DISABLED; ?></p>
	<p><?php echo _LANG_R_R_CLOSED; ?><br />
	<a href="<?php echo $siteurl.'/'.$blogfilename; ?>" title="Go back to the blog">Home</a>
	</p>
</div>

</body>
</html>

	<?php
break;

default:

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>WordPress &raquo; Registration Form</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $blog_charset; ?>" />
<style media="screen" type="text/css">
    <!--
	body {
		font-family: "¥Ò¥é¥®¥Î³Ñ¥´ Pro W3", Osaka, Verdana, "£Í£Ó £Ð¥´¥·¥Ã¥¯", sans-serif;
		margin-left: 15%;
		margin-right: 15%;
	}
	#logo {
		margin: 0;
		padding: 0;
		background-image: url(wp-images/wordpress.gif);
		background-repeat: no-repeat;
		height: 60px;
		border-bottom: 1px solid #dcdcdc;
	}
	#logo a {
		display: block;
		height: 60px;
	}
	#logo a span {
		display: none;
	}
	p, li {
		line-height: 140%;
	}
    -->
	</style>
</head>
<body>
<h1 id="logo"><a href="http://wordpress.xwd.jp/"><span>WordPress Japan</span></a></h1>
<div>
<p><?php echo _LANG_R_R_REGISTRATION; ?></p>

<form method="post" action="wp-register.php">
	<input type="hidden" name="action" value="register" />
<table border="0" cellpadding="0" cellspacing="3">
  <tbody>
    <tr>
      <td width="150"><label for="user_login"><?php echo _LANG_R_USER_LOGIN; ?></label></td>
      <td><input type="text" name="user_login" id="user_login" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><label for="user_email"><?php echo _LANG_R_USER_EMAIL; ?></label></td>
      <td><input type="text" name="user_email" id="user_email" size="20" maxlength="100" /></td>
    </tr>
    <tr>
      <td><label for="pass1"><?php echo _LANG_R_USER_PASSWORD; ?></label></td>
      <td><input type="password" name="pass1" id="pass1" size="10" maxlength="100" /></td>
    </tr>
    <tr>
      <td><label for="pass2"><?php echo _LANG_R_TWICE_PASSWORD; ?></label></td>
      <td><input type="password" name="pass2" size="10" maxlength="100" /></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="OK" class="search" name="submit" /></td>
    </tr>
  </tbody>
</table>
</form>
</div>

</body>
</html>
<?php

break;
}