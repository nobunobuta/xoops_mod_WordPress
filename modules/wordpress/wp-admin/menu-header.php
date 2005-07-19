<?php
if ('menu-header.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ();
?>
<div id="wpAdminMain">
<h1 id="wphead"><a href="http://wordpress.xwd.jp/" rel="external"><span>WordPress Japan</span></a></h1>
<ul id="adminmenu">
<?php
$self = preg_replace('|^.*/wp-admin/|i', '', $_SERVER['PHP_SELF']);
$self = preg_replace('|^.*/plugins/|i', '', $self);

get_admin_page_parent();

foreach ($menu as $item) {
	$class = '';

    // 0 = name, 1 = user_level, 2 = file
    if ((substr($self, -10) == substr($item[2], -10) && empty($parent_file)) || ($parent_file && ($item[2] == $parent_file))) $class = ' class="current"';
    
    if ($user_level >= $item[1]) {
		echo "\n\t<li><a href='".$siteurl."/wp-admin/{$item[2]}'$class>{$item[0]}</a></li>";
    }
}
	echo "\n\t<li><a href='$siteurl/'>View site</a></li>";

?>
</ul>

<?php if ( isset($submenu["$parent_file"]) ) { // Sub-menu ?>
<ul id="adminmenu2">
<?php 
	foreach ($submenu["$parent_file"] as $item) {
		if ($user_level < $item[1]) {
			 continue;
		}

		if (($parent_file != 'options.php')||(!preg_match('/^options.php/',$item[2]))) {
			if ( (substr($self, -10) == substr($item[2], -10)) || (isset($plugin_page) && $plugin_page == $item[2]) ) {
				$class = ' class="current"';
			} else {
				$class = '';
			}
		} else {
			if ((isset($_GET['option_group_id']))&&($item[2] == 'options.php?option_group_id='.$_GET['option_group_id'])) {
			 	$class = ' class="current"';
			 } else {
			 	$class = '';
			}
		}
		if (file_exists(wp_base()."/wp-content/plugins/{$item[2]}")) {
			echo "\n\t<li><a href='" . $siteurl . "/wp-admin/admin.php?page={$item[2]}'$class>{$item[0]}</a></li>";
		} else {
			echo "\n\t<li><a href='" . $siteurl . "/wp-admin/{$item[2]}'$class>{$item[0]}</a></li>";
		}
	}
?>

</ul>
<?php } ?>
