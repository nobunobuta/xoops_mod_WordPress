<?php
require_once('admin.php');

$title = 'Users';
$this_file = 'users.php';
$parent_file = 'users.php';

param( 'action', 'string', '');

switch ($action) {
case 'promote':
		wp_refcheck("/wp-admin/users.php");

	    param('prom',  'string',  true);
	    param('id',    'integer',  true);

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
		wp_refcheck("/wp-admin/users.php");

	    param('id', 'integer',  true);
	
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
		require_once ('admin-header.php');
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
	$style = '';
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
		$numposts = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts[$wp_id]} WHERE post_author = $user->ID and post_status = 'publish'");		if (0 < $numposts) {
			$numposts = "<a href='edit.php?author=$user_data->ID' title='View posts'>$numposts</a>";
		}
		if ((($user_level >= 2) and ($user_level > $user_data->user_level) and ($user_data->user_level > 0)) or
		    (($user_level == 10) and ($user_data->ID != 1))) {
			$level_down = "<a href=\"users.php?action=promote&id=".$user_data->ID."&prom=down\">-</a>";
		} else {
			$level_down = "&nbsp;";
		}
		if ((($user_level >= 2) and ($user_level > ($user_data->user_level + 1))) or
		    (($user_level == 10) and ($user_data->user_level < 10))) {
			$level_up = "<a href=\"users.php?action=promote&id=".$user_data->ID."&prom=up\">+</a>";
		} else {
			$level_up = "&nbsp;";
		}
?>
	<tr <?php echo $style?>>
		<td align='center'><?php echo $user_data->ID ?></td>
		<td><strong><?php echo $user_data->user_nickname ?></strong></td>
		<td><?php echo "$user_data->user_firstname $user_data->user_lastname" ?></td>
		<td><a href='mailto:<?php echo $email ?>' title='e-mail: <?php echo $email ?>'><?php echo $email ?></a></td>
		<td><a href='<?php echo $url ?>' title='website: <?php echo $url ?>'><?php echo $short_url ?></a></td>
		<td align='center'><?php echo "$level_down  $user_data->user_level $level_up" ?></td>
		<td align='right'><?php echo $numposts ?></td>
	</tr>
<?php
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
		if ($user_level >= 3) {
			$user_del = "<a href=\"users.php?action=delete&id=".$user_data->ID."\" style=\"color:red;font-weight:bold;\" onclick=\"return confirm('You are about to delete this user\\n  \'OK\' to delete, \'Cancel\' to stop.')\">X</a>";
		} else {
			$user_del = "&nbsp;";
		}
		if ($user_level >= 2) {
			$level_up = "<a href=\"users.php?action=promote&id=".$user_data->ID."&prom=up\">+</a>";
		} else {
			$level_up = "&nbsp;";
		}
?>
		<tr <?php echo $style ?>>
			<td align='center'><?php echo $user_data->ID ?></td>
			<td><strong><?php echo $user_data->user_nickname ?></td>
			<td><?php echo "$user_data->user_firstname $user_data->user_lastname" ?></td>
			<td><a href='mailto:<?php echo $email ?>' title='e-mail: <?php echo $email ?>'><?php echo $email ?></a></td>
			<td><a href='<?php echo $url ?>' title='website: <?php echo $url ?>'><?php echo $short_url ?></a></td>
			<td align='center'><?php echo "$user_del $user_data->user_level $level_up" ?></td>
		</tr>
<?php
	}
	?>
	</table>
</div>
	<?php 
}
?>
	  <p><?php echo _LANG_WUS_AU_WARNING; ?></p>
	<?php
break;
}
include('admin-footer.php');
?>