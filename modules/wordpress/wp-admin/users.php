<?php
$title = 'Users';
$parent_file = 'users.php';

/* <Team> */
	
$wpvarstoreset = array('action','standalone','redirect','profile');
for ($i=0; $i<count($wpvarstoreset); $i += 1) {
	$wpvar = $wpvarstoreset[$i];
	if (!isset($$wpvar)) {
		if (empty($_POST["$wpvar"])) {
			if (empty($_GET["$wpvar"])) {
				$$wpvar = '';
			} else {
				$$wpvar = $_GET["$wpvar"];
			}
		} else {
			$$wpvar = $_POST["$wpvar"];
		}
	}
}

switch ($action) {
case 'adduser':
	$standalone = 1;
	require_once('admin-header.php');
	wp_refcheck("/wp-admin");
	function filter($value)	{
		return ereg('^[a-zA-Z0-9\_-\|]+$',$value);
	}

	$user_login = $_POST['user_login'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$user_email = $_POST['email'];
	$user_firstname = $_POST['firstname'];
	$user_lastname = $_POST['lastname'];
		
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
	$loginthere = $wpdb->get_var("SELECT user_login FROM {$wpdb->users[$wp_id]} WHERE user_login = '$user_login'");
    if ($loginthere) {
		die ('<strong>ERROR</strong>: This login is already registered, please choose another one.');
	}

	$user_login = addslashes(stripslashes($user_login));
	$pass1 = addslashes(stripslashes($pass1));
	$user_nickname = addslashes(stripslashes($user_nickname));
	$user_firstname = addslashes(stripslashes($user_firstname));
	$user_lastname = addslashes(stripslashes($user_lastname));
	$now = current_time('mysql');

	$result = $wpdb->query("INSERT INTO {$wpdb->users[$wp_id]} 
		(user_login, user_pass, user_nickname, user_email, user_ip, user_domain, user_browser, dateYMDhour, user_level, user_idmode, user_firstname, user_lastname)
	VALUES 
		('$user_login', '$pass1', '$user_nickname', '$user_email', '$user_ip', '$user_domain', '$user_browser', '$now', '".get_settings('new_users_can_blog')."', 'nickname', '$user_firstname', '$user_lastname')");
	
	if ($result == false) {
		die ('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:'.get_settings('admin_email').'">webmaster</a> !');
	}

	$stars = '';
	for ($i = 0; $i < strlen($pass1); $i = $i + 1) {
		$stars .= '*';
	}

	$message  = "get_settings('blogname'): "._LANG_R_USER_REGISTRATION."\r\n\r\n";
	$message .= "Login: $user_login\r\n\r\nE-mail: $user_email";
	$wpm_title = "[get_settings('blogname')] "._LANG_R_MAIL_REGISTRATION;
	$header = "From: ".get_settings('admin_email')."\r\nErrors-To: ".get_settings('admin_email');

	if (function_exists('mb_send_mail')) {
	mb_send_mail(get_settings('admin_email'), $wpm_title, $message, $header);
	} else {
	@mail(get_settings('admin_email'), $wpm_title, $message, $header);
	}
	header('Location: users.php');
break;

case 'promote':

	$standalone = 1;
	require_once('admin-header.php');
	wp_refcheck("/wp-admin");

	if (empty($_GET['prom'])) {
		header('Location: users.php');
	}

	$id = $_GET['id'];
	$id = intval($id);
	$prom = $_GET['prom'];

	$user_data = get_userdata($id);
	$usertopromote_level = $user_data->user_level;
	if (($user_level <= $usertopromote_level) and ( $user_ID != 1)){
		die('Can&#8217;t change the level of a user whose level is higher than yours.');
	}
	
	if ('up' == $prom) {
		$new_level = $usertopromote_level + 1;
		$sql="UPDATE {$wpdb->users[$wp_id]} SET user_level=$new_level WHERE ID = $id";
	} elseif ('down' == $prom) {
		$new_level = $usertopromote_level - 1;
		$sql="UPDATE {$wpdb->users[$wp_id]} SET user_level=$new_level WHERE ID = $id";
	}
	$result = $wpdb->query($sql);

	header('Location: users.php');

break;

case 'delete':
	$standalone = 1;
	require_once('admin-header.php');
	wp_refcheck("/wp-admin");

	$id = intval($_GET['id']);

	if (!$id) {
		header('Location: users.php');
	}
	
	$user_data = get_userdata($id);
	$usertodelete_level = $user_data->user_level;

	if (0 != $usertodelete_level)
		die('Can&#8217;t delete a user whose level is higher than yours.');

	$post_ids = $wpdb->get_col("SELECT ID FROM {$wpdb->posts[$wp_id]} WHERE post_author = $id");
	if ($post_ids) {
		$post_ids = implode(',', $post_ids);
		
		// Delete comments, *backs
		$wpdb->query("DELETE FROM {$wpdb->comments[$wp_id]} WHERE comment_post_ID IN ($post_ids)");
		// Clean cats
		$wpdb->query("DELETE FROM {$wpdb->post2cat[$wp_id]} WHERE post_id IN ($post_ids)");
		// Clean links
		$wpdb->query("DELETE FROM {$wpdb->links[$wp_id]} WHERE link_owner = $id");
		// Delete posts
		$wpdb->query("DELETE FROM {$wpdb->posts[$wp_id]} WHERE post_author = $id");
	}

	// FINALLY, delete user
	$wpdb->query("DELETE FROM {$wpdb->users[$wp_id]} WHERE ID = $id");
	header('Location: users.php');

break;

default:
	
	$standalone = 0;
	include ('admin-header.php');
	?>
<div class="wrap">
  <h2><?php echo _LANG_WUS_AU_THOR; ?></h2>
  <table cellpadding="3" cellspacing="3" width="100%">
	<tr>
	<th>ID</th>
	<th><?php echo _LANG_WUS_AU_NICK; ?></th>
	<th><?php echo _LANG_WUS_AU_NAME; ?></th>
	<th><?php echo _LANG_WUS_AU_MAIL; ?></th>
	<th><?php echo _LANG_WUS_AU_URI; ?></th>
	<th><?php echo _LANG_WUS_AU_LEVEL; ?></th>
	<th><?php echo _LANG_WUS_AU_POSTS; ?></th>
	</tr>
	<?php
	$users = $wpdb->get_results("SELECT ID FROM {$wpdb->users[$wp_id]} WHERE user_level > 0 ORDER BY ID");
	foreach ($users as $user) {
		$user_data = get_userdata($user->ID);
		$email = $user_data->user_email;
		$url = $user_data->user_url;
		$short_url = str_replace('http://', '', stripslashes($url));
		$short_url = str_replace('www.', '', $short_url);
		if ('/' == substr($short_url, -1))
			$short_url = substr($short_url, 0, -1);
		if (strlen($short_url) > 35)
		$short_url =  substr($short_url, 0, 32).'...';
		$style = ('class="alternate"' == $style) ? '' : 'class="alternate"';
		$numposts = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts[$wp_id]} WHERE post_author = $user->ID and post_status = 'publish'");
		if (0 < $numposts) $numposts = "<a href='edit.php?author=$user_data->ID' title='View posts'>$numposts</a>";
		echo "
<tr $style>
	<td align='center'>$user_data->ID</td>
	<td><strong>$user_data->user_nickname</strong></td>
	<td>$user_data->user_firstname $user_data->user_lastname</td>
	<td><a href='mailto:$email' title='e-mail: $email'>$email</a></td>
	<td><a href='$url' title='website: $url'>$short_url</a></td>
	<td align='center'>";
	if ((($user_level >= 2) and ($user_level > $user_data->user_level) and ($user_data->user_level > 0)) or (($user_level == 10) and ($user_data->ID !=1 )))
		echo " <a href=\"users.php?action=promote&id=".$user_data->ID."&prom=down\">-</a> ";
	echo $user_data->user_level;
	if ((($user_level >= 2) and ($user_level > ($user_data->user_level + 1))) or (($user_level == 10) and ($user_data->user_level <10)))
		echo " <a href=\"users.php?action=promote&id=".$user_data->ID."&prom=up\">+</a> ";
	echo "<td align='right'>$numposts</td>";
	echo '</tr>';
	}
	
	?>
	
  </table>
</div>

<?php
	$users = $wpdb->get_results("SELECT * FROM {$wpdb->users[$wp_id]} WHERE user_level = 0 ORDER BY ID");
	if ($users) {
?>
<div class="wrap">
	<h2><?php echo _LANG_WUS_AU_USERS; ?></h2>
	<table cellpadding="3" cellspacing="3" width="100%">
	<tr>
		<th>ID</th>
		<th><?php echo _LANG_WUS_AU_NICK; ?></th>
		<th><?php echo _LANG_WUS_AU_NAME; ?></th>
		<th><?php echo _LANG_WUS_AU_MAIL; ?></th>
		<th><?php echo _LANG_WUS_AU_URI; ?></th>
		<th><?php echo _LANG_WUS_AU_LEVEL; ?></th>
	</tr>
	<?php
	foreach ($users as $user) {
		$user_data = get_userdata($user->ID);
		$email = $user_data->user_email;
		$url = $user_data->user_url;
		$short_url = str_replace('http://', '', stripslashes($url));
		$short_url = str_replace('www.', '', $short_url);
		if ('/' == substr($short_url, -1))
			$short_url = substr($short_url, 0, -1);
		if (strlen($short_url) > 35)
		$short_url =  substr($short_url, 0, 32).'...';
		$style = ('class="alternate"' == $style) ? '' : 'class="alternate"';
echo "\n<tr $style>
<td align='center'>$user_data->ID</td>
<td><strong>$user_data->user_nickname</td>
<td>$user_data->user_firstname $user_data->user_lastname</td>
<td><a href='mailto:$email' title='e-mail: $email'>$email</a></td>
<td><a href='$url' title='website: $url'>$short_url</a></td>
<td align='center'>";
		if ($user_level >= 3)
			echo " <a href=\"users.php?action=delete&id=".$user_data->ID."\" style=\"color:red;font-weight:bold;\" onclick=\"return confirm('You are about to delete this user\\n  \'OK\' to delete, \'Cancel\' to stop.')\">X</a> ";
		echo $user_data->user_level;
		if ($user_level >= 2)
			echo " <a href=\"users.php?action=promote&id=".$user_data->ID."&prom=up\">+</a> ";	
		echo "</td>\n</tr>\n";
	}
	?>
	
	</table>
</div>

	<?php 
	} ?>
	  <p><?php echo _LANG_WUS_AU_WARNING; ?></p>
	<?php if(0) { ?>
<div class="wrap">
<h2><?php echo _LANG_WUS_ADD_USER; ?></h2>
<p><a href="<?php echo $siteurl ?>/wp-register.php">Register Themselves</a> : <?php echo _LANG_WUS_ADD_THEMSELVES; ?></p>
<form action="" method="post" name="adduser" id="adduser">
  <table border="0" cellspacing="5" cellpadding="3">
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WUS_AU_NICK; ?>
      <input name="action" type="hidden" id="action" value="adduser" /></th>
      <td><input name="user_login" type="text" id="user_login" /></td>
    </tr>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WUS_ADD_FIRST; ?></th>
      <td><input name="firstname" type="text" id="firstname" /></td>
    </tr>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WUS_ADD_LAST; ?></th>
      <td><input name="lastname" type="text" id="lastname" /></td>
    </tr>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WUS_AU_MAIL; ?></th>
      <td><input name="email" type="text" id="email" /></td>
    </tr>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WUS_AU_URI; ?></th>
      <td><input name="uri" type="text" id="uri" /></td>
    </tr>
    <tr>
      <th scope="row" align="left"><?php echo _LANG_WUS_ADD_TWICE; ?></th>
      <td><input name="pass1" type="text" id="pass1" />
      <br />
      <input name="pass2" type="text" id="pass2" /></td>
    </tr>
  </table>
  <p>
    <input name="adduser" type="submit" id="adduser" value="<?php echo _LANG_WUS_ADD_USER; ?>">
  </p>
  </form>
</div>
	<?php
	}
break;
}
	
/* </Team> */
include('admin-footer.php');
?>