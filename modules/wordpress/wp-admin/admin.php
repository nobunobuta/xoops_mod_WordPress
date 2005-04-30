<?php
require('../wp-config.php');
require_once('admin-functions.php');
require_once('auth.php');

get_currentuserinfo();

$posts_per_page = get_settings('posts_per_page');
$what_to_show = get_settings('what_to_show');
$date_format = get_settings('date_format');
$time_format = get_settings('time_format');

require_once(dirname(__FILE__). '/menu.php');
?>