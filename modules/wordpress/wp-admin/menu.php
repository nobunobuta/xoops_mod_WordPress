<div id="wpAdminMain">
<h1 id="wphead"><a href="http://wordpress.xwd.jp/" rel="external"><span>WordPress Japan</span></a></h1>

<ul id="adminmenu">
<?php
if (file_exists("./menu."._LANGCODE.".txt")) {
	$menu = file("./menu."._LANGCODE.".txt");
} else {
	$menu = file('./menu.txt');
}
$continue = true;
foreach ($menu as $item) {
	$class = '';
	$item = trim($item);
	if ('***' == $item) $continue = false;
	if ($continue) {
		$item = explode("\t", $item);
		// 0 = user level, 1 = file, 2 = name
		$self = str_replace('/wp-admin/', '', $PHP_SELF);
		if ((substr($self, -20) == substr($item[1], -20)) || ($parent_file && ($item[1] == $parent_file))) $class = ' class="current"';
		if ($user_level >= $item[0]) echo "\n\t<li><a href='{$item[1]}'$class>{$item[2]}</a></li>";
	}
}
	if ($parent_file && ('profile.php' == $parent_file)) $class = ' class="current"';

?>
	<li><a href="profile.php" <?php echo $class ?>>My Profile</a></li>
	<li><a href="<?php echo "$siteurl/index.php"; ?>">View site</a></li>
</ul>

<h2><?php echo $title; ?></h2>