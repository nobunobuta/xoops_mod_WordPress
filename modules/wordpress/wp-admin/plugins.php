<?php
require_once('admin.php');

$title = 'Manage Plugins';
$this_file = 'plugins.php';
$parent_file = 'plugins.php';

if ($user_level < 9) {
	redirect_header($siteurl.'/wp-admin/',5,_LANG_PG_LEAST_LEVEL);
	exit();
}

param('action','string','');

switch($action) {
	case 'activate':
		param('plugin','string',true);
		if ( ! $xoopsWPTicket->check(false) ) {
			redirect_header($siteurl.'/wp-admin/plugins.php',3,$xoopsWPTicket->getErrors());
		}
		wp_refcheck("/wp-admin/plugins.php");
		$current = "\n" . get_settings('active_plugins') . "\n";
		$current = preg_replace("|(\n)+\s*|", "\n", $current);
		$current = trim($current) . "\n " . trim($plugin);
		$current = trim($current);
		$current = preg_replace("|\n\s*|", "\n", $current); // I don't know where this is coming from
		update_option('active_plugins', $current);
		header('Location: plugins.php?activate=true');
		break;
	
	case 'deactivate':
		param('plugin','string',true);
		if ( ! $xoopsWPTicket->check(false) ) {
			redirect_header($siteurl.'/wp-admin/plugins.php',3,$xoopsWPTicket->getErrors());
		}
		wp_refcheck("/wp-admin/plugins.php");
		$current = "\n" . get_settings('active_plugins') . "\n";
		$current = str_replace("\n" . $plugin, '', $current);
		$current = preg_replace("|(\n)+\s*|", "\n", $current);
		update_option('active_plugins', trim($current));
		header('Location: plugins.php?deactivate=true');
		break;
		
	default:
		$standalone = 0;
		require_once('admin-header.php');

		param('activate','string','');
		param('deactivate','string','');

		// Clean up options
		// if any files are in the option that don't exist, axe 'em
		if(!get_settings('active_plugins')) {
			add_option('active_plugins','');
		}

		$check_plugins = explode("\n", (get_settings('active_plugins')));
		foreach ($check_plugins as $check_plugin) {
			if (!file_exists(ABSPATH . 'wp-content/plugins/' . $check_plugin)) {
					$current = get_settings('active_plugins') . "\n";
					$current = str_replace($check_plugin . "\n", '', $current);
					$current = preg_replace("|\n+|", "\n", $current);
					update_option('active_plugins', trim($current));
			}
		}
?>
<?php if ($activate) { ?>
<div class="updated"><p><?php echo _LANG_PG_ACTIVATED_OK; ?></p>
</div>
<?php } ?>
<?php if ($deactivate) { ?>
<div class="updated"><p><?php echo _LANG_PG_DEACTIVATED_OK; ?></p>
</div>
<?php } ?>
<div class="wrap">
<h2><?php echo _LANG_PG_PAGE_TITLE; ?></h2>
<p><?php echo _LANG_PG_NEED_PUT; ?></p>
<?php
	// Files in wp-content/plugins directory
	$plugins_dir = @ dir(ABSPATH . 'wp-content/plugins');
	if ($plugins_dir) {
		while(($file = $plugins_dir->read()) !== false) {
		  if ( !preg_match('|^\.+$|', $file) && preg_match('|\.php$|', $file) ) 
			$plugin_files[] = $file;
		}
	}

	if ('' != trim(get_settings('active_plugins'))) {
		$current_plugins = explode("\n", (get_settings('active_plugins')));
	}

	if (!$plugins_dir || !$plugin_files) {
		echo "<p>" . _LANG_PG_OPEN_ERROR . "</p>"; // TODO: make more helpful
	} else {
?>
<table width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<th nowrap><?php echo _LANG_PG_SUB_PLUGIN; ?></th>
		<th nowrap><?php echo _LANG_PG_SUB_VERSION; ?></th>
		<th nowrap><?php echo _LANG_PG_SUB_AUTHOR; ?></th>
		<th nowrap><?php echo _LANG_PG_SUB_DESCR; ?></th>
		<th nowrap><?php echo _LANG_PG_SUB_ACTION; ?></th>
	</tr>
<?php
		sort($plugin_files); // Alphabetize by filename. Better way?
		$style = '';
		$ticket=$xoopsWPTicket->getTicketParamString('plugins');
		foreach($plugin_files as $plugin_file) {
			$plugin_data = implode('', file(ABSPATH . '/wp-content/plugins/' . $plugin_file));
			preg_match("|Plugin Name:(.*)|i", $plugin_data, $plugin_name);
			preg_match("|Plugin URI:(.*)|i", $plugin_data, $plugin_uri);
			preg_match("|Description:(.*)|i", $plugin_data, $description);
			preg_match("|Author:(.*)|i", $plugin_data, $author_name);
			preg_match("|Author URI:(.*)|i", $plugin_data, $author_uri);
			if ( preg_match("|Version:(.*)|i", $plugin_data, $version) ) {
				$version = $version[1];
			} else {
				$version ='';
			}
			$description = wptexturize($description[1]);
			if ('' == $plugin_uri) {
				$plugin = $plugin_name[1];
			} else {
				$plugin = "<a href='{$plugin_uri[1]}' title='Visit plugin homepage'>{$plugin_name[1]}</a>";
			}

			if ('' == $author_uri) {
				$author = $author_name[1];
			} else {
				$author = "<a href='{$author_uri[1]}' title='Visit author homepage'>{$author_name[1]}</a>";
			}
			$style = ('class="alternate"' == $style) ? '' : 'class="alternate"';

			if (!empty($current_plugins) && in_array($plugin_file, $current_plugins)) {
				$action = "<a href='plugins.php?action=deactivate&amp;plugin=$plugin_file$ticket' title='Deactivate this plugin' class='delete'>" . _LANG_PG_SUB_DEACTIVATE . "</a>";
				$plugin = "<strong>$plugin</strong>";
			} else {
				$action = "<a href='plugins.php?action=activate&amp;plugin=$plugin_file$ticket' title='Activate this plugin' class='edit'>" . _LANG_PG_SUB_ACTIVATE . "</a>";
			}
			if(preg_match("/_LANG_PG_/", $description)) {
				$description = constant(trim($description));
			}
?>
	<tr <?php echo $style ?>>
		<td><?php echo $plugin ?></td>
		<td><?php echo $version ?></td>
		<td><?php echo $author ?></td>
		<td><?php echo $description ?></td>
		<td><?php echo $action ?></td>
	</tr>
<?php
		}
?>
</table>
<?php
	}
?>
</div>
<?php
}
include('admin-footer.php');
?>